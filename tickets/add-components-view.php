 <?php 
  include '../connection.php';
  $asset_sql= "select * from asset";
  $company_sql="select * from comp";
   $status_sql="select * from statuslist";
   $warehouse_sql="select * from warehouse";
  $dep_sql="select * from department";
 
  
  $asset_command=$conn->prepare($asset_sql);
  $asset_command->execute();
  $asset_result=$asset_command->get_result();

  $warehouse_command=$conn->prepare($warehouse_sql);
  $warehouse_command->execute();
  $warehouse_result=$warehouse_command->get_result();

   $status_command=$conn->prepare($status_sql);
   $status_command->execute();
   $status_result=$status_command->get_result();

  $company_command=$conn->prepare($company_sql);
  $company_command->execute();
  $company_result=$company_command->get_result();

  $dep_command=$conn->prepare($dep_sql);
  $dep_command->execute();
  $dep_result=$dep_command->get_result();

?>

<div class="row"><h5 class="card-title">Fill all the required field</h5></div>
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


      <!-- this php file shoudn't be included in add-item-form file, cuase of same id-->
<form class="g-3" method="POST" enctype="multipart/form-data" action="add-components-action.php" name="compForm" id="compForm" onsubmit="return validateAddForm()">
                <div id="custom-input-container2">
                              <?php include "../connection.php";
    ?> 
      <div class="row" id="comp_0">
                     <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <input type="text" class="form-control" id="component_name_1" name="component_name[]" placeholder="Name" required>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <input type="text" class="form-control" id="component_desc_1" name="component_desc[]" placeholder="Description" required><br>
                    </div>
                   
              </div>

                     <!--  <span onclick="removeField(this)"><i class="btn btn-danger bi bi-trash" ></i></span> --> 
                </div>
    <div class="row">
               
                <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8" id="componentsdiv" >
                   <!--  <button id="rowAdderbtn" type="button" class="btn btn-dark" style="margin-top: 5px">
                        <span class="bi bi-plus-square-dotted">
                        </span> Add
                    </button> -->
                     <div id="custom-box2">
                <!-- <div id="custom-input-container2">
                    
                </div> -->
               
                <button onClick="addMore2()" type="button" class="btn btn-dark" style="margin-top: 5px">
                        <span class="bi bi-plus-square-dotted">
                        </span> Add
                    </button>
            </div>
                  </div>
           
                  </div>
                 
  
 
                   <div class="text-center">
    <button type="submit" class="btn btn-primary" name="submit" value='<?php echo $itemid?>' style="float: right; cursor: pointer;">Submit</button>
    <button type="reset" class="btn btn-secondary" style="float: right; margin-right: 10px; cursor: pointer;">Reset</button>
  </div>
</form><!-- End Multi Columns Form -->
