<?php
require_once __DIR__ . '/connection.php';

// If already logged in, redirect away
if (isset($_SESSION['logid'])) {
    redirect('index.php');
}

$error = '';

if (isset($_POST['submit'])) {
    // Verify CSRF
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        $error = 'Invalid form submission. Please try again.';
    } else {
        $username = trim($_POST['Username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Please enter both username and password.';
        } else {
            // Prepared statement – no SQL injection possible
            $rows = secure_select(
                "SELECT log_id, password, type FROM login WHERE username = ? AND login_status = 'active'",
                's',
                [$username]
            );

            if (!empty($rows)) {
                $stored = $rows[0]['password'];
                // Support both bcrypt hashes and legacy plain-text (fallback)
                $valid = password_verify($password, $stored)
                      || $stored === $password; // legacy plain-text fallback

                if ($valid) {
                    $_SESSION['logid'] = $rows[0]['log_id'];
                    $type = $rows[0]['type'];

                    if ($type === 'admin') {
                        redirect('admin_home.php');
                    } elseif ($type === 'user') {
                        redirect('user_home.php');
                    } elseif ($type === 'tour_providers') {
                        redirect('provider_home.php');
                    }
                } else {
                    $error = 'Invalid username or password.';
                }
            } else {
                $error = 'Invalid username or password, or account is blocked.';
            }
        }
    }
}
?>
<?php include 'public_header.php'; ?>

<div style="min-height:70vh; display:flex; align-items:center; justify-content:center; padding: 40px 16px;">
  <div class="ts-form-card">

    <div class="ts-text-center ts-mb-16">
      <div class="ts-form-icon"><i class="fa fa-plane"></i></div>
      <h2 class="ts-mt-0">Welcome Back</h2>
      <p class="ts-text-muted">Sign in to your Travel Shadow account</p>
    </div>

    <?php if ($error): ?>
      <div class="ts-alert ts-alert-error">
        <i class="fa fa-exclamation-circle"></i>
        <?php echo esc($error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" novalidate>
      <?php csrf_field(); ?>

      <div class="ts-input-group">
        <label for="login-username">Username</label>
        <div class="ts-input-icon">
          <i class="fa fa-user"></i>
          <input
            id="login-username"
            type="text"
            name="Username"
            class="ts-input"
            placeholder="Enter your username"
            value="<?php echo esc($_POST['Username'] ?? ''); ?>"
            required
            autofocus
          >
        </div>
      </div>

      <div class="ts-input-group">
        <label for="login-password">Password</label>
        <div class="ts-input-icon">
          <i class="fa fa-lock"></i>
          <input
            id="login-password"
            type="password"
            name="password"
            class="ts-input"
            placeholder="Enter your password"
            required
          >
        </div>
      </div>

      <button type="submit" name="submit" class="ts-btn ts-btn-primary ts-btn-full" style="margin-top:8px;">
        <i class="fa fa-sign-in"></i> Sign In
      </button>
    </form>

    <div class="ts-divider" style="margin-top:28px;">New to Travel Shadow?</div>

    <div style="display:flex; gap:10px;">
      <a href="user_register.php" class="ts-btn ts-btn-outline" style="flex:1; font-size:0.8rem;">
        <i class="fa fa-user-plus"></i> User Register
      </a>
      <a href="tourprovider_register.php" class="ts-btn ts-btn-outline" style="flex:1; font-size:0.8rem;">
        <i class="fa fa-building"></i> Provider Register
      </a>
    </div>

  </div>
</div>

<?php include 'footer.php'; ?>