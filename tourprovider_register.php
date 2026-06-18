<?php
require_once __DIR__ . '/connection.php';

$error   = '';
$success = '';

if (isset($_POST['register_tourprovider'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $name       = trim($_POST['name']       ?? '');
    $place      = trim($_POST['place']      ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $about      = trim($_POST['about']      ?? '');
    $username   = trim($_POST['username']   ?? '');
    $password   = $_POST['password']        ?? '';

    if (empty($name) || empty($username) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error = 'Phone number must be exactly 10 digits.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $existing = secure_select("SELECT log_id FROM login WHERE username = ?", 's', [$username]);
        if (!empty($existing)) {
            $error = 'Username already taken. Please choose another.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            $login_id = secure_execute(
                "INSERT INTO login (username, password, type, login_status) VALUES (?, ?, 'tour_providers', 'active')",
                'ss',
                [$username, $hashed]
            );

            secure_execute(
                "INSERT INTO tour_providers (login_id, name, place, email, phone, about, status)
                 VALUES (?, ?, ?, ?, ?, ?, 'active')",
                'isssss',
                [$login_id, $name, $place, $user_email, $phone, $about]
            );

            $success = 'Provider account created successfully! You can now log in.';
        }
    }
}
?>
<?php include 'public_header.php'; ?>

<div style="padding: 40px 16px;">
  <div class="ts-form-card ts-form-card--wide">

    <div class="ts-text-center ts-mb-16">
      <div class="ts-form-icon"><i class="fa fa-building"></i></div>
      <h2 class="ts-mt-0">Tour Provider Registration</h2>
      <p class="ts-text-muted">Partner with Travel Shadow to offer your tour packages</p>
    </div>

    <?php if ($error): ?>
      <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="ts-alert ts-alert-success">
        <i class="fa fa-check-circle"></i> <?php echo esc($success); ?>
        <a href="Login.php" style="color:inherit; font-weight:700; margin-left:8px;">Sign In &rarr;</a>
      </div>
    <?php endif; ?>

    <form method="post" novalidate>
      <?php csrf_field(); ?>

      <div class="ts-divider">Company Information</div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="p-name">Provider / Company Name</label>
            <div class="ts-input-icon">
              <i class="fa fa-building"></i>
              <input id="p-name" type="text" name="name" class="ts-input"
                placeholder="Business Name" pattern="[a-zA-Z\s]{1,30}" required
                value="<?php echo esc($_POST['name'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="p-place">Place / Location</label>
            <div class="ts-input-icon">
              <i class="fa fa-map-marker"></i>
              <input id="p-place" type="text" name="place" class="ts-input"
                placeholder="Headquarters" pattern="[a-zA-Z\s]{1,30}" required
                value="<?php echo esc($_POST['place'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="p-email">Email Address</label>
            <div class="ts-input-icon">
              <i class="fa fa-envelope"></i>
              <input id="p-email" type="email" name="user_email" class="ts-input"
                placeholder="contact@company.com" required
                value="<?php echo esc($_POST['user_email'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="p-phone">Contact Phone</label>
            <div class="ts-input-icon">
              <i class="fa fa-phone"></i>
              <input id="p-phone" type="text" name="phone" class="ts-input"
                placeholder="10-digit number" pattern="[0-9]{10}" required
                value="<?php echo esc($_POST['phone'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="ts-input-group">
            <label for="p-about">About Company</label>
            <textarea id="p-about" name="about" class="ts-input ts-textarea"
              placeholder="Brief description of your tour operations..." required><?php echo esc($_POST['about'] ?? ''); ?></textarea>
          </div>
        </div>
      </div>

      <div class="ts-divider">Account Credentials</div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="p-username">Username</label>
            <div class="ts-input-icon">
              <i class="fa fa-at"></i>
              <input id="p-username" type="text" name="username" class="ts-input"
                placeholder="Choose a username" required autocomplete="off"
                value="<?php echo esc($_POST['username'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="p-password">Password</label>
            <div class="ts-input-icon">
              <i class="fa fa-lock"></i>
              <input id="p-password" type="password" name="password" class="ts-input"
                placeholder="Min. 6 characters" minlength="6" required autocomplete="new-password">
            </div>
          </div>
        </div>
      </div>

      <button type="submit" name="register_tourprovider" class="ts-btn ts-btn-primary ts-btn-full" style="margin-top:12px;">
        <i class="fa fa-check-square"></i> Register Provider
      </button>
    </form>

    <p class="ts-text-muted ts-text-center" style="margin-top:20px;">
      Already registered? <a href="Login.php" style="color:var(--primary); font-weight:600;">Sign In</a>
    </p>

  </div>
</div>

<?php include 'footer.php'; ?>