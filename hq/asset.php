<?php 
session_start();
if($_SESSION['role']=="hq"){
include ("recoredserver.php");
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
  <style>

a {
  color: #47b2e4;
  text-decoration: none;
}

a:hover {
  color: #73c5eb;
  text-decoration: none;
}

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  overflow: hidden;
  background: #37517e;
}

#preloader:before {
  content: "";
  position: fixed;
  top: calc(50% - 30px);
  left: calc(50% - 30px);
  border: 6px solid #37517e;
  border-top-color: #fff;
  border-bottom-color: #fff;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  -webkit-animation: animate-preloader 1s linear infinite;
  animation: animate-preloader 1s linear infinite;
}

@-webkit-keyframes animate-preloader {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes animate-preloader {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.clients {
  padding: 60px 0;
  text-align: center;
}
.clients img {
  max-width: 100%;
  transition: all 0.4s ease-in-out;
  display: inline-block;
  padding: 15px 0;
  filter: grayscale(100);
}
.clients img:hover {
  filter: none;
  transform: scale(1.1);
}
@media (max-width: 768px) {
  .clients img {
    max-width: 110%;
  }
}
.card-img-top{

object-fit: cover;

}
.header,.sidebar{

background-color: #6F8FAF!important;
 }

 /* headlines with lines */
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
<?php include('headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="asset.php">
          <i class="bi bi-grid"></i>
          <span>Assets</span>
        </a>
      </li><!-- End Dashboard Nav -->

        <li class="nav-item">
       
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="inde.php">
          
          <i class="bi bi-layout-text-window-reverse"></i><span>Vehicle</span>         
        </a>     
        
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Excavator</span>
        </a>     
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Bus</span>
        </a>  
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Generator</span>
        </a>  
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Motorbike</span>
        </a>  
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Crane</span>
        </a>  
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Forklift</span>
        </a>  
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Truck</span>
        </a>  
      </li> 
  </aside>
 <main id="main" class="main">
 <div class="card">
               
 <div class="row">           	
     <div class="pagetitle">
     <br><h1 class="decorated"><span>Asset Inspection System<span></h1> 

         </div>
          <!-- <hr class="hline col-lg-3">-->
     </div>
   </div>
       <section id="clients" class="clients">
      <div class="container">  
         <div class='row' data-aos="zoom-in">
    <?php 
      $query = "SELECT * from asset";
       $result = $conn->query($query);
        if ($result->num_rows > 0) {           
                  $count=1;              
                while($row = $result->fetch_assoc()) {
                  $img = $row["image"];
                  $_SESSION['cata'] = $row['catagory']; 
                ?>     
          <div class="col-lg-3">
              <div class="card">
                <div class="card-body">                                  
                <a href="dashboard.php?asset=<?php echo $_SESSION['cata']; ?>">
                <img src="<?php echo '../image/'.$img;?>"  style="width:400px; height:200px;" class="card-img-top" alt="">
                </a>          
                </div>
              </div>
          </div>
      <?php  }
      }
      ?>
   </div>
   </section>
  </main>
   <?php include('../footer.html');?>




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
  <script>

    function showAlert(){
    var myText='Not available yet';
    alert(myText);
  }     
</script>

</body>

</html>
<?php }else{
  header("location:../index.php");
}