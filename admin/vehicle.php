<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$cata = $_GET['asset'];
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> AIS | Asset Inspection System </title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="select.css"  rel="stylesheet"> 
  <style>

 .card-header{
  height: 50px;
 }
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

<?php include('../headersidebar.php');?>
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

       <section class="section">
       <div class="row">
       <div style="text-align:right;">
    <a href="insuranceandbolo.php?asset=<?php echo $cata ?>" class="btn btn-primary" style="width:50%;" type="button" name="updateinfo"><i class="bi bi-plus"></i>Update Service and Insurance Date</a><br><br>
       </div> 
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">                                   
                 <li class="nav-link">Total Vehicle List</li>         
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
                    <th scope="col">Insurance due date</th>
                    <th scope="col">Service due date</th>
                  </tr>
                </thead>
                <?php
                $comp = $_SESSION['company'];
                  if($comp ='Hagbes HQ.')
                    $sql ="SELECT model,plateno,driver,company,  MAX(insurance_date) as insudate,  MAX(bolo_date) as bolodate  from vehicle  GROUP BY plateno";
                    else
                    $sql ="SELECT * from vehicle where company =  $comp GROUP BY plateno";
                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      $cou=1;  
                    while($row = $result->fetch_assoc()) {                                                         
                    echo          
                   "<tr><td  style ='color:#012970;'>". $cou. "</td><td style ='color:#012970;'>"

                     . $row["model"] ."</td><td style ='color:#012970;'>"

                    . $row["plateno"] . "</td><td style ='color:#012970;'>"

                    . $row['driver']. "</td><td style ='color:#012970;'>"

                    . $row['company']."</td><td  style ='color:#012970;'>"
                    
                    .$row['insudate']."</td><td  style ='color:#012970;'>"
                    .$row['bolodate']."</td>";?>
                   <?php 
                    $cou++;
                    }
                    
                     
                                   
                    } else { echo "0 results"; }
                    }
                   
                  ?>                     
               </table>

          </form>
          </div>
          </div>
          
<div class="modal fade" id="insudate" data-bs-backdrop='static'>
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
      <span class="modal-title" id="myModalLabel">Confirm Delete</span>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="edit.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&id=<?php echo $iid;?>" method="POST">
                    <div class="modal-body">
                    <div class="form-group"> 
                    <input type="hidden" name="delete_id" value="<?php echo $iid ?>" id="update_id">     
                        <span>Are you sure you want to delete this inspection data? <?php echo  $iid ?></span>                    
                     </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-danger" name="deleteinsp">Delete</button>
                      </form>
                    </div>
                  </div>
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