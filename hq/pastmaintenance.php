<?php 
session_start();
if($_SESSION['role']=="hq"){
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

</head>
<style>
.card-header{
  background-color:#87CEEB !important;
  height:50px;
}
h5,h6{
  color:black;
}
body{
    width: 100%;
    height: 100%;
	
	padding:50px;
	font-family: sans-serif;
}

*{
	box-sizing: border-box;
}

.table{
	width: 100%;
	border-collapse: collapse;
}

.table td,.table th{
  padding:12px 15px;
  border:1px solid #ddd;
  text-align: center;
  font-size:16px;
}

.table th{
	background-color: #87CEEB ;
	color:white;
}

.table tbody tr:nth-child(even){
	background-color: #F0FFFF;
}

/*responsive*/

@media(max-width: 1000px){
	.table thead{
		display: none;
	}

	.table, .table tbody, .table tr, .table td{
		display: block;
		width: 100%;
	}
	.table tr{
		margin-bottom:20px;
	}
	.table td{
		text-align: right;
		padding-left: 50%;
		text-align: right;
		position: relative;
	}
	.table td::before{
		content: attr(data-label);
		position: absolute;
		left:0;
		width: 50%;
		padding-left:15px;
		font-size:15px;
		font-weight: bold;
		text-align: left;
	}
}
</style>
<body>

 <?php include('../headersidebar.php');?>
 <?php include('sidebar.php');?>
 <main id="main" class="main">
    <div class="pagetitle">
      <h1>Preventative Maintenance History</h1>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inspection_rec.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&type=<?php echo $_SESSION['type'];?>">Back</a></li>        
        </ol>
      </nav>
    </div>


      <div class="col-lg-12">
     <div class="card">
            <div class="card-header"> 
            <span class="text-white"> Vehicle</span>                    
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
                     
                
                 $sql = "SELECT * FROM `Maintenance` where plateno='$pnn'  LIMIT 1" ;
              
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
            <span style ="color:#012970;">Checked at odometer:&nbsp'. $row["checked_at_odo"] .'</span><br>
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

     <div class="col-lg-12">

     <div class="card">
            <div class="card-header"> 
            <span class="text-white">Maintenance History</span>                    
               </div>
            <div class="card-body">
       <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <!-- Table with stripped rows -->
            <table class="table datatable">
                <thead>
                  <tr>
                    
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Updated date</th>                   
                    <th scope="col">Action Taken</th>
                    <th scope="col">checked at odometer</th>
                    <th scope="col">Status</th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                     <?php 
                 $sql = "SELECT * FROM Maintenance where plateno='$pnn'" ;
              
                 $result = $conn->query($sql);
                   $count = 1;
                   if ($result->num_rows > 0) {
                    
                   while($row = $result->fetch_assoc()){?>
                    <th data-label="#" style ="color:#012970;" scope="row"><?php echo $count; ?></th>
                    <td data-label="Type" style ="color:#012970;"><?php echo $row["type"]; ?></td>
                    <td data-label="Description" style ="color:#012970;"><?php echo $row["description"];?></td>
                    <td data-label="Updated date" style ="color:#012970;"><?php echo $row["update_date"];?></td>
                    <td data-label="Action Taken" style ="color:#012970;"><?php echo $row["action"];?>d &nbsp at &nbsp<?php echo $row["pms_reading"];?></td>
                    <td data-label="checked at odometer" style ="color:#012970;"><?php echo $row["checked_at_odo"];?></td>
                    <td data-label="Status" style ="color:#012970;"><span class="badge text-light<?php echo ($row['job_status']=='done')?' bg-success':' bg-danger'?>"><?php echo $row["job_status"];?></span></td></tr>
                    <?php
                  $count ++;
                  }                  
                }             
                  ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
        </div>
      </div>
    </section>                         
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script>
 $(document).ready(function() {
   
  if ($('.txt:contains("done")').length) {
    $('.txt').css('color', 'green');
  } else {
    $('.txt').css('color', 'red');
  }

});
 </script>

</body>

</html>
<?php }else{
  header("location:../index.php");
}
















