<?php
session_start(); 
include "../connection.php";
if (isset($_POST['allAudit'])) {
 $id=$_POST["selectedItem"];
 //$keyword=$_POST["searchedItem"];
 $query="SELECT statuslist.description as status_desc,item_holder.holder_name,asset.category,warehouse.warehouse_code,
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
 items.custodian FROM items INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id INNER JOIN item_holder on item_holder.id=items.custodian where";
	 $verify=$query." items.id=?;";

$verify_cmd=$conn->prepare($verify) or die(mysqli_connect_error($conn));
$verify_cmd->bind_param("s",$id);
$verify_cmd->execute();
$verify_result=$verify_cmd->get_result();
 if ($verify_cmd==true && $verify_result->num_rows>0) {
$row = $verify_result->fetch_assoc();
		      $_SESSION['SUCCESS']="Detail info in our records !";
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
  //echo $_SESSION['NAME'];       
}
 else {
$_SESSION['FAILURE']="The item not matched our recored";
 //echo $_SESSION["FAILURE"];  
}


mysqli_close($conn);
//header("location:test-file-scan.php");
//header("location:scann-qr-by-camera.php");

header( "location:".$_SERVER['HTTP_REFERER']); 
   







    }
    else {
    $_SESSION['NOTPOSTED']="Error in posting data"; 
     header( "location:".$_SERVER['HTTP_REFERER']); 
    }
?>