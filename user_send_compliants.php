<?php include 'user_header.php'; ?>

<?php 
$success = '';
$error = '';

if (isset($_POST['sent_complaint'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $package_name = (int)($_POST['package_name'] ?? 0);
    $complaint_desc = trim($_POST['complaint_description'] ?? '');
    $user_id = $_SESSION['logid'];
    
    if ($package_name > 0 && !empty($complaint_desc)) {
        $q = "INSERT INTO complaint (package_id, user_id, complaint_description, datetime, reply_description) 
              VALUES (?, ?, ?, now(), 'pending')";
        secure_execute($q, 'iis', [$package_name, $user_id, $complaint_desc]);
        $success = "Your complaint has been submitted successfully.";
    } else {
        $error = "Please select a package and write a complaint description.";
    }
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-exclamation-circle"></i> Send Complaint</h2>
  </div>

  <div class="row">
    <div class="col-md-5">
      <div class="ts-form-card" style="margin:0; max-width:100%;">
        <h3 style="font-size:1.2rem; margin-bottom:15px;">New Complaint</h3>
        
        <?php if ($error): ?>
          <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="ts-alert ts-alert-success"><i class="fa fa-check-circle"></i> <?php echo esc($success); ?></div>
        <?php endif; ?>

        <form method="post">
          <?php csrf_field(); ?>
          
          <div class="ts-input-group">
            <label for="c-pkg">Select Package</label>
            <select id="c-pkg" name="package_name" class="ts-input ts-select" required>
              <option value="">-- Choose Package --</option>
              <?php
              $pkgs = secure_select("SELECT package_id, package_title FROM packages WHERE status = 'active'");
              foreach ($pkgs as $pkg) {
                  echo '<option value="' . $pkg['package_id'] . '">' . esc($pkg['package_title']) . '</option>';
              }
              ?>
            </select>
          </div>
          
          <div class="ts-input-group">
            <label for="c-desc">Complaint Description</label>
            <textarea id="c-desc" name="complaint_description" class="ts-input ts-textarea" placeholder="Please describe the issue..." required></textarea>
          </div>
          
          <button type="submit" name="sent_complaint" class="ts-btn ts-btn-primary ts-btn-full">
            Submit Complaint <i class="fa fa-paper-plane"></i>
          </button>
        </form>
      </div>
    </div>
    
    <div class="col-md-7">
      <div class="ts-table-wrap" style="margin:0;">
        <div class="ts-table-title"><i class="fa fa-history"></i> My Complaints History</div>
        <div class="table-responsive">
          <table class="ts-table">
            <thead>
              <tr>
                <th>Package</th>
                <th>Complaint</th>
                <th>Date Submitted</th>
                <th>Status / Reply</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT c.*, p.package_title 
                      FROM complaint c 
                      INNER JOIN packages p ON p.package_id = c.package_id 
                      WHERE c.user_id = ?";
              $res = secure_select($sql, 'i', [$_SESSION['logid']]);
              
              if (empty($res)) {
                  echo '<tr><td colspan="4" class="ts-text-center">No complaints submitted yet.</td></tr>';
              } else {
                  foreach ($res as $row) {
                      $reply = $row['reply_description'];
                      $badge = ($reply === 'pending') ? '<span class="ts-badge ts-badge-pending">Pending</span>' : esc($reply);
                      
                      echo '<tr>
                              <td><strong>'.esc($row['package_title']).'</strong></td>
                              <td>'.esc($row['complaint_description']).'</td>
                              <td>'.esc(date('M d, Y H:i', strtotime($row['datetime']))).'</td>
                              <td>'.$badge.'</td>
                            </tr>';
                  }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>