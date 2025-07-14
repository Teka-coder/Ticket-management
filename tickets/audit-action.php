<?php
session_start();
require_once "../connection.php";
include "../phpqrcode/qrlib.php";
if (isset($_POST['Checkin']) && $_SESSION['username']!='') {
	 $ticket=$_POST['Checkin'];
   $status='checkedin';
   $stg = "SELECT * FROM tickets WHERE ticket_unique_id=? && checkin_status=?"; // SQL with parameters
   $qtg = $conn->prepare($stg) or die(mysqli_connect_error($conn)); 
   $qtg->bind_param("ss", $ticket,$status);
   $qtg->execute();
   $rtg = $qtg->get_result(); // get the mysqli result
   if($rtg->num_rows > 0) {
    $_SESSION['processed']="Ooops! This Ticket is Used-up ! Unable to check-in";
    $_SESSION["theticket"]=$ticket; 
    mysqli_close($conn);

     header( "location:".$_SERVER['HTTP_REFERER']);
  //  echo $_SESSION['processed'].' '.$_SESSION['theticket'];
    
 }
else{

   
    $auditedby=mysqli_real_escape_string($conn, $_SESSION["username"]);
    $currentDateTime = new DateTime('now');
    $now = $currentDateTime->format('Y-m-d h:i:s');
    $checkinremark = 'Ticket: '.$ticket.' is used up at: '.$now.' and verified by '.$auditedby.'.';
$status='checkedin';
  
 $sql="UPDATE tickets SET verified_by=?,checkin_time=?, checkin_status=?, checkin_remark=? WHERE ticket_unique_id=?";

 $cmd=$conn->prepare($sql);
 $cmd->bind_param("sssss",$auditedby,$now,$status,$checkinremark,$ticket);
 $cmd->execute();
 if ($cmd==TRUE) {
$_SESSION['processed']='Verification completed successfully !';
$_SESSION["theticket"]=$ticket;  
//echo $_SESSION['processed'].' '.$_SESSION['theticket'];    
}
 else {
$_SESSION['processfailed']="Something went wrong, Unable to finish the process";
  //echo $_SESSION["processfailed"]; 
}

mysqli_close($conn);
header( "location:".$_SERVER['HTTP_REFERER']); 

}
   

 
    }
    else {
    	$_SESSION["sessionerror"]="Unable to precess, Logout and Login again!";
     // echo $_SESSION['sessionerror'];
      header( "location:".$_SERVER['HTTP_REFERER']); 
    }
?>