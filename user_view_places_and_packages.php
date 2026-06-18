<?php include 'user_header.php'; ?>

<?php
if (isset($_GET['favid'])) {
    // Basic validation
    $favid = (int) $_GET['favid'];
    if ($favid > 0) {
        $check = secure_select("SELECT favourite_id FROM favourite WHERE package_id = ? AND user_id = ?", 'ii', [$favid, $_SESSION['logid']]);
        if (empty($check)) {
            secure_execute("INSERT INTO favourite (package_id, user_id) VALUES (?, ?)", 'ii', [$favid, $_SESSION['logid']]);
        }
        redirect('user_view_places_and_packages.php');
    }
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-suitcase"></i> Explore Packages</h2>
  </div>

  <div class="ts-card-grid">
    <?php
    $sql = "SELECT p.*, tp.name as provider_name, c.category_name 
            FROM packages p
            INNER JOIN tour_providers tp ON tp.tour_provider_id = p.tour_provider_id 
            INNER JOIN categories c ON c.category_id = p.category_id 
            WHERE p.status = 'active'";
    $res = secure_select($sql);

    foreach ($res as $row) {
        $package_id = $row['package_id'];
        
        // Check if favourite
        $favCheck = secure_select("SELECT favourite_id FROM favourite WHERE package_id = ? AND user_id = ?", 'ii', [$package_id, $_SESSION['logid']]);
        $isFav = !empty($favCheck);
    ?>
    <div class="ts-pkg-card">
      <div class="ts-pkg-card__img-wrap">
        <div class="ts-pkg-card__overlay"></div>
        <span class="ts-badge ts-badge-active ts-pkg-card__category" style="background:var(--primary); color:#111; border:none; z-index:2;">
          <?php echo esc($row['category_name']); ?>
        </span>
        <img src="<?php echo esc($row['package_image']); ?>" alt="Package Image">
      </div>

      <div class="ts-pkg-card__body">
        <h4 class="ts-pkg-card__title"><?php echo esc($row['package_title']); ?></h4>
        <span class="ts-pkg-card__provider"><i class="fa fa-building-o"></i> <?php echo esc($row['provider_name']); ?></span>
        <span class="ts-pkg-card__provider"><i class="fa fa-map-marker"></i> <?php echo esc($row['places_included']); ?></span>
        
        <p class="ts-pkg-card__desc"><?php echo esc($row['description']); ?></p>
        
        <div class="ts-pkg-card__amount">
          ₹<?php echo esc($row['amount']); ?> <span>/ person</span>
        </div>
      </div>

      <div class="ts-pkg-card__actions">
        <a href="user_make_booking.php?title=<?php echo urlencode($row['package_title']); ?>&description=<?php echo urlencode($row['description']); ?>&amount=<?php echo urlencode($row['amount']); ?>&bid=<?php echo $package_id; ?>" class="ts-btn ts-btn-primary" style="flex:1; padding: 8px;">
          Book Now
        </a>
        <a href="user_images.php?id=<?php echo $package_id; ?>" class="ts-btn ts-btn-outline" title="Gallery" style="padding: 8px 12px;">
          <i class="fa fa-picture-o"></i>
        </a>
        <a href="user_send_enquiries.php?enid=<?php echo $package_id; ?>" class="ts-btn ts-btn-outline" title="Enquiry" style="padding: 8px 12px;">
          <i class="fa fa-question"></i>
        </a>
        <?php if ($isFav): ?>
          <span class="ts-btn ts-btn-outline" style="padding: 8px 12px; cursor:default; border-color:#ff6b7a; color:#ff6b7a;" title="Favourited">
            <i class="fa fa-heart"></i>
          </span>
        <?php else: ?>
          <a href="user_view_places_and_packages.php?favid=<?php echo $package_id; ?>" class="ts-btn ts-btn-outline" style="padding: 8px 12px;" title="Add to Favourites">
            <i class="fa fa-heart-o"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<?php include 'footer.php'; ?>