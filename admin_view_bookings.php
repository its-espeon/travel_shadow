<?php include 'admin_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-calendar-check-o"></i> View Bookings</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">All System Bookings</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Package</th>
            <th>Provider</th>
            <th>People</th>
            <th>Total Amount</th>
            <th>Booked Date</th>
            <th>Tour Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT b.*, u.first_name, u.last_name, p.package_title, tp.name as provider_name 
                  FROM booking b 
                  INNER JOIN user u ON u.login_id = b.user_id 
                  INNER JOIN packages p ON p.package_id = b.package_id 
                  INNER JOIN tour_providers tp ON tp.tour_provider_id = p.tour_provider_id
                  ORDER BY b.booking_id DESC";
                  
          $res = secure_select($sql, '', []);
          
          if (empty($res)) {
              echo '<tr><td colspan="9" class="ts-text-center">No bookings found.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $st = $row['status'];
                  if ($st === 'pending') $badge = 'ts-badge-pending';
                  elseif ($st === 'accept') $badge = 'ts-badge-active';
                  else $badge = 'ts-badge-rejected';
                  
                  echo '<tr>
                          <td>#'.esc($row['booking_id']).'</td>
                          <td><strong>'.esc($row['first_name'].' '.$row['last_name']).'</strong></td>
                          <td>'.esc($row['package_title']).'</td>
                          <td>'.esc($row['provider_name']).'</td>
                          <td>'.esc($row['quantity']).'</td>
                          <td>₹'.esc($row['total_amount']).'</td>
                          <td>'.esc(date('M d, Y', strtotime($row['booked_date']))).'</td>
                          <td>'.esc(date('M d, Y', strtotime($row['tour_date']))).'</td>
                          <td><span class="ts-badge '.$badge.'">'.esc($st).'</span></td>
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