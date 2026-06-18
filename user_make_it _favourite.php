<?php include 'user_header.php'; ?>

<?php
if (isset($_GET['removeid'])) {
    $favid = (int)$_GET['removeid'];
    secure_execute("DELETE FROM favourite WHERE favourite_id = ? AND user_id = ?", 'ii', [$favid, $_SESSION['logid']]);
    redirect('user_make_it _favourite.php');
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-heart"></i> My Favourites</h2>
  </div>

  <div class="ts-card-grid">
    <?php
    $sql = "SELECT f.favourite_id, p.*, tp.name as provider_name, c.category_name 
            FROM favourite f
            INNER JOIN packages p ON p.package_id = f.package_id 
            INNER JOIN tour_providers tp ON tp.tour_provider_id = p.tour_provider_id 
            INNER JOIN categories c ON c.category_id = p.category_id 
            WHERE f.user_id = ?";
            
    $res = secure_select($sql, 'i', [$_SESSION['logid']]);

    if (empty($res)) {
        echo '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);">
                <i class="fa fa-heart-o" style="font-size: 3rem; margin-bottom: 16px; display: block; opacity: 0.5;"></i>
                <h4>No favourites yet.</h4>
                <p>Start exploring and save your favourite packages here!</p>
                <a href="user_view_places_and_packages.php" class="ts-btn ts-btn-primary" style="margin-top:16px;">Explore Packages</a>
              </div>';
    } else {
        foreach ($res as $row) {
            $favourite_id = $row['favourite_id'];
            $package_id = $row['package_id'];
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
        
        <p class="ts-pkg-card__desc"><?php echo esc($row['description']); ?></p>
        
        <div class="ts-pkg-card__amount">
          ₹<?php echo esc($row['amount']); ?> <span>/ person</span>
        </div>
      </div>

      <div class="ts-pkg-card__actions">
        <a href="user_make_booking.php?title=<?php echo urlencode($row['package_title']); ?>&description=<?php echo urlencode($row['description']); ?>&amount=<?php echo urlencode($row['amount']); ?>&bid=<?php echo $package_id; ?>" class="ts-btn ts-btn-primary" style="flex:1;">
          Book Now
        </a>
        <a href="user_make_it _favourite.php?removeid=<?php echo $favourite_id; ?>" class="ts-btn ts-btn-outline" style="border-color:#ff6b7a; color:#ff6b7a;" title="Remove from Favourites" onclick="return confirm('Remove from favourites?');">
          <i class="fa fa-trash"></i>
        </a>
      </div>
    </div>
    <?php 
        } 
    } 
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>