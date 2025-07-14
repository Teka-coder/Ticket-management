
 	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 alert alert-success">
     <!-- <label class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-form-label"><b>Available accessories</b></label><br> -->
<?php
$val=1;
$count="SELECT count(*) as c from accessories WHERE accessory_status=? and custodian=? and tag_or_pn!=?";

$count_cmd=$conn->prepare($count);
$count_cmd->bind_param("sss",$val,$val,$itemid);
$count_cmd->execute();
$res=$count_cmd->get_result();
$c=$res->fetch_assoc();
?>
      <h5 class="card-title" style="color: red;">Assign new accessories<em>(optional)</em> <i style="float: right;">Tot:<?php echo $c["c"];?></i></h5>
      <select class="form-select" aria-label="Default select example" multiple name="new_acc[]" id="newselect">
   <?php
$acc_stm="SELECT * from accessories WHERE accessory_status=? and custodian=? and tag_or_pn!=?";

$acc_cmd=$conn->prepare($acc_stm);
$acc_cmd->bind_param("sss",$val,$val,$itemid);
$acc_cmd->execute();
$acc_res=$acc_cmd->get_result();
  if ($acc_res->num_rows>0) { 
  while($i=$acc_res->fetch_assoc()){
  	// if ($i["accessory_status"]!='1' && $i["custodian"]!='0') {
  	// 	continue;
  	// }
  echo "<option value=".$i["id"].">".$i["accessory_name"]."</option>";
  }
  }
 else {
?>
 <option value="" class="alert alert-danger alert-dismissible fade show">No free accessories found</option>
 <?php
}
 ?>  
</select>
 </div>
               
          


