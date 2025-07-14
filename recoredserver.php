<?php 
include("../connection.php");
/****************for specefic vehicle description**************/
//Include required phpmailer files
require 'include/PHPMailer.php';
require 'include/SMTP.php';
require 'include/Exception.php';
//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create instance of phpmailer
$mail = new PHPMailer();

///////// for submit  /////////////  
if(isset($_POST["submit"]))
 {
  $comm=$_POST['note'];
  $_SESSION['comment'] = str_replace("'","\'",$comm);
  $_SESSION['submit'] = $ppn;
  $_SESSION['inspectiontype'] ='Regular';
  $_SESSION['prev_odometer_reading'] = '';
  $_SESSION['serviced_at_odo'] =$_POST['serviced'];
  $status=0;
 

  if(isset($_SESSION['curr_odo'])){
    $_SESSION['curr_odometer_reading'] = $_SESSION['curr_odo'];
  }
  else
  {
    $_SESSION['curr_odometer_reading'] = $_POST['odometer'];
  }

  

 if(isset($_SESSION['random'])){
  $_SESSION['inspectiontype'] ='Random';
  }             
              $_SESSION['int_okay']="";
              $_SESSION['ex_okay']="";
              $_SESSION['int_notokay']="";
              $_SESSION['ex_notokay']="";
              $_SESSION['int_not_available']="";
              $_SESSION['ext_not_available']="";          
                                                  
              $test2 ="SELECT * FROM checklist_item";
              $res2 = $conn->query($test2);
                if ($res2->num_rows > 0) {
                    while($row2 = $res2->fetch_assoc()){
                        if($row2['type']=="interior")
                        {
                          if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes'){
                            $_SESSION['int_okay'].= str_replace('_',' ',$row2['item_name'])." , ";
                          }
                          elseif($_POST[str_replace(' ','_',$row2['item_name'])]=='no'){
                            $status++;
                            $_SESSION['int_notokay'].= str_replace('_',' ',$row2['item_name'])." , ";                                                 
                          }
                          else{
                            $_SESSION['int_not_available'].= str_replace('_',' ',$row2['item_name'])." , "; 
                          }                         
                        }
                        else
                        {
                          if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes'){
                            $_SESSION['ex_okay'].= str_replace('_',' ',$row2['item_name'])." , ";}
                          elseif($_POST[str_replace(' ','_',$row2['item_name'])]=='no'){
                            $status++;
                            $_SESSION['ex_notokay'].= str_replace('_',' ',$row2['item_name'])." , ";                                                 
                          }
                           else{
                            $_SESSION['ext_not_available'].= str_replace('_',' ',$row2['item_name'])." , ";
                           }                        
                        }
                      }
                     
                  }                      
            if($status > 0 ){                  
              $_SESSION['email'] = true;                                
                  } 
     
  header("location:interiorinspection.php?asset=".$_SESSION['cata']."&pn=$ppn");  
                                      
        $si=array('odometer','dashboared', 'frontseat', 'backseat', 'frontbackview', 'trunk');
        foreach($si as $li)
        {
          unset($_POST[$li]);
        }                          
                }                                          
        
/////////exterior//////////
  if(isset($_POST['image'])){
    $img = $_POST['image'];
    $folderPath = "../upload/";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.jpg';
  
      $file = $folderPath . $fileName;
     file_put_contents($file, $image_base64);

    if(isset($_SESSION['current']))
    {
      $_SESSION[$_SESSION['current']] = $file;
      unset($_SESSION['current']);
    }
    else if(isset($_SESSION['eopt']))
    {
      $_SESSION[$_SESSION['eopt']] = $file;
    }
  }
  
  //////////interior////////////////
  if(isset($_POST['image2'])){
    $img = $_POST['image2'];
    $folderPath = "../upload2/";
    
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.jpg';
    $filee = $folderPath . $fileName;
    file_put_contents($filee, $image_base64); 
    if(isset($_SESSION['curr']))
    {
      $_SESSION[$_SESSION['curr']] = $filee;
      unset($_SESSION['curr']);
    }
    else if(isset($_SESSION['iopt']))
    {
      $_SESSION[$_SESSION['iopt']] = $filee;    
    }  
  }
  //}

  

  //////////////////////////////////////////***************************/////////////////////////////////
  
  $side=array('front', 'front_bonnet', 'front_wing_driver_side', 'front_wing_pass_side', 'front_door_driver_side',
  'front_door_pass_side', 'back_door_driver_side', 'back_door_pass_side', 'back_wing_driver_side', 'back_wing_pass_side', 'rear_top_view',
'rear_down_view');

  foreach($side as $s){  
  if(isset($_POST[$s])){  
    $_SESSION['status'.$s]=$_POST['status'.$s];
    if($_SESSION['status'.$s]=='damaged'){
      $_SESSION['damage'.$s]=$_POST['damage'.$s];
      $_SESSION['remark'.$s]=$_POST['remark'.$s];
     
    }
    $_SESSION['current']=$s;
    header("location:firsttry.php?asset=$cata&pn=$ppn");
    }
  }
  if(isset($_POST['optional2'])){
   // if(!isset($_SESSION['index_eopt'])) $_SESSION['index_eopt']=0;
   // else 
   // $_SESSION['index_eopt']++;
   // for($e = 0; $e <=  $_SESSION['index_eopt'] ; $e++ ){
    $_SESSION['eopt']='optional2';
    $_SESSION['statuseopt']=$_POST['statusoptional2'];
    if($_SESSION['statuseopt']=='damaged'){
      $_SESSION['damageeopt']=$_POST['damageoptional2'];
      $_SESSION['remarkeopt']=$_POST['remarkoptional2'];    
   // }
  }
  header("location:firsttry.php?asset=$cata&pn=$ppn"); 
  }
  ///////////////////////////////*****************////////////////////////////////////
  $si=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
  foreach($si as $li){    
    if(isset($_POST[$li]))
    {
      $_SESSION['status'.$li]=$_POST['status'.$li];
      if($_SESSION['status'.$li]=='damaged'){
        $_SESSION['damage'.$li]=$_POST['damage'.$li];
        $_SESSION['remark'.$li]=$_POST['remark'.$li];
        $_SESSION['email']=true;
      }
      $_SESSION['curr']=$li;
               
    $si=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
    foreach($si as $li)
    {
      unset($_POST[$li]);
    }
      header("location:camera2.php?asset=$cata&pn=$ppn");
    } 
  }

  if(isset($_POST['optional'])){
   // if(!isset($_SESSION['index_iopt'])) 
   // $_SESSION['index_iopt']=0;
   // else 
   // $_SESSION['index_iopt']++;
   // for($i = 0; $i <= $_SESSION['index_iopt']; $i++ ){
    $_SESSION['iopt']='optional';
    $_SESSION['statusopt']=$_POST['statusoptional'];
    if($_SESSION['statusopt']=='damaged'){
      $_SESSION['damageopt']=$_POST['damageoptional'];
      $_SESSION['remarkopt']=$_POST['remarkoptional'];
   // }
  }
  header("location:camera2.php?asset=$cata&pn=$ppn"); 
  }
 
///////////////////////////////////////////for interior body inspection//////////////////////////////////////
  if(isset($_POST['isubmit'])){                  
    foreach($_SESSION['type'] as $li){     
      if(!isset($_SESSION[$li]))
      {
        $_SESSION['err']= '<script>alert("all images are required")</script>';
        break;
      }
    }    
    header("location:bodystructure.php?asset=$cata&pn=$ppn");
 
} 
   
///////////////////////////////////for exterior body inspection/////////////////////////////////////  
  if(isset($_POST['bsubmit'])){
    $inspection_date=date('Y-m-d H:i:s');
    $nxt_insp_date = date('y-m-03',strtotime('+1 month',strtotime($inspection_date)));
    $test ="SELECT model,plateno,driver,company FROM vehicle WHERE plateno = '$ppn'";
    $res = $conn1->query($test);
      $companypp="non";$model=$driver="";
      if ($res->num_rows > 0) {
          while($row = $res->fetch_assoc()){          
            $model=$row['model'];
            $plateno=$row['plateno'];
            $driver=$row['driver'];
            $companypp=$row['company'];              
          }
        }
    $que="INSERT INTO `inspection` (`catagory`,`model`, `plateno`, `inspection_date`, `nxt_inspection_date`, `int_okay`,`int_notokay`, `ex_okay`, `ex_notokay`,`int_not_available`,`ex_not_available`,`inspected_by`, `driver`,`prev_odometer_reading`,`odometer_reading` ,`serviced_at_odo`,`company`,`comments`,`inspection_type`)

   VALUES('$cata','".$model."','".$plateno."','".$inspection_date."','".$nxt_insp_date."','".$_SESSION['int_okay']."',
                 '".$_SESSION['int_notokay']."','".$_SESSION['ex_okay']."','".$_SESSION['ex_notokay']."','".$_SESSION['int_not_available']."','".$_SESSION['ext_not_available']."','".$_SESSION['username']."','".$driver."','".$_SESSION['prev_odometer_reading']."','".$_SESSION['curr_odometer_reading']."','". $_SESSION['serviced_at_odo']."','".$companypp."','".$_SESSION['comment']."','".$_SESSION['inspectiontype']."')";
              
    if($conn->query($que)==true){
          $_SESSION['insp_id'] = $conn->insert_id;
          $_SESSION['inspected'.$ppn] = true;
          if(isset($_SESSION['random'])){
          unset($_SESSION['random']);
          unset($_SESSION['date']);
          }
        }

        if(isset($_SESSION['iopt'])){
         
          $sta = $_SESSION['statusopt'];   
          $damtype='';
          $rem='';
          
          if($sta=='damaged'){
            foreach($_SESSION['damageopt'] as $v)       
            $damtype .= $v.",";
            $rem =  $_SESSION['remarkopt'];
            $_SESSION['email']=true;
          }
            if(isset($_SESSION['optional'])){
            $query3 = "INSERT INTO `int_inspection`(`name`,`image`, `status`, `damage_type`,`remark`, `insp_id`)VALUES('optional','".$_SESSION['optional']."','$sta','$damtype','$rem', '".$_SESSION['insp_id']."')";
            $result2 = $conn->query($query3) or die(mysqli_error($conn));
            } 
           
        } 

    if(!isset($_SESSION['err'])){
      foreach($_SESSION['type'] as $li){ 
        $status = $_SESSION['status'.$li];   
        $damagetype='';
        $remark='';
        if($status=='damaged'){
          foreach($_SESSION['damage'.$li] as $va)       
          $damagetype .= $va.",";       
          $remark =  $_SESSION['remark'.$li];
          $_SESSION['email']=true;
        } 
        $query2 = "INSERT INTO `int_inspection`(`name`,`image`, `status`, `damage_type`,`remark`, `insp_id`)VALUES('$li','".$_SESSION[$li]."','$status','$damagetype','$remark', '".$_SESSION['insp_id']."')";
        $result = $conn->query($query2) or die(mysqli_error($conn)); 
        
        if($result==true){      
            $_SESSION['submit']=true;        
        }  
    }
  }   
  
  if(isset($_SESSION['eopt'])){
    $stae = $_SESSION['statuseopt'];   
    $damtypee='';
    $reme='';
    if($stae=='damaged'){
      foreach($_SESSION['damageeopt'] as $vari)       
      $damtypee .= $vari.",";
      $reme =  $_SESSION['remarkeopt'];
      $_SESSION['email']=true;
    }
      if(isset($_SESSION['optional2'])){
      $q = "INSERT INTO `ext_inspection`(`name`,`image`, `status`, `damage_status`,`remark`, `exinsp_id`)VALUES('optional','".$_SESSION['optional2']."','$stae','$damtypee','$reme', '".$_SESSION['insp_id']."')";
      $r = $conn->query($q) or die(mysqli_error($conn)); 
      }   
}

  foreach($_SESSION['side'] as $s){
    if(!isset($_SESSION[$s]))
    {
     $_SESSION['error']= '<script>alert("all images are required")</script>';
      break;
    } 
    }
  if(!isset($_SESSION['error'])){
    foreach($_SESSION['side'] as $s){   
      $stat = $_SESSION['status'.$s];   
      $damagety='';
      $remrk='';
      if($stat=='damaged'){
        foreach($_SESSION['damage'.$s] as $var)
        $damagety .= $var.",";
        $remrk =  $_SESSION['remark'.$s];
        $_SESSION['email']=true;
        } 
    $query3 = "INSERT INTO `ext_inspection`(`name`,`image`,`status`,`damage_status`,`remark`,`exinsp_id`)VALUES('$s','".$_SESSION[$s]."','$stat','$damagety','$remrk','".$_SESSION['insp_id']."')";
    $result2=$conn->query($query3);
     //}
  }
if(isset($_SESSION['email'])){
//Set mailer to use smtp
$mail->isSMTP();
//define smtp host
$mail->Host = "smtp.gmail.com";
//enable smtp authentication
$mail->SMTPAuth ="true";
//set type of encryption(ssl/tls)
$mail->SMTPSecure = "tls";
//set port to connect smtp
$mail->Port = "587";
//set gmail username
$mail->Username = "assethagbes@gmail.com";
//set gmail password
$mail->Password = "gszlagohzwdznkyx";
//set email subject
$date=date("Y-m-d");
$mail->IsHTML(true);

$mail->Subject = "Issue Report on vehicle $ppn for driver $driver";
//set sender email
$mail->setFrom("assethagbes@gmail.com","AIS | Asset Inspection System");
//email body
//$mail->Body = "Vehicle#:$ppn<br>Vehicle Name:$model<br><br><strong>Defective item(internal):</strong><br><br>For more visit <a href='http://ais.hagbes.com'>HERE</a><br><br>With Ragards,<br>AIS Software Development Team";
$mail->Body = "Dear Sir/Madam,<br><br>This vehicle $ppn($model) for date <strong>'$date'</strong> has status:<ul><li> not ok</li><li>not available or</li> <li>damaged part or body.</li></ul><br><br>For more visit <a href='http://ais.hagbes.com'>HERE</a><br><br>With Ragards,<br>AIS Software Development Team";
//add recipient
$recipients = array(
   'zewdu.tesfaye@hagbes.com' => 'Zewdu Tesfaye',
   'sevag.behesnilian@hagbes.com' => 'Sevag Behesnilian',
   'desalegn.whawariat@hagbes.com' => 'Desalegn W/hawariat',
   // ..
);
foreach($recipients as $email => $name)
{
   $mail->addAddress($email, $name);
}
//Add CC
$mail->AddCC("gashu.wendawke@hagbes.com");
$mail->AddCC("mahlet.nigussie@hagbes.com");
//finally send email
$mail->Send();
$mail->smtpClose();
    } 
 
  if($result2==true){     
    $_SESSION['submited']=true;
echo '<script> alert("Inspection done Succesfully"); </script>';
    if(isset($_SESSION['type'])){
      foreach($_SESSION['type'] as $fi)
             unset($_SESSION[$fi]);
     }
     if(isset($_SESSION['side'])){
      foreach($_SESSION['side'] as $f)
      unset($_SESSION[$f]);
      }
    // if(isset($_SESSION['optional'])){
     //  for($i=0; $i <=  $_SESSION['index_opt']; $i++)
        //   unset($_SESSION['optional'.$i]);
  //   }
    if(isset($_SESSION['eopt']) || isset($_SESSION['optional2'])){
     // for($e=0; $e <=  $_SESSION['index_eopt']; $e++)
         unset($_SESSION['optional2']);
    }
    header("location:inde.php?asset=$cata");
  }
  else
  {
      echo '<script> alert("Inspection Not Done"); </script>';    
  }
  }
}
/////////////////////////////////////////////////      

////////////////for maintenance/////////////////
 if(isset($_POST['msubmit'])){   
  $nxtkm = 5000;
  $submit = $ppn;
  $test ="SELECT model, plateno, driver, company  FROM inspection WHERE plateno = '$ppn'";
      $res = $conn->query($test);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()){
              $model=$row['model'];
              $plateno=$row['plateno'];
              $driver=$row['driver'];
              $checked_by=$_SESSION["username"];
              $maintenance_date=date('Y-m-d H:i:s');
              //$odometer=$row['maxodo'];
              $company = $_SESSION["company"];
              $driver=$row['driver'];
       // echo'<script>alert( "'.$ppn.'")</script>';

          $query = "SELECT * FROM pmsrule WHERE `every_interval` < '".$odo."' OR `at`='".$odo."'"; 
          //$query = "SELECT * FROM pmsrule WHERE `every_interval` < '".$_SESSION['odo']."' AND '".$_SESSION['odo']."'% `every_interval`= 0 OR `at`='".$_SESSION['odo']."'";     
           $result = $conn->query($query);
                if ($result->num_rows > 0) {

                    while($ro = $result->fetch_assoc()){
                      $type =$ro['type'];
                      $description= $ro['type-description'];
                      $interval = $ro['every_interval'];
                      $at = $ro['at'];
                      $action = $ro['action'];
                      //$nxtkm = $nxtkm + $interval; 
                      $jobstatus = "";
                      $pms_reading ="";
                      $check_status ="";
                      if($ro['every_interval']!= ''){
                     if(($odo % $ro['every_interval'])== 0){
                      if($_POST[$ro['id']]=='done'){
                             $jobstatus = $_POST[$ro['id']];
                             //echo'<script>alert("DONE '.$_POST[$ro['id']].'")</script>';
                           }else{
                             $jobstatus = $_POST[$ro['id']];
                              //echo'<script>alert("'.$_POST[$ro['id']].'")</script>';
                           }

                      if($odo > $interval OR $odo == $interval ) { 
                            $pms_reading = $interval;
                            $check_status = 'interval';
                            $nxtkm = $nxtkm + $pms_reading;
                            //echo '<script>alert("DONE '.$interval.'")</script>'; 
                            }
                            $query = "INSERT INTO `maintenance` (`model`, `plateno`, `update_date`, `type`, `description`, `checked_at_odo`, `nxt_km_check`, `action`, `job_status`, `pms_reading`, `check_status`, `company`,`driver`,`catagory`)
 VALUES ('$model','$plateno','$maintenance_date','$type','$description','$odo','$nxtkm','$action','$jobstatus','$pms_reading','$check_status','$company','$driver','$cata') ";

if($conn->query($query)==true){         
header("location:inde.php?asset=$cata");
}else{
  echo die(mysqli_error($conn));
}
                          }
                        }
                      if($odo == $at){
                        if($_POST[$ro['id']]=='done'){
                               $jobstatus =$_POST[$ro['id']];
                               //echo'<script>alert("DONE '.$_POST[$ro['id']].'")</script>';
                             }else{
                               $jobstatus =$_POST[$ro['id']];
                                //echo'<script>alert("'.$_POST[$ro['id']].'")</script>';
                             }
                             $pms_reading =$at;
                             $check_status ='at';
                             $query = "INSERT INTO `maintenance` (`model`, `plateno`, `update_date`, `type`, `description`, `checked_at_odo`, `nxt_km_check`, `action`, `job_status`, `pms_reading`, `check_status`, `company`,`driver`,`catagory`)
 VALUES ('$model','$plateno','$maintenance_date','$type','$description','$odo','$nxtkm','$action','$jobstatus','$pms_reading','$check_status','$company','$driver','$cata') ";

if($conn->query($query)==true){         
header("location:inde.php?asset='$cata'");
}else{
  echo die(mysqli_error($conn));
}
                            // $nxtkm = ;
                             //echo '<script>alert("DONE '.$at.'")</script>';
                           }
     //echo "submit done";
}             
}
} 
}
}

if(isset($_POST['updateinfo'])){
  $pln = $_POST['plateno'];
  $insudate  = '';
  $bolodate = '';
  if($_POST['insudate'] != ''){
    $insudate  = $_POST['insudate'];
  }
  if($_POST['bolodate'] != ''){
    $bolodate = $_POST['bolodate'];
  }  
  $test ="SELECT model,plateno,driver,company FROM vehicle WHERE plateno = '$pln'";
  $res = $conn1->query($test);
    if ($res->num_rows > 0) {
        while($row = $res->fetch_assoc()){          
          $model=$row['model'];
          $plateno=$row['plateno'];
          $driver=$row['driver'];
          $company=$row['company'];            
        }
      }  
      $resultset_1 = "SELECT * from vehicle where insurance_date = '".$insudate."' OR bolo_date = '".$bolodate."' ";
      $result = $conn->query($resultset_1);
      $count = $result->num_rows;
   if($count == 0)
    {   
$query = "INSERT INTO `vehicle`(`model`, `plateno`, `driver`, `company`, `insurance_date`, `bolo_date`) VALUES ('$model','$pln','$driver','$company','$insudate','$bolodate')";
$result = mysqli_query($conn, $query);  
    }
    else{
      echo '<script>alert("Date already exist");</script>';
   }
/*if(isset($_POST['bolodate'])){ 
  $insudate = (isset($_POST['insudate']))?", `insurancedate`='".$_POST['insudate']."'":"";
  $sql =  "UPDATE `vehicle` SET `bollodte` = '$bolodate'$insudate WHERE plateno = '$pln'";
}  
else if(isset($_POST['insudate'])){
  $bolodate = (isset($_POST['bolodate']))?", `bollodte`='".$_POST['bolodate']."'":"";
    $sql =  "UPDATE `vehicle` SET `insurancedate` = '$insudate'$bolodate  WHERE plateno = '$pln'";  
  }
else if(isset($_POST['bolodate']) && isset($_POST['insudate'])){
  $sql = "UPDATE `vehicle` SET `bollodte` = '$bolodate',`insurancedate` = '$insudate' WHERE plateno = '$pln'";
 } 
 $run_query = mysqli_query($conn1, $sql);*/
  if($result)
  {
      echo '<script> alert("Date Updated successfully"); </script>';
  }
  else
  {
      echo '<script> alert("Date Not Updated"); </script>';     
  } 
}
?>