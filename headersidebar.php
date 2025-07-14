<?php
//session_start(); //session shoud checked here
$username=$_SESSION['username'];
$role=$_SESSION['role'];
if($role=='edit'){
  $bgcolor='#87CEEB';
}else{
  $bgcolor='#6F8FAF';
}
//$cata = $_GET['asset'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

   <title><?php echo $cata ?> | Ticket Verification System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="image/gbglogo.png" rel="icon">
  <link href="image/gbglogo.png" rel="touch-icon">
  <!--<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">-->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


<style>
.header, .sidebar {
    background-color: <?php echo $bgcolor; ?> !important;
}

.header {
    /*height: 50px;*/
    margin-bottom: 0px;
}

.sidebar {
    height: 1000px !important;
    min-height: calc(100vh - 50px);
}
</style>




</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block text-white">TVS</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn text-white"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
       <!-- <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>-->
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
          <!--  <i class="bi bi-search"></i>-->
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <!--<i class="bi bi-bell"></i>
            <span class="badge bg-white text-primary badge-number">4</span>-->
          </a><!-- End Notification Icon -->

         <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">-->
             <!-- You have 4 new notifications-->
             <!-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>-->
           <!-- </li>
            <li>
              <hr class="dropdown-divider">
            </li>
          </ul>--><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0 text-white" href="#" data-bs-toggle="dropdown">
            <!--<img src="" alt="Profile" class="rounded-circle">-->
             <?php echo ucfirst ($_SESSION["username"])?>
            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
            
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6 ></h6>
              <?php echo ucfirst ($_SESSION["username"])?>
              <br><span></span>
              <?php echo ucfirst ($_SESSION["role"])?>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>Change Password</span>
              </a>
            </li>
           
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
</body>

</html>
















