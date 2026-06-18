<?php include 'user_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-book"></i> My Bookings</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">Booking History</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Package Title</th>
            <th>Booking Details</th>
            <th>Tour Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Payment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT b.*, p.package_title 
                  FROM booking b 
                  INNER JOIN packages p ON p.package_id = b.package_id 
                  WHERE b.user_id = ?
                  ORDER BY b.booking_id DESC";
                  
          $res = secure_select($sql, 'i', [$_SESSION['logid']]);
          
          if (empty($res)) {
              echo '<tr><td colspan="6" class="ts-text-center">You have no bookings yet.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $st = $row['status'];
                  if ($st === 'pending') $badge = 'ts-badge-pending';
                  elseif ($st === 'accept') $badge = 'ts-badge-active';
                  else $badge = 'ts-badge-rejected';
                  
                  // Check if payment exists
                  $pay_check = secure_select("SELECT payment_id FROM payment WHERE booking_id = ?", 'i', [$row['booking_id']]);
                  $is_paid = !empty($pay_check);
                  
                  echo '<tr>
                          <td><strong>'.esc($row['package_title']).'</strong></td>
                          <td>People: '.esc($row['quantity']).'<br><small>Booked: '.esc(date('M d, Y', strtotime($row['booked_date']))).'</small></td>
                          <td>'.esc(date('M d, Y', strtotime($row['tour_date']))).'</td>
                          <td>₹'.esc($row['total_amount']).'</td>
                          <td><span class="ts-badge '.$badge.'">'.esc($st).'</span></td>
                          <td>';
                          
                  if ($is_paid) {
                      echo '<span style="color:var(--success); font-weight:600;"><i class="fa fa-check-circle"></i> Paid</span>';
                  } else {
                      if ($st === 'rejected') {
                          echo '<span class="ts-text-muted">Cancelled</span>';
                      } else {
                          echo '<a href="payment.php?id='.$row['booking_id'].'&amount='.$row['total_amount'].'" class="ts-btn ts-btn-sm ts-btn-primary">Pay Now</a>';
                      }
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