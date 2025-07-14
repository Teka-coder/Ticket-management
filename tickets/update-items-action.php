<?php
    session_start();
include "../connection.php";
    if (isset($_POST['update_asset_item'])) {
  
    $id = $_POST['update_asset_item'];
    $customername = mysqli_real_escape_string($conn, $_POST['customername']);
    $transactionref = mysqli_real_escape_string($conn, $_POST['transactionref']);
    $soldoutremark = mysqli_real_escape_string($conn, $_POST['soldoutremark']);
    $customerphone = mysqli_real_escape_string($conn, $_POST['customerphone']);
    $soldoutstatus='soldout';
    $upby='';
    if ($_SESSION["username"]=='') {
   // $upby='current user';
   $_SESSION['completed']='Session expired';
   header( "location:".$_SERVER['HTTP_REFERER']);
    } else {
    $upby = mysqli_real_escape_string($conn, $_SESSION["username"]);
    
   

    // $qrcode  = $_FILES["QR_code"]["qrcode"];
    // move_uploaded_file($_FILES["QR_code"]["tmp_name"], "QR code/img/" . $_FILES["QR_code"]["qrcode"]);

    
$query1= "SELECT soldout_status FROM tickets  WHERE tickets.id=?;";


$old_cmd=$conn->prepare($query1) or die(mysqli_connect_error($conn));
$old_cmd->bind_param("s",$id);
$old_cmd->execute();
$old=$old_cmd->get_result();
$row = $old->fetch_assoc();
if ($row['soldout_status']!="soldout"){
    $ref_query= "SELECT ticket_unique_id,customer_name FROM tickets  WHERE transaction_ref=?;";
    $ref_cmd=$conn->prepare($ref_query) or die(mysqli_connect_error($conn));
    $ref_cmd->bind_param("s",$transactionref);
    $ref_cmd->execute();
    $ref=$ref_cmd->get_result();
    if ($ref->num_rows > 0){
        $row = $ref->fetch_assoc();
        $usedcustomer=$row['customer_name'];
        $usedticket=$row['ticket_unique_id'];
        $_SESSION['completed']=$itemname.' Oops! You are trying to sell with used Trans. Ref.'.$transactionref.' Used by '.$usedcustomer;
        header( "location:".$_SERVER['HTTP_REFERER']);
    } else{

        $currentDateTime = new DateTime('now');
        $now = $currentDateTime->format('Y-m-d h:i:s');
         $query2 = "UPDATE tickets SET customer_name=?, customer_phone=?, transaction_ref=?, soldout_status=?, date_booked=?, soldout_remark=?, sold_by=? WHERE id=?";
        
        $update_cmd=$conn->prepare($query2) or die(mysqli_connect_error($conn));
        $update_cmd->bind_param("ssssssss",$customername,$customerphone,$transactionref,$soldoutstatus,$now,$soldoutremark,$upby,$id);
        $update_cmd->execute();
        // $stmt= $conn->prepare($query2);
        // $stmt->bind_param("ssssssssss", $itemname,$status,$description,$condition,$acqdate,$assetcategory,$acqvalue,$currentvalue,$explifecycle,$id);
        // $stmt->execute();
    
    }




}
 else 
 {
    $update_cmd=false;
    $_SESSION['completed']=$itemname.' Oops! the ticket is already sold out';
 } 
if($update_cmd==true){

   $_SESSION['completed']=$itemname.' Sold out!';
  }  

else{
    $_SESSION['notposted']="Failed to sell ticket";
}
    }
}
else {
$_SESSION['notposted']="Can't find the ticket";

}
 header( "location:".$_SERVER['HTTP_REFERER']);
?>