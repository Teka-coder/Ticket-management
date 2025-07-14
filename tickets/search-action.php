<?php
$query = "";
$keyword = $_REQUEST['keyword'];
$company = $_REQUEST['company'];
$custodian = $_REQUEST['custodian'];
$department=$_REQUEST['department'];
if(isset($keyword)){//if keyword set goes here
   $query = "SELECT * FROM items WHERE company LIKE '%$keyword%' OR custodian LIKE '%$keyword%' OR department LIKE '%$keyword%'";
   if(isset($company)){
     $query .= "AND company LIKE '$companyy'";
   }
   if(isset($custodian)){
     $query . = "AND custodian LIKE '$custodian'"
   }
     if(isset($department)){
     $query . = "AND department LIKE '$department'"
   }
}else if (isset($company)){ //if keyword not set but category set then goes here
  $query = "SELECT * FROM items WHERE company LIKE '$company'";
  if(isset($custodian)){
    $query . = "AND custodian LIKE '$custodian'";
  }
}else if(isset($country)){//if only country set goes here
  $query = "SELECT * FROM items WHERE custodian LIKE '$custodian'"
}
?>