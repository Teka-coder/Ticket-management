<?php
include "../connection.php";




 if (isset($_POST['MatchScan'])) {
 $qr=$_POST["ScannedData"];

 $verify="SELECT statuslist.description as status_desc,item_holder.holder_name,asset.category,warehouse.warehouse_code,
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
 items.custodian FROM items INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id INNER JOIN item_holder on item_holder.id=items.custodian where items.QR_plain=?;";
 //$verify_result=$conn->query($verify);
// echo "<h1>".$verify."</h1>";
//  echo $verify;
// echo $qr; 
$verify_cmd=$conn->prepare($verify);
$verify_cmd->bind_param("s",$qr);
$verify_cmd->execute();
$verify_result=$verify_cmd->get_result();
 if ($verify_cmd==true && $verify_result->num_rows>0) {
$row = $verify_result->fetch_assoc();
    $_SESSION['SUCCESS2']="Item Matched";
    $_SESSION['ID2'] = $row["id"];
    $_SESSION['IMAGE2']=$row["QR_code"];  
	$_SESSION['STATUS2']=$row["status_desc"];
	$_SESSION['ACQ_DATE2']=$row["acquisition_date"];
	$_SESSION['ACQ_VAL2']=$row["acquisition_value"];
	$_SESSION['CONDITION2']=$row["item_condition"];
	$_SESSION['CUSTODIAN2']=$row["holder_name"];
	$_SESSION['CUR_VAL2']=$row["current_value"];
	$_SESSION['EXP_LC2']=$row["expected_lifecycle"];
	$_SESSION['TAG-PN2']=$row["tag_or_pn"];
	$_SESSION['SN2']=$row["manufactures_SN"];
	$_SESSION['AT2']=$row["created_at"];
	$_SESSION['BY2']=$row["created_by"];
	$_SESSION['DEP2']=$row["department"];
	$_SESSION['WARE2']=$row["warehouse_code"];
	$_SESSION['COMP2']=$row["company"];
	$_SESSION['CAT2']=$row["category"];
	$_SESSION['NAME2']=$row["item_name"];
 // echo $_SESSION['NAME'];       
}
 else {
$_SESSION['FAILURE2']="The item not matched our recored";
 echo $_SESSION["FAILURE2"];  
}




mysqli_close($conn);
//header("location:test-file-scan.php");
//header("location:scann-qr-by-camera.php");
header( "location:".$_SERVER['HTTP_REFERER']); 
    }
    else {
    $_SESSION['NOTPOSTED2']="Oops! something error in posting data";	
    header( "location:".$_SERVER['HTTP_REFERER']); 
    }