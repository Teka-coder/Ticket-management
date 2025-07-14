  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
       <?php 
      $query = "SELECT * from tickets GROUP BY soldout_status";
      $command=$conn->prepare($query);
      $command->execute();
      $result = $command->get_result();
      if (!is_null($result)) { 

        $count=1;              
        while($row = $result->fetch_assoc()) {
          $label1 = $row['soldout_status']; 
          if($label1=='soldout'){
$link1='outstock.php';
          }else{
            $link1='instock.php';
          }

        ?>    
      <li class="nav-item">
        <a class="nav-link " href="<?php echo $link1?>">
          <i class="bi bi-grid"></i>
          <span><?php echo  ucfirst($label1);?></span>
        </a>
      </li>
  <?php  }
      }
$query2 = "SELECT * from tickets GROUP BY checkin_status";
$command2=$conn->prepare($query2);
$command2->execute();
$result2 = $command2->get_result();
if (!is_null($result2)) { 
    $count2=1;              
    while($row2 = $result2->fetch_assoc()) {
      $label2= $row2['checkin_status'];
      if($label2=='checkedin'){
$label2='Used';
$link2='used.php';
      } else{
        $link2='pending.php';
      }
    ?>
  <li class="nav-item">
        <a class="nav-link " href="<?php echo $link2?>">
          <i class="bi bi-grid"></i>
          <span><?php echo  ucfirst($label2).' Tickets';?></span>
        </a>
      </li>
<?php  }

}

          ?>
      
  
  </aside>