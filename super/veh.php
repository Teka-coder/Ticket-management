<?php 
session_start();
if($_SESSION['role']=="admin"){
include ("recoredserver.php");
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TVS | Ticket Verification System </title>
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

 <?php ?>

  <main id="main" class="main">

      <div class="pagetitle">
      <h1>Vehicle</h1>
      <nav>
    </div>
      <div>
            <form action ="recoredserver.php" method = "post"> 
             <section class="section">

    <div class="card text-center">
            <div class="card-header">
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                 <i class="bi bi-plus">All Available Vehicle List</i>
              </button>
               
                </li>
              </ul>
            </div>
            
            <div class="card-body">
     

             <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Driver</th>
                    <th scope="col">Organization</th>
                    <th scope="col">Odometer Reading</th>                                  
                  </tr>
                </thead>
                <?php
                   
                    $sql ="SELECT * from vehicle";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      
                    while($row = $result->fetch_assoc()) {
                     
                  
                                                                  
                    echo          
                   "<tr><td>".$row["id"]. "</td><td>"

                    . $row["model"] ."</td><td>"

                    . $row['plateno']. "</td><td>"

                    . $row['driver']."</td><td>"

                    . $row['odometer_km_reading']."</td><td>";
                    //$count++;

                    }
                                 
                    
                    } else { echo "0 results"; }
                    $conn->close();}
                   
                  ?>                     
               </table>


            </div>
          </form>
                  </div>

  </main>




  
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