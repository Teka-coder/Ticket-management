<?php 
include "../connection.php";
// if (session_status()==PHP_SESSION_NONE) {
//   session_start();
// }
?>

<style>
  .result{
    background-color: green;
    color:#fff;
    padding:20px;
  }
  .row{
    display:flex;
  }
     .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }
        i.blink {
          color: green;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
</style>
<?php 
if (isset($_POST['MatchScan'])) {
 $qr=$_POST["ScannedData"];

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
//  echo $verify;
// echo $qr;
$verify_command=$conn->prepare($verify) or die(mysqli_connect_error($conn));
$verify_command->bind_param("s",$qr);
$verify_command->execute();
$verify_result=$verify_command->get_result(); 
 if ($verify_command==true && $verify_result->num_rows>0) {
$row =$verify_result->fetch_assoc();
  $_SESSION['SUCCESS']="Item Matched Our Record !";
  $_SESSION['ID'] = $row["id"];
  $_SESSION['IMAGE']=$row["QR_code"];  
  $_SESSION['STATUS']=$row["status_desc"];
  $_SESSION['ACQ_DATE']=$row["acquisition_date"];
  $_SESSION['ACQ_VAL']=$row["acquisition_value"];
  $_SESSION['CONDITION']=$row["item_condition"];
  $_SESSION['CUSTODIAN']=$row["holder_name"];
  $_SESSION['CUR_VAL']=$row["current_value"];
  $_SESSION['EXP_LC']=$row["expected_lifecycle"];
  $_SESSION['TAG-PN']=$row["tag_or_pn"];
  $_SESSION['SN']=$row["manufactures_SN"];
  $_SESSION['AT']=$row["created_at"];
  $_SESSION['BY']=$row["created_by"];
  $_SESSION['DEP']=$row["department"];
  $_SESSION['WARE']=$row["warehouse_code"];
  $_SESSION['COMP']=$row["company"];
  $_SESSION['CAT']=$row["category"];
  $_SESSION['NAME']=$row["item_name"];
   $_SESSION['DESC']=$row["description"];
 // echo $_SESSION['NAME'];       
}
 else {
$_SESSION['FAILURE']="The item not matched our recored";
// echo $_SESSION["FAILURE"];  
}




mysqli_close($conn);
//header("location:test-file-scan.php");
//header("location:scann-qr-by-camera.php");
//header( "location:".$_SERVER['HTTP_REFERER']); 
    }
    else {
    $_SESSION['NOTPOSTED']="Info not sent"; 
   // header( "location:".$_SERVER['HTTP_REFERER']); 
    }
?>
<section class="section">
  <?php if(isset($_SESSION["SUCCESS"])) {
      $msg=$_SESSION["SUCCESS"];
    ?>
  <div class="col-lg-8 col-xl-8">
        <div class="card shadow-sm">
            <div class="card-header bg-dark">
              <span><i class="bi bi-check-circle blink fs-3" style="float: left"><?php echo $msg?></i></span>
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
            <div class="card-footer bg-secondary">
               <a class="badge bg-info" href='<?php echo "update-items-form-view.php?update_item=".$_SESSION["ID"];?>'>
                            <i class="bx bx-edit"></i>
                          </a>

 <a class="badge bg-danger" href="?undo" style="float: right;">Undo</a>
    <?php
    if(isset($_GET['undo'])) {
    //session_unset();
    unset($_SESSION['SUCCESS']);
    ?>
    <script type="text/javascript">
      window.location="test-file-scan.php";
    </script>
    <?php
    }
    ?>
            </div>
        </div>
    </div>




      <?php }
      elseif (isset($_SESSION["FAILURE"])) {
     ?>
      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["FAILURE"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
               <button type="button" class="btn btn-dark bi bi-chevron-double-left mb-2">
                <a class="text-white" href="?back">Prev.</a>
              </button>
    <?php
    if(isset($_GET['back'])) {
    //session_unset();
    unset($_SESSION['FAILURE']);
    ?>
    <script type="text/javascript">
      window.location="test-file-scan.php";
    </script>
    <?php
    }
    ?>
      
      <?php }
      elseif(isset($_SESSION['NOTPOSTED'])) {
             ?> 
  <section class="section">       
 <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
    <span class="sr-only">Waiting result to display...</span>
                 <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
</div>
  <div class="row">
  <div class="col">
    <div style="width:500px;" id="reader"></div>
  </div>
  <div class="col" style="padding:30px;">
   <!--  <h4>RESULT</h4> -->
    <div id="result" class="d-none">


     <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8">
  <!-- <label for="ScannedData" class="form-label"><b>Result</b></label> -->
         <span id="ScannedData-info" class="info text-danger blink"><h1><?php echo $_SESSION["NOTPOSTED"]; ?></h1></span><br />
         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
   <div class="row">
   <!--  <label for="ScannedData" class="form-label col-sm-12 col-md-12 col-lg-12 col-xl-12"><b>Click "Check" button when the box filled</b></label> -->
  <div class="col-sm-12 col-md-6 col-lg-9 col-xl-9">
     <input type="text" class="form-control" id="ScannedData" name="ScannedData" value="" readonly style="margin-bottom: 5px;" >
  </div>
              
   <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3"> 
     <button type="submit" name="MatchScan" class="btn btn-success rounded-pill disabled" id="checkButton">Check</button>
   </div>
 </div>
</form>
 
</div>
    </div>
  </div>
</div>
</section>
<script src="camera_js\v2\html5-qrcode.min.js"></script>
<script type="text/javascript">
    var data=document.getElementById("ScannedData-info");
    var inputvalue=document.getElementById("ScannedData");
    var LastScan, countScans=0;
    var res=document.getElementById("result");
    var chkBtn=document.getElementById("checkButton");
function onScanSuccess(qrCodeMessage) {
    // document.getElementById('result').innerHTML = '<span class="result">'+qrCodeMessage+'</span>';
    //document.getElementById('result').innerHTML = '<span class="result">'+qrCodeMessage+'</span>';
    if (qrCodeMessage!=null && qrCodeMessage!==LastScan) {
          ++countScans;
          LastScan = qrCodeMessage;
         
if (LastScan!=null) {
  res.classList.remove('d-none');
   inputvalue.value=(LastScan);
    data.innerHTML="<i class='bi bi-exclamation-circle-fill'></i>"+("Be sure the box filled with ("+qrCodeMessage+") and Click Check Button");
    chkBtn.classList.remove('disabled');
}


          //html5QrcodeScanner.clear();
    }
     
}

function onScanError(errorMessage) {
  //handle scan error
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess, onScanError);

</script>
</section>
              <?php
      }

else {
            unset($_SESSION['SUCCESS']);
             unset($_SESSION['FAILURE']);
            unset($_SESSION['NOTPOSTED']);
             ?> 
 
              <?php
      }
  ?>

<!-- to ignore the resubition of form-->
<script type="text/javascript">
  
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
 





