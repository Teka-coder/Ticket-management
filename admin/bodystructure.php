<?php 
session_start();
if($_SESSION['role']=="pad"){
  $cata=$_GET['asset'];
  $ppn=$_GET['pn'];
include ("recoredserver.php");
//$iid=$_GET['iid'];
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AIS | Asset Inspection System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
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
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
  
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
    <style type="text/css">
        #results {  padding:20px; border:1px solid; background:#ccc; }      
    </style>
  <style>
.card-header-color{
    background-color: #87CEEB !important;
    height: 40px;
  }

div.gallery {
  margin: 15px;
  float: left;
  width: 200px;
}


div.gallery img {
  width: 100%;
  height: auto;
}
</style>
<script>
  function modalc(e)
  {
    // document.getElementById('mymodal').innerHTML = holder;
    // alert();
    var temp = holder;
    while(temp.includes("XXXX"))
      temp = temp.replace('XXXX',e)

    document.getElementById('mymodal').innerHTML = temp;
  }
</script>
</head>

<body>

 <?php include('../headersidebar.php');?>
 <?php include('sidebar.php');?>

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Vehicle Body Inspection</h1>
    </div><!-- End Page Title -->
     <div class="row">
      <div class="align-item-center col-lg-6">
<form action="bodystructure.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn;?>"   method='post'>
<?php
     $side=array('front', 'front_bonnet', 'front_wing_driver_side', 'front_wing_pass_side', 'front_door_driver_side',
     'front_door_pass_side', 'back_door_driver_side', 'back_door_pass_side', 'back_wing_driver_side', 'back_wing_pass_side', 'rear_top_view',
     'rear_down_view');
      $_SESSION['side']=$side;
      foreach($_SESSION['side'] as $s){?>
<span class="badge text-light <?php echo (isset($_SESSION['front']))?' bg-success':' bg-danger'?>">Front</span>
<span class="badge text-light <?php echo (isset($_SESSION['front_bonnet']))?' bg-success':' bg-danger'?>">front bonnet</span>
<span class="badge text-light <?php echo (isset($_SESSION['front_wing_driver_side']))?' bg-success':' bg-danger'?>">front wing driver side</span>
<span class="badge text-light <?php echo (isset($_SESSION['front_wing_pass_side']))?' bg-success':' bg-danger'?>">front wing pass side</span>
<span class="badge text-light <?php echo (isset($_SESSION['front_door_driver_side']))?' bg-success':' bg-danger'?>">front door driver side</span>
<span class="badge text-light <?php echo (isset($_SESSION['front_door_pass_side']))?' bg-success':' bg-danger'?>">front door pass side</span>
 <!--Image Map Generated by http://www.image-map.net/ -->
<img src="../image/resizedagain.png" usemap="#image-map" class="map">
<span class="badge text-light <?php echo (isset($_SESSION['back_door_driver_side']))?' bg-success':' bg-danger'?>">back door driver side</span>
<span class="badge text-light <?php echo (isset($_SESSION['back_door_pass_side']))?' bg-success':' bg-danger'?>">back door pass side</span>
<span class="badge text-light <?php echo (isset($_SESSION['back_wing_driver_side']))?' bg-success':' bg-danger'?>">back wing driver side</span>
<span class="badge text-light <?php echo (isset($_SESSION['back_wing_pass_side']))?' bg-success':' bg-danger'?>">back wing pass side</span>
<span class="badge text-light <?php echo (isset($_SESSION['rear_top_view']))?' bg-success':' bg-danger'?>">rear top view</span>
<span class="badge text-light <?php echo (isset($_SESSION['rear_down_view']))?' bg-success':' bg-danger'?>">rear down view</span>
<?php
break; }
 ?> 
          
<map id="map" name="image-map"  style="cursor:pointer;">
    <area target="_blank" id="Area1" alt="front" title="Front" onmouseover="this.style.backgroundColor='#00FF00';" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('front')" coords="143,8,315,51" shape="rect">
    <area target="_blank" id="Area2" alt="front_bonnet" title="front_bonnet" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('front_bonnet')"  coords="155,96,199,90,258,90,300,96,301,191,285,240,169,239,156,191" shape="poly">
    <area target="_blank" id="Area3" alt="front_wing_driver_side" title="front_wing_driver_side" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('front_wing_driver_side')"   coords="102,93,110,107,115,127,117,150,119,167,121,182,124,192,100,188,84,187,62,191,47,194,45,181,39,171,28,162,24,148,32,132,48,123,45,115,46,95,61,89,64,81,81,82,85,101,101,106" shape="poly">
    <area target="_blank" id="Area4" alt="front_wing_pass_side" title="front_wing_pass_side"  data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('front_wing_pass_side')"   coords="354,93,344,115,339,143,338,168,331,191,364,187,391,188,410,195,410,182,416,173,430,159,430,139,417,127,408,125,410,115,410,94,395,88,392,81,374,82,372,101,356,106" shape="poly">
    <area target="_blank" id="Area5" alt="front_door_driver_side" title="front_door_driver_side" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('front_door_driver_side')"  coords="46,196,47,288,85,284,122,286,162,288,160,245,144,219,127,197,89,189" shape="poly">
    <area target="_blank" id="Area6" alt="front_door_pass_side" title="front_door_pass_side" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('front_door_pass_side')"  coords="410,196,411,288,372,285,337,287,294,289,296,245,331,195,370,187" shape="poly">
    <area target="_blank" id="Area7" alt="back_door_driver_side" title="back_door_driver_side" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('back_door_driver_side')"  coords="162,295,160,338,128,364,105,375,89,359,70,346,48,340,47,291,101,286" shape="poly">
    <area target="_blank" id="Area8" alt="back_door_pass_side" title="back_door_pass_side" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('back_door_pass_side')"  coords="295,293,294,318,297,339,319,360,351,374,372,355,393,345,410,340,410,292,371,287" shape="poly">
    <area target="_blank" id="Area9" alt="back_wing_driver_side" title="back_wing_driver_side"  data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('back_wing_driver_side')"  coords="159,346,150,379,127,419,117,452,110,460,105,451,85,448,82,460,70,464,61,457,48,450,47,413,42,404,28,394,25,375,32,363,49,355,47,344,76,353,92,365,103,374,114,372" shape="poly">
    <area target="_blank" id="Area10" alt="back_wing_pass_side" title="back_wing_pass_side" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('back_wing_pass_side')"  coords="297,345,308,383,330,423,337,443,347,460,352,452,372,449,378,462,397,459,410,450,410,414,401,408,416,404,429,394,432,376,422,362,409,349,395,350,382,354,372,363,356,376,340,372" shape="poly">
    <area target="_blank" id="Area11" alt="rear_top_view" title="rear_top_view" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('rear_top_view')"  coords="170,358,154,425,154,461,195,467,259,466,301,461,302,425,286,358,265,352,197,351" shape="poly">
    <area target="_blank" id="Area12" alt="rear_down_view" title="rear_down_view" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('rear_down_view')"  coords="140,481,317,532" shape="rect">
</map>
</div>

<div class="card col-lg-6">
<div class="row"> 
<?php
     $side=array('front', 'front_bonnet', 'front_wing_driver_side', 'front_wing_pass_side', 'front_door_driver_side',
     'front_door_pass_side', 'back_door_driver_side', 'back_door_pass_side', 'back_wing_driver_side', 'back_wing_pass_side', 'rear_top_view',
     'rear_down_view');
      $_SESSION['side']=$side;
      foreach($_SESSION['side'] as $s){?>        
        <div class="col-lg-6"> 
        <div class="row">        
        <div class="gallery"><?php 
            if(!isset($_SESSION[$s])){
              echo "<img src='#' class='card-img-top noimage' alt='...'>";
            } 
            else  {
            echo "<figure><img loading='lazy' src='".$_SESSION[$s]."' title='$s' class='card-img-top popup' style= 'height:150px; width:200px;cursor:zoom-in;' alt='...'><figcaption style='text-align:center;'><i>".ucfirst($s)."</i></figcaption></figure>";    
            }            
            ?>
             </div>
             </div>
             </div>
           <?php }                
            ?>


</div>
</div>
</div>

<div class="card">
     <div class="card-body">
        <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <span class='fw-bold'>Optional Fields</span>
                  </button>
                </h2>                                                                 
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
               <div class="accordion-body">                 
  <a herf="#" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('optional2')" name="optional2" value="capture image" class="btn btn-primary btn-sm  text-center" id="img"><i class="bi bi-camera"></i> capture image</a>(Optional)<br>          
  <?php if(isset($_SESSION['optional2'])){
         // for($e = 0; $i <= $_SESSION['index_eopt']; $e++ ){  
           echo "<figure><img loading='lazy' src='".$_SESSION['optional2']."' alt='".$_SESSION['optional2']."' title='optional'  class='popup' style='cursor:zoom-in;width:50%;max-height:50%;' alt='...'><figcaption style='text-align:center;'></figcaption></figure> ";
         // }
               } ?>
               </div>
              </div>
            </div>
           </div>
          </div>
        </div>

        <div class="row"> 
       <div class="text-center"> 
      <!-- <button onclick="goBack()" id="prev"class='btn btn-success align-items-center justify-content-center' name='previous' style="width:25%;" type='button'><i class="bi bi-arrow-left"></i>Previous Page</button> -->               
   <a href="interiorinspection.php?asset=<?php echo $cata ?>&pn=<?php echo  $ppn ?>" class='btn btn-success  justify-content-center'  name='previous' style="width:25%;" type='button'><i class="bi bi-arrow-left"></i>Previous Page</a>
       <button class='btn btn-success  justify-content-center' id="finishform" name='bsubmit' onclick="checkimage(this)" style="width:25%;"  type='button'>Finish</button><br>
</div> 
</div> 
</div>
</form>

<?php $side=array('front', 'front_bonnet', 'front_wing_driver_side', 'front_wing_pass_side', 'front_door_driver_side',
'front_door_pass_side', 'back_door_driver_side', 'back_door_pass_side', 'back_wing_driver_side', 'back_wing_pass_side', 'rear_top_view',
'rear_down_view');
 $_SESSION['side']=$side;            
    ?>
<div class="modal fade" id="mymodal" data-bs-backdrop='static'>
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
             <p class="modal-title text-capitalize">XXXX</p>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                                                           
			</div> 
			<div class="modal-body">
        <form action="bodystructure.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn;?>" method='post'>   
        <p><strong>Is panal Damaged?</strong></p>
             <input type="radio" id="styes" name="statusXXXX" value="damaged" onclick="document.getElementById('da').classList.remove('d-none');document.getElementById('capimg').classList.add('d-none')"> Yes
             <input type="radio" id="stno" name="statusXXXX" value="not damaged" onclick="document.getElementById('capimg').classList.remove('d-none');document.getElementById('da').classList.add('d-none')"> No</p>
             <r id="da" class='d-none' required><br><p><strong>What Kind of Damage?</strong></p>                                
             <input type="checkbox" id="dmgden" name="damageXXXX[]" value="dent" onclick="document.getElementById('capimg').classList.remove('d-none')"> Dent
             <input type="checkbox" id="dmgscr" name="damageXXXX[]" value="scratch" onclick="document.getElementById('capimg').classList.remove('d-none')"> Scratch
             <input type="checkbox" id="dmgbro" name="damageXXXX[]" value="broken" onclick="document.getElementById('capimg').classList.remove('d-none')"> Broken
             <input type="checkbox" id="dmgcrk" name="damageXXXX[]" value="crack" onclick="document.getElementById('capimg').classList.remove('d-none')"> Crack
             <input type="checkbox" id="dmgfde" name="damageXXXX[]" value="fade" onclick="document.getElementById('capimg').classList.remove('d-none')"> Fade
             <input type="checkbox" id="dmgdeep" name="damageXXXX[]" value="deeply damaged" onclick="document.getElementById('capimg').classList.remove('d-none')"> Deeply Damaged 
             <input type="checkbox" id="dmgrmrk" name="rmkkXXXX[]" value="remark" onclick="document.getElementById('capimg').classList.remove('d-none');document.getElementById('dmgremark').classList.remove('d-none')"> Add remark                 
            </r><br>
             <div class='d-none' id="dmgremark"><label for="remark">Remark(Optional):<textarea placeholder="Mandatory for optional images"  class="control"  name="remarkXXXX"></textarea></label></div>
             <input type="submit" name="XXXX" class="btn btn-success btn-sm d-none rounded-pill form-control" id="capimg" value="Capture Image">               
             <?php 
            ?>   
				</form>
			</div>   
		</div>                                                                       
	</div>                                      
</div><!-- End Vertically centered Modal-->
<div class="modal fade mm"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <div class="modal-header">
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
      </div>
      <div class="modal-body text-center">
        <img id="popup-img" loading="lazy" src="" alt="Image" style="max-height:100%; max-width: 100%;">
      </div>
    </div>
  </div>
</div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('../footer.html');


?>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <!--<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--> 
  <!--<script  src='http://davidlynch.org/projects/maphilight/jquery.maphilight.js'></script>-->
  <script src="Scripts/jquery-1.4.1.min.js"></script>
  <script src="Scripts/maphighlight.js"></script>
  
<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script>
function checkimage(e){
  var img = document.getElementsByClassName("noimage");
  // alert(img.length);
if(img.length == 0){ 
  e.type = "submit";
  e.click();
  e.classList.add('d-none');
  }
  else{
    alert("all images are required");
  }
}
</script>
<script>
function goBack(){
  window.history.back();
}
 </script> 
<script>
        $(function () {
            $('area').click(function (event) {
                var map = document.getElementById('map');                
                var areas = map.getElementsByTagName('area');
                for (var i = 0; i < areas.length; i++) {
                    var area = areas[i];
                    var id = area.id;
                    var data = $('#' + id).data('maphilight') || {};
                    if (area.id == $(this)[0].id)
                        data.fillColor = '02FC1F'; // Sample color           
                    else data.fillColor = 'ff0000'; // Sample color           
                    $('#' + id).data('maphilight', data).trigger('alwaysOn.maphilight');
                }
            });
            $('.map').maphilight({ strokeColor: '808080', strokeWidth: 0, fill: 'ff0000', fillColor: 'ff0000', alwaysOn: true });
        });
    </script>
<script>
        $('.popup').click(function(){
        var src=$(this).attr('src');
        $('.mm').modal('show');
        $('#popup-img').attr('src',src);
        });   
    </script>
<script> 
  var holder =document.getElementById('mymodal').innerHTML;
  </script>
<?php
echo "<script>";
foreach($_SESSION['side'] as $s)
{
  if(isset($_SESSION[$s]))
  {
    if($_SESSION['status'.$s]!='damaged')
      echo "$('#stno$s').click();";
    else
    {
      echo "$('#styes$s').click();
      // $('.da$s').css('display', 'block');  
      ";
      if($_SESSION['damage'.$s]=='scratch')
        echo "$('#dmgscr$s').click();";
      else
        echo "$('#dmgden$s').click();";
    }
  }
}
echo "</script>";
?>
</body>
</html>
<?php }else{
  header("location:../index.php");
}
if(isset($_SESSION['error']))
  {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
  }
?>