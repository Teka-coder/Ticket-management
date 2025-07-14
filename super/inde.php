<?php 
if(!isset($_SESSION['username'])){
include ("recoredserver.php");
}
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

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <style>
   table,th,tr{
    border: 1px;
   }
      .card-header{
    height:50px;
   }
   
  </style>

</head>

<body>

 <!--<?php //include('../headersidebar.php');?>-->

  <main id="main" class="main">

    <div class="pagetitle text-center" >
      <h1>Ticket Verification System</h1>
      <nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-12">

         
          <div class="card text-center">
            <div class="card-header">
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                 <i class="bi bi-plus">Add Vehicle</i>
              </button>
               
                </li>
              </ul>
            </div><br>
            <div class="card-body">
            
              
              <!-- Table with stripped rows -->
             <form action ="recoredserver.php" method = "POST">

             <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Last inspection Date</th>
                    <th scope="col">Days to next inspection</th>
                    <th scope="col">Inspect vehicle</th>
                    <th scope="col">odometer km reading</th>
                    <th scope="col">km before next service</th>
                    <th scope="col">update PMS</th>
                  </tr>
                </thead>
                <?php
                    //$km = $_SESSION['$servicekm']; 
                    $sql ="SELECT * from vehicle";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      
                    while($row = $result->fetch_assoc()) {
                     

                     $test="SELECT id, MAX(inspection_date) as date, MAX(nxt_inspection_date) as next, MAX(odometer_reading) as odometer, MIN(km_beforenxt_service) AS km FROM `inspection`  WHERE plateno ='" .$row['plateno']."' " ;
                  
                    if ($maxdate = $conn->query($test)) {                       
                    if ($maxdate->num_rows > 0) {
                      $count=1;  
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
                   "<tr><td>".$row["id"]. "</td><td>"

                     . $row["model"] ."</td><td><button class='btn btn-primary' type='submit' name='plateno".$row['plateno']."'>"

                    . $row["plateno"] . "</td><td>"

                    . $ro['date']. "</td><td title='$var'>"

                    . $remaining."</td><td><button class='btn btn-primary' type='submit' name='inspect".$row['plateno']."'>Inspect</button></td><td>"

                    . $ro["odometer"].  "</td><td>"
                    
                    .$ro['km'].  "</td><td><button class='btn btn-primary'  type='submit' name='update".$row['plateno']."'>Update</button></td></tr>";
                    $count++;

                    }
                   
                  }
                }
              }
                
                
                    
                    } else { echo "0 results"; }
                    $conn->close();}
                   
                  ?>                     
               </table>

</form>
          </div>
          </div>
    <form action='recoredserver.php' method='post'>
            <div class="modal fade" id="ExtralargeModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add Vehicle</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

         <br><div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Vehicle Model:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="model" id="inputText" required>
                  </div>
                </div>
                  <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" >Plate Number:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control check_vehicle" name="plateno" id="inputText" required>
                    <small class='error' style='color:red;'></small>
                  </div>
                </div>
                <div class="row mb-3">
                  <label  class="col-sm-2 col-form-label" >Driver:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="dri" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label  class="col-sm-2 col-form-label" >Organization:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="org" required>
                  </div>
                </div>
                 <div class="row mb-3">
                  <label  class="col-sm-2 col-form-label" >odometer Reading:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="odometer" required>
                  </div>
                </div>
                 <div class="row mb-3">
                  <label  class="col-sm-2 col-form-label">km before service:</label>
                   <div class="col-sm-10">
                  <input type="text" class="form-control" name="km" required>
                </div>
              </div>
               
      </div>
      <div class="modal-footer">
         <button type="submit" name="addv"  class="btn btn-primary" data-bs-dismiss="modal"><i class="bi bi-plus">Add Vehicle</i></button>
        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">close</button>
        
      </div>
    </div>
  </div>

</div>




   
  </form>
 </section>
  </main><!-- End #main -->

  
 <?php include('../footer.html');?>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


</body>

</html>