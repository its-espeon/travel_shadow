<?php
require_once __DIR__ . '/connection.php';
// If already logged in, redirect appropriately
if (isset($_SESSION['logid'])) {
    $rows = secure_select("SELECT type FROM login WHERE log_id = ?", 'i', [$_SESSION['logid']]);
    if (!empty($rows)) {
        $type = $rows[0]['type'];
        if ($type === 'admin') redirect('admin_home.php');
        elseif ($type === 'user') redirect('user_home.php');
        elseif ($type === 'tour_providers') redirect('provider_home.php');
    }
}
include 'public_header.php'; 
?>
<!-- start banner Area -->
<section class="banner-area relative">
  <div class="overlay overlay-bg"></div>        
  <div class="container">
    <div class="row fullscreen align-items-center justify-content-between">
      <div class="col-lg-6 col-md-6 banner-left">
        <h6 class="text-white">Away from monotonous life</h6>
        <h1 class="text-white">Travel Shadow</h1>
        <p class="text-white" style="font-size: 1.1rem; line-height: 1.6;">
          "Better to see something once than hear about it a thousand times."
        </p>
        <a href="Login.php" class="ts-btn ts-btn-primary" style="margin-top: 20px;">Get Started</a>
      </div>
    </div>
  </div>          
</section>
<!-- End banner Area -->

<!-- Start popular-destination Area -->
<section class="popular-destination-area section-gap">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="menu-content pb-70 col-lg-8">
        <div class="title ts-text-center">
          <h2 class="mb-10" style="color: var(--primary);">Popular Destinations</h2>
          <p class="ts-text-muted">We all live in an age that belongs to the young at heart. Life that is becoming extremely fast.</p>
        </div>
      </div>
    </div>            
    <div class="ts-card-grid">
      <div class="ts-pkg-card">
        <div class="ts-pkg-card__img-wrap">
          <div class="ts-pkg-card__overlay"></div>
          <img src="img/d1.jpg" alt="Mountain River">
        </div>
        <div class="ts-pkg-card__body">
          <h4 class="ts-pkg-card__title">Mountain River</h4>
          <span class="ts-pkg-card__provider">Idukki</span>
        </div>
      </div>
      <div class="ts-pkg-card">
        <div class="ts-pkg-card__img-wrap">
          <div class="ts-pkg-card__overlay"></div>
          <img src="img/d2.jpg" alt="Dream Cities">
        </div>
        <div class="ts-pkg-card__body">
          <h4 class="ts-pkg-card__title">Dream Cities</h4>
          <span class="ts-pkg-card__provider">Various Locations</span>
        </div>
      </div> 
      <div class="ts-pkg-card">
        <div class="ts-pkg-card__img-wrap">
          <div class="ts-pkg-card__overlay"></div>
          <img src="img/d3.jpg" alt="Cloud Mountain">
        </div>
        <div class="ts-pkg-card__body">
          <h4 class="ts-pkg-card__title">Cloud Mountain</h4>
          <span class="ts-pkg-card__provider">Munnar</span>
        </div>
      </div>                        
    </div>
  </div>  
</section>
<!-- End popular-destination Area -->

<!-- Start other-issue Area -->
<section class="other-issue-area section-gap" style="background: rgba(255,255,255,0.02);">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="menu-content pb-70 col-lg-9">
        <div class="title ts-text-center">
          <h2 class="mb-10" style="color: var(--primary);">Celebrate your adventure</h2>
          <p class="ts-text-muted">Discover new ways to experience the world.</p>
        </div>
      </div>
    </div>          
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-30">
        <div class="ts-pkg-card" style="height: 100%;">
          <div class="ts-pkg-card__img-wrap" style="height: 160px;">
            <img src="img/o1.jpg" alt="Vintage">
          </div>
          <div class="ts-pkg-card__body text-center">
            <h4 class="ts-pkg-card__title" style="color: var(--primary); margin-bottom:10px;">Vintage</h4>
            <p class="ts-pkg-card__desc">The preservation of human life is the ultimate value.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-30">
        <div class="ts-pkg-card" style="height: 100%;">
          <div class="ts-pkg-card__img-wrap" style="height: 160px;">
            <img src="img/o2.jpg" alt="Cruise">
          </div>
          <div class="ts-pkg-card__body text-center">
            <h4 class="ts-pkg-card__title" style="color: var(--primary); margin-bottom:10px;">Cruise</h4>
            <p class="ts-pkg-card__desc">Enjoy the vast ocean waves in pure luxury.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-30">
        <div class="ts-pkg-card" style="height: 100%;">
          <div class="ts-pkg-card__img-wrap" style="height: 160px;">
            <img src="img/o3.jpg" alt="Memories">
          </div>
          <div class="ts-pkg-card__body text-center">
            <h4 class="ts-pkg-card__title" style="color: var(--primary); margin-bottom:10px;">Memories</h4>
            <p class="ts-pkg-card__desc">Make moments that last a lifetime with us.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-30">
        <div class="ts-pkg-card" style="height: 100%;">
          <div class="ts-pkg-card__img-wrap" style="height: 160px;">
            <img src="img/o4.jpg" alt="Food">
          </div>
          <div class="ts-pkg-card__body text-center">
            <h4 class="ts-pkg-card__title" style="color: var(--primary); margin-bottom:10px;">Food</h4>
            <p class="ts-pkg-card__desc">Taste culinary delights from all around the globe.</p>
          </div>
        </div>
      </div>                                    
    </div>
  </div>  
</section>
<!-- End other-issue Area -->

<?php include 'footer.php'; ?>