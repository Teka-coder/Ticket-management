 <?php 
session_start();
if($_SESSION['role']=="edit" && isset($_SESSION['username']) && $_SESSION['username']!=''){
include ("../recoredserver.php");

  $customer_sql="select customer_name from tickets";
  $checkin_sql="select checkin_status from tickets";
  $soldout_sql="select soldout_status from tickets";
  //  $items_sql= "select * from items";
  
  // $items_result = $conn->query($items_sql);
 

  $customer_command=$conn->prepare($customer_sql);
  $customer_command->execute();
  $customer_result=$customer_command->get_result();

  $checkin_command=$conn->prepare($checkin_sql);
  $checkin_command->execute();
  $checkin_result=$checkin_command->get_result();
 
  $soldout_command=$conn->prepare($soldout_sql);
  $soldout_command->execute();
  $soldout_result=$soldout_command->get_result();
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
<?php 
}
}
?>

  <!-- Google Fonts -->
 
 <?php include('css.php');?>
<style type="text/css">
   .blink {
            animation: blinker 2s linear infinite;
            color: orange;
            font-family: sans-serif;
        }
     
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
</style>


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
     <h1 class="decorated"><span>Ticket Sells Management<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
       <section class="section">
  <div class="card">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
<div class="row">
 <div class="col-sm-6 col-md-4 col-lg-2 col-xl-2">
   <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>By Ticket ID</b></label>
  <input type="text" name="ticketid" placeholder="type Ticket ID">
</div>
<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
   <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>By Customer</b></label>
  <select class="col-lg-12 col-xl-12 col-sm-12 col-md-12" name="customer"  style="cursor: pointer;">
  <option value="">Select</option>
  <?php
  if ($customer_result->num_rows > 0) { 
  while($row = $customer_result->fetch_assoc()){
  $customer = $row["customer_name"];
  echo "<option value='".$customer."'>$customer</option>";
  }
  }
  ?>
  </select>
  </div>
   <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
     <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>Stock Status</b></label>
  <select  class="col-lg-12 col-xl-12 col-sm-12 col-md-12" name="soldout_status"  style="cursor: pointer;">
   <option value="">Select</option>
  <option value='soldout'>Sold Out</option>
  <option value='instock'>In Stock</option>
  </select>
  </div>

     <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
       <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>Checkedin Status</b></label>
         <select class="col-lg-12 col-xl-12 col-sm-12 col-md-12" name="checkinstatus"  style="cursor: pointer;">
         <option value="">Select</option> 
 
      <option value='checkedin'>Checked-In</option>
      <option value='pending'>Pending</option>
      </select>
    </div>
      <div class="col-sm-6 col-md-4 col-lg-1 col-xl-1">
        <div class="row">
           <button class="btn btn-success" type="submit" name="filter">Filter</button>
           <button class="reset btn btn-danger" onclick="location.reload()">Reset</button>
        </div>
   
  </div>
  
    </div>

    

  </form>
</div>
    <?php
    $msg="";
    $blink="";
    $tot_sql="select count(*) as c from tickets";
   
    $query = "SELECT *FROM tickets";

if (!isset($_POST['filter'])or(empty($_POST['customer'])&&empty($_POST['soldout_status'])&&empty($_POST['checkinstatus'])&&empty($_POST['ticketid']))) {
   
            $query = "SELECT *FROM tickets LIMIT 10";
            $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
         
            $msg="All record";

   $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  
        }
        else{ 
$tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
//$query = "";
$ticketid = $_POST['ticketid'];
$customer = $_POST['customer'];
$soldoutstatus = $_POST['soldout_status'];
$checkinstatus=$_POST['checkinstatus'];

if(!empty($ticketid)){//if ticketid set goes here
  $blink="blink";
   $msg="Search result with Ticket ID:".$ticketid;
   $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));


  if (empty($customer)&&empty($soldoutstatus)&&empty($checkinstatus)) {
    $ticketid="%$ticketid%";
    $query.=" WHERE ticket_unique_id LIKE ?";
    $msg=$msg;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$ticketid);
   
  }
   
}
else {

   $blink="blink";
  if (!empty($customer)&&(empty($soldoutstatus)&&empty($checkinstatus))) {
    $query .= " WHERE customer_name=? ORDER BY tickets.date_inserted DESC";
      $tot_sql.=" where customer_name=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$customer);
    $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("s",$customer);
   
    $msg="Search result with Customer name:".$customer;
  }
   elseif(!empty($soldoutstatus)&&(empty($customer)&&empty($checkinstatus))){
    $query .= " WHERE soldout_status=? ORDER BY tickets.date_inserted DESC";
      $tot_sql.=" where soldout_status=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$soldoutstatus);
    $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("s",$soldoutstatus);
  
    $msg="Search result with Stock status:".$soldoutstatus;
  }
    elseif(!empty($checkinstatus)&&(empty($customer)&&empty($soldoutstatus))){
    $query .= " WHERE checkin_status=? ORDER BY tickets.date_inserted DESC";
      $tot_sql.=" where checkin_status=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$checkinstatus);
    $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("s",$checkinstatus);
   
    $msg="Search result with Checkin:".$checkinstatus;
  }

  elseif((!empty($customer)&&!empty($soldoutstatus))&&empty($checkinstatus)){
    $query .= " WHERE customer=? AND soldout_status=? ORDER BY tickets.date_inserted DESC";
      $tot_sql.=" where customer=? and soldout_status=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("ss",$customer,$soldoutstatus);
    $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("ss",$customer,$soldoutstatus);
   $cust="SELECT soldout_status FROM tickets WHERE id=?";
    $cust_cmd=$conn->prepare($cust) or die(mysqli_connect_error($conn));
    $cust_cmd->bind_param("s",$soldoutstatus);
    $cust_cmd->execute();
    $cust_res=$cust_cmd->get_result();
    $cust_rec=$cust_res->fetch_assoc();
    $msg="Search result with Customer:".$customer." and Stock status:".$cust_rec["soldout_status"];
  }
  elseif((!empty($customer)&&!empty($checkinstatus))&&empty($soldoutstatus)){
    $query .= " WHERE customer_name=? AND checkin_status=? ORDER BY tickets.date_inserted DESC";
      $tot_sql.=" where customer_name=? and checkin_status=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("ss",$customer,$checkinstatus);
    $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("ss",$customer,$checkinstatus);
     $msg="Search result with Customer:".$customer." and Checkin:".$checkinstatus;
  }
   elseif((!empty($soldoutstatus)&&!empty($checkinstatus))&&empty($customer)){
    $query .= " WHERE soldout_status=? AND checkin_status=? ORDER BY tickets.date_inserted DESC";
      $tot_sql.=" where soldout_status=? and checkin_status=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("ss",$soldoutstatus,$checkinstatus);
  $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("ss",$soldoutstatus,$checkinstatus);
   $cust="SELECT soldout_status FROM tickets WHERE id=?";
    $cust_cmd=$conn->prepare($cust) or die(mysqli_connect_error($conn));
    $cust_cmd->bind_param("s",$soldoutstatus);
    $cust_cmd->execute();
    $cust_res=$cust_cmd->get_result();
    $cust_rec=$cust_res->fetch_assoc();
     $msg="Search result with Stock status:".$cust_rec["soldout_status"]." and Checkin:".$checkinstatus;
  }
elseif(!empty($customer)&&!empty($soldoutstatus)&&!empty($checkinstatus)){
  $query .= " WHERE customer_name=? AND soldoutstatus=? AND checkin_status=? ORDER BY tickets.date_inserted DESC";
    $tot_sql.=" where customer_name=? and soldoutstatus=? and checkin_status=?";
   $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$customer,$soldoutstatus,$checkinstatus);
   $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->bind_param("sss",$customer,$soldoutstatus,$checkinstatus);
   $cust="SELECT soldout_status FROM tickets WHERE id=?";
    $cust_cmd=$conn->prepare($cust) or die(mysqli_connect_error($conn));
    $cust_cmd->bind_param("s",$soldoutstatus);
    $cust_cmd->execute();
    $cust_res=$cust_cmd->get_result();
    $cust_rec=$cust_res->fetch_assoc();
   $msg="Search result with Stock status:".$cust_rec["holder_name"]." and Checkin:".$checkinstatus." and Customer:".$customer;
}
}
}

  $tot_cmd->execute();
  $resu=$tot_cmd->get_result(); 
  $counting=$resu->fetch_assoc();
 $total=$counting["c"]; 
  ?>
  <div class="card"  style="overflow: scroll;">
           
            <div class="card-body">
              <div style="float: left;">
                <!-- <h1><?php echo $query."&nbsp;"?></h1> -->
             
              
               <span class="badge bg-primary rounded-pill">Total: <?php echo $total ?> tickets</span>
               </div>
              <div style="float: right; padding-bottom: 15px">
                <h5 style="color: green"><b>Color Keys for Status:</b></h5>
                  <i class="badge bg-success">1</i><span><b>Instock</b></span>
                  <i class="badge bg-warning">2</i><span><b>Notset</b></span>
                  <i class="badge bg-danger">3</i><span><b>Sold out</b></span>
                  
             </div>
              <h5 style="float: left;"><em class=' <?php echo($blink);?>'><?php echo $msg?></em></h5>
  <table class="table table-striped">
                <thead class="table table-dark">
                  <tr>
                     <th scope="col">Action</th>
                    <th scope="col">#</th>
                      <th scope="col">Ticket ID</th>
                        <th scope="col">Customer</th>
                          <th scope="col">Stock Status</th>
                           <th scope="col">QR code</th>
                            <th scope="col">Checkin Status</th>
                      <th scope="col">GR</th>
                        <th scope="col">Transaction Ref</th>
                       
                           <th scope="col">Booking date</th>
                           <th scope="col">Sold by</th>
                          <th scope="col">Registered by</th>
                          
                      
                 
                  </tr>
                </thead>
                <tbody>
                   <?php
 //$list_result = mysqli_query($conn,$query);
                    $list_cmd->execute();
 $list_result=$list_cmd->get_result();
 if ($list_result->num_rows>0) {
  $count=$list_result->num_rows;
while($row = mysqli_fetch_array($list_result)){
   $id = $row["id"];
    $qr_code_image=$row["QR_plain"];                
                    
  ?>
                  <tr>
                    <th> 
                             <a class="badge bg-info" href='<?php echo "update-items-form-view.php?update_item=".$row["id"];?>'>
                            <i class="bx bx-dollar"></i>
                          </a>
                        </th>
                    <th scope="row"><?php echo $count ?>
                      
                    </th>
                    <td><?php echo ucfirst($row["ticket_unique_id"]) ?></td>
                
                    <td><?php echo ucfirst($row["customer_name"]) ?></td>
                     <td>
                  <?php
                     if ($row["soldout_status"] == 'instock') {
                      echo '<i class="badge bg-success">&nbsp;&nbsp;</i>';
                    }elseif ($row["soldout_status"] == 'notset') {
                      echo '<i class="badge bg-warning">&nbsp;&nbsp;</i>';
                      } 
                     elseif ($row["soldout_status"] == 'soldout') {
                      echo '<i class="badge bg-danger">&nbsp;&nbsp;</i>';
                      }
                      else {
                       echo '<span class="badge bg-secondary text-dark">No status</span>';
                       // <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Waiting">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      }
                  
                    ?>

                  </td>
                  <td>
                      <a class="badge bg-secondary" onclick="printQrcode(this)" name="<?php echo  ucfirst($row["ticket_unique_id"]);?>" id="<?php echo  ucfirst($qr_code_image);?>">
                           <i class="bi bi-eye"></i>
                           <!-- View QR code -->
                          </a>
                   </td>
                  
                  <td><?php echo ucfirst($row["checkin_status"]) ?></td>
                  <td><?php echo ucfirst($row["general_remark"]) ?></td>
                    <td><?php echo ucfirst($row["transaction_ref"]) ?></td>
                     
                                 <td><?php echo date("M d, Y",strtotime($row["date_booked"]));?></td>
                                 
                                 
                                   <td><?php echo ucfirst($row["sold_by"]) ?></td>
                                   <td><?php echo ucfirst($row["inserted_by"]) ?></td>
                               
                  </tr>
                   <?php
                  $count--; }
                   }
                  else{
                    ?>
                    <tr>
                      <th scope="row" class="text-center" colspan="14">No tickets found</th>
                    </tr>
                    <?php
                  }
                   
                   ?>
              
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
</section>
              <div class="modal fade" id="addAccessoryForm" tabindex="-1" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Accessory registration Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body" id='cardBody'>

              


            </div>
          </div>

        </div>


      </div>
    </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
           <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>
           </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
  <?php include('script.php');?>
</body>

</html>

<?php }else{
  header("location:../logout.php");
}
?>
<!-- to ignore the resubition of form-->
<script type="text/javascript">
  
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>