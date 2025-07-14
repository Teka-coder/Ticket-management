<?php 
include("../connection.php");
/****************for specefic vehicle description**************/
 $sql = "SELECT * FROM vehicle";
 $result = $conn->query($sql);

  if ($result->num_rows > 0) { 

    while($row = $result->fetch_assoc()){

   
     if(isset($_POST["plateno".$row['plateno']]))
        {

       $_SESSION["plateno"]=$row['plateno'];
     

       header("location:inspection_rec.php");
       }            
  
  }
}

/******************for vehicle inspection form***************/

 $sql = "SELECT * FROM vehicle ";
 $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()){

    
     if(isset($_POST["inspect".$row['plateno']]))
        {
       $_SESSION["inspect"]=$row['plateno'];
       $_SESSION['odometer']=$row['odometer_km_reading'];
       $_SESSION['inspection']=true;
       header("location:insp_form.php");
       }            
 
  }
}
/******************for update form*************************/


 $sql = "SELECT * FROM vehicle";
 $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()){

    
     if(isset($_POST["update".$row['plateno']]))
        {

       $_SESSION["update"]=$row['plateno'];

       header("location:rule.php");
       }            
  
  }
}
/***************for past inspection history*************************/

  $sql = "SELECT * FROM inspection";
   $result = $conn->query($sql);
  if ($result->num_rows > 0) { 

    while($row = $result->fetch_assoc()){
      if(isset($_POST["inspect".$row['inspection_date']]))
        {
      $_SESSION["detail"]=$row['inspection_date'];
      
       header("location:pastinspection.php");
       }             
  }
}

/**************for past maintenance history********/
  $sql = "SELECT * FROM maintenance";
   $result = $conn->query($sql);
  if ($result->num_rows > 0) { 

    while($row = $result->fetch_assoc()){
      if(isset($_POST["update".$row['update_date']]))
        {
      $_SESSION["detailm"]=$row['update_date'];

       header("location:pastmaintenance.php");
       }             
  }
}


if(isset($_POST["check_submit_btn"])){

$plate =$_POST['plateno_id'];
$que= "SELECT * from vehicle WHERE plateno = '$plate' ";

  $result = $conn->query($que);
  //$rows =  mysqli_num_rows($result);
  
    if(mysqli_num_rows($result) > 0){
      //$_SESSION['status'] = "vehicle already exists";
     echo"vehicle already exists";
    //header("location:inde.php");
   }

}



//for adding vehicle

if(isset($_POST["addv"])){
   $model=$_POST['model'];
   $plate=$_POST['plateno']; 
   $driver=$_POST['dri'];
   $organization=$_POST['org'];
   $odometer=$_POST['odometer'];
   $kmbeforeservice=$_POST['km'];
  
   $_SESSION['nkm'] =  $kmbeforeservice; 
$que= "SELECT * from vehicle WHERE plateno = '$plate' ";

  $result = $conn->query($que);
    if(mysqli_num_rows($result) > 0){
      $_SESSION['status'] = "vehicle already exists";
    //echo'<script>"vehicle already exists"</script>';
    header("location:inde.php");
   }
   else{
  $_SESSION["inspect"]=$plate;
  $_SESSION["added"]=true;
  $_SESSION['odo']=$odometer;

     $sq = "INSERT INTO `vehicle`(`model`,`plateno`,`driver`,`organization`,`odometer_km_reading`,`km_before_service`) VALUES ('$model','$plate',' $driver',' $organization','$odometer','$kmbeforeservice')";
    $re = $conn->query($sq);
    echo $sq;
    header("location:insp_form.php");    
       } 
   }
////// to start new inspection
if(isset($_POST["newinspect"])){
$_SESSION["vehicle"]=$_POST['selected'];
$_SESSION["select"]=true;
//echo $_POST["selected"] </script>';
header("location:insp_form.php"); 
}

//////

 



/// for submit
    
if(isset($_POST["submit"]))
 {
  $curr_odometer_reading=$_POST['odometer'];
  $inspector=$_SESSION["username"];
  $inspection_date=date('Y-m-d H:i:s');
  $comment=$_POST['note'];
  $next_insp_date=date("Y-m-d",strtotime('+1 month',strtotime($inspection_date)));
  $submit = $ppn;
  $company = $_SESSION["company"];

  $test ="SELECT id, model,plateno,driver,MAX(odometer_km_reading) AS odo, MIN(km_before_service) as km FROM vehicle WHERE plateno = '$submit'";
      $res = $conn->query($test);

        if ($res->num_rows > 0) {

            while($row = $res->fetch_assoc()){          
              $model=$row['model'];
              $plateno=$row['plateno'];
              $driver=$row['driver'];
              $prev_odometer_reading=$row['odo'];
              $monthlykm = $curr_odometer_reading - $prev_odometer_reading;
              $km_beforenxt_service= $row['km'] - $monthlykm;
              
            }
          }
      //  }
              
              $int_okay="";
              $ext_available="";
              $int_notokay="";
              $ext_notavailable="";
              $count=0;
                       
              if(isset($_SESSION['added'])){

                $km_beforenxt_service = $_SESSION['nkm'];
                     }               

                $_SESSION['$servicekm']= $km_beforenxt_service;

              if($km_beforenxt_service <= 0){
                  /*"send email to pad"*/              
                      }
                              
              $test2 ="SELECT * FROM checklist_item";
              $res2 = $conn->query($test2);
                if ($res2->num_rows > 0) {
                    while($row2 = $res2->fetch_assoc()){
                        if($row2['type']=="interior")
                        {
                          if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes')
                            $int_okay.= str_replace('_',' ',$row2['item_name'])." , ";
                          else
                            $int_notokay.= str_replace('_',' ',$row2['item_name'])." , ";                           
                            $status ++;
                            //echo'<script>alert("'$int_notokay'");</script>';
                        }
                        else
                        {
                          if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes')
                            $ext_available.= str_replace('_',' ',$row2['item_name'])." , ";
                          else
                            $ext_notavailable.= str_replace('_',' ',$row2['item_name'])." , ";
                            $status++;
                            //echo '<script>alert("'$ext_notavailable'");</script>';
                        }
                      }
                  }
                  if($status!=0){
                    $status=1;
                  }
 

  $que="INSERT INTO `inspection` (`catagory`,`model`, `plateno`, `inspection_date`, `nxt_inspection_date`, `int_okay`,`int_notokay`, `ex_okay`, `ex_notokay`,`inspected_by`, `driver`,`prev_odometer_reading`,`odometer_reading` ,`km_beforenxt_service`,`company`,`comments`)

   VALUES('$cata','".$model."','".$plateno."','".$inspection_date."','".$next_insp_date."','".$int_okay."',
                 '".$int_notokay."','".$ext_available."','".$ext_notavailable."','".$inspector."','".$driver."','".$prev_odometer_reading."','".$curr_odometer_reading."','".$km_beforenxt_service."','".$company."','".$comment."')";
              
    if($conn->query($que)==true){
          $_SESSION['insp_id'] = $conn->insert_id;
          $_SESSION['inspected'.$ppn] = true;  
  //$notif="INSERT INTO `notification`(`status`,`in_id`) VALUES ('$status','".$_SESSION['insp_id']."')";  
  //$result = $conn->query($notif);
                                      
        $si=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
        foreach($si as $li)
        {
          unset($_POST[$li]);
        }
         header("location:interiorinspection.php?asset=".$_SESSION['cata']."&pn=$ppn");              
        $update="UPDATE vehicle SET odometer_km_reading = '$curr_odometer_reading', km_before_service = ' $km_beforenxt_service' WHERE plateno = '$submit'";
                       $re = $conn->query($update);
                }                                          
      else{  
        echo die(mysqli_error($conn));
       }
      } 

/////save image front
//if(isset($_POST['front'])){

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
    }
  }
  

  //////////interior}
  if(isset($_POST['image2'])){
    $img = $_POST['image2'];
    $folderPath = "../upload2/";
    
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.jpg';
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64); 
    
    if(isset($_SESSION['curr']))
    {
      $_SESSION[$_SESSION['curr']] = $file;
    }
  }
  //}

  

  //////////////////
  
  $side=array('front', 'front_bonnet', 'front_wing_driver_side', 'front_wing_pass_side', 'front_door_driver_side',
  'front_door_pass_side', 'back_door_driver_side', 'back_door_pass_side', 'back_wing_driver_side', 'back_wing_pass_side', 'rear_top_view',
'rear_down_view');


  foreach($side as $s){  
  if(isset($_POST[$s])){  
    $_SESSION['status'.$s]=$_POST['status'.$s];
    if($_SESSION['status'.$s]=='damaged')
      $_SESSION['damage'.$s]=$_POST['damage'.$s];
    $_SESSION['current']=$s;
    header("location:firsttry.php?asset=$cata&pn=$ppn");
    }
  }
  /////
  $si=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
  foreach($si as $li){    
    if(isset($_POST[$li]))
    {
      $_SESSION['status'.$li]=$_POST['status'.$li];
      if($_SESSION['status'.$li]=='damaged')
        $_SESSION['damage'.$li]=$_POST['damage'.$li];
      $_SESSION['curr']=$li;
               
    $si=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
    foreach($si as $li)
    {
      unset($_POST[$li]);
    }
      header("location:camera2.php?asset=$cata&pn=$ppn");
    }  
  }
  /////////////////
  if(isset($_POST['isubmit'])){                     
      foreach($_SESSION['type'] as $type){  
        $status = $_SESSION['status'.$type];   
        $damagetype='no damage';
        if($status=='damaged')
        {
          $damagetype = $_SESSION['damage'.$type];
        }
                
      // echo "<script>alert('$type    -    $status  - ".$_SESSION[$type]." -  $damagetype - ".$_SESSION['insp_id']."')</script>";
       $query = "INSERT INTO `int_inspection`(`name`, `image`, `status`, `damage_type`, `insp_id`)VALUES('$type','".$_SESSION[$type]."''$status',' $damagetype', '".$_SESSION['insp_id']."')";
      
       $conn->query($query);
       echo "<script>alert('$type    -    $status  - ".$_SESSION[$type]." -  $damagetype - ".$_SESSION['insp_id']."')</script>";
      // header("location:bodystructure.php?asset=$cata&pn=$ppn");
      // $conn->query($query2);
     
      }
    /*if($conn->query($query2)==true){      
      $_SESSION['submit']=true;
      $_SESSION['ins'.$pnn]=true;
      foreach($_SESSION['si'] as $fi)
      unset($_SESSION[$fi]);
      header("location:bodystructure.php?asset=$cata&pn=$ppn");
    }*/
    }
   // }
    //////      
   
  
  if(isset($_POST['bsubmit'])){  
  $query = "INSERT INTO body_inspection(front,front_bonnet,front_wing_driver_side,front_wing_pass_side,front_door_driver_side,front_door_pass_side,back_door_driver_side,back_door_pass_side,back_wing_driver_side,back_wing_pass_side,rear_top_view,rear_down_view,insp_id)VALUES ( ";
  foreach($_SESSION['side'] as $s){
    if(!isset($_SESSION[$s]))
    {
      $_SESSION['error']= '<script>alert("all images are required")</script>';
      break;
    }
    if($s=='front')
      $query =$query. "'".$_SESSION[$s]."'";
    else
      $query =$query. ",'".$_SESSION[$s]."'";  
      //$counter++;
    }
   $query .=",  '".$_SESSION['insp_id']."')";
  
  if(!isset($_SESSION['error'])){
    foreach($_SESSION['side'] as $s){   
      $status = $_SESSION['status'.$s];   
      $damagetype='no damage';
      if($status=='damaged'){
        $damagetype = $_SESSION['damage'.$s];
        }
    $query2 = "INSERT INTO `bodyinsp_stat`(`name`, `status`, `damage_type`, `inspid`)VALUES('$s','$status',' $damagetype', '".$_SESSION['insp_id']."')";
     $conn->query($query2);
     } 

  if($conn->query($query)==true){      
    $_SESSION['submited']=true;
    $_SESSION['insp'.$pnn]=true;
    foreach($_SESSION['side'] as $field)
    unset($_SESSION[$field]);
    header("location:inde.php?asset=$cata");
  }
  }
  }
  //////      

//for maintenance


 if(isset($_POST['msubmit'])){   
  $nxtkm = 5000;
  $submit = $ppn;
  $test ="SELECT model, plateno, driver, company ,MAX(odometer_km_reading) AS maxodo FROM vehicle WHERE plateno = '$ppn'";
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

          $query = "SELECT * FROM pmsrule WHERE `every_interval` < '". $odo."' OR `at`='". $odo."'"; 
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
//header("location:inde.php?asset='$cata'");
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

if(isset($_POST['viewdetail'])){
  $vehicle=$_POST['selected'];
  $datee=$_POST['date'];
  
  $sql = "SELECT * FROM inspection where plateno = '$vehicle' AND inspection_date='$datee'";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()){
      $_SESSION['inspid'] = $row['id'];
      header("location:pastinspection.php?asset='$cata'&pn='$vehicle'&date='$datee'");
    }
  }
  }
?>