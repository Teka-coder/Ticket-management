<?php 
include "../connection.php";
 //echo $_GET['delete_item'];
if (isset($_GET['delete_item'])) {
 $sql="DELETE  from items where id=?";
 $cmd=$conn->prepare($sql) or die(mysqli_connect_error());
 $cmd->bind_param("s",$_GET['delete_item']);
 $cmd->execute();
}
?>