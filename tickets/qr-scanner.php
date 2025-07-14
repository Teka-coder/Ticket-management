<?php 
//include "../connection.php";
// if (session_status()==PHP_SESSION_NONE) {
//   session_start();
// }
?>

<style>
  .result{
    background-color: red;
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
          color: yellow;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
</style>
<?php 
if (isset($_POST['MatchScan2'])) {
 $qr=$_POST["ScannedData2"];

 $verify="SELECT * FROM tickets  where qr_code=?;";
 //$verify_result=$conn->query($verify);
// echo "<h1>".$verify."</h1>";
//  echo $verify;
// echo $qr; 
$verify_command=$conn->prepare($verify);
$verify_command->bind_param("s",$qr);
$verify_command->execute();
$verify_result=$verify_command->get_result();
 if ($verify_command==true && $verify_result->num_rows>0) {
$row = $verify_result->fetch_assoc();
  $_SESSION['SUCCESS2']="Item Matched Our Record !";
  $_SESSION['ticketid2'] = $row["ticket_unique_id"];
  $_SESSION['IMAGE2']=$row["qr_code"];  
  $_SESSION['STATUS2']=$row["checkin_status"];
  $_SESSION['BOOKED2']=$row["date_booked"];
  $_SESSION['TRANS2']=$row["transaction_ref"];
  $_SESSION['PHONE2']=$row["customer_phone"];
  $_SESSION['NAME2']=$row["customer_name"];
   $_SESSION['GR2']=$row["general_remark"];
   $_SESSION['BOOKEDAT2']=$row["date_booked"];
   $_SESSION['CHEKEDAT2']=$row["checkin_time"];
   $_SESSION['STOCK2']=$row["soldout_status"];
   $_SESSION['SR2']=$row["soldout_remark"];
   $_SESSION['ID2']=$row["id"];
 // echo $_SESSION['NAME'];       
}
 else {
$_SESSION['FAILURE2']=" ".$qr." not found in our recored";
// echo $_SESSION["FAILURE"];  
}




//mysqli_close($conn);
//header("location:test-file-scan.php");
//header("location:scann-qr-by-camera.php");
//header( "location:".$_SERVER['HTTP_REFERER']); 
    }
    else {
    $_SESSION['NOTPOSTED2']="Info not sent"; 
   // header( "location:".$_SERVER['HTTP_REFERER']); 
    }
?>

  <?php
  $msg="Item not matched";
  $bg="bg-dark";
  
  $btntext="End";
  $btn='';
  $usercolor='';
  $btnlink='';
   if(isset($_SESSION["SUCCESS2"]) && !isset($_SESSION['processed'])) {
    if($_SESSION['STOCK2']=='instock'){
        $bg='bg-info';
        $usercolor='bg-dark';
        $msg="Item matched, But Not Sold out";
    }elseif($_SESSION['STOCK2']=='soldout' && $_SESSION['STATUS2']=='checkedin'){
        $bg="bg-danger";
        $usercolor='bg-dark';
        $msg="This Ticket is Used";
    }elseif($_SESSION['STOCK2']=='soldout' && $_SESSION['STATUS2']=='pending'){
        $usercolor='bg-dark';
        $bg='bg-success';
        $msg="Active Ticket";
        $btnlink=' <a class="badge bg-info text-white" href="?audit">
        Mark as Checked-In<i class="bx bx-edit"></i>
      </a>';
    }
    
      
      $btntext="Stop";
    
    
     
    ?>
  <div class="card col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card shadow-sm">
            <div class="card-header <?php echo($bg);?>">
              <span><i class="bi bi-check-circle blink fs-3" style="float: left"><?php echo $msg?></i></span>
                <!-- <h6 class="fw-600 text-white bg-dark" style="float: left"><?php echo $msg?></h6> -->
                <span><img src='<?php echo '../QR_code/'.$_SESSION['IMAGE2'].'.png'?>' width="40px" height="40px" style="float: right" alt="<?php echo($_SESSION['IMAGE2'])?>"></span>
                <h6 class="fw-600 text-white <?php echo $usercolor ?> p-2" style="float: right"><?php echo $_SESSION["NAME2"]?></h6>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Ticket ID:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["ticketid2"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Customer Phone:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["PHONE2"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm  mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-birthday-cake text-black-blue"></i>
                    </span>
                            <div class="media-body">
<div class="mb-1 text-xs text-underline-dashed text-dark-grey">Booking Date:</div>
<div class="text-md text-black fw-500"><?php echo date("M d, Y",strtotime($_SESSION["BOOKEDAT2"])); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon  mr-3">
                        <i class="fal fa-mobile-alt text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Check-In Status:</div>
                                <div class="text-md text-black fw-500">
                                   <?php 
$sta='Unknown';
$tbg='';
if($_SESSION['STOCK2']=='soldout' && $_SESSION['STATUS2']=='pending'){
    $tbg='background-color:green;';
$sta= 'Waiting...';
}elseif($_SESSION['STOCK2']=='soldout' && $_SESSION['STATUS2']=='checkedin'){
    $tbg='background-color:red;';
$sta='Used';
}?>
 <mark style="<?php echo $tbg;?>">
                                <?php echo $sta;?></mark></div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-flag-alt text-dark-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Trans. Ref.:</div>
                                <div class="text-md text-black fw-500"><?php echo $_SESSION["TRANS2"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="media lh-sm  mb-4">
                    <span class="media-icon mr-3">
                        <i class="fal fa-mailbox text-dark-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-grey">Ticket Type:</div>
                                <div class="text-md text-black fw-500"><?php echo $_SESSION["GR2"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6 col-lg-6 col-md-6">
                        <div class="media lh-sm mb-4">
                    <span class="media-icon mr-3 ">
                       <i class="fal fa-envelope text-black-blue"></i>
                    </span>
                            <div class="media-body">
                                <div class="mb-1 text-xs text-underline-dashed text-dark-gray">Sales Remark:</div>
                                <div class="text-md text-black fw-500" style="word-break:break-word;"><?php echo $_SESSION["SR2"]; ?></div>
                            </div>
                        </div>
                    </div> 
              
                   
                   





                </div>
            </div>
            <div class="card-footer <?php echo $bg?>">
              <?php 
            echo $btnlink;
                ?>
                <?php
    if(isset($_GET['audit'])) {
    $audited_item=$_SESSION['ticketid2'];
    $btntext="Terminate";
    ?>
    <!--  <script type="text/javascript">
      window.location="ticket-verification-form.php";
    </script> -->
   <div class="p-1">
  <form class="row g-3" method="POST" enctype="multipart/form-data" action="audit-action.php" name="formAudit" onsubmit="return validateAuditForm()" id="auditform1" autocomplete="on">
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
  <!-- <label for="inputItemname" class="form-label"><b>Remark</b></label>
  <span id="inputName-info" class="info text-danger">*</span><br />
  <textarea class="form-control" id="inputRemark" name="checkinremark" placeholder="Check-in remark..." ></textarea> -->
   <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3"> 
   <button type="submit" name="Checkin" class="btn btn-warning rounded-pill m-2" id="auditButton" value="<?php echo $audited_item?>">Finish</button>
   </div>
  </div>
</form>
   </div>
    <?php
    }
    else {
      echo "<div></div>";
    }
             
                echo '<a class="badge bg-secondary text-white" href="?try2" style="float: left;">Scan another<i class="bx bx-arrow-left"></i></a>';
              
             ?> 

 <a class="badge bg-secondary" href="?end" style="float: right;"><?php echo $btntext;?></a>
    <?php
    if(isset($_GET['end'])) {
    //session_unset();
    unset($_SESSION['SUCCESS2']);
    unset($_SESSION['SUCCESS']);
    ?>
    <script type="text/javascript">
      window.location="ticket-verification-form.php";
    </script>
    <?php
    }

    if(isset($_GET['try2'])) {
    //session_unset();
    unset($_SESSION['SUCCESS2']);
    ?>
    <script type="text/javascript">
      window.location="ticket-verification-form.php";
    </script>
    <?php
    }
    ?>
            </div>
        </div>
    </div>




      <?php }
      elseif (isset($_SESSION["FAILURE2"])) {
     ?>
      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
              <?php echo $_SESSION["FAILURE2"]?>
               <!--  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
              </div>
               <div class="card-footer bg-secondary">
                <a class="badge bg-dark text-white" href="?back2">Check again<i class="bx bx-arrow-left"></i></a>
              </div>
    <?php
    if(isset($_GET['back2'])) {
    //session_unset();
    unset($_SESSION['FAILURE2']);
    ?>
    <script type="text/javascript">
      window.location="ticket-verification-form.php";
    </script>
    <?php
    }
    ?>
      
      <?php }
      elseif(isset($_SESSION['NOTPOSTED2'])) {
             ?> 
         
 <div class="alert alert-success alert-dismissible fade show mt-1 col-sm-12 col-md-12 col-lg-10 col-xl-10" role="alert">
    <span class="sr-only">Waiting result to display...</span>
                 <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
</div>
  <div class="row">
  <div class="col">
    
    <!-- style="width:500px;"  or style="
  width: 100%;
  max-width: 500px;
  margin: 0 auto;
"-->
    <div style="width:500px;" id="reader"></div>

  </div>
  <div class="col" style="padding:30px;">
   <!--  <h4>RESULT</h4> -->
    <div id="result" class="d-none">


     <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8">
  <!-- <label for="ScannedData" class="form-label"><b>Result</b></label> -->
         <span id="ScannedData-info" class="info text-danger blink"><h1><?php echo $_SESSION["NOTPOSTED2"]; ?></h1></span><br />
         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
   <div class="row">
   <!--  <label for="ScannedData" class="form-label col-sm-12 col-md-12 col-lg-12 col-xl-12"><b>Click "Check" button when the box filled</b></label> -->
  <div class="col-sm-12 col-md-6 col-lg-9 col-xl-9">
     <input type="hidden" class="form-control" id="ScannedData2" name="ScannedData2" value="" readonly style="margin-bottom: 5px;" >
  </div>
              
   <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3"> 
     <button type="submit" name="MatchScan2" class="btn btn-success rounded-pill" id="checkButton">Check</button>
   </div>
 </div>
</form>
 
</div>
    </div>
  </div>
</div>

<script src="camera_js\v2\html5-qrcode.min.js"></script>
<script type="text/javascript">
    var data=document.getElementById("ScannedData-info");
    var inputvalue=document.getElementById("ScannedData2");
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
 // res.classList.remove('d-none');
   inputvalue.value=(LastScan);
   chkBtn.click();
    //data.innerHTML="<i class='bi bi-exclamation-circle-fill'></i>"+("Be sure the box filled with ("+qrCodeMessage+") and Click Check Button");
    //chkBtn.classList.remove('disabled');
    
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

              <?php
      }

else {
            unset($_SESSION['SUCCESS2']);
            unset($_SESSION['FAILURE2']);
            unset($_SESSION['NOTPOSTED2']);
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
 





