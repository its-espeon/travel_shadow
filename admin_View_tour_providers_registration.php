<?php include 'admin_header.php'; ?>

<?php
// Handle status changes securely
if (isset($_GET['id']) && isset($_GET['log_id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $log_id = (int)$_GET['log_id'];
    $new_status = ($_GET['status'] === 'active') ? 'reject' : 'active';
    
    // Update both tables securely
    secure_execute("UPDATE login SET login_status = ? WHERE log_id = ?", 'si', [$new_status, $log_id]);
    secure_execute("UPDATE tour_providers SET status = ? WHERE tour_provider_id = ?", 'si', [$new_status, $id]);
    
    redirect('admin_view_tour_providers_registration.php');
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-building"></i> Tour Providers</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">Registered Tour Providers</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Company Name</th>
            <th>Location</th>
            <th>Email</th>
            <th>Phone</th>
            <th>About</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM tour_providers";
          $res = secure_select($sql, '', []);
          
          if (empty($res)) {
              echo '<tr><td colspan="7" class="ts-text-center">No tour providers registered yet.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $badge = ($row['status'] === 'active') ? 'ts-badge-active' : 'ts-badge-rejected';
                  
                  echo '<tr>
                          <td><strong>'.esc($row['name']).'</strong></td>
                          <td>'.esc($row['place']).'</td>
                          <td><a href="mailto:'.esc($row['email']).'" style="color:var(--primary);">'.esc($row['email']).'</a></td>
                          <td>'.esc($row['phone']).'</td>
                          <td><small>'.esc($row['about']).'</small></td>
                          <td><span class="ts-badge '.$badge.'">'.esc($row['status']).'</span></td>
                          <td>
                            <a href="admin_view_tour_providers_registration.php?log_id='.$row['login_id'].'&status='.esc($row['status']).'&id='.$row['tour_provider_id'].'" class="ts-btn ts-btn-sm ts-btn-outline">
                              Toggle Status
                            </a>
                          </td>
                        </tr>';
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>