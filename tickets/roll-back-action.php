<?php
session_start(); 
include "../connection.php";
 
 if (isset($_POST['transfer_asset'])) { 
  $id = $_POST['transfer_asset'];
  $by = mysqli_real_escape_string($conn, $_SESSION["username"]);
  $fcustodian = mysqli_real_escape_string($conn, $_POST['custodian']);
   $tcustodian = mysqli_real_escape_string($conn, $_POST['custodian']);
   $fcompany = mysqli_real_escape_string($conn, $_POST['custodian']);
    $tcompany = mysqli_real_escape_string($conn, $_POST['custodian']);
   $fdep = mysqli_real_escape_string($conn, $_POST['custodian']);
  $tdep = mysqli_real_escape_string($conn, $_SESSION["username"]);
   $fwarehouse = mysqli_real_escape_string($conn, $_POST['custodian']);
  $twarehouse = mysqli_real_escape_string($conn, $_SESSION["username"]);
  //now fetch old data to show the change
  $prev_query="SELECT item_holder.holder_name FROM items INNER JOIN item_holder on items.custodian=item_holder.id where items.id=?";
 $update_query = "UPDATE items SET custodian=? where id=?";

 $prev_cmd=$conn->prepare($prev_query);
 $prev_cmd->bind_param("s",$id);
 $prev_cmd->execute();
 $prev_result=$prev_cmd->get_result();
  if ($prev_result->num_rows > 0) {
    $row = $prev_result->fetch_assoc();
     $pre_user=$row["holder_name"];

     $update_cmd=$conn->prepare($update_query);
     $update_cmd->bind_param("ss",$custodian,$id);
     $update_cmd->execute();

if($update_cmd){
 $new_query="SELECT item_holder.holder_name FROM items INNER JOIN item_holder on items.custodian=item_holder.id where items.id=?";
 $new_cmd=$conn->prepare($new_query) or die(mysqli_connect_error($conn));
 $new_cmd->bind_param("s",$id);
 $new_cmd->execute();
 $newer=$new_cmd->get_result();
  if ($newer->num_rows > 0) 
    $rec = $older->fetch_assoc();
    $new_user=$rec["holder_name"];
$now = date('Y-m-d H:i:s');
$change_text="The custodian for ".$row["item_name"].":_:Changed from ".$pre_user." to ".$rec["holder_name"].":_:by ".$upby." at ".$now;
$history="INSERT INTO history(item,change_log,updated_by) VALUES (?,?,?)";
$command=$conn->prepare($history) or die(mysqli_connect_error($conn));
$command->bind_param("sss",$id,$change_text,$upby);
$command->execute();
   
   $_SESSION['querysucceed']='Item holder changed from '.$pre_user.' to '.$new_user;
  }  

else{
    $_SESSION['queryfailed']="Unable to Save the change";  
}
}
else {
  $_SESSION['queryfailed']="Unable to Update recored!, Can't fetch old data";
}
header( "location:".$_SERVER['HTTP_REFERER']);
}
else {
$_SESSION['notposted']="Can't find the item";
header( "location:".$_SERVER['HTTP_REFERER']);
}
?>