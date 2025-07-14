<?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
include ("../pad/recoredserver.php");
include '../connection.php';
 ?>
  <?php
          
 //  $company_sql="select * from comp";
 //   $warehouse_sql="select * from warehouse";
 //   $dep_sql="select * from department";
 // $holder_sql="select * from item_holder";
 
 //  $holder_result=$conn->query($holder_sql);
 //  $warehouse_result = $conn->query($warehouse_sql);
 //  $company_result= $conn->query($company_sql);
 //  $dep_result= $conn->query($dep_sql);
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
     <h1 class="decorated"><span>Asset Transfer<span></h1>
      <?php if(isset($_SESSION["completed"])) {

      $ses=$_SESSION['completed'];?>
      <script type="text/javascript">
        alert('<?php echo $ses;?>');
        window.location="asset-transaction.php";
      </script>
       <?php }
      elseif (isset($_SESSION["nochange"])) {
        $ses=$_SESSION["nochange"];?>
        <script type="text/javascript">
          alert('<?php echo $ses;?>');
          window.location="asset-transaction.php";
        </script>
      <?php }
      unset($_SESSION['completed']);
      unset($_SESSION['nochange']);
     
     
      ?>  
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">

          <div class="card">
            
            <div class="card-body">
              <div class="row">
    <!--  <h5 class="card-title text-center"><span class="badge bg-info">Make transaction here</span></h5>
        <h5>Example h5 heading <span class="badge bg-warning">Warning</span></h5> -->
         <h1 class="text-center"><span class="badge bg-primary">Transfer Assets here</span></h1>
         <hr/>
       </div>
              

              <!-- General Form Elements -->
                <div class="row">
             <!--  <h5 class="card-title">General Form Elements</h5> -->
      <div class="col-xl-12 col-lg-12">
                  <table class="table table-striped">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                     <th scope="col">Status</th>
                    <th scope="col">Custodian</th>
                     <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                      <?php
                        $stm="SELECT items.id,statuslist.value,items.item_name,statuslist.description,item_holder.holder_name FROM items INNER JOIN item_holder ON items.custodian=item_holder.id INNER JOIN statuslist ON items.item_status=statuslist.id ORDER BY items.created_at DESC";
                        
                        $cmd=$conn->prepare($stm);
                        $cmd->execute();
                        $res=$cmd->get_result();
                        
                          if ($res->num_rows>0) {
                            $iden=$res->num_rows;
                            $disable=$stat="";
                          while($irec=$res->fetch_assoc()){
                            if ($irec["value"]==3 or $irec["value"]==2) {
                              $disable="disabled";
                            }
                            else {
                              $disable="";
                            }
                            if ($irec["value"]==1) {
                              $stat="bg-success";
                            }else if ($irec["value"]==2) {
                              $stat="bg-warning";
                            }else if ($irec["value"]==3) {
                              $stat="bg-danger";
                            }
                            else{
                              $stat="bg-white";
                            } ?>
                            <tr>
                              <td> <?php echo $iden;?></td>
                              <td> <?php echo $irec["item_name"];?></td>
                              <td> <i class="text-white p-1 <?php echo $stat;?>"><?php echo $irec["description"];?></i></td>
                              <td> <?php echo $irec["holder_name"];?></td>
                              <td> <a href="asset-transaction-form.php?id=<?php echo $irec['id'];?>" class="btn btn-success <?php echo $disable;?>">Continue</a></td>
                            </tr>

                          <?php 
                          $iden--;}}?>
                </tbody>
                </table>
              </div> 
    </div>
   </div>  
           
         </div>
             </div>
   </section>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">          


            <div class="card">
      <div class="card-header  text-center" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff">Transfer List</h5>
          </div>
                    <?php 
 $stmt= "SELECT item_transaction.*,items.item_name from item_transaction INNER JOIN items on items.id=item_transaction.item GROUP BY item_transaction.item ORDER BY item_transaction.created_at DESC";
 
  $comm=$conn->prepare($stmt);
  $comm->execute();
  $record=$comm->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:</p>
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
                           See All <i class="bi bi-eye"></i>
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
                    <th scope="row " class="text-center"  colspan="7">No transfer history found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>



         </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../index.php");
} ?>