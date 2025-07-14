<?php
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
	require_once "../connection.php";
	  $cond_sql= "select * from condition_list";
  $company_sql="select * from comp";
   $status_sql="select * from statuslist";
   $warehouse_sql="select * from warehouse";
  $audit_sql="select * from audition_type";
  $holder_sql="select * from item_holder where id=?";
  $items_sql= "select * from items";
  if (isset($_GET['at'])) {
  $_SESSION["audit_type"]=$_GET['at'];
}

  $val=1;
  $holder_cmd=$conn->prepare($holder_sql) or die(mysqli_connect_error($conn));
  $holder_cmd->bind_param("s",$val);
  $holder_cmd->execute();
  $holder_result=$holder_cmd->get_result();

$cond_cmd=$conn->prepare($cond_sql) or die(mysqli_connect_error($conn));
$cond_cmd->execute();
$cond_result=$cond_cmd->get_result();

$company_cmd=$conn->prepare($company_sql) or die(mysqli_connect_error($conn));
$company_cmd->execute();
$company_result=$company_cmd->get_result();


$status_cmd=$conn->prepare($status_sql) or die(mysqli_connect_error($conn));
$status_cmd->execute();
$status_result=$status_cmd->get_result();

$warehouse_cmd=$conn->prepare($warehouse_sql) or die(mysqli_connect_error($conn));
$warehouse_cmd->execute();
$warehouse_result=$warehouse_cmd->get_result();

$audit_cmd=$conn->prepare($audit_sql) or die(mysqli_connect_error($conn));
$audit_cmd->execute();
$audit_type_result=$audit_cmd->get_result();

$items_cmd=$conn->prepare($items_sql) or die(mysqli_connect_error($conn));
$items_cmd->execute();
$items_result=$items_cmd->get_result();

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
     <h1 class="decorated"><span>Semi-anual Audit<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <?php 
if (isset($_SESSION["complete"])) {
	unset($_SESSION["SUCCESS2"]);
	unset($_SESSION["SUCCESS"]);
	?>
	 <div class="alert alert-info alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["complete"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
              unset($_SESSION["complete"]);
}
elseif (isset($_SESSION["posterror"])) {
	unset($_SESSION["SUCCESS2"]);
	unset($_SESSION["SUCCESS"]);
	?>
	 <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["posterror"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
               unset($_SESSION["posterror"]);
}
else {
	unset($_SESSION["complete"]);
	unset($_SESSION["posterror"]);
	echo "<div></div>";
}
?>
<div class="row">
	<?php
	$span=""; 
	$btn="";
	if (isset($_SESSION["SUCCESS"]) OR isset($_SESSION["FAILURE"])  OR isset($_SESSION["NOTPOSTED"]) ) {
		$btn="disabled";
		$span="Item already selected";
	}
	?>
<div class="border border-primary col-sm-6 col-md-6 col-lg-4 col-xl-4">
	<form action="select-audit-item.php" method="post" autocomplete="off">


  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
  <label for="selectItem" class="form-label"><b>Select Item to be Audited</b></label>
  <select id="selectItem" class="form-select input-field" name="selectedItem"  style="cursor: pointer;" required>
  <option <?php echo($btn); ?>></option>
  <?php
  if ($items_result->num_rows > 0) { 
  while($row = $items_result->fetch_assoc()){
  $item_name = $row["item_name"];
  ?>
  <option <?php echo($btn); ?> value='<?php echo $row["id"]?>'><?php echo $row["item_name"]?>&nbsp;&nbsp;(TAG|PN: <?php echo $row["tag_or_PN"]?>)</option>
  <?php
  }
  }
  ?>
  </select>
  </div>



<div class="row">
	<div class="col-2 p-2"> 
     <button type="submit" name="allAudit" class="btn btn-secondary rounded <?php echo($btn); ?> " id="nextButton" style="float: right;">Next</button>
    
   </div>

</div>
 
</form>
   <span><?php echo $span;?></span>
</div>
<!-- view section -->
<div class="row border border-primary col-sm-12 col-md-6 col-lg-8 col-xl-8" >
<div class="card col-sm-12 col-md-6 col-lg-6 col-xl-6">
	 <?php 
	 if(isset($_SESSION["SUCCESS"])) {
      $msg=$_SESSION["SUCCESS"];
    ?>
        <div class="card shadow-sm">
            <div class="card-header bg-dark">
              <span><i class="bi bi-check-circle fs-3" style="float: left"><?php echo $msg?></i></span>
                <!-- <h6 class="fw-600 text-white bg-dark" style="float: left"><?php echo $msg?></h6> -->
                <span><img src='<?php echo '../../QR_code/'.$_SESSION['IMAGE']?>' width="40px" height="40px" style="float: right" alt="<?php echo($_SESSION['IMAGE'])?>"></span>
                <h6 class="fw-600 text-white bg-dark p-2" style="float: right"><?php echo $_SESSION["NAME"]?></h6>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Category:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["CAT"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Company:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["COMP"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm  mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-birthday-cake text-black-blue"></i>
                    </span>
                            <div class="media-body">
								<div class="mb-1 text-xs text-underline-dashed text-dark-grey">Registered at:</div>
								<div class="text-md text-black fw-500"><?php echo date("M d, Y",strtotime($_SESSION["AT"])); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon  mr-3">
                        <i class="fal fa-mobile-alt text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Custodian:</div>
                                <div class="text-md text-black fw-500"><mark style="background-color:orange; "><?php echo $_SESSION["CUSTODIAN"];?></mark></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm  mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-venus-mars text-dark-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Department:</div>
                                <div class="text-md text-black fw-500"><?php echo $_SESSION["DEP"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-flag-alt text-dark-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Warehouse:</div>
                                <div class="text-md text-black fw-500"><?php echo $_SESSION["WARE"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm  mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-mailbox text-dark-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">TAG or PN:</div>
                                <div class="text-md text-black fw-500"><?php echo $_SESSION["TAG-PN"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Serial No.:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["SN"]; ?></div>
                            </div>
                        </div>
                    </div>
              
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Acquisition date:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo date("M d, Y",strtotime($_SESSION["ACQ_DATE"])); ?></div>
                            </div>
                        </div>
                    </div>
                      <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Acquisition value:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["ACQ_VAL"]; ?></div>
                            </div>
                        </div>
                    </div>
                  <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Current value:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["CUR_VAL"]; ?></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Expected life cycle:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["EXP_LC"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Condition:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["CONDITION"]; ?></div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Registerd by:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["BY"]; ?></div>
                            </div>
                        </div>
                    </div>
                      <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Status:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["STATUS"]; ?></div>
                            </div>
                        </div>
                    </div>
                          <div class="col-12">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-map-marked-alt text-dark-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Description:</div>
                                <div class="text-md text-black fw-500"><?php echo $_SESSION["DESC"]; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $anchor=""; 
            if (!isset($_SESSION["SUCCESS2"])) {
            	$anchor="disabled";
            }
            ?>
            <div class="card-footer bg-secondary">
               <!-- <a class="badge bg-info text-white" href="?audit">
                            Initiate Audit<i class="bx bx-edit"></i>
                          </a> -->

 <a class="badge bg-danger" href="?undo" style="float: right;">Undo</a>
    <?php
    if(isset($_GET['undo'])) {
    //session_unset();
    unset($_SESSION['SUCCESS']);
    ?>
    <script type="text/javascript">
      window.location="semi-anual-audit-form.php";
    </script>
    <?php
    }
    ?>
      </div>
        </div>
      <?php }
  elseif (isset($_SESSION["FAILURE"])) {
     ?>
      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["FAILURE"]?>
               <!--  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
              </div>
             
                <a class=" badge bg-dark text-white" href="?back">Select another.</a>
            
    <?php
    if(isset($_GET['back'])) {
    //session_unset();
    unset($_SESSION['FAILURE']);
    ?>
    <script type="text/javascript">
      window.location="semi-anual-audit-form.php";
    </script>
    <?php
    }
    ?>
      
      <?php }
  elseif(isset($_SESSION['NOTPOSTED'])) {
             ?> 
    <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["NOTPOSTED"]?>
              <!--   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
              </div>
             
                <a class=" badge bg-dark text-white" href="?try">Try again.</a>
            
    <?php
    if(isset($_GET['try'])) {
    //session_unset();
    unset($_SESSION['NOTPOSTED']);
    ?>
    <script type="text/javascript">
      window.location="semi-anual-audit-form.php";
    </script>
    <?php
    }
    ?>

 <?php
}

else {
	echo "<h5>Result will display here</h5>";
            unset($_SESSION['SUCCESS']);
            unset($_SESSION['FAILURE']);
            unset($_SESSION['NOTPOSTED']);
             ?> 
 
              <?php
      }
  ?>
</div>
<?php
$camera=""; //can be d-none
if (isset($_SESSION["SUCCESS"])) {
  ?>
	<div class="row col-sm-12 col-md-6 col-lg-6 col-xl-6 <?php echo($camera);?>">
  <?php
  $val1=2;
  $check_sql="select * from audition where item_id=? and type=? order by audited_at desc limit 1";
  
  $cmd=$conn->prepare($check_sql) or die(mysqli_connect_error($conn));
  $cmd->bind_param("ss",$_SESSION["ID"],$val1);
  $cmd->execute();
  $res=$cmd->get_result();
  //echo "<h1>".$check_sql."</h1>";
  if ($res->num_rows<=0) {
    echo '<div><span class="blink">No previous audit</span></div><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="cameradiv" > 
                <div id="camera-box">
               <h5 class="card-title">Item scanning panel</h5>
                <div id="custom-camera-container">
                               <div class="row" id="camera_0">';
                  include "qr-scanner.php";
              echo '</div>
                </div>
                <button onClick="initiateMore()" type="button" class="btn btn-dark" style="margin-top: 5px">
                        <span class="bi bi-plus-square-dotted">
                        </span> Initiate another
                    </button>
            </div>
                  </div>';
  }
  if ($res->num_rows>0) {
    $record=$res->fetch_assoc();
    $last_audit=new DateTime($record["audited_at"]);
    $today= date("Y-m-d");
    $date1=date_create($today);
    $date2=date_create($last_audit->format('Y-m-d'));
    $diff=date_diff($date1,$date2);
    $interval=$diff->format('%m months');

    if ($interval>6) {
      ?>
       <span>Last audit at: <?php echo date("Y-m-d",strtotime($record["audited_at"]));?><br>Year diff:<?php echo $interval;?></span>
  
       <?php
       echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="cameradiv" > 
                <div id="camera-box">
               <h5 class="card-title">Item scanning panel</h5>
                <div id="custom-camera-container">
                               <div class="row" id="camera_0">';
                  include "qr-scanner.php";
            echo '</div>
                </div>
                <button onClick="initiateMore()" type="button" class="btn btn-dark" style="margin-top: 5px">
                        <span class="bi bi-plus-square-dotted">
                        </span> Initiate another
                    </button>
            </div>
                  </div>';
              }
            
                  else {
?>
<div><span class="badge bg-info text-black"><?php echo $diff->y;?> Year diff.<br> Anual audition time not reached<br> last audit was at: <?php echo date("Y-m-d",strtotime($record["audited_at"]));?></span></div>
<?php
              }
          }
              ?>
                  </div>
                  <?php
}
?>

          
</div>
</div>

   </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php
     }
     else{
  header("location:../index.php");
}   
?>
