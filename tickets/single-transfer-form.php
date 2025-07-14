 <form method="POST" enctype="multipart/form-data" class="form-horizontal" action="single-transfer-action.php">
    <div class="row">                                                 
   <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
    <input type="hidden" name="fcustodian"  class="form-control" value='<?php echo $row2["hid"] ?>'>
  <label for="inputCustodian" class="form-label col-sm-12 col-md-6 col-lg-12 col-xl-12"><b>From Custodian:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["holder_name"] ?></em></label><br>
 <label for="inputCustodian" class="form-label"><b>To:</b></label>
  <select  class="form-select" name="tcustodian"  style="cursor: pointer;" required>
 <!--  <option selected value="<?php echo $custodian_id?>"><?php echo $custodian ?></option> -->
   <option selected value='<?php echo $row2["hid"] ?>'><?php echo $row2["holder_name"] ?></option>
  <?php
  if ($holder_result->num_rows > 0) { 
  while($roww = $holder_result->fetch_assoc()){
          if ($row2["hid"]==$roww["id"]) {
      continue;
    }
  echo "<option value='".$roww["id"]."'>".$roww["holder_name"]."</option>";
  }
  }
  ?>
  </select>
  </div>
  
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
      <input type="hidden" name="fcompany"  class="form-control" value='<?php echo $row2["company"] ?>' id="inputC">
        <label for="inputName2" class="form-label col-sm-12 col-md-6 col-lg-12 col-xl-12"><b>From Company:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["company"] ?></em></label><br>
        <label for="inputName2" class="col-sm-4 col-form-label"><b>To:</b></label>
      <select id="inputCompany" class="form-select" name="tcompany"  style="cursor: pointer;">
          <option selected value='<?php echo $row2["company"] ?>'><?php echo $row2["company"] ?></option>
          <?php
          if ($company_result->num_rows > 0) { 
          while($roww = $company_result->fetch_assoc()){
          $company = $roww["Name"];
                       if ($row2["company"]==$company) {
      continue;
    }
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
    <label for="inputName2" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Department:</b><em class="badge border-primary border-1 text-primary"><?php echo $row2["department"] ?></em>
   </label><br>
    <label for="inputName2" class="col-sm-4 form-label"><b>To:</b></label>
         <select id="inputCompany" class="form-select" name="tdepartment"  style="cursor: pointer;">
      <option selected value='<?php echo $row2["department"] ?>'><?php echo $row2["department"] ?></option>
      <?php
      if ($dep_result->num_rows > 0) { 
      while($roww = $dep_result->fetch_assoc()){
      $department = $roww["Name"];
       if ($row2["department"]==$department) {
      continue;
    }
      echo "<option value='".$department."'>$department</option>";
      }
      }
      ?>
      </select>
    </div>
 
     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-6">
      <input type="hidden" name="fwarehouse"  class="form-control" value='<?php echo $row2["wid"] ?>' id="inputW">
<label for="inputName2" class="col-sm-12 col-md-6 col-lg-12 col-xl-12 form-label"><b>From Warehouse:</b> <em class="badge border-primary border-1 text-primary"><?php echo $row2["warehouse_code"] ?></em></label><br>
<label for="inputName2" class="col-sm-12 form-label"><b>To:</b></label>
      <select id="inputWarehouse" class="form-select" name="twarehouse"  style="cursor: pointer;" required>
                  <option selected value='<?php echo $row2["wid"] ?>'><?php echo $row2["warehouse_code"] ?></option>
                  <?php
                  if ($warehouse_result->num_rows > 0) { 
                  while($roww = $warehouse_result->fetch_assoc()){
                  $warehouse = $roww["warehouse_code"];
                                    if ($row2["wid"]==$roww["id"]) {
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
 <div class="row">
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
     <h5 class="card-title">Available accessories</h5>
  <?php 
 // $comp = $_SESSION['company'];
  $s= "SELECT statuslist.description,item_holder.holder_name,accessories.id,accessories.accessory_name from accessories INNER JOIN item_holder on accessories.custodian=item_holder.id INNER JOIN statuslist on accessories.accessory_status=statuslist.id WHERE accessories.tag_or_pn=?";
 
  $cmd=$conn->prepare($s) or die(mysqli_connect_error($conn));
  $cmd->bind_param("s",$itemid);
  $cmd->execute();
  $reco=$cmd->get_result();
  if ($reco->num_rows > 0) {
  $count=1;
  ?>
   <ol class="list-group list-group-numbered">
   <?php 
  while($r = $reco->fetch_assoc()){
  ?>
   
     <input type="hidden" name="acc_name[]"  class="form-control" value='<?php echo $r["id"] ?>' id='<?php echo 'inputacc'.$count ?>'/> <li class="list-group-item d-flex justify-content-between align-items-start">
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
                No accessories found with this item!
               <!--  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
              </div>
 <?php
}
 ?>
    </div>
    <?php include 'assign-accessories.php';?>
  </div>
     <input type="hidden" name="item-name" value='<?php echo $itemname ?>' class="form-control"  id="iname"/>
     <div class="">
  <button style="float: right; margin-top: 5px" value='<?php echo $itemid ?>' name="single_transfer_form"  id="<?php echo $itemid ?>" type="submit" class="btn btn-success">Transfer
  </button>
  </div>
   </form>