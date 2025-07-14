<?php 
session_start();
if($_SESSION['role']=="hq"){
include ("recoredserver.php");
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

</head>
<style>
.card-header{

  height:60px;
}
h5,h6{
  color:black;
}
div.gallery {
  margin: 15px;
  border: 1px solid #ccc;
  float: left;
  width: 200px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}


</style>
<body>

 <?php //include('headersidebar.php');?>
 <?php include('sidebar.php');?>
 <main id="main" class="main">
<div class="pagetitle">
      <h1>past inspection data</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="inspection_rec.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>">Back</a></li>         
        </ol>
      </nav>
    </div>

     <div class="col-lg-12">

     <div class="card">
            <div class="card-header"><ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Inspection Information</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Internal Items</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">External Items</button>
                </li>
              </ul>
              </div>
            <div class="card-body">

              <!-- Pills Tabs -->
                       
                   <?php 
                 
                 //$detail = $_SESSION["detail"];
                 //$plateno = $_SESSION['plateno'];

                 $sql = "SELECT * FROM inspection WHERE inspection_date = '$date' and plateno = '$pnn'" ;
                    
                 $result = $conn->query($sql);

                  if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()){
                      $_SESSION['inspid'] = $row['id'];
                      
                         echo 
                         " <div class='tab-content pt-2' id='myTabContent'>
                <div class='tab-pane fade show active' id='pills-home' role='tabpanel' aria-labelledby='home-tab'>
                

                      <p>Vehicle Model: " .$row['model']."</p>
                      <p>Plate Number: " .$row['plateno']."</p>
                       <p>Inspection Date: " .$row['inspection_date']."</p>
                        <p>Next Inspection Date: " .$row['nxt_inspection_date']."</p>
                        </div>
                         <div class='tab-pane fade' id='pills-profile' role='tabpanel' aria-labelledby='profile-tab'>
                          <p>Available internal  items: " .$row['int_okay']."</p>
                          <p>Not Available Internal items: " .$row['int_notokay']."</p><br>
                         </div>
                          <div class='tab-pane fade' id='pills-contact' role='tabpanel' aria-labelledby='contact-tab'>
                              <p>Available external items: " .$row['ex_okay']."</p>
                          <p>Not Available external items: " .$row['ex_notokay']."</p></div>";                       
                     break;

                       }           
                  }
                  
                ?>
                         
              </div>

            </div>
          </div>

        </div>

        <div class="card">
            <div class="card-header">body inspection image</div>
            <div class="card-body">
   <div class="col-lg-12">
   <?php 
     $id =  $_SESSION['inspid'];

     $sql = "SELECT * from bodyinsp_stat";
     $res = $conn->query($sql);
     $datas = array();
        if($res->num_rows > 0){
         while($ro = $res->fetch_assoc()){ 
           
         }
        }     
     $test = "SELECT * from body_inspection where insp_id = '$iid'";
     $result = mysqli_query($conn,$test);
     $row = mysqli_fetch_assoc($result);        
            ?>            
            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['front'] ?>">
            <img src="<?php echo $row['front'] ?>" alt="front" width="600" height="400">
             </a>
            <!-- <div class="desc text-black" > <?php // echo $ro['status'] ?></div>
             <div class="desc text-black"> <?php //echo $ro['damage_type'] ?></div>-->
            </div>
          
            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['rear'] ?>">
            <img src="<?php echo $row['rear'] ?>" alt="rear" width="600" height="400">
             </a>
             
            </div>       
        
            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['front_door_driverside'] ?>">
            <img src="<?php echo $row['front_door_driverside'] ?>" alt="front_door_driverside" width="600" height="400">
             </a>
             </div>
            <div class="gallery col-lg-3">
          <a target="_blank" href="<?php echo $row['back_door_passide'] ?>">
            <img src="<?php echo $row['back_door_passide'] ?>" alt="back_door_passide" width="600" height="400">
             </a>
            
            </div>

            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['front_door_passside'] ?>">
            <img src="<?php echo $row['front_door_passside'] ?>" alt="front_door_passside" width="600" height="400">
             </a>
             
            </div>

            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['back_door_driverside'] ?>">
            <img src="<?php echo $row['back_door_driverside'] ?>" alt="back_door_driverside" width="600" height="400">
             </a>
           
            </div>

            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['front_wing_pass_side'] ?>">
            <img src="<?php echo $row['front_wing_pass_side'] ?>" alt="front_wing_pass_side" width="600" height="400">
             </a>
           
            </div>

            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['back_wing_pass_side'] ?>">
            <img src="<?php echo $row['back_wing_pass_side'] ?>" alt="back_wing_pass_side" width="600" height="400">
             </a>
             
            </div>

            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['front_wing_driver_side'] ?>">
            <img src="<?php echo $row['front_wing_driver_side'] ?>" alt="front_wing_driver_side" width="600" height="400">
             </a>
           
            </div>

            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['back_wing_driver_side'] ?>">
            <img src="<?php echo $row['back_wing_driver_side'] ?>" alt="back_wing_driver_side" width="600" height="400">
             </a>
            
            </div>
            
            <div class="gallery col-lg-3">
            <a target="_blank" href="<?php echo $row['front_bonnet'] ?>">
            <img src="<?php echo $row['front_bonnet'] ?>" alt="front_bonnet" width="600" height="400">
             </a>
            
            
            </div>       
      
   </div>
   </div>
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
















