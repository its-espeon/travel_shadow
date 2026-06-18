<?php include 'admin_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-users"></i> Registered Users</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">All Users</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>House Name</th>
            <th>Location</th>
            <th>Contact</th>
            <th>Gender</th>
            <th>Date of Birth</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM user ORDER BY user_id DESC";
          $res = secure_select($sql, '', []);
          
          if (empty($res)) {
              echo '<tr><td colspan="6" class="ts-text-center">No users registered yet.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $location = esc($row['place']) . ', ' . esc($row['district']) . ' - ' . esc($row['pincode']);
                  $contact = '<a href="mailto:'.esc($row['email']).'" style="color:var(--primary);">'.esc($row['email']).'</a><br>'.esc($row['phone']);
                  
                  echo '<tr>
                          <td><strong>'.esc($row['first_name']).' '.esc($row['last_name']).'</strong></td>
                          <td>'.esc($row['house_name']).'</td>
                          <td><small>'.$location.'</small></td>
                          <td><small>'.$contact.'</small></td>
                          <td style="text-transform:capitalize;">'.esc($row['gender']).'</td>
                          <td>'.esc($row['date_of_birth']).'</td>
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