<?php include 'admin_header.php'; ?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-map-marker"></i> All Places</h2>
  </div>

  <div class="ts-card-grid">
    <?php
    $sql = "SELECT * FROM places ORDER BY place_name ASC";
    $res = secure_select($sql, '', []);

    if (empty($res)) {
        echo '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);">
                <h4>No places added to the system yet.</h4>
              </div>';
    } else {
        foreach ($res as $row) {
    ?>
    <div class="ts-pkg-card">
      <div class="ts-pkg-card__img-wrap" style="height: 200px;">
        <div class="ts-pkg-card__overlay"></div>
        <img src="<?php echo esc($row['place_image']); ?>" alt="Place Image">
      </div>

      <div class="ts-pkg-card__body">
        <h4 class="ts-pkg-card__title" style="font-size: 1.4rem; color: var(--primary);">
          <?php echo esc($row['place_name']); ?>
        </h4>
        <p class="ts-pkg-card__desc" style="margin-top: 10px;">
          <?php echo esc($row['description']); ?>
        </p>
        <div style="margin-top:10px; font-family: monospace; color:var(--text-muted);">
          <i class="fa fa-crosshairs"></i> <?php echo esc($row['latitude']); ?>, <?php echo esc($row['longitude']); ?>
        </div>
      </div>
    </div>
    <?php 
        } 
    } 
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>