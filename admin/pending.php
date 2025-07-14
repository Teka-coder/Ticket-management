<?php 
session_start();
if($_SESSION['role']=="admin" && isset($_SESSION['username']) && $_SESSION['username']!=''){
include ("../admin/recoredserver.php");

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
  $sql= "select * from comp where branch = '$comp'";
  $sql="SELECT * FROM account WHERE branch=?";
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
     <h1 class="decorated"><span>Check-In records<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
<section class="section">
<div class="row">

<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
<?php
$val='pending'; 
$soldstatus='soldout';
 $stmt= "SELECT * from tickets WHERE checkin_status=? AND soldout_status=? ORDER BY checkin_time DESC";
$tot_sql="select count(*) as c from tickets where checkin_status=? AND soldout_status=?;";
  $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));;
  $tot_cmd->bind_param("ss",$val,$soldstatus);
  $tot_cmd->execute();
  $resu=$tot_cmd->get_result();
  $counting=$resu->fetch_assoc();
  $total=$counting["c"];

  $result = $conn->prepare($stmt) or die(mysqli_connect_error($conn));
  $result->bind_param("ss",$val,$soldstatus);
  $result->execute();
  $record=$result->get_result();
  ?>
            <div class="card">
      <div class="card-header  text-center p-0 card-header bg-dark">
           <h5 class="card-title text-white">Waiting List</h5>
          </div>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ticket ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Phone</th>
                    <!-- <th scope="col">Action</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ( $record->num_rows>0) {  
                     $ct=$record->num_rows; 
                  while($rec = $record->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $ct;?></th>
                    <td><?php echo $rec["ticket_unique_id"];?></td>
                    <td><?php echo $rec["customer_name"];?></td>
                    <td><?php echo $rec["customer_phone"];?></td>
                    <!-- <td><a class="badge bg-dark" href='<?php echo "audition-record.php?all_type1=".$rec["id"];?>'>
                            Detail<i class="bi bi-eye"></i>
                          </a></td> -->
                  </tr>
                  <?php
                 $ct--;}}
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="5">No record found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>
</div>
</div> 
            
</section>
</main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../logout.php");
}