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
     <h1 class="decorated"><span>All accessories<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">
<?php 
 // $comp = $_SESSION['company'];
  $sql= "SELECT statuslist.description as status_name, items.tag_or_pn, asset.category,warehouse.warehouse_code,
 items.created_by,
 items.QR_code,
 items.description as item_desc,
 items.item_name,
 items.custodian,accessories.id, accessories.accessory_name,accessories.accessory_SN,accessories.created_at FROM accessories INNER JOIN statuslist on accessories.accessory_status=statuslist.id INNER JOIN items on accessories.tag_or_pn=items.id INNER JOIN asset on items.category=asset.id INNER JOIN warehouse ON items.warehouse=warehouse.id ORDER BY accessories.created_at DESC;";
  $comm=$conn->prepare($sql) or die(mysqli_connect_error($conn));
  $comm->execute();
  $result=$comm->get_result();
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()){
      $qr_code_image = $row["QR_code"];
  ?>
   

          <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
              <div class="card text-center p-2">
                 <div class="card-header">
                  <?php
                     if ($row["status_name"] == 'Active') {
                      echo '<span class="badge bg-success">'.$row["status_name"].'</span>';
                      }
                      elseif ($row["status_name"] == 'Maintenance required') {
                         echo '<span class="badge bg-warning">'.$row["status_name"].'</span>';
                      } 
                     elseif ($row["status_name"] == 'Out of use') {
                        echo '<span class="badge bg-danger">'.$row["status_name"].'</span>';
                      }
                      else {
                        echo '<span class="badge bg-primary">'.$row["status_name"].'</span>';
                      }
                  
                    ?>
              <span class="badge border-info border-1 text-info"><?php echo date("M d, Y",strtotime($row["created_at"]));?></span>
              <span class="badge border-secondary border-1 text-secondary"><?php echo ucfirst($row["accessory_SN"])?></span>
               <span class="badge border-light border-1 text-black-50"><?php echo $row["category"]?></span>
            </div>
                 <!-- <img src='<?php echo '../../QR_code/'.$qr_code_image?>' class="card-img-top" alt="<?php echo  ucfirst($row["QR_code"]);?>" width="100%"> -->
                  <div class="card-body">
              <h5 class="card-title"><?php echo ucfirst($row["accessory_name"])?></h5>
              <p class="card-text"><?php echo ucfirst($row["item_desc"])?></p>
              <a class="btn btn-primary" href='<?php echo "view-details-action.php?view_item=".$row["id"];?>'>View detail      
                          </a>
            </div>
          </div>
        </div>              
   
<?php 
}
}

else 
 echo' 
      <div style="padding-top: 15px; text-align:center;" class="col-sm-3 col-md-6 col-lg-12 col-xl-12">
      <span data-feather="alert-triangle" style="color:red;text-align:center;">
      <section class="trashsection">
  <span class="trash">
      <span></span>
      <i></i>
    </span>
</section>
      <h1>NO items found</h3>
      </span>
      </div>';
?>
 </div>
  

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