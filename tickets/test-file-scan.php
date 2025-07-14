<?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
include ("../pad/recoredserver.php");

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
  <?php 
  $comp = $_SESSION['company'];
  $sql="SELECT * FROM comp WHERE name=?";
  $command=$conn->prepare($sql);
  $command->bind_param("s",$comp);
  $command->execute();
  $result = $command->get_result();
  if (!is_null($result)) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">
<?php 
}
}
?>

  <!-- Google Fonts -->
 
 <?php include('css.php');?>



</head>
<body>
  <?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
 <?php include('side.php');?>
 <main id="main" class="main">
   <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Test Camera and Photo Scan<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">
<?php //include 'qr-scanner.php'; ?>
<?php include "scann-qr-by-camera.php"; ?>
<?php //include 'scann-qr-by-image.php';?>

</section>





    </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../index.php");
}