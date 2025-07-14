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
     <h1 class="decorated"><span>Check-in Page<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">

         

 
 <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div class="card text-center p-1 rounded-circle border border-warning" >
            
               	  <h5 class="card-title">Verifying Ticket</h5>
                 <div class="card-body">
              <p class="badge border-secondary border-1 text-secondary">Intended To Be Done on The Entrance</p><hr>
  
    

              <a class="btn btn-primary" href="ticket-verification-form.php?at=1">Open Camera      
                          </a>
                         
                     <!--  <input class="form-check-input" type="radio" name="auditType" value='<?php echo $row["id"]; ?>' onclick="SelectAuditType()" checked>
                      <label class="form-check-label" for="gridRadios1">
                       <?php echo $row["name"];?>
                      </label> -->
                    
            </div>
          </div>
        </div>   
 </div>
  

</section>
<?php include 'all-audit-type.php';?>

 </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../index.php");
}