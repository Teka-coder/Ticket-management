<?php
session_start();
require_once "../connection.php";
include "../phpqrcode/qrlib.php";

    if (isset($_POST['single_transfer_form'])) { 
      if ($_POST['tcustodian']!= $_POST['fcustodian'] or $_POST['tcompany']!= $_POST['fcompany'] or $_POST['tdepartment']!= $_POST['fdepartment'] or $_POST['twarehouse']!=$_POST['fwarehouse']) {
         $id = $_POST['single_transfer_form'];
  $itemname=$_POST['item-name'];
  $by = mysqli_real_escape_string($conn, $_SESSION["username"]);
  $fcustodian = mysqli_real_escape_string($conn, $_POST['fcustodian']);
   $tcustodian = mysqli_real_escape_string($conn, $_POST['tcustodian']);
   $fcompany = mysqli_real_escape_string($conn, $_POST['fcompany']);
    $tcompany = mysqli_real_escape_string($conn, $_POST['tcompany']);
   $fdep = mysqli_real_escape_string($conn, $_POST['fdepartment']);
  $tdep = mysqli_real_escape_string($conn, $_POST['tdepartment']);
   $fwarehouse = mysqli_real_escape_string($conn, $_POST['fwarehouse']);
  $twarehouse = mysqli_real_escape_string($conn, $_POST['twarehouse']);
  $released="No release";
 $newadded="";
$received="";
if(isset($_POST['new_acc'])) {
     foreach ($_POST['new_acc'] as $key0 => $value0) {
      $query="UPDATE accessories SET custodian=? WHERE id=?;";

$comm_query=$conn->prepare($query) or die(mysqli_connect_error($conn));
$comm_query->bind_param("ss",$tcustodian,$value0);
$comm_query->execute();

      $sel="SELECT accessory_name FROM accessories WHERE id=?;";
    
      $cmd=$conn->prepare($sel) or die(mysqli_connect_error($conn));
      $cmd->bind_param("s",$value0);
      $cmd->execute();
      $res=$cmd->get_result();
      if ($res->num_rows>0) 
        $row=$res->fetch_assoc();
        $newadded.=$row["accessory_name"].":_:";
}
}
 foreach ($_POST['acc_name'] as $key => $value) {
  $query2="UPDATE accessories SET custodian=? WHERE id=?;";
     
$comm_query2=$conn->prepare($query2) or die(mysqli_connect_error($conn));
$comm_query2->bind_param("ss",$tcustodian,$value);
$comm_query2->execute();

       $sel2="SELECT accessory_name FROM accessories WHERE id=?;";
   
      $cmd2=$conn->prepare($sel2) or die(mysqli_connect_error($conn));
      $cmd2->bind_param("s",$value);
      $cmd2->execute();
      $res2=$cmd2->get_result();

      if ($res2->num_rows>0) 
        $row2=$res2->fetch_assoc();
   $received.=$row2["accessory_name"].":_:";
}
 //echo $received. "<br />";
$check_sql="SELECT * FROM items WHERE id=?;";

 $check_cmd=$conn->prepare($check_sql) or die(mysqli_connect_error($conn));
$check_cmd->bind_param("s",$id);
$check_cmd->execute();
$check_res=$check_cmd->get_result();

 while($check_rec=$check_res->fetch_assoc()){
  if ($check_rec["Affected"]=='1') {
    continue; 
 }
 
   $orig_sql="INSERT INTO item_transaction(item,from_warehouse,to_warehouse,from_custodian,to_custodian,from_dep,to_dep,from_comp,to_comp,new_added,received_acc,released_acc,created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $val="Not yet";
        $orig_comm=$conn->prepare($orig_sql) or die(mysqli_connect_error($conn));
        $orig_comm->bind_param("sssssssssssss",$id,$check_rec["warehouse"],$check_rec["warehouse"],$check_rec["custodian"],$check_rec["custodian"],$check_rec["department"],$check_rec["department"],$check_rec["company"],$check_rec["company"],$val,$val,$val,$by);
        $orig_comm->execute();
 
 }

       $sql="INSERT INTO item_transaction(item,from_warehouse,to_warehouse,from_custodian,to_custodian,from_dep,to_dep,from_comp,to_comp,new_added,received_acc,released_acc,created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
       $trans_cmd=$conn->prepare($sql) or die(mysqli_connect_error($conn));
       $trans_cmd->bind_param("sssssssssssss",$id,$fwarehouse,$twarehouse,$fcustodian,$tcustodian,$fdep,$tdep,$fcompany,$tcompany,$newadded,$received,$released,$by);
       $trans_cmd->execute();
 // echo $sql;
 if ($trans_cmd) {
           $update_sql="UPDATE items SET warehouse=?,custodian=?,department=?,company=? WHERE id=?";
           $update_command=$conn->prepare($update_sql) or die(mysqli_connect_error($conn));
           $update_command->bind_param("sssss",$twarehouse,$tcustodian,$tdep,$tcompany,$id);
           $update_command->execute();
          
           $_SESSION['querysucceed']=$itemname.' transfered successfully !';
           
}
 else {
   $_SESSION['queryfailed']="Unable to transfer item";
   
}

 mysqli_close($conn);
     header( "location:".$_SERVER['HTTP_REFERER']);   
    }
    else{
       $_SESSION['nochange']="No item transfered, at least one field needs to be changed";
      header( "location:".$_SERVER['HTTP_REFERER']);  
    }
      }
 

elseif(isset($_POST['single_transfer_form2'])) {

  if ($_POST['tcustodian']!= $_POST['fcustodian'] or $_POST['tcompany']!= $_POST['fcompany'] or $_POST['tdepartment']!= $_POST['fdepartment'] or $_POST['twarehouse']!=$_POST['fwarehouse']) {
 $id = $_POST['single_transfer_form2'];
       $itemname=$_POST['item-name'];
  $by = mysqli_real_escape_string($conn, $_SESSION["username"]);
  $fcustodian = mysqli_real_escape_string($conn, $_POST['fcustodian']);
   $tcustodian = mysqli_real_escape_string($conn, $_POST['tcustodian']);
   $fcompany = mysqli_real_escape_string($conn, $_POST['fcompany']);
    $tcompany = mysqli_real_escape_string($conn, $_POST['tcompany']);
   $fdep = mysqli_real_escape_string($conn, $_POST['fdepartment']);
  $tdep = mysqli_real_escape_string($conn, $_POST['tdepartment']);
   $fwarehouse = mysqli_real_escape_string($conn, $_POST['fwarehouse']);
  $twarehouse = mysqli_real_escape_string($conn, $_POST['twarehouse']);
  $released="";
 $newadded="";
$received="";
if(isset($_POST['new_acc'])) {
     foreach ($_POST['new_acc'] as $key0 => $value0) {
      $query="UPDATE accessories SET custodian=? WHERE id=?;";
    
$comm_query=$conn->prepare($query) or die(mysqli_connect_error($conn));
$comm_query->bind_param("ss",$tcustodian,$value0);
$comm_query->execute();

       $sel="SELECT accessory_name FROM accessories WHERE id=?;";
       $cmd=$conn->prepare($sel) or die(mysqli_connect_error($conn));
       $cmd->bind_param("s",$value0);
       $res=$cmd->get_result();

      if ($res->num_rows>0) 
        $row=$res->fetch_assoc();
     $newadded.=$row["accessory_name"].":_:";
}
}

 foreach ($_POST['accessory'] as $key1 => $value1) {
     $query2="UPDATE accessories SET custodian=? WHERE id=?;";
      
$comm_query2=$conn->prepare($query2) or die(mysqli_connect_error($conn));
$comm_query2->bind_param("ss",$tcustodian,$value1);
$comm_query2->execute();

       $sel2="SELECT accessory_name FROM accessories WHERE id=?;";
     
      $cmd2=$conn->prepare($sel2) or die(mysqli_connect_error($conn));
      $cmd2->bind_param("s",$value1);
      $cmd2->execute();
      $res2=$cmd2->get_result();
      if ($res2->num_rows>0) 
        $row2=$res2->fetch_assoc();
     $received.=$row2["accessory_name"].":_:";
}
   foreach ($_POST['unselected'] as $key2 => $value2) {
 $sel3="SELECT accessory_name FROM accessories WHERE id=?;";
      
      $cmd3=$conn->prepare($sel3) or die(mysqli_connect_error($conn));
      $cmd3->bind_param("s",$value2);
      $cmd3->execute();
      $res3=$cmd3->get_result();
      if ($res3->num_rows>0) 
        $row3=$res3->fetch_assoc();
     $released.=$row3["accessory_name"].":_:";
}
     
$check_sql="SELECT * FROM items WHERE id=?;";

 $check_cmd=$conn->prepare($check_sql) or die(mysqli_connect_error($conn));
 $check_cmd->bind_param("s",$id);
 $check_cmd->execute();
 $check_res=$check_cmd->get_result();
 while($check_rec=$check_res->fetch_assoc()){
  if ($check_rec["Affected"]=='1') {
    continue; 
 }
 
   $orig_sql="INSERT INTO item_transaction(item,from_warehouse,to_warehouse,from_custodian,to_custodian,from_dep,to_dep,from_comp,to_comp,new_added,received_acc,released_acc,created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
     $val="Not yet";
 $orig_com=$conn->prepare($orig_sql) or die(mysqli_connect_error($conn));
 $orig_com->bind_param("sssssssssssss",$id,$check_rec["warehouse"],$check_rec["warehouse"],$check_rec["custodian"],$check_rec["custodian"],$check_rec["department"],$check_rec["department"],$check_rec["company"],$check_rec["company"],$val,$val,$val,$by);
 $orig_com->execute();
 }
      $sql="INSERT INTO item_transaction(item,from_warehouse,to_warehouse,from_custodian,to_custodian,from_dep,to_dep,from_comp,to_comp,new_added,received_acc,released_acc,created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $trans_cmd=$conn->prepare($sql) or die(mysqli_connect_error($conn));
      $trans_cmd->bind_param("sssssssssssss",$id,$fwarehouse,$twarehouse,$fcustodian,$tcustodian,$fdep,$tdep,$fcompany,$tcompany,$newadded,$received,$released,$by);
      $trans_cmd->execute();
     
 // echo $sql;
 if ($trans_cmd) {
   $update_sql="UPDATE items SET warehouse=?,custodian=?,department=?,company=? WHERE id=?";
   
    $update_command=$conn->prepare($update_sql) or die(mysqli_connect_error($conn));
    $update_command->bind_param("sssss",$twarehouse,$tcustodian,$tdep,$tcompany,$id);
    $update_command->execute();
   $_SESSION['querysucceed']=$itemname.' trasfered successfully !';
           
}
 else {
   $_SESSION['queryfailed']="Unable to transfer item";
   
}

 mysqli_close($conn);
     header( "location:".$_SERVER['HTTP_REFERER']);   
    }
    else{
       $_SESSION['nochange']="No item transfered, at least one field needs to be changed";
      header( "location:".$_SERVER['HTTP_REFERER']);  
    }

  }



     
?>


    
    
    
    
    