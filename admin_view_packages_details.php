<?php include 'admin_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-suitcase"></i> All Tour Packages</h2>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">System Packages</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Provider</th>
            <th>Category</th>
            <th>Places Included</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT p.*, tp.name as provider_name, c.category_name 
                  FROM packages p 
                  INNER JOIN tour_providers tp ON tp.tour_provider_id = p.tour_provider_id 
                  INNER JOIN categories c ON c.category_id = p.category_id
                  ORDER BY p.package_id DESC";
                  
          $res = secure_select($sql, '', []);
          
          if (empty($res)) {
              echo '<tr><td colspan="7" class="ts-text-center">No packages available.</td></tr>';
          } else {
              foreach ($res as $row) {
                  $badge = ($row['status'] === 'active') ? 'ts-badge-active' : 'ts-badge-rejected';
                  
                  echo '<tr>
                          <td><img src="'.esc($row['package_image']).'" style="width:60px; height:60px; border-radius:4px; object-fit:cover;"></td>
                          <td><strong>'.esc($row['package_title']).'</strong></td>
                          <td><i class="fa fa-building-o" style="color:var(--text-muted);"></i> '.esc($row['provider_name']).'</td>
                          <td>'.esc($row['category_name']).'</td>
                          <td><small>'.esc($row['places_included']).'</small></td>
                          <td>₹'.esc($row['amount']).'</td>
                          <td><span class="ts-badge '.$badge.'">'.esc($row['status']).'</span></td>
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