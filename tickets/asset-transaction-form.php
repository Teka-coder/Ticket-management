 <?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
  include("../connection.php");
include ("../pad/recoredserver.php");
include ("../admin/recoredserver.php");
include ("../hq/recoredserver.php");
 
  $check="select Affected,item_name from items where id=?;";//both existence and transfer history
 $cmd=$conn->prepare($check) or die(mysqli_connect_error($conn));
 $cmd->bind_param("s",$_GET["id"]);
 $cmd->execute();
 $res=$cmd->get_result();
 if (isset($_GET['id'])&& $res->num_rows>0 ) {
   $trans="select it.*,
      sender_wh.warehouse_code as fw,
      receiver_wh.warehouse_code as tw,
      sender_custo.holder_name as fc,
      receiver_custo.holder_name as tc,
      items.item_name
from item_transaction it
join warehouse sender_wh
on it.from_warehouse=sender_wh.id
join warehouse receiver_wh
on it.to_warehouse=receiver_wh.id
join item_holder sender_custo
on it.from_custodian=sender_custo.id
JOIN item_holder receiver_custo
on it.to_custodian=receiver_custo.id
JOIN items
on it.item=items.id
WHERE it.item=? ORDER BY it.created_at DESC limit 1;";

$trans_cmd=$conn->prepare($trans) or die(mysqli_connect_error($conn));
$trans_cmd->bind_param("s",$_GET['id']);
$trans_cmd->execute();
$trans_result=$trans_cmd->get_result(); 
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

  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">

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
<?php 
}
}
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
     <h1 class="decorated"><span>Asset Transfer Form<span></h1>
         <?php if(isset($_SESSION["completed"])) {

      $ses=$_SESSION['completed'];?>
      <script type="text/javascript">
        alert('<?php echo $ses;?>');
        window.location="asset-transaction-form.php";
      </script>
       <?php }
      elseif (isset($_SESSION["nochange"])) {
        $ses=$_SESSION["nochange"];?>
        <script type="text/javascript">
          alert('<?php echo $ses;?>');
          window.location="asset-transaction-form.php";
        </script>
      <?php }
      unset($_SESSION['completed']);
      unset($_SESSION['nochange']);
     
     
      ?>
         </div>
          <!-- <hr class="hline col-lg-3">-->  
     </div>
   </div>
<?php
$check_rec=$res->fetch_assoc();
if ($check_rec["Affected"]=='0') {
  ?>
   <p class="blink text-center"> <i class="bi bi-exclamation-circle-fill"></i> This is First transfer for <?php echo $check_rec["item_name"];?> </p>
  <?php
 } 
?>

<?php
  $company_sql="select * from comp";
   $warehouse_sql="select * from warehouse";
   $dep_sql="select * from department";
 $holder_sql="select * from item_holder";


  $warehouse_command=$conn->prepare($warehouse_sql);
  $warehouse_command->execute();
  $warehouse_result=$warehouse_command->get_result();


  $company_command=$conn->prepare($company_sql);
  $company_command->execute();
  $company_result=$company_command->get_result();

  $dep_command=$conn->prepare($dep_sql);
  $dep_command->execute();
  $dep_result=$dep_command->get_result();

  $holder_command=$conn->prepare($holder_sql);
  $holder_command->execute();
  $holder_result=$holder_command->get_result();
  $id = $_GET['id'];
  $sql="SELECT statuslist.description as status_desc,item_holder.holder_name, item_holder.id as hid, asset.category as asset_type,warehouse.warehouse_code, warehouse.id as wid,
 items.company,
 items.department,
 items.created_at,
 items.created_by,
 items.QR_code,
 items.id,
 items.category,
 items.warehouse,
 items.description,
 items.item_name,
 items.acquisition_date,
 items.acquisition_value,
 items.current_value,
 items.item_condition,
 items.manufactures_SN,
 items.tag_or_pn,
 items.expected_lifecycle,
 items.custodian FROM items INNER JOIN item_holder on items.custodian=item_holder.id INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id where items.id=?;";
 
 $comm=$conn->prepare($sql) or die(mysqli_connect_error($conn));
 $comm->bind_param("s",$id);
 $comm->execute();
 $resul=$comm->get_result();
  if ($resul->num_rows>0) 
    $row = $resul->fetch_assoc(); 
  $itemid=$row["id"];
    ?>
<div class="card">
  <div class="card-header">
  
 <button class="badge bg-dark" data-bs-toggle="modal" data-bs-target="#showRecentTransfer" onclick="showRecentTransfer()">
  <i class="bi bi-exclamation-circle"></i>
</button>
  </div>
<div class="card-body">
 <form method="POST" enctype="multipart/form-data" class="form-horizontal" action="asset-transaction-action.php" id="asset_transfer_form">
    <div class="row">                                                 
   <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
    <input type="hidden" name="fcustodian"  class="form-control" value='<?php echo $row["hid"] ?>'>
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Custodian</b><em class="badge border-primary border-1 text-primary"><?php echo $row["holder_name"] ?></label></em><br>
         <label for="inputCustodian" class="form-label"><b>To:</b></label>
  <select  class="form-select" name="tcustodian"  style="cursor: pointer;">
   <option selected value='<?php echo $row["hid"] ?>'><?php echo $row["holder_name"] ?></option>
  <?php
  if ($holder_result->num_rows > 0) { 
  while($roww = $holder_result->fetch_assoc()){
    if ($row["hid"]==$roww["id"]) {
      continue;
    }
  echo "<option value='".$roww["id"]."'>".$roww["holder_name"]."</option>";
  }
  }
  ?>
  </select>
  </div>    
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
        <input type="hidden" name="fcompany"  class="form-control" value='<?php echo $row["company"] ?>' id="inputC">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Company</b><em class="badge border-primary border-1 text-primary"><?php echo $row["company"] ?></label></em><br>
        <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
      <select id="inputCompany" class="form-select" name="tcompany"  style="cursor: pointer;" required>
          <option selected value='<?php echo $row["company"] ?>'><?php echo $row["company"] ?></option>
          <?php
          if ($company_result->num_rows > 0) { 
          while($roww = $company_result->fetch_assoc()){
             if ($row["company"]==$roww["Name"]) {
      continue;
    }
          echo "<option value='".$roww["Name"]."'>".$roww["Name"]."</option>";
          }
          }
          ?>
          </select>  
    </div>
    </div>
 <div class="row">
     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
      <input type="hidden" name="fdepartment"  class="form-control" value='<?php echo $row["department"] ?>' id="inputD">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Department</b><em class="badge border-primary border-1 text-primary"><?php echo $row["department"] ?></label></em><br>
       <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
         <select id="inputCompany" class="form-select" name="tdepartment"  style="cursor: pointer;" required>
      <option selected value='<?php echo $row["department"] ?>'><?php echo $row["department"] ?></option>
      <?php
      if ($dep_result->num_rows > 0) { 
      while($roww = $dep_result->fetch_assoc()){
        $department = $roww["Name"];
  if ($row["department"]==$department) {
      continue;
    }
      
      echo "<option value='".$department."'>$department</option>";
      }
      }
      ?>
      </select>
    </div>
   

     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
       <input type="hidden" name="fwarehouse"  class="form-control" value='<?php echo $row["wid"] ?>' id="inputW">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Warehouse</b><em class="badge border-primary border-1 text-primary"><?php echo $row["warehouse_code"] ?></label></em><br>
    <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
  
      <select id="inputWarehouse" class="form-select" name="twarehouse"  style="cursor: pointer;" required>
                  <option selected value='<?php echo $row["wid"] ?>'><?php echo $row["warehouse_code"] ?></option>
                  <?php
                  if ($warehouse_result->num_rows > 0) { 
                  while($roww = $warehouse_result->fetch_assoc()){
                     $warehouse = $roww["warehouse_code"];
                    if ($row["wid"]==$roww["id"]) {
      continue;
    }
                 
                  echo "<option value='".$roww["id"]."'>".$roww["warehouse_code"]."</option>";
                  }
                  }
                  ?>
                  </select>  
    </div>
 </div>

 <hr/>

     <div class="col-xl-6 col-lg-6">
 <fieldset class="row mb-3">
                  <legend class="col-form-label col-sm-4 pt-0"><b>Select transfer type</b></legend>
                  <div class="col-sm-8">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="chkTransfer" onclick="ShowHideTransferType()" id="All" required checked>
                      <label class="form-check-label" for="All">
                         With all accessories
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="chkTransfer" onclick="ShowHideTransferType()" id="Sel" required>
                      <label class="form-check-label" for="Sel">
                        Selected accessories
                      </label>
                    </div>
                    <!-- <div class="form-check disabled">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios" value="option" disabled>
                      <label class="form-check-label" for="gridRadios3">
                        Third disabled radio
                      </label>
                    </div> -->
                  </div>
                </fieldset>
               </div>
    
<hr/>
<div class="row">
<div id="Type1" style="display: block;" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
 
     <!-- <label class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-form-label"><b>Available accessories</b></label><br> -->
      <h5 class="card-title">Available accessories</h5>
  <?php 
 // $comp = $_SESSION['company'];
  $s= "SELECT statuslist.description,item_holder.holder_name,accessories.id,accessories.accessory_name from accessories INNER JOIN item_holder on accessories.custodian=item_holder.id INNER JOIN statuslist on accessories.accessory_status=statuslist.id WHERE accessories.tag_or_pn=?";

  $reco_cmd=$conn->prepare($s) or die(mysqli_connect_error($conn));
  $reco_cmd->bind_param("s",$id);
  $reco_cmd->execute();
  $reco=$reco_cmd->get_result();
  if ($reco->num_rows > 0) {
  $count=1;
  ?>
   <ol class="list-group list-group-numbered">
   <?php 
  while($r = $reco->fetch_assoc()){
  ?>
   
     <input type="hidden" name="all_accessory[]"  class="form-control" value='<?php echo $r["id"] ?>' id='<?php echo 'inputacc'.$count ?>'/>
     <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold"><?php echo $r["accessory_name"] ?></div>
                    Held by:&nbsp;<?php echo $r["holder_name"] ?> 
                  </div>
                  <?php
                     if ($r["description"] == 'Active') {
                      echo '<span class="badge bg-success rounded-pill">'.$r["description"].'</span>';
                    }elseif ($r["description"] == 'Maintenance required') {
                      echo '<span class="badge bg-warning rounded-pill">'.$r["description"].'</span>';
                      } 
                     elseif ($r["description"] == 'Out of use') {
                      echo '<span class="badge bg-danger rounded-pill">'.$r["description"].'</span>';
                      }
                      else {
                       echo '<span class="badge bg-primary rounded-pill">'.$r["description"].'</span>';
                       // <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Waiting">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      }
                  
                    ?>
                </li>
     <?php
     $count++;
 }
 ?>
 </ol>
 <?php
}
else {
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
                No available accessories found with this item!
               <!--  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
              </div>
 <?php
}
 ?>
   
</div>
<div id="Type2" style="display: none;" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
 
   <h5 class="card-title">Select accessories</h5>
 <span id="inputAsset-info" class="info text-danger"></span>
   <select class="form-select" multiple aria-label name="selected_accessory[]" style="cursor: pointer;" id="selectivetype">
                       <?php
                 $s= "SELECT statuslist.description,item_holder.holder_name,accessories.id,accessories.accessory_name from accessories INNER JOIN item_holder on accessories.custodian=item_holder.id INNER JOIN statuslist on accessories.accessory_status=statuslist.id WHERE accessories.tag_or_pn=?";

  $reco_cmd=$conn->prepare($s) or die(mysqli_connect_error($conn));
  $reco_cmd->bind_param("s",$id);
  $reco_cmd->execute();
  $reco=$reco_cmd->get_result();
if ($reco->num_rows > 0) {
                    ?>
                     <!--  <option value="">--Select--</option> -->
                       <?php
                  while($r = $reco->fetch_assoc()){
                  $accname = $r["accessory_name"];
                      echo " <option value='".$r["id"]."'>".$r["accessory_name"]." (Held by: ".$r["holder_name"].", Status: ".$r["description"].")</option>";
                      }
                  }
                 else {
?>
 <option>No available accessories found</option>
 <?php
}
 ?>
                    </select>
 
</div>
<?php include "assign-accessories.php";?>
</div>
 <input type="hidden" name="iname" value='<?php echo $row["item_name"] ?>' class="form-control"  id="iname"/>
     <div class="">
  <button style="float: right; margin-top: 5px" name="asset_transfer_form" value='<?php echo $row["id"]?>' type="submit" class="btn btn-primary" onsubmit="return validateAccessory()" id="accTform">Transfer
  </button>
  </div>
   </form>
 </div>
</div>
 <div class="modal fade" id="showRecentTransfer" tabindex="-1" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Recent transfer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body" id='cardBody'>
<?php

if ($trans_result->num_rows>0) {
  $transrow = $trans_result->fetch_assoc();

?>
 <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-2">
    <div class="card">
      <div class="card-header  text-center" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $transrow["item_name"]?></h5>
           <span class="badge bg-success rounded-pill"><?php echo "1" ?></span>
          </div>
            
            <div class="card-body">
               <p class="card-text"><b>Item name: </b><r style="text-align: left;"><?php echo $transrow["item_name"]?></r></p>
               <p class="card-text"><b>From Company: </b><r style="text-align: left;"><?php echo $transrow["from_comp"]?></r></p>
               <p class="card-text"><b>To Company: </b><r style="text-align: left;"><?php echo $transrow["to_comp"]?></r></p>
                <p class="card-text"><b>From Department: </b><r style="text-align: left;"><?php echo $transrow["from_dep"]?></r></p>
                 <p class="card-text"><b>To Department: </b><r style="text-align: left;"><?php echo $transrow["to_dep"]?></r></p>
               <p class="card-text"><b>From Warehouse: </b><r style="text-align: left;"><?php echo $transrow["fw"]?></r></p>
                <p class="card-text"><b>To Warehouse: </b><r style="text-align: left;"><?php echo $transrow["tw"]?></r></p>
                 <p class="card-text"><b>From Custodian: </b><r style="text-align: left;" class="bg bg-danger"><?php echo $transrow["fc"]?></r></p>
                <p class="card-text"><b>To Custodian: </b><r style="text-align: left;" class="bg bg-warning"><?php echo $transrow["tc"]?></r></p>
                <?php
     $taken=explode(":_:",$transrow["received_acc"]);
     ?>
     <p class="card-text"><b>Received Accessory: </b>
      <?php
      foreach($taken as $eachtaken){
                if($eachtaken!=''){
                 ?>
                 <r style="text-align: left;"><?php echo $eachtaken.',' ?></r>
                 <?php 
                }
              }
              ?>
              </p>
              <?php
 $left=explode(":_:",$transrow["released_acc"]);
 ?>
 <p class="card-text"><b>Released Accessory: </b>
  <?php
      foreach($left as $eachleft){
                if($eachleft!=''){
                 ?>
                 <r style="text-align: left;"><?php echo $eachleft.',' ?></r>
                 <?php 
                }
              }
              ?>
              </p>
              <?php
$new=explode(":_:",$transrow["new_added"]);
?>
<p class="card-text"><b>Newly added Accessory: </b>
  <?php
      foreach($new as $eachnew){
                if($eachnew!=''){
                 ?>
                   <r style="text-align: left;"><?php echo $eachnew.',' ?></r>
                 <?php 
                }
              }
     ?>
      </p>         
        <p class="card-text"><b>Transferred by: </b><r style="text-align: left;"><?php echo $transrow["created_by"]?></r></p>
               <p class="card-text"><b>Transferred at: </b><r style="text-align: left;"><?php echo date("M d, Y",strtotime($transrow["created_at"]));?></r></p>
            <a class="badge bg-secondary" href='<?php echo "all-transfer-by-item.php?all_transfer=".$id;?>'>
                            View All<i class="bi bi-eye"></i></a>
                        
            </div>
             </div>
           </div>
<?php
}
else {
  ?>
  <h1>No transfer history found</h1>
  <?php
}
?>
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
<?php include('../footer.html');
   include('script.php');?>
</body>
</html>
   <?php
 }
 else {
   header( "location:".$_SERVER['HTTP_REFERER']);
 }
}
else{
  echo "<script>alert('Item with Id:".$_GET["id"]." not found');
  javascript:history.go(-1);

  </script>";
}
?>

<script type="text/javascript">
  const loadSelectUncheckedValues = function() {
  $('[name="unselectedAcc[]"]').remove(); // cleaning all
  $('select[name="selected_accessory[]"] option').each(function() {
    if($(this).is(':selected')) return; // skipping selected
    $('#asset_transfer_form').append('<input type="hidden" name="unselectedAcc[]" value="'+$(this).val()+'" />');
  });
}

// init
loadSelectUncheckedValues();

$('select[name="selected_accessory[]"]').on('change', function() {
    loadSelectUncheckedValues();
});
</script>