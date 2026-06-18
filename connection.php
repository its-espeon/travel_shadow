<?php
// ============================================================
// Travel Shadow – Database Connection & Helpers
// ============================================================
require_once __DIR__ . '/config.php';

session_start();

// --- Connect ---
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// ============================================================
// CSRF Protection
// ============================================================
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die('<div style="color:red;padding:20px;">CSRF token mismatch. Please go back and try again.</div>');
    }
}

function csrf_field() {
    $token = generate_csrf_token();
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

// ============================================================
// Legacy helpers (kept for backward compatibility – SELECT only
// used on read queries that don't need parameterisation)
// ============================================================
function insert($sql) {
    $res = mysqli_query($GLOBALS['con'], $sql);
    $id  = mysqli_insert_id($GLOBALS['con']);
    return $id;
}

function update_delete($sql) {
    mysqli_query($GLOBALS['con'], $sql);
}

function select($sql) {
    $res    = mysqli_query($GLOBALS['con'], $sql);
    $result = mysqli_fetch_all($res, MYSQLI_BOTH);
    return $result;
}

// ============================================================
// Secure prepared-statement helpers
// ============================================================

/**
 * Secure SELECT with prepared statements.
 * @param  string $sql    SQL with ? placeholders
 * @param  string $types  e.g. 'ssi'
 * @param  array  $params Values matching placeholders
 * @return array
 */
function secure_select($sql, $types = '', $params = []) {
    $stmt = mysqli_prepare($GLOBALS['con'], $sql);
    if ($types && $params) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows   = mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_stmt_close($stmt);
    return $rows;
}

/**
 * Secure INSERT/UPDATE/DELETE with prepared statements.
 * Returns insert ID for INSERT, true for others.
 * @param  string $sql
 * @param  string $types
 * @param  array  $params
 * @return int|bool
 */
function secure_execute($sql, $types, $params) {
    $stmt = mysqli_prepare($GLOBALS['con'], $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $id = mysqli_insert_id($GLOBALS['con']);
    mysqli_stmt_close($stmt);
    return $id ?: true;
}

// ============================================================
// Utility helpers
// ============================================================

/**
 * Server-side redirect (replaces JS window.location).
 */
function redirect($url) {
    // If headers already sent, fall back to JS redirect
    if (headers_sent()) {
        echo '<script>window.location="' . htmlspecialchars($url) . '";</script>';
    } else {
        header('Location: ' . $url);
        exit;
    }
}

/**
 * Show a JS alert then redirect.
 */
function alert_redirect($msg, $url) {
    $msg = addslashes(htmlspecialchars($msg));
    $url = htmlspecialchars($url);
    echo '<script>alert("' . $msg . '"); window.location="' . $url . '";</script>';
    exit;
}

/**
 * JS-only alert (kept for legacy use).
 */
function alert($msg) {
    $msg = addslashes(htmlspecialchars($msg));
    echo '<script>alert("' . $msg . '");</script>';
}

/**
 * Sanitize a string for safe output.
 */
function esc($val) {
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}