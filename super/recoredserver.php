<?php 
include('../connection.php');
//for specefic vehicle description
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

//for vehicle inspection form

 $sql = "SELECT * FROM vehicle ";
 $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()){

    
     if(isset($_POST["inspect".$row['plateno']]))
        {

       $_SESSION["inspect"]=$row['plateno'];

       header("location:insp_form.php");
       }            
  
  }
}

// for update form
 $sql = "SELECT * FROM vehicle";
 $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()){

    
     if(isset($_POST["update".$row['plateno']]))
        {

       $_SESSION["update"]=$row['plateno'];

       header("location:update_form.php");
       }            
  
  }
}

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

/// for submit
    
if(isset($_POST["submit"]))
 {
  $submit= $_SESSION["inspect"];
  $test ="SELECT model,plateno,driver,odometer_km_reading, MIN(km_before_service) as km FROM vehicle WHERE plateno = '$submit'";
      $res = $conn->query($test);

        if ($res->num_rows > 0) {

            while($row = $res->fetch_assoc()){
              
              $model=$row['model'];
              $plateno=$row['plateno'];
              $driver=$row['driver'];
              $inspector=$_SESSION["username"];
              $inspection_date=date('Y-m-d H:i:s');
              $odometer_reading=$_POST['odometer'];
              $comment=$_POST['comment'];
              


              $next_insp_date=date("Y-m-d",strtotime('+1 month',strtotime($inspection_date)));

              $int_okay="";
              $ext_available="";
              $int_notokay="";
              $ext_notavailable="";
          
              $monthlykm = $odometer_reading-$row['odometer_km_reading'];

              $km_beforenxt_service= $row['km'] - $monthlykm;


              $_SESSION['$servicekm']= $km_beforenxt_service;

              if($km_beforenxt_service < 0){
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
                        }
                        else
                        {
                          if($_POST[str_replace(' ','_',$row2['item_name'])]=='yes')
                            $ext_available.= str_replace('_',' ',$row2['item_name'])." , ";
                          else
                            $ext_notavailable.= str_replace('_',' ',$row2['item_name'])." , ";
                        }
                      }
                  }
                   
    }
    $que="INSERT INTO `inspection` (`model`, `plateno`, `inspection_date`, `nxt_inspection_date`, `int_okay`,`int_notokay`, `ex_okay`, `ex_notokay`,`inspected_by`, `driver`,`odometer_reading` ,`km_beforenxt_service`,`comments`)

     VALUES('".$model."','".$plateno."','".$inspection_date."','".$next_insp_date."','".$int_okay."',
    '".$int_notokay."','".$ext_available."','".$ext_notavailable."','".$inspector."','".$driver."','".$odometer_reading."','".$km_beforenxt_service."','".$comment."')";
       }

      if($conn->query($que)==true){          
     header("location:camera/bodyinspection.html");
         //echo "$monthlykm";

        $update="UPDATE vehicle SET odometer_km_reading = '$odometer_reading', km_before_service = ' $km_beforenxt_service' WHERE plateno = '$submit'";
          $re = $conn->query($update);
       }
      else{
        echo "$que";
        
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
    
    //for adding vehicle
    
    if(isset($_POST["additem"])){
       $itemname=$_POST['itemname'];
       $itemtype=$_POST['itemtype']; 
                
    $que= "SELECT * from checklist_item WHERE item_name = '$itemname'";
    
      $result = $conn->query($que);
        if(mysqli_num_rows($result) > 0){
          $_SESSION['status'] = "item already exists";      
        header("location:inspectionmanager.php?asset=$cata");
       }
       else{    
         $sq = "INSERT INTO `vehicle`(`item_name`,`type`) VALUES ('$itemname','$itemtype')";
        $re = $conn->query($sq);
        echo $sq;
        header("location:inspectionmanager.php?asset=$cata");    
           } 
       }
?>