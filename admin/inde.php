<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$_SESSION['cata'] = $_GET['asset'];
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
  <link href="<?php echo '../image/'.$img?>" rel="touch-icon">
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
 <?php include('../headersidebar.php');
 if(isset($_SESSION['side'])){
 foreach($_SESSION['side'] as $fi)
 unset($_SESSION[$fi]);
 }
 if(isset($_SESSION['EMAIL'])){
  unset($_SESSION[$email]); 
 }
 if(isset($_SESSION['iopt'])){
  unset($_SESSION['iopt']); 
  unset($_SESSION['optional']); 
 }
 if(isset($_SESSION['eopt']) || isset($_SESSION['optional2'])){
  unset($_SESSION['eopt']);
  unset($_SESSION['optional2']);   
 }
 ?>
 
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

    <section class="section">
      <div class="row">
      <div style="text-align:right;">
      <a href="notinspected.php?asset=<?php echo $_SESSION['cata'] ?>" class="btn btn-primary" style="width:30%;" type="button" name="updateinfo"><i class="bi bi-list"></i>List of uninspected Vehicles</a><br><br>
</div>
      <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <?php if($_SESSION['cata']=='vehicle'){                   
                   $datee=date('d');
                    if($datee >= 3){             
                    ?>
                    <button class="btn btn-primary btn-sm"><a href="inspection.php?asset=<?php echo $_SESSION['cata']; ?>" class="text-white">
                     <i class="bi bi-plus">Start New Inspection</i></a></button> <?php }else { ?><button class="btn btn-primary btn-sm"><a href="inspection.php?asset=<?php echo $_SESSION['cata']; ?>" class="text-white">
                     <i class="bi bi-plus">Start New Inspection</i></a></button><?php   }?>                             
                </li>
              </ul>    
              </div><?php }  ?>
              <div class="card-body">                      	
             <form action ="recoredserver.php" method = "POST">
                <?php $query = "SELECT catagory FROM inspection where catagory = '".$_SESSION['cata']."' ";
                       $result = $conn->query($query);
                    if ($result = $conn->query($query)) {
                      
                    if ($result->num_rows > 0) {?>
              <!-- Table with stripped rows -->
              <table class="table datatable table-bordered">
              <thead>
                      <tr> 
                    <th style="width: 70px;">Plate Number</th>                     
                    <th>Vehicle Model</th>                 
                    <th>Last inspection Date</th>
                    <th style="width: 70px;">Days to next inspection</th>
                    <th>Inspect vehicle</th>
                    <th>Odometer reading</th>
                    <th>Km before next service</th>
                    <th>Update PMS</th>
                  </tr>
                </thead>
                <tbody>
                <?php                  
                    $comp = $_SESSION['company']; 
                    if($comp ='Hagbes HQ.')
                    $sql ="SELECT * from vehicle";
                    else
                    $sql ="SELECT * from vehicle WHERE `company` = '$comp'";
                    $result = $conn1->query($sql);
                    if ($result = $conn1->query($sql)) {
                      $count=1; 
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                    $test="SELECT id, MAX(inspection_date) as date, MAX(nxt_inspection_date) as next, MAX(odometer_reading) as odometer, MAX(serviced_at_odo) AS km FROM `inspection`  WHERE plateno = '" .$row['plateno']."' GROUP BY plateno" ;
                    if ($maxdate = $conn->query($test)) {  
                                           
                    if ($maxdate->num_rows > 0) {                     
                    while($ro = $maxdate->fetch_assoc()) { 
                     $var=" [".date("d M, Y",strtotime($ro['next']."-2 days"))."<i class='bi bi-dash'></i>".date("d M, Y",strtotime($ro['next']))."]";                    
    		             $next = strtotime($ro['next']);		             
    		             $today = strtotime(date("y-m-d"));
    		             $count = $next - $today;                         
    		             $days_remaining = round($count / (60 * 60 * 24));
                    if($days_remaining < 0){
                        //send auto email to pad
                    }  
                    elseif($days_remaining>=1 && $days_remaining<=3){
                       // send reminder
                    }else{
                       $remaining= $days_remaining ;
                       $_SESSION['$remaining']=$remaining;
                    }     
                    $pnn=$row["plateno"];
                    $date=$ro["date"];

                    $odo=$ro["odometer"];
                    if($days_remaining>3){
                      $_SESSION['insp'] = true;                 
                    }
                    $odometerr = $ro["odometer"];
                    $monthlykm =  $odometerr -  $ro['km'];
                    $km_beforenxt_service= 5000 - $monthlykm;
                     if($row['type'] = "work"){
                  $tester = "SELECT kmatend from actualreport where platenumber = '" .$row['plateno']."' AND registerdate=(SELECT MAX(registerdate) as maxx from actualreport where platenumber = '" .$row['plateno']."')";
                    $res = $conn1->query($tester);
                    if ($res = $conn1->query($tester)){                    
                    if ($res->num_rows > 0) {
                      while($roww = $res->fetch_assoc()) {
                        $kmatend=$roww['kmatend'];
                       if($kmatend > $odometerr){
                          $monthlykm = (int)$kmatend -  $ro['km'];
                          $km_beforenxt_service= 5000 - $monthlykm; 
                          $odometerr = $kmatend;                      
                       }     
                        }
                      }
                    }
                  }
                    ?>   
                 <tr>
                <td data-label="Plate Number" style="width=30px;"><a href='inspection_rec.php?asset=<?php echo $_SESSION['cata'];?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&kmbs=<?php echo $km_beforenxt_service;?>'><?php echo $row["plateno"];?></a></td>
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
                  <?php  if($days_remaining > 3){ ?>         
                <td  data-label="Inspect vehicle" ><a href='insp_form.php?asset=<?php echo $_SESSION['cata'];?>&pn=<?php echo $pnn;?>' class='btn btn-primary btn-sm disabled'>Inspect</a></td>
                <?php }else{?>
                  <td  data-label="Inspect vehicle" ><a href='insp_form.php?asset=<?php echo $_SESSION['cata'];?>&pn=<?php echo $pnn;?>' class='btn btn-primary btn-sm'>Inspect</a></td>
                <?php }?>              
                <td  data-label="odometer reading" ><?php echo  $odometerr;?></td>
                <?php
                if($km_beforenxt_service<=0){?>
                <td  data-label="km before next service" class="table-danger border-danger" title="Last serviced at: <?php echo $ro['km'];?>"><?php echo $km_beforenxt_service;?></td>
                <?php } 
                else {?>
                <td  data-label="km before next service" class="table-success border-success" title="Last serviced at: <?php echo $ro['km'];?>"><?php echo $km_beforenxt_service;?></td>
               <?php } ?>
                <td  data-label="update PMS"><a href='rule.php?asset=<?php echo $_SESSION['cata'];?>&pn=<?php echo $pnn;?>&odometer=<?php echo $odometerr;?>' class='btn btn-primary btn-sm'>Update</a></td>
              </tr>               
              <?php 
             }           
             
           }
                          
         }
       }
     }
   }?>
  
  </tbody>
  </table>
   
  <?php   }
 else 
 echo' 
      <div class="col-xl-12" style="text-align:center;"><span data-feather="alert-triangle" style="color:red;text-align:center;"><h3>NO results found</h3></span></div>';                                        
}
   ?> 
    
</form>
</div>
           

            </div>
          </div>

        </div>
      </div>
    </section>   

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('../footer.html');?>
<?php 
 // if($_SESSION['insp']){
   // unset($_SESSION['insp']);
 // }
 if(isset($_SESSION['random'])){
  unset($_SESSION['random']);
  unset($_SESSION['date']);
  }
  if(isset($_SESSION['eopt'])){
    unset($_SESSION['eopt']);
    unset($_SESSION['optional2']);   
   }
$requiredsession=array($_SESSION['username'],$_SESSION['cata'],$_SESSION['role'],$_SESSION['password'],$_SESSION['company']);
foreach($_SESSION as $key => $value){
  if(!in_array($key,$requiredsession)){
   // unset($_SESSION[$key]);
  }
}
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

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>
<?php }else{
  header("location:../index.php");
}