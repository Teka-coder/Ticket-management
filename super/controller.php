<?php 
include('../connection.php');

if(isset($_POST['save_multiple_data']))
{
    $name = $_POST['name'];
    $passw = $_POST['pass'];
    $rolee = $_POST['role'];
    $com = $_POST['company'];
    $stat = $_POST['status'];
    if($stat == '')
    $stat = 0;

    $user_query = "SELECT * FROM account WHERE username='$name' ";
    $user_query_run = mysqli_query($conn, $user_query);
    if(mysqli_num_rows($user_query_run) > 0)
    {
        $_SESSION['status'] = "User name Already Taken. Please Try Another one.";
        $_SESSION['status_code'] = "error";
        header("Location: account.php?asset=$cata");  
    }

  else{
    foreach($name as $index => $names)
    {
        $s_name = $names;
        $s_role = $rolee[$index];
        $_passw = md5($passw[$index]);
        $s_com = $com[$index];
        $status = $stat[$index];
        
     
        $query = "INSERT INTO account (username,password,role,company,status) VALUES ('$s_name','$_passw','$s_role','$s_com','$status')";
        $query_run = mysqli_query($conn, $query);
    }
}
  echo $s_name.$s_role.$_passw.$s_com.$status; 

    if($query_run)
    {
        $_SESSION['status'] = "Data Inserted Successfully";
        header("Location:account.php?asset=$cata");
       
    }
    else
    {
        $_SESSION['status'] = "Data Not Inserted";
        header("Location:account.php?asset=$cata");
      
    }
}

if(isset($_POST['updatedata']))
{   
    //$id = $_POST['update_id'];   
    $name = $_POST['name'];
    $role = $_POST['role'];
    $company = $_POST['company'];
    $status = (isset($_POST['stat']))?", `status`='".$_POST['stat']."'":"";


    $query = "UPDATE account SET username='$name', `role`='$role', company='$company'$status WHERE username='$name'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Updated"); </script>';
        exit(0);
        //header("Location:account.php?asset=$cata");
    }
    else
    {
        echo '<script> alert("Data Not Updated"); </script>';
        exit(0);
       // header("Location:account.php?asset=$cata");
    }
}
if(isset($_POST['resetpass'])){

    $namee = $_POST['namee'];
    $password = md5('123');
   
    $reset = "UPDATE account SET password = '$password' WHERE username = '$namee'";
    $query_run = mysqli_query($conn, $reset);

    if($query_run)
    {
        echo '<script> alert("Password resetted successfully"'.$namee.');</script>';         
    }
    else
    {
        echo '<script> alert("Action not successful"); </script>';           
    }

} 







if(isset($_POST['updateckinsp'])){
    $int_okay="";
    $ex_okay="";
    $int_notokay="";
    $ex_notokay="";
    $int_not_available="";
    $ext_not_available=""; 

    $test2 ="SELECT * FROM checklist_item";
    $res2 = $conn->query($test2);
      if ($res2->num_rows > 0) {
          while($row2 = $res2->fetch_assoc()){
              if($row2['type']=="interior")
              {
                if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes'){
                    $int_okay.= str_replace('_',' ',$row2['item_name'])." , ";
                }
                elseif($_POST[str_replace(' ','_',$row2['item_name'])]=='no'){
                  $status++;
                  $int_notokay.= str_replace('_',' ',$row2['item_name'])." , ";                                                 
                }
                else{
                  $int_not_available.= str_replace('_',' ',$row2['item_name'])." , "; 
                }                         
              }
              else
              {
                if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes'){
                    $ex_okay.= str_replace('_',' ',$row2['item_name'])." , ";}
                elseif($_POST[str_replace(' ','_',$row2['item_name'])]=='no'){
                  $status++;
                  $ex_notokay.= str_replace('_',' ',$row2['item_name'])." , ";                                                 
                }
                 else{
                 $ext_not_available.= str_replace('_',' ',$row2['item_name'])." , ";
                 }                        
              }
            }
    $query = "UPDATE inspection SET int_okay='$int_okay', int_notokay='$int_notokay', int_not_available='$int_not_available', ex_okay='$ex_okay',ex_notokay='$ex_notokay',ext_not_available='$ext_not_available' WHERE id='$iid'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Updated"); </script>';      
    }
    else
    {
        echo '<script> alert("Data Not Updated"); </script>';
    }   
}
}


/*if(isset($_POST['deleteinsp']))
{
    $uname = $_POST['delete_id'];

    $query = "DELETE FROM account WHERE `username`='$uname'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Deleted");</script>';
    }
    else
    {
       echo '<script> alert("Data Not Deleted");</script>';
    }
}*/
if(isset($_POST['deleteinsp'])){   
$id = $_POST['delete_id'];
$sql = "SELECT * from ext_inspection where exinsp_id='$id'";
$result1=mysqli_query($conn, $sql);
while($row = $result1->fetch_assoc())  
{
 $dd=$row['image'];
 unlink($dd);
}
$query1 = "DELETE FROM ext_inspection WHERE exinsp_id = '$id'";
mysqli_query($conn, $query1);

$sql2 = "SELECT * from int_inspection where insp_id='$id'";
$result2=mysqli_query($conn, $sql2);
while($ro = $result2->fetch_assoc())  
{
 $dd=$ro['image'];
 unlink($dd);

}
$query2 = "DELETE FROM int_inspection WHERE insp_id ='$id'";
mysqli_query($conn, $query2);

$query3 = "DELETE FROM inspection WHERE id = '$id'";
    $run = mysqli_query($conn, $query3);
    if($run)
    {   
        $cata = $_GET['asset'];
        echo $dd;
        echo  '<script> alert("Data Deleted");</script>';
        header("Location:inspectionmanager.php?asset=$cata"); 
        exit(0);
    }
    else
    {
        $cata = $_GET['asset'];
        $pnn = $_GET['pn'];
        $date = $_GET['date'];
        $iid=$_GET['id'];
       echo '<script> alert("Data Not Deleted");</script>';
       header("Location:edit.php?asset=$cata&pn=$pnn&date=$date&id=$iid");
       exit(0); 
    }
}

if(isset($_POST["check_submit_btn"])){
    $plate =$_POST['plateno_id'];
    $que= "SELECT * from checklist_item";
      $result = $conn->query($que);
      //$rows =  mysqli_num_rows($result); 
        if(mysqli_num_rows($result) > 0){
          //$_SESSION['status'] = "vehicle already exists";
         echo"item already exists";
        //header("location:inde.php");
       }
    }
       
if(isset($_POST["additem"])){
    $itemname=$_POST['itemname'];
    $itemtype=$_POST['itemtype']; 
                
         $sq = "INSERT INTO `checklist_item`(`item_name`,`type`) VALUES ('$itemname','$itemtype')";
        $re = $conn->query($sq);
        header("Location:inspectionmanager.php?asset=$cata");     
           } 
?>