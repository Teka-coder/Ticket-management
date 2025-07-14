<?php 
session_start();
if($_SESSION['role']=="edit" && isset($_SESSION['username']) && $_SESSION['username']!=''){
include "../connection.php";

$check="select id from tickets where id=?;";
$cmd=$conn->prepare($check) or die(mysqli_connect_error($conn));
$cmd->bind_param("s",$_GET["update_item"]);
$cmd->execute();
$res=$cmd->get_result();
if (isset($_GET['update_item'])&& $res->num_rows>0) {
  global $itemid;
$itemid=$_GET['update_item'];
  ?>
  <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TVS | Ticket Verification System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">
<?php 
}
}
?>

 <?php include('css.php');?>
  <style type="text/css">
     .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
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
     <h1 class="decorated"><span>Sales Panel<span></h1> 
       <?php if(isset($_SESSION["completed"])) {

      $ses=$_SESSION['completed'];?>
      <script type="text/javascript">
        alert('<?php echo $ses;?>');
        window.location="update-items-form-view.php";
      </script>
       <?php }
  
      elseif (isset($_SESSION["notposted"])) {
        $ses=$_SESSION["notposted"];?>
        <script type="text/javascript">
          alert('<?php echo $ses;?>');
          window.location="update-items-form-view.php";
        </script>
      <?php }
       elseif (isset($_SESSION["nochange"])) {
        $ses=$_SESSION["nochange"];?>
        <script type="text/javascript">
          alert('<?php echo $ses;?>');
          window.location="update-items-form-view.php";
        </script>
         <?php }
      unset($_SESSION['nochange']);
      unset($_SESSION['completed']);
      unset($_SESSION['notposted']);
     
      ?> 
         </div> 
     </div>

   </div>
      <?php 
if (isset($_SESSION["querysucceed"])) {
  ?>
   <div class="alert alert-info alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["querysucceed"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
              unset($_SESSION["querysucceed"]);
}
elseif (isset($_SESSION["failed"])) {
  ?>
   <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["failed"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
               unset($_SESSION["failed"]);
}
else {
  unset($_SESSION["querysucceed"]);
  unset($_SESSION["failed"]);
  echo "<div></div>";
}
?>
   <section class="section">
     <div class="row align-items-top" data-aos="zoom-in">
      <!--<div class="container">  -->
      
          <div class="pp5 col-lg-12" >
          <div class="row">
          <?php
          
  
  
  $sql="SELECT * FROM tickets where tickets.id=".$_GET['update_item'];"";
 $result=$conn->query($sql);
  if ($result->num_rows>0) {
              while($row = $result->fetch_assoc()){
     $qr_code_image=$row["QR_plain"];
     $soldoutstatus=$row["soldout_status"];
     $ticketid=$row["ticket_unique_id"]; 
  ?>
  <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6">
    <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $row["ticket_unique_id"]?></h5>
          </div>
            
            <div class="card-body">
               <p class="card-text"><b>Ticket ID: </b><r style="text-align: left;"><?php echo $row["ticket_unique_id"]?></r></p>
               <p class="card-text"><b>Customer: </b><r style="text-align: left;"><?php echo $row["customer_name"]?></r></p>
               <p class="card-text"><b>Price: </b><r style="text-align: left;"><?php echo $row["price"]?></r></p>
               <p class="card-text"><b>GR: </b><r style="text-align: left;"><?php echo $row["general_remark"]?></r></p>
               <p class="card-text"><b>Transaction Ref: </b><r style="text-align: left;"><?php echo $row["transaction_ref"]?></r></p>
               <p class="card-text"><b>Registerd at: </b><r style="text-align: left;"><?php echo $row["date_inserted"]?></r></p>
               <p class="card-text"><b>Checkin Remark: </b><r style="text-align: left;"><?php echo $row["checkin_remark"]?></r></p>
               <p class="card-text"><b>Sales Remark: </b><r style="text-align: left;"><?php echo $row["soldout_remark"]?></r></p>
               <p class="card-text"><b>Booking date: </b><r style="text-align: left;"><?php echo $row["date_booked"]?></r></p>
              
               <p class="card-text bg bg-warning"><b>Stock Status: </b><r style="text-align: left;"><?php echo $soldoutstatus ?></r></p>
               <p class="card-text"><b>Checkin Status: </b><r style="text-align: left;"><?php echo $row["checkin_status"]?></r></p>
               <!-- <a type="button" class="badge bg-danger"  onclick="delete_record(this)" name='<?php echo $row["ticket_unique_id"]?>' id='<?php echo $row["id"];?>' > --> <!--  href='<?php echo "delete-items-action.php?delete_item=".$row["id"];?>'-->
                            <!-- <i class="bx bx-trash"></i> -->
              <!-- </a> -->
              <!-- <a class="badge bg-secondary" href='<?php echo "view-details-action.php?view_item=".$row["id"];?>'>
                            <i class="bi bi-eye"></i>
              </a>  -->
              <!-- <a class="badge bg-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Roll back" href='<?php echo "roll-back-action.php?roll_item=".$row["id"];?>'>
                            <i class="ri-24-hours-fill"></i>
              </a> -->
               <!-- <a class="badge bg-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Roll back" onclick="roll_back(this)" id='<?php echo $row["id"]?>' name='<?php echo $row["ticket_unique_id"];?>'>
                            <i class="ri-24-hours-fill"></i>
                          </a> -->
                         
            </div>
             </div>
           </div>
 <?php 
                          }
}
$result2=$conn->query($sql);
$disabled='';
                 if ($result2->num_rows>0) {
               while($row2 = $result2->fetch_assoc()){
                $qr_code_image=$row2["QR_plain"];
                if($row2['soldout_status']=='soldout'){
                  $disabled='disabled';
                }
                ?>
                  <div class="col-lg-8 col-xl-8 col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-header p-0">
                                        <ul class="nav nav-pills">
                                            <li class=" nav-item"><a type="button" class=" btn nav-link active"   onclick="toggle(this)" id='tab1' data-toggle="tab">Sell Ticket</a></li>
                                            <li class=" nav-item"><a type='button 'class=" btn nav-link"   id='tab2' onclick="toggle(this)" data-toggle="tab">Scan QR code</a></li>
                                           
                                             <li class=" nav-item"><a type='button 'class=" btn nav-link"   id='tab0' onclick="toggle(this)" data-toggle="tab"></a></li>
                                         
                                       
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
       <div class="tabs active tab-pane" id="update_item">
         <form method="POST" enctype="multipart/form-data" class="form-horizontal" action="update-items-action.php">
        
                   <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
                        <label for="inputName" class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-form-label">Customer Name</label>
                        <input type="text" name="customername"  class="form-control" value='<?php echo $row2["customer_name"] ?>' id="inputName" required>
                                    </div>     
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="inputName" class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-form-label">Phone Number</label>
                        <input type="number" name="customerphone" class="form-control" value='<?php echo $row2["customer_phone"] ?>' id="cp" required>
                                    </div>                                             
                  </div>
                   <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                          <label for="inputcval" class="col-sm-4 col-form-label">Transaction Ref.</label>
                          <?php  echo '<input type="text" name="transactionref"  class="form-control" value="'.$row2["transaction_ref"].'" required>';?>
                    </div>
              
               </div>
                   
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-12">
                      <label for="inputdesc" class="col-sm-6 col-form-label">Sales remark</label>
                       <?php  echo '<textarea name="soldoutremark"  class="form-control" value="'.$row2["soldout_remark"].'" id="inputdesc" placeholder="'.$row2["soldout_remark"].'" required></textarea>';?>
                    </div>
               
               
               
                    <div class="">
                         <!-- <button type="reset" class="btn btn-secondary" style="float: right; margin-right: 10px; cursor: pointer;">Reset</button> -->
               <button style="float: right; margin-top: 5px" value='<?php echo $row2["id"]?>' name="update_asset_item"  id='<?php echo $row2["id"]?>' type="submit" class="btn btn-success <?php echo $disabled?> ">Sell Out</button>
                    </div>
               
            </form>
        </div>
                                           
                  <div class="tabs tab-pane col-sm-12 col-md-6 col-lg-4 col-xl-4" id="scan_qrcode">
                          <!-- onclick="update_record(this)" -->
   
                 
              
              <div class="card text-center p-0 ">
                 <div class="card-header p-0" style="background: #093c73!important;">
                 <h4 style="color: #fff">QR code</h4>
            </div>
                 <img src='<?php echo '../QR_code/'.$qr_code_image ?>' class="card-img-top" alt="<?php echo  ucfirst($row2["QR_plain"]);?>" width="100%">
                 <div class="card-body">
              <h5 class="card-title"> <?php echo  ucfirst($row2["ticket_unique_id"]);?></h5>
             
 <?php
                     if ($row2["soldout_status"] == 'instock') {
                      echo '<span class="badge bg-success">'.$row2["soldout_status"].'</span>';
                      }
                      elseif ($row2["soldout_status"] == 'notset') {
                         echo '<span class="badge bg-warning">'.$row2["soldout_status"].'</span>';
                      } 
                     elseif ($row2["soldout_status"] == 'Out of use') {
                        echo '<span class="badge bg-danger">'.$row2["soldout_status"].'</span>';
                      }
                      else {
                        echo '<span class="badge bg-primary">'.$row2["soldout_status"].'</span>';
                      }
                  
                    ?>
             
            </div>
          </div>
             </div> 
               <!-- /.tab-pane -->
              </div>
                    <!-- /.tab-content -->
                 </div><!-- /.card-body -->
                        </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
            <?php 
}
 }
?>
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

          <?php
  }
  else{
  echo "<script>
  javascript:history.go(-1);

  </script>";
     
}
// else {
//      $_SESSION['failed']= "No item with that Id,Try Again Later";
//      //header('Location: manage-items.php');
//       header( "location:".$_SERVER['HTTP_REFERER']);   
//   }
  }
  else{
  header("location:../logout.php");
}?>

<script>
  function remove_active(){
    var elements=document.getElementsByClassName("tabs"); /// divs 
    //alert(elements.length)
    for(let el of elements)
      el.classList.remove("active");
for(let i=0;i<=2;i++)
   document.getElementById('tab'+i).classList.remove("active") // li
  }
  function toggle(e){
  if(e.id=='tab1'){
  remove_active();
   e.classList.add('active');
    document.getElementById('update_item').classList.add("active")
  }else if(e.id=='tab2'){
     remove_active();
     e.classList.add('active');
    document.getElementById('scan_qrcode').classList.add("active")
}
}
function delete_record(e){

Swal.fire({
  title: 'Are you sure to delete '+e.name+'?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {

let xhr=new XMLHttpRequest();
xhr.onload=function(){
}
xhr.open("GET","delete-items-action.php?delete_item="+e.id)
xhr.send();
    Swal.fire(
      'Deleted!',
      e.id+' has been deleted.',
      'success',
      window.location='manage-items.php',
    )
  }
})
}

// function update_record(e){

// Swal.fire({
//   title: 'Save the changes to '+e.value+'?',
//   text: "You won't be able to revert this!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Yes, save it!'
// }).then((result) => {
//   if (result.isConfirmed) {

// let xhr=new XMLHttpRequest();
// xhr.onload=function(){
// }
// xhr.open("POST","update-items-action.php?update_asset_item="+e.id)
// xhr.send();
//     Swal.fire(
//       'Updated!',
//       e.value+' has been updated.',
//       'success',
//       //window.location='manage-items.php',
//     )
//   }
// })
// }

  var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
document.getElementById("inputacqdate").setAttribute("max", today);
document.getElementById("inputexp").setAttribute("max", "2028-01-01");
document.getElementById("inputacqdate").setAttribute("min", today);
document.getElementById("inputexp").setAttribute("min", "2024-01-01");
</script>
