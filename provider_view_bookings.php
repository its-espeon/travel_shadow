<?php include 'provider_header.php'; ?>

<?php
$id = $_SESSION['logid'];
// Get actual tour_provider_id
$providerInfo = secure_select("SELECT tour_provider_id FROM tour_providers WHERE login_id = ?", 'i', [$id]);
$provider_id = !empty($providerInfo) ? $providerInfo[0]['tour_provider_id'] : 0;

if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = $_GET['status'] === 'accept' ? 'accept' : 'rejected';
    secure_execute("UPDATE booking SET status = ? WHERE booking_id = ?", 'si', [$status, (int)$_GET['id']]);
    redirect('provider_view_bookings.php');
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-calendar-check-o"></i> View Bookings</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">Bookings for My Packages</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Package</th>
            <th>People</th>
            <th>Amount</th>
            <th>Booked Date</th>
            <th>Tour Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($provider_id > 0) {
              $sql = "SELECT b.*, u.first_name, u.last_name, p.package_title 
                      FROM booking b 
                      INNER JOIN user u ON u.login_id = b.user_id 
                      INNER JOIN packages p ON p.package_id = b.package_id 
                      WHERE p.tour_provider_id = ?
                      ORDER BY b.booking_id DESC";
              
              $res = secure_select($sql, 'i', [$provider_id]);
              
              if (empty($res)) {
                  echo '<tr><td colspan="8" class="ts-text-center">No bookings found.</td></tr>';
              } else {
                  foreach ($res as $row) {
                      $st = $row['status'];
                      if ($st === 'pending') $badge = 'ts-badge-pending';
                      elseif ($st === 'accept') $badge = 'ts-badge-active';
                      else $badge = 'ts-badge-rejected';
                      
                      echo '<tr>
                              <td><strong>'.esc($row['first_name'].' '.$row['last_name']).'</strong></td>
                              <td>'.esc($row['package_title']).'</td>
                              <td>'.esc($row['quantity']).'</td>
                              <td>₹'.esc($row['total_amount']).'</td>
                              <td>'.esc(date('M d, Y', strtotime($row['booked_date']))).'</td>
                              <td>'.esc(date('M d, Y', strtotime($row['tour_date']))).'</td>
                              <td><span class="ts-badge '.$badge.'">'.esc($st).'</span></td>
                              <td>';
                              
                      if ($st === 'pending') {
                          echo '<a href="provider_view_bookings.php?status=accept&id='.$row['booking_id'].'" class="ts-btn ts-btn-sm ts-btn-success" style="margin-right:4px;">Accept</a>
                                <a href="provider_view_bookings.php?status=reject&id='.$row['booking_id'].'" class="ts-btn ts-btn-sm ts-btn-danger">Reject</a>';
                      } else {
                          echo '<span class="ts-text-muted">Processed</span>';
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