  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="asset.php">
          <i class="bi bi-grid"></i>
          <span>Asset</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Regular Inspection</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
          <a href="inde.php?asset=<?php echo  $_SESSION['cata']; ?>">
              <i class="bi bi-circle"></i><span>Regular Inspection</span>
            </a>
          </li>        
        </ul>
      </li>
      <!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Random Inspection</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
          <a href="randominspection.php?asset=<?php echo $_SESSION['cata']; ?>">
         <!-- <a href="inspection.php?asset=<?php //echo $_SESSION['cata']  ?>">-->
              <i class="bi bi-circle"></i><span>Random Inspection</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#table-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-roadster-line me-1"></i><span>Vehicle</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="table-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
          <a href="vehicle.php?asset=<?php echo $_SESSION['cata']; ?>">
              <i class="bi bi-circle"></i><span>Vehicle List</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-wrench me-1"></i><span>Maintenance</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Update Maintenance</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tab-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tab-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
          <a href="inspreport.php?asset=<?php echo $_SESSION['cata']; ?>">
              <i class="bi bi-circle"></i><span>Inspection Report</span>
            </a>
          </li>
        </ul>
      </li>

    </ul>

  </aside>