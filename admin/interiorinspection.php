<?php 
session_start();
if($_SESSION['role']=="pad"){
  $cata=$_GET['asset'];
  $ppn=$_GET['pn'];
  if(isset( $_SESSION['type'])){
  $type=$_SESSION['type'];
  }
include("recoredserver.php");
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
    label textarea{
        vertical-align: middle;
    }
</style>
<script>
  function modalc(e)
  {
    var temp = holder; 
    while(temp.includes("XXXX"))
      temp = temp.replace('XXXX',e)
    document.getElementById('mymodal').innerHTML = temp;

  $('input[name="damageodometer[]"]').on('change', function () {
  if ($('input[name="damageodometer[]"]').is(':checked')) {
        $(".capimg").show(); // checked
    } else {
        $(".capimg").hide(); // unchecked
    }
  });
  }
</script>
</head>

<body>

 <?php include('../headersidebar.php');?>
 <?php include('sidebar.php');?>
  <main id="main" class="main">

    <div class="pagetitle text-center">
      <h1>Interior Vehicle Inspection</h1>
    </div><!-- End Page Title -->
       
    <div class="card">
         <form action="interiorinspection.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn;?>"   method='post'>
       <?php $side=array('odometer', 'dashboared', 'frontseat', 'backseat', 'frontbackview', 'trunk');
         $_SESSION['type']=$side;
       ?>
            <div class="card-header card-header-color text-white"><h5>Interior Vehicle Inspection</h5><br></div>
            <div class="card-body">
            <div class="row">
             <div class="col-sm-6">
             <?php                        
              $query = "SELECT * from interiorparts";
               $result = $conn->query($query);
                if ($result->num_rows > 0) {           
                          $count=1;              
                        while($row = $result->fetch_assoc()){
                          $img = $row["image"];
                          $_SESSION['type'] = $row['name'];  
                          $type=  $_SESSION['type'];                   
                 ?> 
            <div class="col-lg-6" style="padding: 2%;">
              <fieldset class="btn btn-outline-dark"><legend>
              <h4><?php echo ucfirst($type)?></h4></legend>
              <a href="#"><img src="<?php echo '../image/'.$img;?>" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('<?php echo $type?>')" style="max-width: 100%;max-height: 100%;">
            </a></fieldset>
    		</div>
            <?php } } ?>           
   
  </div>
  <div class="col-sm-6">     
             <?php $side=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
             $_SESSION['type']=$side;
             foreach($_SESSION['type'] as $type){?>
              <div class="card">             
              <div class="card-body" style='height:200px; width:400px;'>    
              <div id="result1"></div> 
           <?php if(!isset($_SESSION[$type])){
              echo "<img src='#' class='card-img-top nointimage' alt='...'>";
            } 
            else{
            echo "<figure><img loading='lazy' src='".$_SESSION[$type]."' title='$type'  class='popup' style='cursor:zoom-in;width:50%;max-height:50%;' alt='...'><figcaption style='text-align:center;'><i>".ucfirst($type)."</i></figcaption></figure> ";
            } ?>
            </div>
    </div><?php } ?>
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
                   <a herf="#" data-bs-toggle="modal" data-bs-target="#mymodal" onclick="modalc('optional')" name ="optional" value="capture image" class="btn btn-primary btn-sm  text-center" id="img"><i class="bi bi-camera"></i> capture image</a>(Optional)<br>                           
                  <?php if(isset($_SESSION['iopt']) && isset($_SESSION['optional'])){                            
                    //  for($i = 0; $i <= $_SESSION['index_iopt']; $i++ ){      
           echo "<figure><img loading='lazy' src='".$_SESSION['optional']."' title='optional'  class='popup' style='cursor:zoom-in;width:50%;max-height:50%;' alt='...'><figcaption style='text-align:center;'></figcaption></figure> ";
               //  }
               } ?>
               </div>           
              </div>
            </div>
           </div>
          </div>
        </div>
     
      <div class="row"> 
       <div class="text-center" >                
  
      <!-- <button onclick="goBack()" id="prev"class='btn btn-success align-items-center justify-content-center' name='previous' style="width:25%;" type='button'><i class="bi bi-arrow-left"></i>Previous Page</button>-->           
       <a href="insp_form.php?asset=<?php echo $cata ?>&pn=<?php echo  $ppn ?>" class='btn btn-success  justify-content-center'  name='previous' style="width:25%;" type='button'><i class="bi bi-arrow-left"></i>Previous Page</a>
       <button id="next" class='btn btn-success align-items-center justify-content-center' name='isubmit' onclick="checkintimage(this)" style="width:25%;"  type='button'>Next Page<i class="bi bi-arrow-right"></i></button>

</div> 
</div>      
</form>            

</div>           
</div>
<?php 
$side=array('odometer', 'dashboard', 'frontseat', 'backseat', 'frontbackview', 'trunk');
$_SESSION['type']=$side;            
    ?>
<div class="modal fade" id="mymodal" data-bs-backdrop='static'>
<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
             <p class="modal-title text-capitalize">XXXX</p>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                                                           
			</div> 
			<div class="modal-body">
        <form action="interiorinspection.php?asset=<?php echo $cata;?>&pn=<?php echo $ppn;?>" method='post'>
             <div class="text-dark">    
             <p><strong>Is item Damaged?</strong></p>
             <input type="radio" id="styes" name="statusXXXX" value="damaged" onclick="document.getElementById('da').classList.remove('d-none');document.getElementById('capimg').classList.add('d-none')">&nbsp;Yes
             <input type="radio" id="stno" name="statusXXXX" value="not damaged" onclick="document.getElementById('capimg').classList.remove('d-none');document.getElementById('da').classList.add('d-none')">&nbsp;No
             <input type="radio" id="doesnotexist" name="statusXXXX" value="does not exist" onclick="document.getElementById('capimg').classList.remove('d-none');document.getElementById('da').classList.add('d-none')">&nbsp;Item Doesn't exist
          </div>
             <r id="da" class='d-none' required><br><p><strong>What Kind of Damage?</strong></p>
             <input type="checkbox" id="dmgbro" name="damageXXXX[]" value="broken" onclick="document.getElementById('capimg').classList.remove('d-none')"> Broken
             <input type="checkbox" id="dmgcou" name="damageXXXX[]" value="Not Counting" onclick="document.getElementById('capimg').classList.remove('d-none')"> Not Counting
             <input type="checkbox" id="dmgfad" name="damageXXXX[]" value="fade" onclick="document.getElementById('capimg').classList.remove('d-none')"> Fade
             <input type="checkbox" id="dmgter" name="damageXXXX[]" value="broken" onclick="document.getElementById('capimg').classList.remove('d-none')"> Tear
             <input type="checkbox" id="dmgrmrk" name="rmkkXXXX[]" value="remark" onclick="document.getElementById('capimg').classList.remove('d-none');document.getElementById('dmgremark').classList.remove('d-none')"> Add remark                                  
             </r><br>
             <div class='d-none' id="dmgremark"><label for="remark">Remark(Optional):<textarea placeholder="Mandatory for optional images"  class="control"  name="remarkXXXX"></textarea></label></div>
             <br><input type="submit" name="XXXX" class="btn btn-success btn-sm d-none form-control rounded-pill" id="capimg" value="Capture Image">                
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
<?php include('../footer.html');?>


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
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
  <script  src='http://davidlynch.org/projects/maphilight/jquery.maphilight.js'></script>
  
<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script>
function checkintimage(e){
  var intimg = document.getElementsByClassName("nointimage");
  // alert(img.length);
if(intimg.length == 0){ 
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
  var holder =document.getElementById('mymodal').innerHTML;
</script>
<script>
$('.popup').click(function(){
 var src=$(this).attr('src');
 $('.mm').modal('show');
 $('#popup-img').attr('src',src);
});
</script>
<script>
  $('input[name="damageodometer[]"]').on('change', function () {
  if ($('input[name="damageodometer[]"]').is(':checked')) {
        $(".capimg").show(); // checked
    } else {
        $(".capimg").hide(); // unchecked
    }
  });
</script> 
</body>
</html>
<?php }else{
  header("location:../index.php");
}
?>
