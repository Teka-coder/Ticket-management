<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="asset.php">
        <i class="bx bxs-dollar-circle"></i>
        <span>Asset</span>
      </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
    <a class="nav-link " href="dashboard.php?asset=<?php echo  $_SESSION['cata']; ?>">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Forms Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-search"></i><span>Inspection</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>

      <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
        <a href="inde.php?asset=<?php echo  $_SESSION['cata'];?>&type=regular">
            <i class="bi bi-circle"></i><span>Regular Inspection</span>
          </a>
        </li>        
      </ul>

      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="inde.php?asset=<?php echo $_SESSION['cata']?>&type=random">
            <i class="bi bi-circle"></i><span>Random Inspection</span>
          </a>
        </li>
      </ul>

      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="inspreport.php?asset=<?php echo  $_SESSION['cata'];?>">
       <!-- <a href="inspection.php?asset=<?php //echo $_SESSION['cata']  ?>">-->
            <i class="bi bi-circle"></i><span>Inspection Report</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Components Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-tools"></i><span>Maintenance</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Maintenance_Report</span>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>