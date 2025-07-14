 <?php
 include "../connection.php";
 $h_s="select * from item_holder";
  $c_s="select * from comp";
   $w_s="select * from warehouse";
   $d_s="select * from department";
  

  $w_c=$conn->prepare($w_s);
  $w_c->execute();
  $w_r=$w_c->get_result();

  
  $c_c=$conn->prepare($c_s);
  $c_c->execute();
  $c_r=$c_c->get_result();

  
  $d_c=$conn->prepare($d_s);
  $d_c->execute();
  $d_r=$d_c->get_result();

 
  $h_c=$conn->prepare($h_s);
  $h_c->execute();
  $h_r=$h_c->get_result();
  ?>
 <form method="POST" enctype="multipart/form-data" class="form-horizontal" action="single-transfer-action.php" id="single_transfer_form2">
  
    <div class="row">
     
                                                   
   <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
        <input type="hidden" name="fcustodian"  class="form-control" value='<?php echo $row2["hid"] ?>' id="inputN">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Custodian:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["holder_name"] ?></em></label><br>
     <label for="inputCustodian" class="form-label"><b>To:</b></label>

  <select  class="form-select" name="tcustodian"  style="cursor: pointer;" required>
 <!--  <option selected value="<?php echo $custodian_id?>"><?php echo $custodian ?></option> -->
   <option selected value='<?php echo $row2["hid"] ?>'><?php echo $row2["holder_name"] ?></option>
  <?php
  if ($h_r->num_rows > 0) { 
  while($rw = $h_r->fetch_assoc()){
      if ($row2["hid"]==$rw["id"]) {
      continue;
    }
  echo "<option value='".$rw["id"]."'>".$rw["holder_name"]."</option>";
  }
  }
  ?>
  </select>
  </div>
      
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
     <input type="hidden" name="fcompany"  class="form-control" value='<?php echo $row2["company"] ?>' id="inputC">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Company:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["company"] ?></em></label><br>
        <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
      <select id="inputCompany" class="form-select" name="tcompany"  style="cursor: pointer;">
          <option selected value='<?php echo $row2["company"] ?>'><?php echo $row2["company"] ?></option>
          <?php
          if ($c_r->num_rows > 0) { 
          while($rw = $c_r->fetch_assoc()){
                       if ($row2["company"]==$rw["Name"]) {
      continue;
    }
          $company = $rw["Name"];
          echo "<option value='".$company."'>$company</option>";
          }
          }
          ?>
          </select>  
    </div>
    </div>
 <div class="row">

     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
      <input type="hidden" name="fdepartment"  class="form-control" value='<?php echo $row2["department"] ?>' id="inputD">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Department:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["department"] ?></em></label><br>
      <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
         <select id="inputCompany" class="form-select" name="tdepartment"  style="cursor: pointer;" required>
      <option selected value='<?php echo $row2["department"] ?>'><?php echo $row2["department"] ?></option>
      <?php
      if ($d_r->num_rows > 0) { 
      while($rw = $d_r->fetch_assoc()){
         if ($row2["department"]==$rw["Name"]) {
      continue;
    }
      $department = $rw["Name"];
      echo "<option value='".$department."'>$department</option>";
      }
      }
      ?>
      </select>
    </div>

     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
   
  <input type="hidden" name="fwarehouse"  class="form-control" value='<?php echo $row2["wid"] ?>' id="inputW">
    <label for="inputN" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Warehouse:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["warehouse_code"] ?></em></label><br>
     <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
      <select id="inputWarehouse" class="form-select" name="twarehouse"  style="cursor: pointer;" required>
                  <option selected value='<?php echo $row2["wid"] ?>'><?php echo $row2["warehouse_code"] ?></option>
                  <?php
                  if ($w_r->num_rows > 0) { 
                  while($rw = $w_r->fetch_assoc()){
                                        if ($row2["wid"]==$rw["id"]) {
      continue;
    }
                  $warehouse = $rw["warehouse_code"];
                  echo "<option value='".$rw["id"]."'>".$rw["warehouse_code"]."</option>";
                  }
                  }
                  ?>
                  </select>  
    </div>
 </div>
 <hr/>
     
   
    <div class="row">
      <div class="col-sm-12 col-md-6 col-xl-6 col-xl-6">
         <h5 class="card-title">Select accessories</h5>
 <span id="inputAsset-info" class="info text-danger"></span>
                    <select class="form-select" multiple name="accessory[]" style="cursor: pointer;" required>
                       <?php
                 $s= "SELECT statuslist.description,item_holder.holder_name,accessories.id,accessories.accessory_name from accessories INNER JOIN item_holder on accessories.custodian=item_holder.id INNER JOIN statuslist on accessories.accessory_status=statuslist.id WHERE accessories.tag_or_pn=".$itemid;
  $reco = $conn->query($s);
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
 <option>No accessories found with this item</option>
 <?php
}
 ?>
                    </select>
                  </div>
   


    <!-- <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Add new Accessory</label>
                  <div class="col-sm-10">
                    <select class="form-select" multiple aria-label="multiple select example">
                      <option selected>Open this select menu</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                </div> -->
      <?php include 'assign-accessories.php';?>
    </div>
     <input type="hidden" name="item-name" value='<?php echo $itemname ?>' class="form-control"  id="itemname"/>
      <div class="">
  <button style="float: right; margin-top: 5px" value='<?php echo $itemid ?>' name="single_transfer_form2"  id="<?php echo $itemid ?>" type="submit" class="btn btn-success">Transfer
  </button>
  </div>
   </form>
   <script type="text/javascript">
  
</script>