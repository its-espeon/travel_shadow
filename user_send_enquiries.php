<?php include 'user_header.php'; ?>

<?php 
$success = '';
$error = '';

$enid = (int)($_GET['enid'] ?? 0);

if (isset($_POST['send_enquiry'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $desc = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['logid'];
    
    if ($enid > 0 && !empty($desc)) {
        $q = "INSERT INTO enquiry (user_id, package_id, description, datetime, reply) 
              VALUES (?, ?, ?, now(), 'pending')";
        secure_execute($q, 'iis', [$user_id, $enid, $desc]);
        $success = "Your enquiry has been submitted successfully.";
    } else {
        $error = "Please write a description for your enquiry.";
    }
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-question-circle"></i> Send Enquiry</h2>
  </div>

  <div class="ts-form-card" style="margin-top:20px;">
    <?php if ($error): ?>
      <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="ts-alert ts-alert-success"><i class="fa fa-check-circle"></i> <?php echo esc($success); ?></div>
    <?php endif; ?>

    <form method="post">
      <?php csrf_field(); ?>
      
      <div class="ts-input-group">
        <label for="e-desc">Enquiry Details</label>
        <textarea id="e-desc" name="description" class="ts-input ts-textarea" placeholder="Ask your question here..." required></textarea>
      </div>
      
      <button type="submit" name="send_enquiry" class="ts-btn ts-btn-primary ts-btn-full">
        Submit Enquiry <i class="fa fa-paper-plane"></i>
      </button>
    </form>
    
    <div class="ts-text-center" style="margin-top: 20px;">
      <a href="user_view_places_and_packages.php" class="ts-btn ts-btn-outline"><i class="fa fa-arrow-left"></i> Back to Packages</a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>