<?php 
session_start();
if($_SESSION['role']=="hq"){
  include ("recoredserver.php");
  $_SESSION['cata'] = $_GET['asset'];
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
  <link href="../image/Hagbeslogo.jpg" rel="icon">
  <link href="../image/Hagbeslogo.jpg" rel="touch-icon">

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


  <style>
  
   /* headlines with lines */
.decorated{
     overflow: hidden;
     text-align: center;
 }
.decorated > span{
    position: relative;
    display: inline-block;
}
.decorated > span:before, .decorated > span:after{
    content: '';
    position: absolute;
    top: 50%;
    border-bottom: 2px solid;
    width: 200%;
    margin: 0 20px;
}
.decorated > span:before{
    right: 100%;
}
.decorated > span:after{
    left: 100%;
}
 
  </style>

</head>

<body>

<?php include('headersidebar.php');?>
<?php include('sidebar.php');?>
  <main id="main" class="main">             
  <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->      	
     <div class="pagetitle">
     <br><h1 class="decorated"><span><?php echo $_SESSION['cata'] ?> Inspection System<span></h1> 

         </div>
          <!-- <hr class="hline col-lg-3">-->
     </div>
   </div>

   <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
            <!-- Sales Card -->
            <div class="col-lg-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Inspection Conducted</span></h5>
                  <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between  align-items-center"><i class="bi bi-collection me-1 text-primary">Total Inspection</i>                  
                <span class="badge bg-primary rounded-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-star me-1 text-success">Good Inspection</i>
                <span class="badge bg-primary rounded-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-exclamation-octagon me-1 text-danger">Faulty Inspection</i>
                <span class="badge bg-primary rounded-pill">14</span>
                </li>             
              </ul><!-- End Clean list group -->
                </div>
              </div>
            </div><!-- End Sales Card -->

                     <!-- Sales Card -->
                     <div class="col-lg-4 col-md-6">
                     <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Vehicle Status</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                     <i class="bi bi-search"></i>
                    </div>
                    <div class="ps-3">
                    <?php 
                   $cata =$_SESSION['cata']; 
                        $test = "SELECT * FROM `inspection` where catagory ='$cata'";
                            $result = $conn->query($test); 
                            $row = $result->num_rows; 
                            if ($row > 0) {
                      echo          
                      '<h6>'
                      .$row.'</h6>';
                                                                      
                    }  
                      else { echo " <h6>0 results </h6>"; }
                    //$conn->close();

                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class=" col-lg-4 col-md-6 mx-auto  me-0">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Total Maintenance</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                     <i class="bx bxs-car-mechanic"></i>
                    </div>
                    <div class="ps-3">
                                        <?php 
                   // $plateno = $_SESSION['plateno'];
                        $sql = "SELECT * FROM `maintenance` WHERE catagory ='$cata' GROUP BY update_date";
                        $res = $conn->query($sql); 
                        $row = $res->num_rows; 
                        if ($row > 0) {
                          echo          
                          '<h6>'
                          .$row.'</h6>';
                           
                        }  
                        else { echo " <h6> 0 results </h6>"; }
                    //$conn->close();

                      ?>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->
</div>
</div>
</section>

  </main><!-- End #main -->

  
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
  <script>


$(document).ready(function(){
   $('.check_vehicle').keyup(function(e){

   var plate = $('.check_vehicle').val();
    // alert('hello');
     $.ajax({
       type: "POST",
       url: "recoredserver.php",
       data: {
           "check_submit_btn":1,
           "plateno_id": plate
       },
          success: function(response){
            //alert(response);
            $('.error_vehicle').text(response);

          }
     });

});

});




</script>
</div>
</body>
</html>
<?php }else{
  header("location:../index.php");
}