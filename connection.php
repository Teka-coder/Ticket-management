<?php 
$conn = mysqli_connect("localhost", "root", "1234", "tvs");
//$conn = mysqli_connect("localhost", "btsccffu", "Umx1B4o1N-80Y*LA![T", "btsccffu_tvs");

// if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
//     $cu = "https"; 
// Redirect to HTTPS if necessary
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://tvs.btsc-cfs.com");
    exit();
  }
else
    $cu = "http"; 
$cu .= "://"; 
$cu .= $_SERVER['HTTP_HOST']; 
$cu .= $_SERVER['REQUEST_URI']; 
?>