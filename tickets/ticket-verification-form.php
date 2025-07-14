<?php
session_start();
if($_SESSION['role']=="edit" && isset($_SESSION['username']) && $_SESSION['username']!=''){
	require_once "../connection.php";


  

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
 if(isset($_SESSION['branch']))
  $comp = $_SESSION['branch'];
  $sql="SELECT * FROM account WHERE branch=?";
  $command=$conn->prepare($sql);
  $command->bind_param("s",$comp);
  $command->execute();
  $result = $command->get_result();
  if (!is_null($result)) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <!-- <link href="<?php echo '../image/'.$img?>" rel="icon"> -->
  <link href="../image/gbglogo.png" rel="touch-icon">
  <style type="text/css">
  .shape{    
  border-style: solid; border-width: 0 140px 80px 0; float:right; height: 0px; width: 0px;
  -ms-transform:rotate(300deg); /* IE 9 */
  -o-transform: rotate(300deg);  /* Opera 10.5 */
  -webkit-transform:rotate(300deg); /* Safari and Chrome */
  transform:rotate(300deg);
}
.item{
  background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.shape {
  border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}

.item-info { border-color: #5bc0de; }
.item-info .shape{
  border-color: transparent #5bc0de transparent transparent;
}

.shape-text{
  color:#fff; font-size:14px; font-weight:bold; position:relative; right:-40px; top:2px; white-space: nowrap;
  -ms-transform:rotate(30deg); /* IE 9 */
  -o-transform: rotate(360deg);  /* Opera 10.5 */
  -webkit-transform:rotate(30deg); /* Safari and Chrome */
  transform:rotate(30deg);
} 


</style>
<?php 
}
}
?>

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
     <h1 class="decorated"><span>Ticket Verification</span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <?php 
if (isset($_SESSION["complete"])) {
	unset($_SESSION["SUCCESS2"]);
	unset($_SESSION["SUCCESS"]);
	?>
	 <div class="alert alert-info alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["complete"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
              unset($_SESSION["complete"]);
}
elseif (isset($_SESSION["posterror"])) {
	unset($_SESSION["SUCCESS2"]);
	unset($_SESSION["SUCCESS"]);
	?>
	 <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["posterror"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
               unset($_SESSION["posterror"]);
}
else {
	unset($_SESSION["complete"]);
	unset($_SESSION["posterror"]);
	echo "<div></div>";
}
?>
<div class="row">
	<?php
	$span=""; 
	$btn="";
	
	?>

<!-- view section -->
<div class="row border border-primary col-sm-12 col-md-12 col-lg-12 col-xl-12" >

<?php
$camera=""; //can be d-none
  ?>
	<div class="row col-sm-12 col-md-6 col-lg-6 col-xl-6 <?php echo($camera);?>">
  <?php
 
    echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="cameradiv" > 
                <div id="camera-box">
               <h5 class="card-title">QR scanning panel</h5>
                <div id="custom-camera-container">
                               <div class="row" id="camera_0">';
                  include "qr-scanner.php";
              echo '</div>
                </div>
              
            </div>
                  </div>';
  
              ?>
                  </div>
                  <?php

?>

<div class="card col-sm-12 col-md-6 col-lg-6 col-xl-6">

   <?php 
   if (isset($_SESSION["processed"]) && isset($_SESSION['theticket'])) {
  // unset($_SESSION["SUCCESS2"]);
  // unset($_SESSION["SUCCESS"]);
  ?>
   <div class="alert alert-info alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["processed"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
             // unset($_SESSION["processed"]);
}
elseif (isset($_SESSION["processfailed"])  && isset($_SESSION['theticket']) ) {
    $theticket=$_SESSION["theticket"]; 
  // unset($_SESSION["SUCCESS2"]);
  // unset($_SESSION["SUCCESS"]);
  ?>
   <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["processfailed"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
               unset($_SESSION["processfailed"]);
}
else {
  // unset($_SESSION["processed"]);
  // unset($_SESSION["processfailed"]);
  // unset($_SESSION["theticket"]); 
  echo "<div></div>";
}
?>



<?php 
   $theticket=''; 
if (isset($_SESSION["processed"]) && isset($_SESSION['theticket'])) {
     $theticket=$_SESSION["theticket"]; 
  $fsql="SELECT * FROM tickets WHERE ticket_unique_id=?";
  $fcommand=$conn->prepare($fsql);
  $fcommand->bind_param("s",$theticket);
  $fcommand->execute();
  $fresult = $fcommand->get_result();
  if (!is_null($fresult)) { 
    $firstrow = $fresult->fetch_assoc();
?>
	<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 pb-2">
   
           <div class="item item-danger">
        <div class="shape">
          <div class="shape-text">
            Used<br>(<?php echo date("M d Y",strtotime($firstrow["checkin_time"]));?>)               
          </div>
        </div>
        <div class="item-content">
          <div class="card-header  text-center" style="background:  #3D4!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $firstrow["customer_name"]?></h5>
           <span class="badge bg-success rounded-pill"><?php echo$firstrow["general_remark"] ?></span>
          </div>           
           <div class="card-body">
             <p class="card-text"><b>Ticket ID: </b><r style="text-align: left;"><?php echo $firstrow["ticket_unique_id"]?></r></p>
               <p class="card-text"><b>Used By: </b><r style="text-align: left;"><?php echo $firstrow["customer_name"]?></r></p>
                
               <p class="card-text"><b>Confirmed By: </b><r style="text-align: left;"><?php echo $firstrow["verified_by"]?></r></p>
                 <p class="card-text"><b>Check-In Status: </b><r style="text-align: left;" class="bg bg-danger"><?php echo $firstrow["checkin_status"]?></r></p>
                <p class="card-text"><b>Used In: </b><r style="text-align: left;" class="bg bg-warning"><?php echo $firstrow["checkin_time"]?></r></p>
                             <a class="badge bg-danger m-1" href="?close" style="float: right;">Close</a>
    <?php
    if(isset($_GET['close'])) {
    //session_unset();
    unset($_SESSION['processed']);
    unset($_SESSION['theticket']);
     unset($_SESSION['SUCCESS2']);
    ?>
    <script type="text/javascript">
      window.location="ticket-verification-form.php";
    </script>
    <?php
    }
    ?>
          </div>
        </div>
      </div>
   
</div>
<?php } }  else {
  unset($_SESSION["processed"]);
  unset($_SESSION["processfailed"]);
  unset($_SESSION["theticket"]); 
}
  ?>






</div>       
</div>
</div>

   </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php
     }
     else{
  header("location:../logout.php");
}   
?>
