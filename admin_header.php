<?php
require_once __DIR__ . '/connection.php';

if (!isset($_SESSION['logid'])) {
    header('Location: Login.php');
    exit;
}
?>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/fav.png">
    <meta name="author" content="Travel Shadow">
    <meta name="description" content="Travel Shadow – Admin Panel">
    <meta charset="UTF-8">
    <title>Travel Shadow | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/travel_custom.css">
  </head>
  <body>
    <header id="header">
      <div class="header-top">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-sm-6 col-6 header-top-left"><ul></ul></div>
            <div class="col-lg-6 col-sm-6 col-6 header-top-right">
              <div class="header-social"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="container main-menu">
        <div class="row align-items-center justify-content-between d-flex">
          <div id="logo">
            <a href="admin_home.php">
              <img src="img/logo.png" alt="Travel Shadow" title="Travel Shadow" />
            </a>
          </div>
          <nav id="nav-menu-container">
            <ul class="nav-menu">
              <li><a href="admin_home.php"><i class="fa fa-home"></i> Home</a></li>
              <li><a href="admin_manage_place_categories.php">Categories</a></li>
              <li class="menu-has-children"><a href="">View</a>
                <ul>
                  <li><a href="admin_view_registered_users.php">Registered Users</a></li>
                  <li><a href="admin_View_tour_providers_registration.php">Tour Providers</a></li>
                  <li><a href="admin_view_places.php">Places</a></li>
                  <li><a href="admin_view_packages_details.php">Package Details</a></li>
                  <li><a href="admin_view_bookings.php">Bookings</a></li>
                  <li><a href="admin_view_complaint.php">Complaints</a></li>
                </ul>
              </li>
              <li class="ts-nav-logout"><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <div class="ts-main-content" style="padding-top: 100px; min-height: 70vh;">