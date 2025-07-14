<?php 
$username=$_SESSION['username'];
$role=$_SESSION['role'];
//$cata = $_GET['asset'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <style>
.sidebar{
  height: 1000px !important;
 min-height: calc(100vh - 50px);

}
</style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
  <div  class="logo d-flex align-items-center">
      <span class="">TVS</span>
   </div>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
     
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
           
          
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li>
              <hr class="dropdown-divider">
            </li>
          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
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
              <a class="dropdown-item d-flex align-items-center" href="changepass.php">
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

















