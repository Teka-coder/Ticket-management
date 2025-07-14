<?php
session_start();
require_once "../connection.php";
include "../phpqrcode/qrlib.php";

    $ticketid = mysqli_real_escape_string($conn, $_POST['ticketid']);
    $generalremark = mysqli_real_escape_string($conn, $_POST['generalremark']);
    $ticketprice = mysqli_real_escape_string($conn, $_POST['ticketprice']);
    $regby = mysqli_real_escape_string($conn, $_SESSION["username"]);
    //$tempDir = "C:\\wamp64\www\\tvsfile\QR_code\\";
    $tempDir = "C:\\wamp64\www\\tvs\QR_code\\";
   // $qrcode = 'Ticket_'.md5($ticketid);
    $qrplain='Ticket_'.$ticketid;
    $qrplainpng='Ticket_'.$ticketid.'.png';
    $pngAbsoluteFilePath = $tempDir.$qrplainpng;
    
  
// generating qr code

  $stg = "SELECT * FROM tickets WHERE ticket_unique_id=?"; // SQL with parameters
  $qtg = $conn->prepare($stg) or die(mysqli_connect_error($conn)); 
  $qtg->bind_param("s", $ticketid);
  $qtg->execute();
  $rtg = $qtg->get_result(); // get the mysqli result


    if (empty($_POST['ticketid']) || empty($_POST['ticketprice']) ) {
        $_SESSION['notposted']="Ticket ID or Price are empty! Unable to Add recored";
        header( "location:".$_SERVER['HTTP_REFERER']);
    }
    elseif($rtg->num_rows > 0) {
       $_SESSION['notposted']="Ooops! Ticket already exist with this Ticket ID ! Unable to Add recored";
        header( "location:".$_SERVER['HTTP_REFERER']);
    }
  else{
  
  QRcode::png($qrplain, $pngAbsoluteFilePath, 'H', 4, 4); //or QRcode::png($qrcode, $pngAbsoluteFilePath);
// Check if QR code was generated
if (file_exists($pngAbsoluteFilePath)) {

  $sql="INSERT INTO tickets(ticket_unique_id, price, general_remark, qr_code,qr_plain,inserted_by) VALUES(?,?,?,?,?,?)";

  $sql_command=$conn->prepare($sql) or die(mysqli_connect_error($conn));
  $sql_command->bind_param("ssssss",$ticketid,$ticketprice,$generalremark,$qrplain,$qrplainpng,$regby);
              

 if ($var=$sql_command->execute()===TRUE) {
   $last_id = $conn->insert_id;
   //$last_id=10000;
$_SESSION['completed']="Ticket with ID:".$ticketid.' Added successfully !';
  //echo $_SESSION["completed"];      
}
 else {
$_SESSION['completed']="Unable to Add recored";
  //echo $_SESSION["completed"]; 
}
mysqli_close($conn);


  //die("Error: QR code generation failed.");
}else{
  $_SESSION['notposted']="Ooops! Can't generate QR code";
  header( "location:".$_SERVER['HTTP_REFERER']);
}






    }
    header( "location:".$_SERVER['HTTP_REFERER']); 
?>


    
    
    
    
    