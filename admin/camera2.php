<?php
session_start();
if($_SESSION['role']=="pad"){ 
  $cata=$_GET['asset'];
  $ppn=$_GET['pn'];
 // $ttyy=$_GET['ty'];

include ("recoredserver.php");
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>AIS | Asset Inspection System </title>
    <?php 
  $comp = $_SESSION['company'];
  $sql= "select * from comp where name = '$comp'";
  $result = $conn1->query($sql);
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/Hagbeslogo.jpg" rel="touch-icon">
<?php 
}
}
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <style type="text/css">
#results {width: 500px; height: 500px;}
#camera--trigger{
    width: 200px;
    background-color: black;
    color: white;
    font-size: 16px;
    border-radius: 30px;
    border: none;
    padding: 15px 20px;
    text-align: center;
    box-shadow: 0 5px 10px 0 rgba(0,0,0,0.2);
    position: fixed;
    bottom: 30px;
    left: calc(50% - 100px);
} 
#retake{
    width: 200px;
    background-color: black;
    color: white;
    font-size: 16px;
    border-radius: 30px;
    border: none;
    padding: 15px 20px;
    text-align: center;
    box-shadow: 0 5px 10px 0 rgba(0,0,0,0.2);
    position: fixed;
    bottom: 30px;
    left: calc(25% - 75px);
    
} 
#continue{
    width: 200px;
    background-color: black;
    color: white;
    font-size: 16px;
    border-radius: 30px;
    border: none;
    padding: 15px 20px;
    text-align: center;
    box-shadow: 0 5px 10px 0 rgba(0,0,0,0.2);
    position: fixed;
    bottom: 30px;
    left: calc(70% - 30px);
}   
    </style>
</head>
<body>
 

<form method="POST" action="interiorinspection.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn?>">
        <div class="col-md-12">
        <div class="row">               
        <div class="col-md-6">  
        <div class="camera"  id="my_camera"></div>
      <button type="submit" id="retake" class="btn d-none" 
        onclick="document.getElementById('camera--trigger').classList.remove('d-none')
        document.getElementById('my_camera').classList.remove('d-none')">Retake</button>
        <button type="submit" id="camera--trigger" class="btn">Take Snapshot</button>
         <input type="hidden" id="camera--output" name="image2" class="image-tag">      
    <a href="interiorinspection.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn;?>" id="continue" class="btn d-none" >Continue</a>    
        </div>
<div class="col-md-6 pull-right">
               <!--<div class="pull-right d-none" id="results"></div>-->   

            <button type="submit" id="camera--trigger" class="btn"
        onclick="take_snapshot();document.getElementById('continue').classList.remove('d-none');
        document.getElementById('retake').classList.remove('d-none');
        document.getElementById('results').classList.remove('d-none');
        document.getElementById('camera--trigger').classList.add('d-none');
        document.getElementById('my_camera').classList.add('d-none');">Take Snapshot</button>
              

           </div>
         </div>
</div>
</form>  
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: window.innerWidth,
        height: window.innerHeight,
        image_format: 'jpeg',
        jpeg_quality: 90,
        constraints: { //for back camera initiation
        facingMode: 'environment'
    }
    }); 
    Webcam.attach('#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
           document.getElementById('results').innerHTML = '<img src="'+data_uri+'" width="700" height="500"/>';          
        } );
    }
    </script>

</body>
</html>
<?php }else{
  header("location:../index.php");
}