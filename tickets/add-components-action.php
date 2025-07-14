 <?php
session_start();
require_once "../connection.php";
include "../phpqrcode/qrlib.php";
    if (isset($_POST['submit'])) {
  
  $id = $_POST['submit'];
  $regby=$_SESSION["username"];
for($i=0;$i<count($_POST['component_name']);){
           
 $comp_name=$_POST['component_name'][$i];
 $comp_desc=$_POST['component_desc'][$i];
 $comp_sql="INSERT INTO components(item_qr,component_name,component_desc,created_by) VALUES(?,?,?,?)";
              $comp_command=$conn->prepare($comp_sql) or die(mysqli_connect_error($conn));
              $comp_command->bind_param("ssss", $id,$comp_name,$comp_desc,$regby);
              $comp_command->execute();
  $i++;
        }
        if($comp_command){
          // foreach ($acc_name as $value) {
          //   # code...
          // }
   $_SESSION['querysucceed']='Components added successfully';
  }  

else{
    $_SESSION['querysucceed']="Unable to add component";  
} 
}
else {
$_SESSION['failed']="Can't find the item";
}
 
   header( "location:".$_SERVER['HTTP_REFERER']);     
        ?>
