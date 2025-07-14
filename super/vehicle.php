<?php 
session_start();
if($_SESSION['role']=="admin"){
include ("recoredserver.php");
$cata = $_GET['asset'];
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> TVS | Ticket Verification System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../image/gbglogo.png" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

</head>

<body>

<?php include('headersidebar.php');?>
<?php include('sidebar.php');?>
  <main id="main" class="main">

       <section class="section">
            <div class="row">
        <div class="col-lg-12">

         
          <div class="card">
            <div class="card-header">                                   
                 <li class="nav-link">Vehicle</li>         
                 <!-- <button class="btn-primary text-right" style="float:right;" data-bs-toggle="tab" data-bs-target="#add vehicle"><i class="bi bi-plus">Add Vehicle</i></button> -->           
            </div>

            <div class="card-body">
            
              
            
             <form action ="recoredserver.php" method = "POST">

             <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Driver</th>
                    <th scope="col">Company</th>                 
                    <th scope="col">Class</th>
                    <th scope="col">Type</th>
                   <!-- <th scope="col">Delete row</th>
                     <th scope="col">Edit</th>-->
                  </tr>
                </thead>
                <?php
                    //$km = $_SESSION['$servicekm']; 
                    $sql ="SELECT * from vehicle";
                    
                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      $cou=1;  
                    while($row = $result->fetch_assoc()) {
                     

                     $test="SELECT id, MAX(inspection_date) as date, MAX(nxt_inspection_date) as next, MAX(odometer_reading) as odometer, MIN(serviced_at_odo) AS km FROM `inspection`  WHERE plateno ='" .$row['plateno']."' " ;
                  
                    if ($maxdate = $conn->query($test)) {                       
                    if ($maxdate->num_rows > 0) {
                     
                    while($ro = $maxdate->fetch_assoc()) { 
                     $var=$ro['next'];
                     
                 $next = strtotime($ro['next']);                 
                 $today = strtotime(date("y-m-d"));
                 $count = $next - $today;                         
                 $days_remaining = round($count / (60 * 60 * 24))-1;
                     if($days_remaining==-2){
                        //send auto email to pad
                    }  
                    else{
                       $remaining= $days_remaining ;
                       $_SESSION['$remaining']=$remaining;
                    }                                                                                   
                    echo          
                   "<tr><td  style ='color:#012970;'>". $cou. "</td><td style ='color:#012970;'>"

                     . $row["model"] ."</td><td style ='color:#012970;'>"

                    . $row["plateno"] . "</td><td style ='color:#012970;'>"

                    . $row['driver']. "</td><td style ='color:#012970;'>"

                    . $row['company']."</td><td  style ='color:#012970;'>"

                    . $row["class"]."</td><td  style ='color:#012970;'>"
                    
                    .$row['type']."</td>";?>
                   <!-- <td  style ='color:#012970;'><button class='btn btn-danger btn-sm ' type='submit' name='delete".$row['plateno']."'><i class='bi bi-trash'></i></button></td>
                    <td  style ='color:#012970;'><button class='btn btn-info btn-sm' type='submit' name='edit".$row['plateno']."'><i class='fa fa-edit ' style='color:white'>Edit</i></button></tr>";-->
                   <?php 
                    }
                    
                  }
                }
                $cou++;
              }
                                   
                    } else { echo "0 results"; }
                    $conn->close();}
                   
                  ?>                     
               </table>

          </form>
          </div>
          </div>
                  
 </section>


    <!--<section class="section">-->
   
  </main>

  
 <?php include('../footer.html');?>
  <!--Vendor JS Files -->
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