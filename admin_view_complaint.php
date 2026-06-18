<?php include 'admin_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-exclamation-circle"></i> View Complaints</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">All User Complaints</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Package</th>
            <th>Provider</th>
            <th>Complaint Description</th>
            <th>Date Submitted</th>
            <th>Reply Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT c.*, u.first_name, u.last_name, p.package_title, tp.name as provider_name 
                  FROM complaint c 
                  INNER JOIN user u ON u.login_id = c.user_id 
                  INNER JOIN packages p ON p.package_id = c.package_id 
                  INNER JOIN tour_providers tp ON tp.tour_provider_id = p.tour_provider_id
                  ORDER BY c.complaint_id DESC";
          $res = secure_select($sql, '', []);
          
          if (empty($res)) {
              echo '<tr><td colspan="7" class="ts-text-center">No complaints found.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $reply = $row['reply_description'];
                  $badge = ($reply === 'pending') ? '<span class="ts-badge ts-badge-pending">Pending</span>' : '<span class="ts-badge ts-badge-active">Replied</span>';
                  
                  echo '<tr>
                          <td><strong>'.esc($row['first_name'].' '.$row['last_name']).'</strong></td>
                          <td>'.esc($row['package_title']).'</td>
                          <td>'.esc($row['provider_name']).'</td>
                          <td>'.esc($row['complaint_description']).'</td>
                          <td>'.esc(date('M d, Y H:i', strtotime($row['datetime']))).'</td>
                          <td>'.$badge.'</td>
                          <td>';
                          
                  if ($reply === 'pending') {
                      echo '<a href="admin_send_reply.php?id='.$row['complaint_id'].'" class="ts-btn ts-btn-sm ts-btn-primary">Reply</a>';
                  } else {
                      echo '<span class="ts-text-muted" title="'.esc($reply).'">Replied</span>';
                  }
                  
                  echo '</td></tr>';
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>