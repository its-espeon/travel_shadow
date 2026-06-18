<?php include 'provider_header.php'; ?>

<?php 
$success = '';
$error = '';
$id = (int)($_GET['id'] ?? 0);

if (isset($_POST['send_reply'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $reply = trim($_POST['reply'] ?? '');
    
    if ($id > 0 && !empty($reply)) {
        secure_execute("UPDATE enquiry SET reply = ? WHERE enquiry_id = ?", 'si', [$reply, $id]);
        redirect('provider_view_enquiries.php');
    } else {
        $error = "Please write a reply.";
    }
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-reply"></i> Send Reply</h2>
  </div>

  <div class="ts-form-card">
    <h3 style="font-size:1.2rem; margin-bottom:15px;">Reply to Enquiry</h3>
    
    <?php if ($error): ?>
      <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
    <?php endif; ?>

    <form method="POST">
      <?php csrf_field(); ?>
      
      <div class="ts-input-group">
        <label>Your Reply Message</label>
        <textarea name="reply" class="ts-input ts-textarea" placeholder="Type your response here..." required></textarea>
      </div>

      <button type="submit" name="send_reply" class="ts-btn ts-btn-primary ts-btn-full">
        Send Reply <i class="fa fa-paper-plane"></i>
      </button>
      
      <div class="ts-text-center" style="margin-top: 20px;">
        <a href="provider_view_enquiries.php" class="ts-btn ts-btn-outline"><i class="fa fa-arrow-left"></i> Cancel</a>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>