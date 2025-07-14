<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$cata=$_GET['asset'];
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
      <h1>Insurance and bolo date</h1>
       <nav>
        <ol class="breadcrumb">
          <li><a href="vehicle.php?asset=<?php echo $cata;?>"><i class="fa fa-arrow-circle-o-left" style="font-size:36px;color:#87CEEB"></i></a></li>         
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <form action ="insuranceandbolo.php?asset=<?php echo $cata;?>" method = "POST"> 
<div class="row">    
<div class="col-md-8">
<label>Vehicle</label>
<select name="plateno" class="form-select">
<option value=""></option>
<?php   
    $query ="SELECT * FROM `vehicle` ORDER BY driver ASC";
        $result = $conn1->query($query);                                                                                          
        if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {                                                
        echo '
            <option value="'.$row['plateno'].'">'.$row['driver'].' | '.$row['plateno'].' - '.$row['model'].'</option>';          
            }
        }       
        ?>
</select>
<br><label for="insudate" class="form-label">Insurance Date</label>
  <div class="input-group has-validation">
     <span class="input-group-text" id="inputGroupPrepend">Due Date</span>
        <input type="Date" name="insudate" class="form-control"  autofocus>
    </div>
    
<br><label for="yourUsername" class="form-label">Service Date</label>
  <div class="input-group has-validation">
     <span class="input-group-text" id="inputGroupPrepend">Due Date</span>
        <input type="Date" name="bolodate" class="form-control"  autofocus>
    </div>
    </div>
</div>

<div class="text-center">
<br><br><button class="btn btn-primary" type="submit" name="updateinfo">Submit</button>
    </div>
      </form>   

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