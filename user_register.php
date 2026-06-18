<?php
require_once __DIR__ . '/connection.php';

$error   = '';
$success = '';

if (isset($_POST['register_user'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $house_name = trim($_POST['house_name'] ?? '');
    $place      = trim($_POST['place']      ?? '');
    $district   = trim($_POST['district']   ?? '');
    $pincode    = trim($_POST['pincode']    ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $gender     = $_POST['gender']          ?? '';
    $dob        = $_POST['dob']             ?? '';
    $username   = trim($_POST['username']   ?? '');
    $password   = $_POST['password']        ?? '';

    // Basic server-side validation
    if (empty($first_name) || empty($last_name) || empty($username) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error = 'Phone number must be exactly 10 digits.';
    } elseif (!preg_match('/^[0-9]{6}$/', $pincode)) {
        $error = 'Pincode must be exactly 6 digits.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Check if username already exists
        $existing = secure_select("SELECT log_id FROM login WHERE username = ?", 's', [$username]);
        if (!empty($existing)) {
            $error = 'Username already taken. Please choose another.';
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            // Insert login record
            $login_id = secure_execute(
                "INSERT INTO login (username, password, type, login_status) VALUES (?, ?, 'user', 'active')",
                'ss',
                [$username, $hashed]
            );

            // Insert user record
            secure_execute(
                "INSERT INTO user (login_id, first_name, last_name, house_name, place, district, pincode, email, phone, gender, date_of_birth)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                'issssssssss',
                [$login_id, $first_name, $last_name, $house_name, $place, $district, $pincode, $user_email, $phone, $gender, $dob]
            );

            $success = 'Registration successful! You can now log in.';
        }
    }
}
?>
<?php include 'public_header.php'; ?>

<div style="padding: 40px 16px;">
  <div class="ts-form-card ts-form-card--wide">

    <div class="ts-text-center ts-mb-16">
      <div class="ts-form-icon"><i class="fa fa-user-plus"></i></div>
      <h2 class="ts-mt-0">Create User Account</h2>
      <p class="ts-text-muted">Join Travel Shadow and start exploring</p>
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

      <div class="ts-divider">Personal Information</div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-first">First Name</label>
            <div class="ts-input-icon">
              <i class="fa fa-user"></i>
              <input id="reg-first" type="text" name="first_name" class="ts-input"
                placeholder="First name" pattern="[a-zA-Z\s]{1,30}" required
                value="<?php echo esc($_POST['first_name'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-last">Last Name</label>
            <div class="ts-input-icon">
              <i class="fa fa-user"></i>
              <input id="reg-last" type="text" name="last_name" class="ts-input"
                placeholder="Last name" pattern="[a-zA-Z\s]{1,30}" required
                value="<?php echo esc($_POST['last_name'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-house">House Name</label>
            <div class="ts-input-icon">
              <i class="fa fa-home"></i>
              <input id="reg-house" type="text" name="house_name" class="ts-input"
                placeholder="House name" required
                value="<?php echo esc($_POST['house_name'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-place">Place</label>
            <div class="ts-input-icon">
              <i class="fa fa-map-marker"></i>
              <input id="reg-place" type="text" name="place" class="ts-input"
                placeholder="Place / Town" required
                value="<?php echo esc($_POST['place'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-district">District</label>
            <div class="ts-input-icon">
              <i class="fa fa-map"></i>
              <input id="reg-district" type="text" name="district" class="ts-input"
                placeholder="District" required
                value="<?php echo esc($_POST['district'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-pin">Pin Code</label>
            <div class="ts-input-icon">
              <i class="fa fa-hashtag"></i>
              <input id="reg-pin" type="text" name="pincode" class="ts-input"
                placeholder="6-digit pincode" pattern="[0-9]{6}" required
                value="<?php echo esc($_POST['pincode'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-email">Email Address</label>
            <div class="ts-input-icon">
              <i class="fa fa-envelope"></i>
              <input id="reg-email" type="email" name="user_email" class="ts-input"
                placeholder="you@example.com" required
                value="<?php echo esc($_POST['user_email'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-phone">Phone Number</label>
            <div class="ts-input-icon">
              <i class="fa fa-phone"></i>
              <input id="reg-phone" type="text" name="phone" class="ts-input"
                placeholder="10-digit mobile number" pattern="[0-9]{10}" required
                value="<?php echo esc($_POST['phone'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Gender</label>
            <div class="ts-radio-group">
              <label class="ts-radio-label">
                <input type="radio" name="gender" value="male"
                  <?php echo (($_POST['gender'] ?? '') === 'male') ? 'checked' : ''; ?> required>
                Male
              </label>
              <label class="ts-radio-label">
                <input type="radio" name="gender" value="female"
                  <?php echo (($_POST['gender'] ?? '') === 'female') ? 'checked' : ''; ?>>
                Female
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-dob">Date of Birth</label>
            <div class="ts-input-icon">
              <i class="fa fa-calendar"></i>
              <input id="reg-dob" type="date" name="dob" class="ts-input" required
                value="<?php echo esc($_POST['dob'] ?? ''); ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="ts-divider">Account Credentials</div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-username">Username</label>
            <div class="ts-input-icon">
              <i class="fa fa-at"></i>
              <input id="reg-username" type="text" name="username" class="ts-input"
                placeholder="Choose a username" required autocomplete="off"
                value="<?php echo esc($_POST['username'] ?? ''); ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label for="reg-password">Password</label>
            <div class="ts-input-icon">
              <i class="fa fa-lock"></i>
              <input id="reg-password" type="password" name="password" class="ts-input"
                placeholder="Min. 6 characters" minlength="6" required autocomplete="new-password">
            </div>
          </div>
        </div>
      </div>

      <button type="submit" name="register_user" class="ts-btn ts-btn-primary ts-btn-full" style="margin-top:12px;">
        <i class="fa fa-user-plus"></i> Create Account
      </button>
    </form>

    <p class="ts-text-muted ts-text-center" style="margin-top:20px;">
      Already have an account? <a href="Login.php" style="color:var(--primary); font-weight:600;">Sign In</a>
    </p>

  </div>
</div>

<?php include 'footer.php'; ?>