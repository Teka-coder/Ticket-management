<?php
session_start();
require_once "../connection.php";
include "../phpqrcode/qrlib.php";

    //if (isset($_POST['asset_transfer_form'])) { 
  $id = $_POST['asset_transfer_form'];
  $itemname=$_POST['iname'];
  $by = mysqli_real_escape_string($conn, $_SESSION["username"]);
  $fcustodian = mysqli_real_escape_string($conn, $_POST['fcustodian']);
   $tcustodian = mysqli_real_escape_string($conn, $_POST['tcustodian']);
   $fcompany = mysqli_real_escape_string($conn, $_POST['fcompany']);
    $tcompany = mysqli_real_escape_string($conn, $_POST['tcompany']);
   $fdep = mysqli_real_escape_string($conn, $_POST['fdepartment']);
  $tdep = mysqli_real_escape_string($conn, $_POST['tdepartment']);
   $fwarehouse = mysqli_real_escape_string($conn, $_POST['fwarehouse']);
  $twarehouse = mysqli_real_escape_string($conn, $_POST['twarehouse']);
  $newadded="";
  $received="";
  $released="";
 if(isset($_POST['new_acc'])) {
     foreach ($_POST['new_acc'] as $key0 => $value0) {
     	$query="UPDATE accessories SET custodian=? WHERE id=?;";
      
$cmd= $conn->prepare($query);
$cmd->bind_param("ss",$tcustodian, $value0);
//$cmd->execute();
     	echo $query."<br>";
     $newadded.=$value0.",";
}
}
 if(isset($_POST['selected_accessory'])) {
     foreach ($_POST['selected_accessory'] as $key1 => $value1) {
     $query2="UPDATE accessories SET custodian=? WHERE id=?;";
$cmd2= $conn->prepare($query2);
$cmd2->bind_param("ss",$tcustodian, $value0);
//$cmd2->execute();
  echo $query2."<br>";
     $received.=$value1.",";
}
	 foreach ($_POST['unselectedAcc'] as $key2 => $value2) {
     $released.=$value2.",";
}

  }
  else {
  $released="No release";
  foreach ($_POST['all_accessory'] as $key3 => $value3) {
   $received.=$value3.",";
}
  }
 
 
 echo $received. "<br />";

       $sql="INSERT INTO item_transaction(item,from_warehouse,to_warehouse,from_custodian,to_custodian,from_dep,to_dep,from_comp,to_comp,new_added,received_acc,released_acc,created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
       $cmd=$conn->prepare($sql);
       $cmd->bind_param("sssssssssssss",$id,$fwarehouse,$twarehouse,$fcustodian,$tcustodian,$fdep,$tdep,$fcompany,$tcompany,$newadded,$received,$released,$by);
      // $cmd->execute();

 echo $sql."<br>";


 mysqli_close($conn);
     //header("location:../tickets/asset-transaction.php");
    //}