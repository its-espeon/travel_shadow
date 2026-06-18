<?php require_once __DIR__ . '/config.php'; ?>
    </div> <!-- Close main content wrapper -->
    <footer class="footer-area section-gap" style="margin-top: 60px;">
      <div class="container">
        <div class="row footer-bottom d-flex justify-content-between align-items-center">
          <p class="col-lg-8 col-sm-12 footer-text m-0" style="color: var(--text-muted); font-size: 0.85rem;">
            Copyright &copy; <script>document.write(new Date().getFullYear());</script> Travel Shadow. All rights reserved.
          </p>
          <div class="col-lg-4 col-sm-12 footer-social">
            <a href="#" style="color: var(--primary); margin-left: 15px;"><i class="fa fa-facebook"></i></a>
            <a href="#" style="color: var(--primary); margin-left: 15px;"><i class="fa fa-twitter"></i></a>
            <a href="#" style="color: var(--primary); margin-left: 15px;"><i class="fa fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>      
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars(GOOGLE_MAPS_KEY); ?>"></script>   
    <script src="js/jquery-ui.js"></script>         
    <script src="js/easing.min.js"></script>      
    <script src="js/hoverIntent.js"></script>
    <script src="js/superfish.min.js"></script> 
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>           
    <script src="js/jquery.nice-select.min.js"></script>          
    <script src="js/owl.carousel.min.js"></script>              
    <script src="js/mail-script.js"></script> 
    <script src="js/main.js"></script>  
  </body>
</html>