 <?php 
  include '../connection.php';
  $asset_sql= "select * from asset";
  $company_sql="select * from comp";
   $status_sql="select * from statuslist";
   $warehouse_sql="select * from warehouse";
  $dep_sql="select * from department";
  //  $items_sql= "select * from items";
  
  // $items_result = $conn->query($items_sql);
  $asset_result = $conn->query($asset_sql);
  $warehouse_result = $conn->query($warehouse_sql);
   $status_result = $conn->query($status_sql);
  $company_result= $conn->query($company_sql);
  $dep_result= $conn->query($dep_sql);

  $asset_cmd=$conn->prepare($asset_sql) or die(mysqli_connect_error($conn));
  $asset_cmd->execute();
  $asset_result=$asset_cmd->get_result();

  $warehouse_cmd=$conn->prepare($warehouse_sql) or die(mysqli_connect_error($conn));
  $warehouse_cmd->execute();
  $warehouse_result=$warehouse_cmd->get_result();

  $status_cmd=$conn->prepare($status_sql) or die(mysqli_connect_error($conn));
  $status_cmd->execute();
  $status_result=$status_cmd->get_result();

  $company_cmd=$conn->prepare($company_sql) or die(mysqli_connect_error($conn));
  $company_cmd->execute();
  $company_result=$company_cmd->get_result();

  $dep_cmd=$conn->prepare($dep_sql) or die(mysqli_connect_error($conn));
  $dep_cmd->execute();
  $dep_result=$dep_cmd->get_result();

?> 
<div class="row"><h5 class="card-title">Fill out all the required field</h5></div>
    <?php if (isset($_SESSION['querysucceed'])) {
         echo '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                '.$_SESSION['querysucceed'].'
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
         unset($_SESSION['querysucceed']);
      }
      elseif (isset($_SESSION['queryfailed'])) {
        echo '<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                '.$_SESSION['queryfailed'].'
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION['queryfailed']);
      }
      // elseif (isset($_SESSION['notposted'])) {
      //   echo '<div class="alert alert-warning bg-warning text-light border-0 alert-dismissible fade show" role="alert">
      //           '.$_SESSION['notposted'].'
      //           <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      //         </div>';
      //   unset($_SESSION['notposted']);
      // }
      
     
      ?>
<form class="row g-3" method="POST" enctype="multipart/form-data" action="add-items-action.php" name="frmAdd" id="frmAdd" onsubmit="return validateAddForm()">
   <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">                          
               <div class="input-group-desc">
                <label class="form-check-label" for="accessoryCheck" style="color: red;">
               <input class="form-check-input" type="checkbox" onclick="accessoryFunction()" onkeyup="accessoryFunction()" onload="accessoryFunction()" id="accessoryCheck" wfd-id="id9">
                Does the item has accessories?
                </label>
                     <label class="label--desc">Tick on the Box </label> 
                  </div>
          </div>
          
         
  <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8 d-none" id="accessorydiv" >
   <div class="" id="spacediv" ></div>
                    <button id="rowAdderbtn" type="button" class="btn btn-dark" style="margin-top: 5px">
                        <span class="bi bi-plus-square-dotted">
                        </span> Add
                    </button>
                  </div>
                 
    </div>
  <div class="text-center">
    <button type="submit" class="btn btn-primary" name="submit" style="float: right; cursor: pointer;">Submit</button>
    <button type="reset" class="btn btn-secondary" style="float: right; margin-right: 10px; cursor: pointer;">Reset</button>
  </div>
</form><!-- End Multi Columns Form -->