<?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
  include ("../pad/recoredserver.php");
  include "../connection.php";
  $asset_sql= "select * from asset";
  $company_sql="select * from comp";
   $status_sql="select * from statuslist";
   $warehouse_sql="select * from warehouse";
  $dep_sql="select * from department";
  $holder_sql="select * from item_holder";
  //  $items_sql= "select * from items";
  
  // $items_result = $conn->query($items_sql);
 

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
 
  $holder_command=$conn->prepare($holder_sql);
  $holder_command->execute();
  $holder_result=$holder_command->get_result();
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TVS | Ticket Verification System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<!--  <link href="../assets/css/customcss.css" rel="stylesheet"> -->
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
     <h1 class="decorated"><span>Test Search by Key and Types<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>

<section class="section">
	<div class="card">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
<div class="row">
 <div class="col-sm-6 col-md-4 col-lg-2 col-xl-2">
 	 <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>Keyword</b></label>
 	<input type="text" name="keyword" placeholder="type keywords (company|custodian|department)">
</div>
<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
	 <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>Company</b></label>
  <select class="col-lg-12 col-xl-12 col-sm-12 col-md-12" name="company"  style="cursor: pointer;">
  <option value="">Select</option>
  <?php
  if ($company_result->num_rows > 0) { 
  while($row = $company_result->fetch_assoc()){
  $company = $row["Name"];
  echo "<option value='".$company."'>$company</option>";
  }
  }
  ?>
  </select>
  </div>
   <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
   	 <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>Custodian</b></label>
  <select  class="col-lg-12 col-xl-12 col-sm-12 col-md-12" name="custodian"  style="cursor: pointer;">
   <option value="">Select</option>
  <?php
  if ($holder_result->num_rows > 0) { 
  while($roww = $holder_result->fetch_assoc()){
  echo "<option value='".$roww["id"]."'>".$roww["holder_name"]."</option>";
  }
  }
  ?>
  </select>
  </div>

     <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
     	 <label class="form-label col-lg-12 col-xl-12 col-sm-12 col-md-12"><b>Department</b></label>
         <select class="col-lg-12 col-xl-12 col-sm-12 col-md-12" name="department"  style="cursor: pointer;">
         <option value="">Select</option>	
      <?php
      if ($dep_result->num_rows > 0) { 
      while($roww = $dep_result->fetch_assoc()){
      $department = $roww["Name"];
      echo "<option value='".$department."'>$department</option>";
      }
      }
      ?>
      </select>
    </div>
      <div class="col-sm-6 col-md-4 col-lg-1 col-xl-1">
      	<div class="row">
      		 <button type="submit" name="filter">Filter</button>
      		 <button class="reset" onclick="location.reload()">Reset</button>
      	</div>
   
	</div>
	
		</div>

		

	</form>
</div>
	  <?php
    $msg="";
    $blink="";
         if (!isset($_POST['filter'])) {
   
            $query = "SELECT statuslist.description as status_desc,item_holder.holder_name,asset.category,warehouse.warehouse_code,
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
 items.QR_plain,
 items.expected_lifecycle,
 items.custodian FROM items INNER JOIN item_holder on items.custodian=item_holder.id INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id ORDER BY items.created_at DESC;";
            $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
         
            $msg="All record";
        }
        else{	
$query = "";
$keyword = $_POST['keyword'];
$company = $_POST['company'];
$custodian = $_POST['custodian'];
$department=$_POST['department'];

if(!empty($keyword)){//if keyword set goes here
   $query = "SELECT statuslist.description as status_desc,item_holder.holder_name,asset.category,warehouse.warehouse_code,
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
 items.QR_plain,
 items.expected_lifecycle,
 items.custodian FROM items INNER JOIN item_holder on items.custodian=item_holder.id INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id ORDER BY items.created_at DESC;";
   $msg="Search result with keyword:".$keyword;
   $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
  

  if (empty($company)&&empty($custodian)&&empty($department)) {
    $keyword="%$keyword%";
    $query.=" WHERE custodian LIKE ? OR department LIKE ? OR company LIKE ?";
    $msg=$msg;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$keyword,$keyword);
   
  }
   	 
	elseif (!empty($company)&&(empty($custodian)&&empty($department))) {
     $keyword="%$keyword%";
		$query .= " WHERE custodian LIKE ? OR department LIKE ? AND company=?";
    $msg.=" and company:".$company;
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$keyword,$company);
    
	}
	 elseif(!empty($custodian)&&(empty($company)&&empty($department))){
     $keyword="%$keyword%";
    $query .= " WHERE company LIKE ? OR department LIKE ? AND custodian=?";
    $msg.=" and company:".$custodian;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$keyword,$custodian);
   
  }
    elseif(!empty($department)&&(empty($company)&&empty($custodian))){
       $keyword="%$keyword%";
    $query .= " WHERE custodian LIKE ? OR company LIKE ? AND department=?";
    $msg.=" and company:".$department;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$keyword,$department);
   
  }

  elseif((!empty($company)&&!empty($custodian))&&empty($department)){
     $keyword="%$keyword%";
  	$query .= " WHERE department LIKE ? AND company=? AND custodian=?";
    $msg.=" and company:".$company.", custodian:".$custodian;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$company,$custodian);
   
  }
  elseif((!empty($company)&&!empty($department))&&empty($custodian)){
     $keyword="%$keyword%";
  	$query .= " WHERE custodian LIKE ? AND company=? AND department=?";
    $msg.=" and company:".$company.", department:".$department;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$company,$department);
    
  }
   elseif((!empty($custodian)&&!empty($department))&&empty($company)){
     $keyword="%$keyword%";
  	$query .= " WHERE company LIKE ? AND custodian=? AND department=?";
    $msg.=" and custodian:".$custodian.", department:".$department;
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$keyword,$custodian,$department);
   
  }
elseif(!empty($company)&&!empty($custodian)&&!empty($department)){
	$query .= " WHERE company=? AND custodian=? AND department=?";
  $msg.=" and company:".$company.", custodian:".$custodian.", department:".$department;
  $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$company,$custodian,$department);
    
}
}
else {
	 $query = "SELECT * FROM items";
    $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
   
	 $msg="Reset the Search";
   $blink="blink";
	if (!empty($company)&&(empty($custodian)&&empty($department))) {
		$query .= " WHERE company=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$company);
   
    $msg="Search result with company:".$company;
	}
	 elseif(!empty($custodian)&&(empty($company)&&empty($department))){
    $query .= " WHERE custodian=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$custodian);
   
    $msg="Search result with custodian:".$custodian;
  }
    elseif(!empty($department)&&(empty($company)&&empty($custodian))){
    $query .= " WHERE department=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("s",$department);
   
    $msg="Search result with department:".$department;
  }

  elseif((!empty($company)&&!empty($custodian))&&empty($department)){
  	$query .= " WHERE company=? AND custodian=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("ss",$company,$custodian);
    
    $msg="Search result with company:".$company." and custodian:".$custodian;
  }
  elseif((!empty($company)&&!empty($department))&&empty($custodian)){
  	$query .= " WHERE company=? AND department=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("ss",$company,$department);
    
     $msg="Search result with company:".$company." and department:".$department;
  }
   elseif((!empty($custodian)&&!empty($department))&&empty($company)){
  	$query .= " WHERE custodian=? AND department=?";
     $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("ss",$custodian,$department);
  
     $msg="Search result with custodian:".$custodian." and department:".$department;
  }
elseif(!empty($company)&&!empty($custodian)&&!empty($department)){
	$query .= " WHERE company='".$company."' AND custodian='".$custodian."' AND department='".$department."'";
   $list_cmd=$conn->prepare($query) or die(mysqli_connect_error($conn));
    $list_cmd->bind_param("sss",$company,$custodian,$department);
   
   $msg="Search result with all field";
}
}
}

   $tot_sql="select count(*) as c from items;";
  $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
  $tot_cmd->execute();
  $resu=$tot_cmd->get_result(); 
  $counting=$resu->fetch_assoc();
 $total=$counting["c"];
	?>
  <div class="card"  style="overflow: scroll;">
           
            <div class="card-body">
              <div style="float: left;">
              	<!-- <h1><?php echo $query."&nbsp;"?></h1> -->
             
              
               <span class="badge bg-primary rounded-pill">Total: <?php echo $total ?> items</span>
               </div>
              <div style="float: right; padding-bottom: 15px">
                <h5 style="color: green"><b>Color Keys for Status:</b></h5>
                  <i class="badge bg-success">1</i><span><b>Active</b></span>
                  <i class="badge bg-warning">2</i><span><b>Maintenace Required</b></span>
                  <i class="badge bg-danger">3</i><span><b>Out Of Use</b></span>
                  
             </div>
              <h5 style="float: left;"><em class=' <?php echo($blink);?>'><?php echo $msg?></em></h5>
  <table class="table table-striped">
                <thead class="table table-dark">
                  <tr>
                     <th scope="col">Action</th>
                    <th scope="col">#</th>
                      <th scope="col">Item name</th>
                        <th scope="col">TAG|PN</th>
                          <th scope="col">Status</th>
                           <th scope="col">QR code</th>
                            <th scope="col">Category</th>
                      <th scope="col">Company</th>
                        <th scope="col">Department</th>
                          <th scope="col">Custodian</th>
                          <th scope="col">Warehouse Code</th>
                            <th scope="col">Condition</th>
                      <th scope="col">Description</th>
                        <th scope="col">Current value</th>
                          <th scope="col">Expected life cycle</th>
                           <th scope="col">Acquisition date</th>
                      <th scope="col">Acquisition value</th>
                        <th scope="col">SN</th>
                          <th scope="col">Registered by</th>
                            <th scope="col">Registered at</th>
                      
                 
                  </tr>
                </thead>
                <tbody>
                   <?php
 //$list_result = mysqli_query($conn,$query);
                    $list_cmd->execute();
 $list_result=$list_cmd->get_result();
 if ($list_result->num_rows>0) {
while($row = mysqli_fetch_array($list_result)){
   $id = $row["id"];
    $qr_code_image=$row["QR_code"];                
                    
  ?>
                  <tr>
                    <th> <!-- <button class="badge bg-danger" onclick="delete_record(this)" id='<?php echo $row["id"]?>' name='<?php echo $row["item_name"];?>' >
                            <i class="bx bx-trash"></i>
                          </button> -->
                             <a class="badge bg-info" href='<?php echo "update-items-form-view.php?update_item=".$row["id"];?>'>
                            <i class="bx bx-edit"></i>
                          </a>
                          <a class="badge bg-secondary" href='<?php echo "view-details-action.php?view_item=".$row["id"];?>'>
                            <i class="bi bi-eye"></i>
                          </a>
                           <!-- <a class="badge bg-danger" href='<?php echo "reset-action.php?roll_item=".$row["id"];?>'>
                            <i class="ri-24-hours-fill"></i>
                          </a> -->
                          <!--  <button class="badge bg-danger" onclick="roll_back(this)" id='<?php echo $row["id"]?>' name='<?php echo $row["item_name"];?>'>
                            <i class="ri-24-hours-fill"></i>
                          </button> -->
                           <!-- <button class="badge bg-dark" data-bs-toggle="modal" data-bs-target="#addAccessoryForm" onclick="fill_modal2()">
                            <i class="bi bi-plus"></i>
                          </button> --> 

                          <!-- <button class="btn btn-primary"   data-bs-toggle="modal" data-bs-target="#addAccessoryForm" onclick="fill_modal2()" type="button">Add Accessory</button> -->
                        </th>
                    <th scope="row"><?php echo ucfirst($row["id"]) ?>
                      
                    </th>
                    <td><?php echo ucfirst($row["item_name"]) ?></td>
                
                    <td><?php echo ucfirst($row["tag_or_pn"]) ?></td>
                     <td>
                  <?php
                     if ($row["status_desc"] == 'Active') {
                      echo '<i class="badge bg-success">&nbsp;&nbsp;</i>';
                    }elseif ($row["status_desc"] == 'Maintenance required') {
                      echo '<i class="badge bg-warning">&nbsp;&nbsp;</i>';
                      } 
                     elseif ($row["status_desc"] == 'Out of use') {
                      echo '<i class="badge bg-danger">&nbsp;&nbsp;</i>';
                      }
                      else {
                       echo '<span class="badge bg-secondary text-dark">No status</span>';
                       // <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Waiting">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      }
                  
                    ?>

                  </td>
                  <td>
                      <a class="badge bg-secondary" onclick="printQrcode(this)" name="<?php echo  ucfirst($row["item_name"]);?>" id="<?php echo  ucfirst($qr_code_image);?>">
                           <i class="bi bi-eye"></i>
                           <!-- View QR code -->
                          </a>
                   </td>
                  
                  <td><?php echo ucfirst($row["category"]) ?></td>
                  <td><?php echo ucfirst($row["company"]) ?></td>
                    <td><?php echo ucfirst($row["department"]) ?></td>
                       <td><?php echo ucfirst($row["custodian"]) ?></td>
                        <td><?php echo ucfirst($row["warehouse_code"]) ?></td>
                          <td><?php echo ucfirst($row["item_condition"]) ?></td>
                            <td><?php echo ucfirst($row["description"]) ?></td>
                             <td><?php echo ucfirst($row["current_value"]) ?></td>
                              <td><?php echo ucfirst($row["expected_lifecycle"]) ?></td>
                                 <td><?php echo date("M d, Y",strtotime($row["acquisition_date"]));?></td>
                                  <td><?php echo ucfirst($row["acquisition_value"]) ?></td>
                                   <td><?php echo ucfirst($row["manufactures_SN"]) ?></td>
                                   <td><?php echo ucfirst($row["created_by"]) ?></td>
                                <td><?php echo date("M d, Y",strtotime($row["created_at"]));?></td>
                               
                  </tr>
                   <?php
                   }
                   }
                  else{
                    ?>
                    <tr>
                      <th scope="row" class="text-center" colspan="20">No items found</th>
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
<!-- <section class="section">
<div class="container">
  <h2>Pager</h2>
  <p>The .previous and .next classes align each link to the sides of the page:</p>                  
  <ul class="pager">
    <li class="previous"><a href="#">Previous</a></li>
    <li class="next"><a href="#">Next</a></li>
  </ul>
</div>
</section> -->


           </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 

</body>

</html>

<?php }else{
  header("location:../index.php");
}
?>
<!-- to ignore the resubition of form-->
<script type="text/javascript">
  
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>