<?php 
session_start();
if($_SESSION['role']=="pad"){
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
  <link href="../assets/css/customcss.css" rel="stylesheet">
</head>
<body>
<?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- End Dashboard Nav --><?php 
      $query = "SELECT * from asset WHERE type='inspection' AND availablity=1";
       $result = $conn->query($query);
        if ($result->num_rows > 0) {           
                  $count=1;              
                while($row = $result->fetch_assoc()) {
                  $img = $row["image"];
                  $_SESSION['cata'] = $row['catagory']; 
                ?>    
              <li class="nav-item">
                <a class="nav-link " href="inde.php?asset=<?php echo $_SESSION['cata']; ?>">
                  <i class="bi bi-grid"></i>
                  <span><?php echo  ucfirst($row["catagory"]);?></span>
                </a>
              </li>
          <?php  }
          }$query = "SELECT * from asset WHERE type='office' AND availablity=1";
           $result = $conn->query($query);
            if ($result->num_rows > 0) {           
                      $count=1;              
                    while($row = $result->fetch_assoc()) {
                      $img = $row["image"];
                      $_SESSION['cata'] = $row['catagory']; 
                    ?>
                  <li class="nav-item">
                    <a class="nav-link " href="../fixed_assets/index.php?asset=<?php echo $_SESSION['cata']; ?>">
                      <i class="bi bi-grid"></i>
                      <span><?php echo  ucfirst($row["catagory"]);?></span>
                    </a>
                  </li>
          <?php  }
          }
          ?>
      
  
  </aside>
 <main id="main" class="main">
 <div class="card">          
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->      	
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Asset Inspection System<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>
   </div>
       <section class="section">
      <div class="container">  
         <div class='row' data-aos="zoom-in">
    <?php 
      $query = "SELECT * from asset WHERE type='inspection' AND availablity=1";
       $result = $conn->query($query);
        if ($result->num_rows > 0) {           
                  $count=1;              
                while($row = $result->fetch_assoc()) {
                  $img = $row["image"];
                  $_SESSION['cata'] = $row['catagory']; 
                ?>     
          <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
              <div class="card">
                <div class="card-body text-center p-2">                                  
                <a href="inde.php?asset=<?php echo $_SESSION['cata']; ?>">
                <img src="<?php echo '../image/'.$img;?>" class="card-img-top" alt="asset picture" width="100%" height="200px">
                </a> 
                <?php echo  ucfirst($row["catagory"]);?>             
                </div>
              </div>
          </div>
      <?php  }
      }$query = "SELECT * from asset WHERE type='office' AND availablity=1";
       $result = $conn->query($query);
        if ($result->num_rows > 0) {           
                  $count=1;              
                while($row = $result->fetch_assoc()) {
                  $img = $row["image"];
                  $_SESSION['cata'] = $row['catagory']; 
                ?>     
          <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
              <div class="card">
                <div class="card-body text-center p-2">                                  
                <a href="../fixed_assets/index.php?asset=<?php echo $_SESSION['cata']; ?>">
                <img src="<?php echo '../image/'.$img;?>" class="card-img-top" alt="" width="100%" height="200px">
                </a>  
                <?php echo  ucfirst($row["catagory"]);?>       
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
