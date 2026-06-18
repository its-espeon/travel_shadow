<?php include 'user_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-envelope-open-o"></i> Enquiry Replies</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">My Enquiries</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Package</th>
            <th>Enquiry Description</th>
            <th>Date Submitted</th>
            <th>Reply Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT e.*, p.package_title 
                  FROM enquiry e 
                  INNER JOIN packages p ON p.package_id = e.package_id 
                  WHERE e.user_id = ?";
          $res = secure_select($sql, 'i', [$_SESSION['logid']]);
          
          if (empty($res)) {
              echo '<tr><td colspan="4" class="ts-text-center">No enquiries submitted.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $reply = $row['reply'];
                  $badge = ($reply === 'pending') ? '<span class="ts-badge ts-badge-pending">Pending</span>' : esc($reply);
                  
                  echo '<tr>
                          <td><strong>'.esc($row['package_title']).'</strong></td>
                          <td>'.esc($row['description']).'</td>
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

<?php include 'footer.php'; ?>