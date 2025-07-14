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
     <h1 class="decorated"><span>Ticket Recordes<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">
<?php 
 // $comp = $_SESSION['company'];
  $sql= "SELECT statuslist.description as status_desc,asset.category,warehouse.warehouse_code,
 items.company,
 items.department,
 items.created_at,
 items.created_by,
 items.QR_code,
 items.id,
 items.description,
 items.item_name,
 items.acquisition_date,
 items.acquisition_value,
 items.current_value,
 items.item_condition,
 items.manufactures_SN,
 items.tag_or_pn,
 items.expected_lifecycle,
 items.custodian FROM items INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id ORDER BY items.created_at DESC;";
 $cmd=$conn->prepare($sql);
 $cmd->execute();
 $result=$cmd->get_result();
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()){
      $qr_code_image = $row["QR_code"];
      $name=$row["item_name"];
      $status=$row["status_desc"];
  ?>
   

          <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
              <div class="card text-center p-2">
                 <div class="card-header">
                  <?php
                     if ($row["status_desc"] == 'Active') {
                      echo '<span class="badge bg-success">'.$row["status_desc"].'</span>';
                      }
                      elseif ($row["status_desc"] == 'Maintenance required') {
                         echo '<span class="badge bg-warning">'.$row["status_desc"].'</span>';
                      } 
                     elseif ($row["status_desc"] == 'Out of use') {
                        echo '<span class="badge bg-danger">'.$row["status_desc"].'</span>';
                      }
                      else {
                        echo '<span class="badge bg-primary">'.$row["status_desc"].'</span>';
                      }
                  
                    ?>
              <span class="badge border-info border-1 text-info"><?php echo date("M d, Y",strtotime($row["created_at"]));?></span>
              <span class="badge border-secondary border-1 text-secondary"><?php echo ucfirst($row["custodian"])?></span>
               <span class="badge border-light border-1 text-black-50"><?php echo $row["category"]?></span>
            </div>
                 <img src='<?php echo '../../QR_code/'.$qr_code_image?>' class="card-img-top" alt="<?php echo  ucfirst($row["QR_code"]);?>" width="100%">
                 <div class="card-body">
              <h5 class="card-title"> <?php echo  ucfirst($row["item_name"]);?></h5>
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