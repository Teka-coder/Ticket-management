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
  $command=$conn1->prepare($sql);
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
     <h1 class="decorated"><span>All history view<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">

            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff">Transfer List</h5>
          </div>
                    <?php 
 $stmt= "SELECT item_transaction.*,items.item_name from item_transaction INNER JOIN items on items.id=item_transaction.item GROUP BY item_transaction.item ORDER BY item_transaction.created_at DESC";
 $tot_sql="select count(*) as c from item_transaction;";
 $cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
 $cmd->execute();
 $res=$cmd->get_result();
  $counting=$res->fetch_assoc();
 $total=$counting["c"];

 $rec_cmd=$conn->prepare($stmt) or die(mysqli_connect_error($conn));
 $rec_cmd->execute();
 $record=$rec_cmd->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Transfered By</th>
                    <th scope="col">Transfered At</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record->num_rows > 0) {
                  $count=$record->num_rows;  
                  while($rec = $record->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count ?></th>
                     <td><?php echo $rec["item_name"];?></td>
                    <td><?php echo $rec["created_by"];?></td>
                    <td><?php echo $rec["created_at"];?></td>
                    <td><a class="badge bg-dark" href='<?php echo "all-transfer-by-item.php?all_transfer=".$rec["item"];?>'>
                            See All<i class="bi bi-eye"></i>
                          </a></td>
                  </tr>
                  <?php
                  $count--;
                }
              }
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="5">No transfer history found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>

</section>

 <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">

            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff">Change's List</h5>
          </div>
                    <?php 
 $stmt2= "SELECT history.*,items.item_name from history INNER JOIN items on items.id=history.item GROUP BY history.item ORDER BY history.updated_at DESC";
 $tot_sql2="select count(*) as c from history;";


   $cmd2=$conn->prepare($tot_sql2) or die(mysqli_connect_error($conn));
 $cmd2->execute();
 $res2=$cmd2->get_result();
  $counting2=$res2->fetch_assoc();
 $total2=$counting2["c"];

 $rec_cmd2=$conn->prepare($stmt2) or die(mysqli_connect_error($conn));
 $rec_cmd2->execute();
 $record2=$rec_cmd2->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total2; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                     <th scope="col">Item Name</th>
                    <th scope="col">Changed By</th>
                     <th scope="col">Changed At</th>
                      <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record2->num_rows > 0) {
                  $count=$record2->num_rows;  
                  while($rec2 = $record2->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count ?></th>
                     <td><?php echo $rec2["item_name"];?></td>
                    <td><?php echo $rec2["updated_by"];?></td>
                    <td><?php echo $rec2["updated_at"];?></td>
                    <td><a class="badge bg-dark" href='<?php echo "all-changes-by-item.php?all_changes=".$rec2["item"];?>'>
                            See All<i class="bi bi-eye"></i>
                          </a></td>
                  </tr>
                  <?php
                  $count--;
                }
              }
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="5">No change found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
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
  header("location:../index.php");
}