  
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php if ((strpos($cu, "index.php") == false) ) { echo 'collapsed';}?>" href="index.php">
          <i class="bi bi-house-door"></i>
          <span>Home</span>
        </a>
      </li><!-- End Dashboard Nav -->
<li class="nav-item">
      <a class="nav-link <?php if ((strpos($cu, "manage-items.php") == false) ) { echo 'collapsed';}?>" href="manage-items.php">                 
      <i class="bi bi-layout-text-window-reverse"></i><span>Tickets</span>         
        </a>       
      </li>
   <li class="nav-item">
      <a class="nav-link <?php if ((strpos($cu, "ticket-registration.php") == false) ) { echo 'collapsed';}?>" href="ticket-registration.php">                 
      <i class="bi bi-plus"></i><span>New Ticket</span>         
        </a>       
      </li>
    
      <li class="nav-item">
      <a class="nav-link <?php if ((strpos($cu, "ticket-verification-form.php") == false) ) { echo 'collapsed';}?>" href="ticket-verification-form.php">                 
      <i class="bi bi-calendar-check"></i><span>Check-In</span>         
        </a>       
      </li>
      <li class="nav-item">
      <a class="nav-link <?php if ((strpos($cu, "checkin-record.php") == false) ) { echo 'collapsed';}?>" href="checkin-record.php">                 
      <i class="bi bi-person"></i><span>Used Tickets</span>         
        </a>       
      </li>
      <li class="nav-item">
      <a class="nav-link <?php if ((strpos($cu, "sold-record.php") == false) ) { echo 'collapsed';}?>" href="sold-record.php">                 
      <i class="bi bi-cart"></i><span>Out Of Stock</span>         
        </a>       
      </li>
      <button type="button" class="btn btn-success bi bi-chevron-double-left mb-2">
                <a class="text-white" href="javascript:history.go(-1)">Back</a><span class="badge bg-white text-dark"></span>
              </button>
      
  </aside>