<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$cata = $_GET['asset'];
$pnn=$_GET['pn'];
$date=$_GET['date'];  
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AIS | Asset Inspection System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <?php 
  $comp = $_SESSION['company'];
  $sql= "select * from comp where name = '$comp'";
  $result = $conn1->query($sql);
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/Hagbeslogo.jpg" rel="touch-icon">
<?php 
}
}
?>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <style>
th, td {
  border: 1px solid black; 
}

  </style>

</head>

<body>

 <?php include('../headersidebar.php');?>
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
      <i class="bi bi-menu-button-wide"></i><span><?php echo $_SESSION['cata']; ?></span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
       <!-- <a href="#">-->
      <a href="inde.php?asset=<?php echo $_SESSION['cata']; ?>">
          <i class="bi bi-circle"></i><span><?php echo $_SESSION['cata']; ?></span>
        </a>
      </li>        
    </ul>
  </li>
  <!-- End Components Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Inspection</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="#">
      <!--<a href="inspection.php?asset=<?php echo $_SESSION['cata']; ?>">-->
          <a href="inspection.php?asset=<?php echo $_SESSION['cata']; ?>">
          <i class="bi bi-circle"></i><span>Inspection_Form</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Maintenance</span><i class="bi bi-chevron-down ms-auto"></i>
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

  <main id="main" class="main">

     <div class="pagetitle text-center">
      <h1>Maintenance Schedule Control Sheet</h1>
    
    </div><!-- End Page Title -->

   
    <div class="col-lg-12">
     <div class="card">
            <div class="card-header"> 
            <span class=""> Vehicle</span>                    
               </div>
            <div class="card-body">
       <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            
          <?php 
                  $sql ="SELECT * FROM `vehicle` LIMIT 1";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                     
                    if ($result->num_rows > 0) {
                      
                    while($ro = $result->fetch_assoc()) {
                     
                
                 $sql = "SELECT model,plateno,driver,company,MAX(	checked_at_odo) AS checked FROM `Maintenance` where plateno='$pnn' AND update_date='$date'  LIMIT 1" ;
              
                 $result = $conn->query($sql);

                  if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()){
              echo'
              <div class="col-lg-4">
            <span  style ="color:#012970;">Model:&nbsp'. $row["model"].'</span><br>
            <span style ="color:#012970;">Plate No:&nbsp'. $row["plateno"].'</span>                  
            </div>
            
           <div class="col-lg-4">
          <span style ="color:#012970;">Driver:&nbsp'. $row["driver"].'</span><br>
          <span style ="color:#012970;">Company:&nbsp'. $row["company"].'</span>
                   
        </div>
           <div class="col-lg-4">
            <span style ="color:#012970;">Checked at odometer:&nbsp'.$row["checked"].'</span><br>
            <span style ="color:#012970;">Current Millage:&nbsp'.$ro["odometer_km_reading"] .'</span>
            </div>';
          }
        }
      }
    }
  }
            ?>
           
        </div>
      </div>
    </section>                       
          </div>

        </div>
      </div> 
  
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          

          

              <!-- Default Table -->
                <div class="card">
                	<div class="card-header">add rule</div>
            <div class="card-body">
              
             
            
              <!-- Bordered Table -->
              <br><table class="table" border='1px'>
               
                <tbody >
                  <tr border='1px'>
                  <th rowspan="2" style="text-align:center"  class="col-2" >Description</th>
                   <th rowspan="2" style="text-align:center" class="col-2" >Inspect/Replace Interval</th>
                   <th style="text-align:center" colspan="2">service Interval (km)</th>      
                  </tr>
                  <tr>
                  <?php 
                 $types=array('Engine','Air, Fuel and Exhaust','Electrical');
                 
                 $flag = true;
                // foreach($types as $t){
                 $sql = "SELECT * from pmsrule where `type`='engine'";
                 $result = $conn->query($sql);
                   $count = 1;
                   $min=60000;//dynamic
                   if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc())
                    {
                      $sql2 ="SELECT * FROM `maintenance` where `plateno`='$pnn' AND `description`= '".$row['type-description']."' AND 	checked_at_odo='$min' GROUP BY checked_at_odo ";
                      $res = $conn->query($sql2);
                      if ($res->num_rows > 0) {
                      while($ro = $res->fetch_assoc())
                      {
                        if($flag){
                        ?>
                        
                        <th colspan="2"><?php echo $ro['checked_at_odo'];?></th></tr> 
                        <th colspan="4" style="text-align:center;background-color:#FF6347;"><?php echo $ro['type']?></th>
                        </tr>
                           <?php 
                          $flag = false;
                          //echo '<script>alert("'.$t.'")</script>';
                       }
                        ?>
                          <tr>
                          <td><?php echo $row['type-description']?></td>
                          <td><?php echo  ($row['every_interval']!='')? $row['action']." every ".$row['every_interval'] : $row['action']." at ".$row['at'] ?></td>
                          <td><?php echo $row['action']?></td>
                        <?php
                        if($row['at']==$ro['pms_reading'] || ($row['every_interval']!='' && $ro['pms_reading'] % $row['every_interval']==0)){

                           ?>

                          
                          <td> <?php if($ro['job_status']=='done'){?>
                            <i class="bi bi-check 20x text-success" style="font-size:30px"></i>
                          <?php }else{?>
                            <i class="bi bi-x text-danger" style="font-size:30px"></i>
                          <?php }?>
                        </td>
                        </tr>
                    
                   <?php  }else{?>
                       <td></td>
                       
                   </tr>
                 <?php   }
                      }
                    }
                }
              
              }
               ?>
              </tbody>
            </table>
              <!-- End Bordered Table -->
<div class="text-center">                
  <button class='btn btn-primary' name='submit'  type='submit'>Submit</button>
</div>                   
</div>
</div>










 </main><!-- End #main -->

  
<?php include('../footer.html');?>

  


    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>
<?php }else{
  header("location:../index.php");
}