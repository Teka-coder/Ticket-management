<?php
session_start(); 
include "../connection.php";
 
if (isset($_GET['reset_item'])) {
	//echo $_POST['roll_item'];
	$id=$_GET['reset_item'];
	$val=3;
 $sql="UPDATE items SET item_status=? where id=?;";
 $cmd=$conn->prepare($sql) or die(mysqli_connect_error($conn));
 $cmd->bind_param("ss",$val,$id);
 $cmd->execute();
 //echo $id." ".$_GET["reset_item"]." ".$sql;
}
  // $_SESSION['querysucceed']=' Reset successfully !';
  //    header( "location:".$_SERVER['HTTP_REFERER']);
       ?>