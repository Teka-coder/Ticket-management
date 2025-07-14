<?php
include "../connection.php";
//install composer
//cd to current path of project folder
//$ composer require khanamiryan/qrcode-detector-decoder
require __DIR__ . "/vendor/autoload.php";
use Zxing\QrReader;
?>
<section class="section">
	<div class="card">
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
 <div class="row">
     <label for="scanQr" class="form-label col-sm-12 col-md-12 col-lg-12 col-xl-12"><b>Verify Item by QR Reader</b></label>
  <div class="col-sm-12 col-md-6 col-lg-9 col-xl-9">
  <input type="file" class="form-control" id="scanQr" name="qr" style="margin: 5px;" >
  </div>
              
   <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3"> 
     <button type="submit" name="scan" class="btn btn-success rounded-pill">Scan</button>
   </div>
 </div>
 </form>
	</div>
</section>
 
<section class="section">
   <?php
   if (isset($_POST['scan'])) {
 $qr=$_FILES["qr"]['name']; 
 $expqr=explode('.',$qr);
 $qrexptype=$expqr[1];
 date_default_timezone_set('Australia/Melbourne');
 $date = date('m/d/Yh:i:sa', time());
 $rand=rand(10000,99999);
 $encname=$date.$rand;
 $qrname=md5($encname).'.'.$qrexptype;
 $qrpath="../QR_scanned/".$qrname;
 move_uploaded_file($_FILES["qr"]["tmp_name"],$qrpath);
 
 $file="C:\\wamp64\www\portalsys\tvs\QR_scanned\\".$qrname;
$qrcode = new QrReader($file);
$text = $qrcode->text(); //return decoded text from QR Code
//echo "<h1>".$text."</h1>";

 $verify="SELECT statuslist.description as status_desc,item_holder.holder_name,asset.category,warehouse.warehouse_code,
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
 items.custodian FROM items INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id INNER JOIN item_holder on item_holder.id=items.custodian where items.QR_plain=?;";
 //$verify_result=$conn->query($verify);
// echo "<h1>".$verify."</h1>";
 $verify_command=$conn->prepare($verify);
 $verify_command->bind_param("s",$text);
 $verify_command->execute();
 $verify_result=$verify_command->get_result();

 if ($verify_result->num_rows>0) {

  ?>
   <div class="row">
    <?php
$row = mysqli_fetch_array($verify_result);
   $id = $row["id"];
    $qr_code_image=$row["QR_code"];  
?>
 
         
  <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-2">
    <div class="card">
      <div class="card-header  text-center" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $row["item_name"]?></h5>
          </div>
            
            <div class="card-body">
               <p class="card-text"><b>Item name: </b><r style="text-align: left;"><?php echo $row["item_name"]?></r></p>
               <p class="card-text"><b>Asset type: </b><r style="text-align: left;"><?php echo $row["category"]?></r></p>
               <p class="card-text"><b>Company/Branch: </b><r style="text-align: left;"><?php echo $row["company"]?></r></p>
               <p class="card-text"><b>Warehouse: </b><r style="text-align: left;"><?php echo $row["warehouse_code"]?></r></p>
               <p class="card-text"><b>Department: </b><r style="text-align: left;"><?php echo $row["department"]?></r></p>
               <p class="card-text"><b>Registerd by: </b><r style="text-align: left;"><?php echo $row["created_by"]?></r></p>
               <p class="card-text"><b>Registerd at: </b><r style="text-align: left;"><?php echo $row["created_at"]?></r></p>
               <p class="card-text"><b>Manufacture's SN: </b><r style="text-align: left;"><?php echo $row["manufactures_SN"]?></r></p>
               <p class="card-text"><b>TAG or plate No.: </b><r style="text-align: left;"><?php echo $row["tag_or_pn"]?></r></p>
               <p class="card-text"><b>Expected life cycle: </b><r style="text-align: left;"><?php echo $row["expected_lifecycle"]?></r></p><p class="card-text"><b>Current value: </b><r style="text-align: left;"><?php echo $row["current_value"]?></r></p>
               <p class="card-text"><b>Current user/Custodian: </b><r style="text-align: left;"><?php echo $row["holder_name"]?></r></p>
               <p class="card-text"><b>Condition: </b><r style="text-align: left;"><?php echo $row["item_condition"]?></r></p>
               <p class="card-text"><b>Acquisition value: </b><r style="text-align: left;"><?php echo $row["acquisition_value"]?></r></p>
               <p class="card-text"><b>Acquisition date: </b><r style="text-align: left;"><?php echo $row["acquisition_date"]?></r></p>
               <p class="card-text"><b>Status: </b><r style="text-align: left;"><?php echo $row["status_desc"]?></r></p>
             <!--  <a class="badge bg-danger"  href='<?php echo "delete-items-action.php?delete_item=".$row["id"];?>'>
                            <i class="bx bx-trash"></i>
                          </a> -->
                             <a class="badge bg-info" href='<?php echo "update-items-form-view.php?update_item=".$row["id"];?>'>
                            <i class="bx bx-edit"></i>
                          </a>
                        
            </div>
             </div>
           </div>
        <?php
}
else{
?>
<div><h3>nothing found</h3></div>
<?php
unset($_POST['scan']);
}
}
else{
  $_POST['scan']='';
    ?>
    <div><h1>Waitting for image upload</h1></div>
    <?php
}
?>
</div>
</section>

