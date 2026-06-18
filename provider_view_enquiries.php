<?php include 'provider_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-comments"></i> View Enquiries</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">User Enquiries for My Packages</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Package</th>
            <th>Enquiry Description</th>
            <th>Date Submitted</th>
            <th>Reply Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $id = $_SESSION['logid'];
          $providerInfo = secure_select("SELECT tour_provider_id FROM tour_providers WHERE login_id = ?", 'i', [$id]);
          $provider_id = !empty($providerInfo) ? $providerInfo[0]['tour_provider_id'] : 0;

          if ($provider_id > 0) {
              $sql = "SELECT e.*, u.first_name, u.last_name, p.package_title 
                      FROM enquiry e 
                      INNER JOIN user u ON u.login_id = e.user_id 
                      INNER JOIN packages p ON p.package_id = e.package_id 
                      WHERE p.tour_provider_id = ?
                      ORDER BY e.enquiry_id DESC";
              $res = secure_select($sql, 'i', [$provider_id]);
              
              if (empty($res)) {
                  echo '<tr><td colspan="6" class="ts-text-center">No enquiries found.</td></tr>';
              } else {
                  foreach ($res as $row) {
                      $reply = $row['reply'];
                      $badge = ($reply === 'pending') ? '<span class="ts-badge ts-badge-pending">Pending</span>' : '<span class="ts-badge ts-badge-active">Replied</span>';
                      
                      echo '<tr>
                              <td><strong>'.esc($row['first_name'].' '.$row['last_name']).'</strong></td>
                              <td>'.esc($row['package_title']).'</td>
                              <td>'.esc($row['description']).'</td>
                              <td>'.esc(date('M d, Y H:i', strtotime($row['datetime']))).'</td>
                              <td>'.$badge.'</td>
                              <td>';
                              
                      if ($reply === 'pending') {
                          echo '<a href="provider_send_reply.php?id='.$row['enquiry_id'].'" class="ts-btn ts-btn-sm ts-btn-primary">Reply</a>';
                      } else {
                          echo '<span class="ts-text-muted" title="'.esc($reply).'">Replied</span>';
                      }
                      
                      echo '</td></tr>';
                  }
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>