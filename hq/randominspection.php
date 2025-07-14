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
<section>
            <div class="card">
            <div class="card-body">             
             <div class="section">            	
             <form action ="recoredserver.php" method = "POST">

                <?php 
                $cata=$_SESSION['cata'];
                $query = "SELECT catagory FROM inspection where catagory = '$cata' ";
                       $result = $conn->query($query);
                    if ($result = $conn->query($query)) {                     
                    if ($result->num_rows > 0) {?>
              <table class="table datatable">
                <thead>
                  <tr>
                   
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Last inspection Date</th>
                    <th scope="col">Days to next inspection</th>
                    <th scope="col">Current odometer km reading</th>
                    <th scope="col">km before next service</th>
                    <th scope="col">Driver</th>
                    <th scope="col">company</th>
                  </tr>
                </thead>
                <?php                  
                    $comp = $_SESSION['company']; 
                    $sql ="SELECT * from vehicle";
                    $result = $conn1->query($sql);
                    if ($result = $conn1->query($sql)) {
                      $count=1; 
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {

                    $test="SELECT id, MAX(inspection_date) as date, MAX(nxt_inspection_date) as next, MAX(odometer_reading) as odometer, MIN(km_beforenxt_service) AS km,inspection_type FROM `inspection`  WHERE plateno = '" .$row['plateno']."' AND inspection_type = 'random' GROUP BY plateno" ;
                    if ($maxdate = $conn->query($test)) {  
                                           
                    if ($maxdate->num_rows > 0) {                     
                    while($ro = $maxdate->fetch_assoc()) { 
                     $var=$ro['next'];                    
    		             $next = strtotime($ro['next']);		             
    		             $today = strtotime(date("y-m-d"));
    		             $count = $next - $today;                         
    		             $days_remaining = round($count / (60 * 60 * 24));
                    if($days_remaining==-2){
                        //send auto email to pad
                    }  
                    elseif($days_remaining<=3){
                    
                    }
                    else{
                       $remaining= $days_remaining ;
                       $_SESSION['$remaining']=$remaining;
                      echo '<script> alert('.$comp.') </script>';
                    }     
                    $pnn=$row["plateno"];
                    $date=$ro["date"]; 
                    $odo=$ro["odometer"];
                    $insp_type=$ro["inspection_type"];
                    $inspected = (isset($_SESSION['inspected'.$pnn]))?' disabled':'';?>     
                 <tr>
                <td style="width=30px;"><a href='inspection_rec.php?asset=<?php echo $_SESSION['cata'];?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&type=<?php echo $insp_type;?>'><?php echo $row["plateno"];?></a></td>
                <td><?php echo $row["model"];?></td>               
                <td><?php echo $ro['date'];?></td>
                <?php 
                if($days_remaining<=0){ ?>
                  <td class="table-danger border-danger" title=<?php echo $var; ?>><?php echo $days_remaining;?></td>
                 <?php }
                elseif($days_remaining>=1 && $days_remaining<=3  ){ ?>
                  <td class='table-warning border-warning' title=<?php echo $var; ?>><?php echo $days_remaining;?></td>
                   <?php }
                else {?>
                <td class="table-success border-success" title=<?php echo $var; ?>><?php echo $remaining;?></td>  
                  <?php  } ?>           
                    <td><?php echo $ro["odometer"]?></td>                   
                    <?php
                if($ro['km']<=0){?>
                <td class="table-danger border-danger"><?php echo $ro['km'];?></td>
                <?php } 
                else {?>
                <td><?php echo $ro['km'];?></td>
               <?php } ?>
                    <td><?php echo $row['driver']?></td>
                    <td><?php echo $row['company']?></td><td>
                   <?php  $count++;

                    }
                  
                    
                  }
                                 
                }
                
              }
            }
          }
       }
        else 
        echo' 
             <br><div class="col-xl-12" style="text-align: center;"><span data-feather="alert-triangle" style="color:red"><h3>NO results Found</h3></span></div>'; 
                              
              
     }
              ?>
                              
                  </table>
                  </div>                                  
         </form>
          </div>
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