<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="asset.php">
          <i class="bi bi-grid"></i>
          <span>Asset</span>
        </a>
      </li>

               
          <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>Account</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="account.php?asset=<?php echo $_SESSION['cata']; ?>">
              <i class="bi bi-circle"></i><span>Manage Account</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Vehicle</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="vehicle.php?asset=<?php echo $_SESSION['cata']; ?>">
              <i class="bi bi-circle"></i><span>vehicle list</span>
            </a>
          </li>        
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Inspection</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="inspectionmanager.php?asset=<?php echo $_SESSION['cata']; ?>">
            <i class="bi bi-circle"></i><span>Manage Inspection Record</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Maintenance</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Manage Mintenance Record</span>
            </a>
          </li>
          <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Add PMS Rule</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </aside>