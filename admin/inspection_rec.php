<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$cata=$_GET['asset'];
$pnn=$_GET['pn'];
$date=$_GET['date'];
if(isset($_GET['kmbs'])){
  $_SESSION['kmbs']= $_GET['kmbs'];
  } 

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

</head>

<body>

<?php include('../headersidebar.php');?>
<?php include('sidebar.php');?>

  <main id="main" class="main">


    <div class="pagetitle" style="text-align: center">
      <h1>Inspection and Maintenance records</h1>
       <nav>
        <ol class="breadcrumb">
          <li><a href="inde.php?asset=<?php echo $cata;?>"><i class="fa fa-arrow-circle-o-left" style="font-size:36px;color:#87CEEB"></i></a></li>         
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
     <div class="row">
       <div class="col-lg-4 col-md-6">
             <form action ="recoredserver.php" method = "POST">
           
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Days to next inspection <span>| Plate Number:&nbsp;<?php echo $pnn?></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="ps-3">
                     <?php 
                                  
                    if(!isset($_POST['$plateno'])){                   
                    $test = "SELECT Max(nxt_inspection_date) as next FROM `inspection` WHERE plateno= '$pnn' AND catagory='$cata'" ;
                    $result = $conn->query($test);  
                     if ($result->num_rows > 0) {
                     while($row = $result->fetch_assoc()) {
                         $var=$row['next'];
                     
                 $next = strtotime($row['next']);                 
                 $today = strtotime(date("y-m-d"));
                 $count = $next - $today;                         
                 $days_remaining = round($count / (60 * 60 * 24));
                    
                       $remaining= $days_remaining ;                      
                        echo 
                       '<h6>'. $remaining.'</h6>';                                                 
                       }  
                     }       
                 else {
                  echo "<h6>0 results </h6>"; 
                    }              
               }
                  ?> 
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Sales Card -->


   

         <div class=" col-lg-4 col-md-6 mx-auto  me-0">
              <div class="card info-card revenue-card">
                      <?php
                      $test = "SELECT MIN(serviced_at_odo) AS km, driver FROM `inspection` WHERE plateno = '$pnn'";
                        $result = $conn->query($test);  
                         if ($result->num_rows > 0) {                      
                    while($row = $result->fetch_assoc()){
                     $driver = $row['driver']; ?>
              
                <div class="card-body">
                  <h5 class="card-title">Km before next service <span>| Driver:&nbsp;<?php echo $driver?></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-speedometer"></i>
                    </div>
                    <div class="ps-3">

                                 
                        <h6><?php echo $_SESSION['kmbs']?></h6>
                        <?php 
                        break;                          
                           } }
                       
                        else { echo " <h6> 0 results </h6>"; }
                         ?>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->       


          
           
           <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title" style="text-align:center">Monthly Inspection Record</h5>

              <!-- Dark Table -->
              <table id="insp_report" class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Inspection Date</th>
                    <th scope="col">Monthly Inspection Report</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>                  
                    <?php
                   // $model= $_SESSION["plateno"];

                    $sql = "SELECT * FROM `inspection` WHERE plateno='$pnn' ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $count=1;    
                    while($row = $result->fetch_assoc()) {
                      $iid = $row['id'];
                     
                       echo
                         "<th scope='row'>".$count."</th>
                         <td>".$row['inspection_date']."</td>
                          <td>
                          <a href='pastinspection.php?id=$iid&asset=$cata&pn=$pnn&date=$date' class='btn btn-outline-primary btn-sm' name='inspect".$row['inspection_date']."'>View Detail</a></td>
                          </tr>";
                        
                 
                  $count++;
                }
        }
      else { echo "<tr><td align-items-center>0 results </td></tr>"; }
                    
                  ?>                
                </tbody>
              </table>
            </div>
          </div>
        </div>
       
       <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
             <h5 class="card-title" style="text-align:center">Vehicle Maintenance History</h5>

              <!-- Table with hoverable rows -->
              <table class="table  datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">preventive maintenance history</th>
                    <th scope="col">perform vehicle inspection</th>
       
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                    $sql = "SELECT * FROM `maintenance` WHERE plateno ='$pnn' GROUP BY update_date";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $count=1;    
                    while($row = $result->fetch_assoc()) {
                      $mdate=$row['update_date'];
                       echo
                         "<th scope='row'>".$count."</th>
                         <td>".$row['update_date']."</td><td>
                         <a href='pastmaintenance.php?asset=$cata&pn=$pnn&date=$mdate' class='btn btn-outline-primary btn-sm' name='inspect".$row['update_date']."'>View Detail</a></td>                        
                          </tr>";                
                  $count++;
                }
        }
      else { echo "<h6 style='text-align:center'><td colspan='3' style='text-align:center'>0 results</td></h6>"; }                 
                  ?>        
                
                               
                </tbody>
              </table>
              <!-- End Table with hoverable rows -->

            </div>
          </div>
          </div>
        </div>

</form>
   
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('../footer.html');?>
  <!-- Vendor JS Files -->
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