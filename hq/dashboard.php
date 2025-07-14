<?php 
session_start();
if($_SESSION['role']=="hq"){
  include ("recoredserver.php");
  $_SESSION['cata'] = $_GET['asset'];
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
<?php include('sidebar.php');?>
  <main id="main" class="main">             
  <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->      	
     <div class="pagetitle">
     <br><h1 class="decorated"><span><?php echo $_SESSION['cata'] ?> Inspection System<span></h1> 

         </div>
          <!-- <hr class="hline col-lg-3">-->
     </div>
   </div>

   <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
            <!-- Sales Card -->
            <div class="col-lg-4 col-md-6">
              <div class="card info-card sales-card">
              <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <?php $sql="select company from vehicle GROUP BY company";
                    $result = $conn1->query($sql);
                    if ($result->num_rows > 0) {                 
                      while($row = $result->fetch_assoc()){
                    ?>
                    <li><a id='<?php echo $row['company']?>' onclick="load(this,'counted')" class="dropdown-item" href="#"><?php echo $row['company']?></a></li>
                    <?php 
                      }
                    }
                    ?>                   
                  </ul>
                </div>
                <div class="card-body">                
                <ul class="list-group list-group-flush" id="counted">
               </ul>                  
              <!-- End Clean list group -->
                </div>
              </div>
            </div><!-- End Sales Card -->

                     <!-- Sales Card -->
                     <div class="col-lg-4 col-md-6">
                     <div class="card info-card sales-card">
                     <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <?php $sql2="select company from vehicle GROUP BY company";
                    $result2 = $conn1->query($sql2);
                    if ($result2->num_rows > 0) {                 
                      while($row2 = $result2->fetch_assoc()){
                    ?>
                    <li><a onclick="load(this,'vehcounted')" class="dropdown-item" href="#"><?php echo $row2['company']?></a></li>
                    <?php 
                      }
                    }
                    ?>
                  </ul>
                </div>
                <div class="card-body">                
                  <ul class="list-group list-group-flush" id='vehcounted'>  
              </ul>
                </div>
              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-lg-4 col-md-6 mx-auto  me-0">
              <div class="card info-card revenue-card">
              <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <?php $sql2="select company from vehicle GROUP BY company";
                    $result3 = $conn1->query($sql2);
                    if ($result3->num_rows > 0) {                 
                      while($row3 = $result3->fetch_assoc()){
                    ?>
                    <li><a onclick="load(this,'maincounted')" class="dropdown-item" href="#"><?php echo $row3['company']?></a></li>
                    <?php 
                      }
                    }
                    ?>
                  </ul>
                </div>
                <div class="card-body">                
                  <ul class="list-group list-group-flush" id='maincounted'>           
              </ul>
                </div>
              </div>
            </div><!-- End Revenue Card -->


            <div class="col-lg-12">
              <div class="card info-card revenue-card">
              <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <?php $get_month = date('m');
                          $curr_year = date('y');
                          $prevmonth = date('m', strtotime("last month")); 
                         ?>                 
                    <li><a id="thismonth"  name="<?php echo $get_month ?>" onclick="load(this,'date')" class="dropdown-item" href="#">This month</a></li>
                    <li><a id="prevmonth" name="<?php echo $prevmonth ?>" onclick="load(this,'date')" class="dropdown-item" href="#">Previous month</a></li>
                    <li><a id ="year"name="<?php echo $curr_year ?>" onclick="load(this,'date')" class="dropdown-item" href="#">This year</a></li>                                    
                  </ul>
                </div>
                <div class="card-body">               
                  <ul id="date" class="list-group list-group-flush">                          
              </ul>
                </div>
              </div>
            </div><!-- End Revenue Card -->

  </div>
   </div>
     </section>
         </main><!-- End #main -->

  
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
    function load(e,type)
    {
        
        const req = new XMLHttpRequest();
        req.onload = function(){//when the response is ready
        document.getElementById(type).innerHTML=this.responseText;
        }

        req.open("GET", "ajax.php?data="+e.innerHTML+"&type="+type);
        req.send();
    }
    //const currentMonth = (date.getMonth() + 1) ;
    load(document.getElementById('Hagbes HQ.'),'counted');
    load(document.getElementById('Hagbes HQ.'),'vehcounted');
    load(document.getElementById('Hagbes HQ.'),'maincounted');
    load(document.getElementById('thismonth'),'date');
    //var today = new Date();
    //var month = today.getMonth() + 1;
    //var currentMonth = (date.getMonth() + 1) ;
    
$(document).ready(function(){
   $('.check_vehicle').keyup(function(e){

   var plate = $('.check_vehicle').val();
    // alert('hello');
     $.ajax({
       type: "POST",
       url: "recoredserver.php",
       data: {
           "check_submit_btn":1,
           "plateno_id": plate
       },
          success: function(response){
            //alert(response);
            $('.error_vehicle').text(response);

          }
     });

});
});
</script>
</div>
</body>
</html>
<?php }else{
  header("location:../index.php");
}