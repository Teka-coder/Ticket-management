<?php
session_start();
if($_SESSION['role']=="pad"){ 
  $cata=$_GET['asset'];
  $ppn=$_GET['pn'];
include ("recoredserver.php");
 ?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
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
 

<form method="POST" action="camera3.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn;?>">
        <div class="col-md-12">                    
        <div class="col-md-6">  
        <div class="camera"  id="my_camera"></div>
        <button type="submit" id="camera--trigger" class="btn">Take Snapshot</button>
        <input type="hidden" id="camera--output" name="image3" class="image-tag">            
        </div>
        </div>
        </div>
</form>
   Configure a few settings and attach camera
<script language="JavaScript">
    Webcam.set({
        width: 700,
        height: 700,
        image_format: 'jpeg',
        flip_horiz: true,
        jpeg_quality: 90
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