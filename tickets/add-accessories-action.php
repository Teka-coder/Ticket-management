 <?php
session_start();
require_once "../connection.php";
include "../phpqrcode/qrlib.php";
    if (isset($_POST['submit'])) {
  
  $id = $_POST['submit'];
  $regby=$_SESSION["username"];
for($i=0;$i<count($_POST['accessory_name']);){
           
             $acc_name=$_POST['accessory_name'][$i];
             $acc_qty=$_POST['accessory_SN'][$i];
             $ii=$i+1;
             $acc_status=$_POST["accessory_status_$ii"];

              $acc_sql="INSERT INTO accessories(tag_or_pn,accessory_name,accessory_SN,accessory_status,created_by) VALUES(?,?,?,?,?)";
              $acc_command=$conn->prepare($acc_sql) or die(mysqli_connect_error($conn));
              $acc_command->bind_param("sssss", $id,$acc_name,$acc_qty,$acc_status,$regby);
              $acc_command->execute();
              $i++;

        }
        if($acc_command){
          // foreach ($acc_name as $value) {
          //   # code...
          // }
   $_SESSION['querysucceed']='Accessories added successfully';
  }  

else{
    $_SESSION['querysucceed']="Unable to add accessory ".$acc_command->error;  
} 
}
else {
$_SESSION['failed']="Can't find the item";
}


 $acc_command->close();
 $conn->close();
 header( "location:".$_SERVER['HTTP_REFERER']);     
        ?>


        <!-- if (isset($_POST['accessory_name'])) {
for($i=0;$i<count($_POST['accessory_name']);){
        
             $acc_name=$_POST['accessory_name'][$i];
             $acc_sn=$_POST['accessory_SN'][$i];
             $ii=$i+1;
             $acc_status=$_POST["accessory_status$ii"];
             $acc_sql="INSERT INTO accessories(tag_or_pn,accessory_name,accessory_SN,accessory_status,created_by) VALUES('".$id."','".$acc_name."','".$acc_sn."','".$acc_status."','".$regby."')";
              $acc_command=$conn->query($acc_sql) or die(mysqli_error($conn));
              $i++;
        }
    } -->