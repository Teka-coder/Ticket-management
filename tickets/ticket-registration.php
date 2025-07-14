    <?php 
session_start();
if($_SESSION['role']=="edit" && isset($_SESSION['username']) && $_SESSION['username']!=''){
  include("../connection.php");
include ("../admin/recoredserver.php");
include ("../hq/recoredserver.php");
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
  // if(isset($_SESSION['branch']))
  // $comp = $_SESSION['branch'];
  // $sql= "select * from account where branch = '$comp'";
  // $sql="SELECT * FROM account WHERE branch=?";
  // $command=$conn->prepare($sql);
  // $command->bind_param("s",$comp);
  // $command->execute();
  // $result = $command->get_result();
  // if (!is_null($result)) { 
  //   while($row = $result->fetch_assoc()){
  //     $img = $row["logo"];
  ?>
  <!-- <link href="<?php echo '../image/'.$img?>" rel="icon"> -->
  <link href="../image/gbglogo.png" rel="touch-icon">
<?php 
// }
// }
?>


<?php include('css.php');?>
 

</head>
<body>
  <?php 
   include('../headersidebar.php');
   include('side.php');
 ?>
  
  <main id="main" class="main">
  <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Ticket Registration<span></h1>
       <?php if(isset($_SESSION["completed"])) {

      $ses=$_SESSION['completed'];?>
            <div class="alert alert-warning alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["completed"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
      <!-- <script type="text/javascript">
        alert('<?php echo $ses;?>');
        window.location="ticket-registration.php";
      </script> -->
      <?php }
      elseif (isset($_SESSION["notposted"])) {
        $ses=$_SESSION["notposted"];?>
              <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["notposted"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
       <!--  <script type="text/javascript">
          alert('<?php echo $ses;?>');
          window.location="ticket-registration.php";
        </script> -->
      <?php }
      unset($_SESSION['completed']);
      unset($_SESSION['notposted']);
     
      ?>  
         </div>
        
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
 

  <?php 
  // $asset_sql= "select * from asset"; //if one of this statement is wrong the following main body will not be displayed
  // $company_sql="select * from comp";
  //  $status_sql="select * from statuslist";
  //  $warehouse_sql="select * from warehouse";
  //  $dep_sql="select * from department";
  

  //  $asset_command=$conn->prepare($asset_sql);
  // $asset_command->execute();
  // $asset_result=$asset_command->get_result();

  // $warehouse_command=$conn->prepare($warehouse_sql);
  // $warehouse_command->execute();
  // $warehouse_result=$warehouse_command->get_result();

  //  $status_command=$conn->prepare($status_sql);
  //  $status_command->execute();
  //  $status_result=$status_command->get_result();

  // $company_command=$conn->prepare($company_sql);
  // $company_command->execute();
  // $company_result=$company_command->get_result();

  // $dep_command=$conn->prepare($dep_sql);
  // $dep_command->execute();
  // $dep_result=$dep_command->get_result();
?> 

<div class="card">
  <div class="card-body">
    <?php include("add-items-form-view.php");?>
    </div>
  </div>
</main>
<?php 
 
   include('../footer.html');
   include('script.php');
 ?>
</body>
</html>
<?php 
}
else{
  header("location:../logout.php");
}
?>