<?php 
session_start();
if($_SESSION['role']=="hq"){
  include ("recoredserver.php");
  $_SESSION['cata'] = $_GET['asset'];
  $type=$_GET['type'];
if(!($_SESSION['cata']))
header("location:asset.php");
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
  <script src="../jquery.min.js"></script>


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
body{
    width: 100%;
    height: 100%;
  font-family: sans-serif;
}

*{
  box-sizing: border-box;
}

.table{
  
  border-collapse: collapse;
}

.table td,.table th{
  padding:12px 15px;
  border:1px solid #ddd;
  text-align: center;
  font-size:16px;
}

.table th{
  background-color: #87CEEB ;
  color:white;
}

.table tbody tr:nth-child(even){
  background-color: #F0FFFF;
}

/*responsive*/

@media(max-width: 900px){
  .table thead{
    display: none;
  }

  .table, .table tbody, .table tr, .table td{
    display: block;
    width: 100%;
  }
  .table tr{
    margin-bottom:20px;
  }
  .table td{
    text-align: right;
    padding-left: 50%;
    text-align: right;
    position: relative;
    padding-bottom:20px;
    margin-bottom:20px;
    height:50px;
    padding: 3px 3px;

  }
  .table td::before{
    content: attr(data-label);
    position: absolute;
    left:0;
    width: 50%;
    padding-left:15px;
    font-size:14px;
    font-weight: bold;
    text-align: left;
  }
}

 
  </style>

</head>

<body>

<?php include('headersidebar.php');?>
<?php include('sidebar.php');
?>
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
                    <th scope="col">Plate Number</th>
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Last inspection Date</th>
                    <th scope="col">Days to next inspection</th>
                    <th scope="col">Current odometer reading</th>
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

                    $test="SELECT id, MAX(inspection_date) as date, MAX(nxt_inspection_date) as next, MAX(odometer_reading) as odometer, MAX(serviced_at_odo) AS km,inspection_type FROM `inspection`  WHERE plateno = '" .$row['plateno']."'  AND inspection_type = '$type' GROUP BY plateno" ;
                    if ($maxdate = $conn->query($test)) {  
                                           
                    if ($maxdate->num_rows > 0) {                     
                    while($ro = $maxdate->fetch_assoc()) { 
                     $var=" [".date("d M, Y",strtotime($ro['next']."-2 days"))."<i class='bi bi-dash'></i>".date("d M, Y",strtotime($ro['next']))."]";                     
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
                  
                    $monthlykm =  $odo-  $ro['km'];
                    $km_beforenxt_service= 5000 - $monthlykm;
                     if($row['type'] = 'work'){
                  $tester = "SELECT kmatend from actualreport where platenumber = '" .$row['plateno']."' AND registerdate=(SELECT MAX(registerdate) as maxx from actualreport where platenumber = '" .$row['plateno']."')";
                    $res = $conn1->query($tester);
                    if ($res = $conn1->query($tester)) {                    
                    if ($res->num_rows > 0) {
                      while($roww = $res->fetch_assoc()) {
                        $kmatend=$roww['kmatend'];
                       if($kmatend> $odo){
                          $monthlykm = (int)$kmatend -  $ro['km'];
                          $km_beforenxt_service= 5000 - $monthlykm; 
                          $odo = $kmatend;                                             
                       }     
                        }
                      }
                    }
                  }
                    ?>     
                 <tr>
                <td data-label="Plate Number" style="width=30px;"><a href='inspection_rec.php?asset=<?php echo $_SESSION['cata'];?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&type=<?php echo $insp_type;?>&kmbs=<?php echo $km_beforenxt_service;?>'><?php echo $row["plateno"];?></a></td>
                <td  data-label="Vehicle Model"><?php echo $row["model"];?></td>               
                <td  data-label="Last inspection Date"><?php echo $ro['date'];?></td>
                <?php 
                if($days_remaining<=0){ ?>
                  <td data-label="Days to next inspection" class="table-danger border-danger"><?php echo $days_remaining.$var;?></td>
                 <?php }
                elseif($days_remaining>=1 && $days_remaining<=3  ){ ?>
                  <td  data-label="Days to next inspection" class='table-warning border-warning'><?php echo $days_remaining.$var;?></td>
                   <?php }
                else {?>
                <td  data-label="Days to next inspection" class="table-success border-success"><?php echo $remaining.$var;?></td>  
                  <?php  } ?>           
                    <td  data-label="Current odometer reading"><?php echo $odo?></td>                   
                    <?php
                if($km_beforenxt_service<=0){?>
                <td  data-label="km before next service" class="table-danger border-danger" title="Last serviced at: <?php echo  $ro['km'];?>"><?php echo $km_beforenxt_service;?></td>
                <?php } 
                else {?>
                <td  data-label="km before next service" class="table-success border-success" title="Last serviced at: <?php echo  $ro['km'];?>"><?php echo $km_beforenxt_service;?></td>
               <?php } ?>
                    <td  data-label="Driver"><?php echo $row['driver']?></td>
                    <td  data-label="Company"><?php echo $row['company']?></td>
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
             <br><div class="col-xl-12" style="text-align: center;"><span data-feather="alert-triangle" style="color:red"><h3>No results found</h3></span></div>'; 
                              
              
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