<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$cata=$_SESSION['cata'];
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style>
  .card-header{
    background-color: #87CEEB !important;
  }
  h4{
    color:white;
  }
 .card-header{
  height: 50px;
 }
 .decorated{
     overflow: hidden;
     text-align: center;
 }
.decorated > span{
    position: relative;
    display: inline-block;
}
.decorated > span:before, .decorated > span:after{
    content: '';
    position: absolute;
    top: 50%;
    border-bottom: 2px solid;
    width: 200%;
    margin: 0 20px;
}
.decorated > span:before{
    right: 100%;
}
.decorated > span:after{
    left: 100%;
}

  </style>
</head>

<body>

 <?php include('../headersidebar.php');?>
 <?php include('sidebar.php');?>
 <main id="main" class="main">
 <!--<div class="card">-->             
               <div class="row">    	
               <div class="pagetitle">
               <br><h1 class="decorated"><span><?php echo $cata ?> Inspection Form<span></h1>
               <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="inde.php?asset=<?php echo $cata;?>">Back</a></li>        
                </ol>
              </nav>          
                </div>
               </div>
            <!-- </div>-->

    <form action ="insp_form.php?"  method="GET" onsubmit="validate();">
    <div class="row"> 
    <div class="col-lg-6">
     <div class="card">
            <div class="card-header"> 
            <span class=" text-white">Select a <?php echo $cata ?></span>                   
               </div>
            <div class="card-body">
       <br> 
           <?php if($cata=='vehicle'){  ?>
       <select class="form-select" name="pn2" id="floatingSelect" aria-label="Floating label select example" value="Vehicle" required>
       <option value="">select a <?php echo $cata ?></option>
                         <?php 
                  $comp = $_SESSION['company'];   
                    if($comp ='Hagbes HQ.')      
                      $sql ="SELECT * from vehicle";
                    else
                      $sql ="SELECT * from vehicle where `company` = '$comp'";
                    $result = $conn1->query($sql);
                    if ($result = $conn1->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                     $_SESSION['random']=true;
                    while($row = $result->fetch_assoc()) {             
              echo ' 
               <option  value="'.$row["plateno"].'">'.$row['driver'].' | '.$row['model'].'&nbsp'.$row['plateno'].'</option>';                           
                    }
                  }
                }                   
              }else{?>
               
            <?php  
             }     
                  ?>
                   </select><br>
   
   </div>
 </div>
</div>
<!--<div class="col-lg-6">
<div class="card">
            <div class="card-header"> 
            <span class="text-white">Select Next Inspection</span>                   
               </div>
            <div class="card-body">
   <br><input type='date' id='randomdate' name='randomdate' style='width:400px;height:35px'>
   </div><br>
            </div>
            </div>-->
      <div> 
            </div> 
            </div> 
      <?php  if($cata=='vehicle'){  ?>     
     <button type="submit" name='asset2' value=<?php echo $cata ?> class="btn btn-primary"><i class="bi bi-check"></i>start inspection</button></div>   
     <?php } ?>
   
    </form>   
  </main>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
   
  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>
</html>
<?php }else{
  header("location:../index.php");
}