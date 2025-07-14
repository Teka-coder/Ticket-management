<?php 
session_start();
if($_SESSION['role']=="pad"){
include ("recoredserver.php");
$cata=$_GET['asset'];
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../styles/style_div.css" rel="stylesheet">
  <link href="../styles/styles.css" rel="stylesheet">
  <script src="../jquery.min.js"></script>
  <script src="../getscript.js"></script>

</head>

<body>

<?php include('../headersidebar.php');?>
<?php include('sidebar.php');
if(isset($_SESSION['kmbs']))
unset($_SESSION['kmbs']);
?>

  <main id="main" class="main">


    <div class="pagetitle" style="text-align: center">
      <h1>Inspection and Maintenance report</h1>
       <nav>
        <ol class="breadcrumb">
         <!-- <li><a href="dashboard.php?asset=<?php //echo $cata;?>"><i class="fa fa-arrow-circle-o-left" style="font-size:36px;color:#87CEEB"></i></a></li> -->        
        </ol>
      </nav>
    </div><!-- End Page Title -->

  
    <form class="form-horizontal" action="inspreport.php?asset=<?php echo $cata;?>" method='post' enctype="multipart/form-data"> 
    <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="border: 2px solid  #fff; text-align: right;">         
              <select name="comp" style="cursor:pointer;" class="btn btn-outline-primary" id="comp">
                            <option value="">---Company---</option>
                              <?php
                              $query="SELECT * from comp GROUP BY Name";
                                $ma=mysqli_query($conn1,$query) or die(mysqli_error($conn1));
                                while($row=mysqli_fetch_array($ma))
                                {
                                  $name=$row['Name'];
                                  ?>
                            <option value="<?php echo $name?>"><?php echo $name?></option>
                              <?php
                              }
                              ?>
                            </select>&nbsp; &nbsp;
              <select name="pn" style="cursor:pointer;" class="btn btn-outline-primary" id="pn">
                            <option value="">---Plate Number---</option>
                              <?php
                              $query="SELECT * from vehicle ORDER BY  plateno";
                                $ma=mysqli_query($conn1,$query) or die(mysqli_error($conn1));
                                while($row=mysqli_fetch_array($ma))
                                {
                                  $name=$row['plateno'];
                                  ?>
                            <option value="<?php echo $name?>"><?php echo $name?></option>
                              <?php
                              }
                              ?>
                            </select>&nbsp; &nbsp;
             
              <select name="insp_type" style="cursor: pointer;" class="btn btn-outline-primary">
                    <option value="">---Inspection Type---</option>
                    <option value="Regular">Regular Inspection</option>
                    <option value="Random">Random Inspection</option>
                        </select>&nbsp;&nbsp;
                        <input type="date" name="insp_date" class="btn btn-outline-primary"  style="cursor:pointer;">
                  <button class="btn btn-primary" type="submit" name="view"><i class="bi bi-search"></i>Search</button>
              </div></div>
  
    <div class='container py-3 pricing'>
    <div class='section-title text-center py-2  mb-3  alert-primary rounded'>
                <h5 class='text-white'>Inspection Report</h5> 
            </div>
           <div class='row'>         
    <?php
    if(isset($_POST['view'])){
      $pn=$_POST['pn'];
      $insp_date=$_POST['insp_date'];
      $insp_type=$_POST['insp_type'];
      $company=$_POST['comp'];
    if($pn=="" AND $company=="" AND $insp_date=="" AND $insp_type=="")
      {
        $querym = "SELECT * from inspection   ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company=="" AND $insp_date=="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE inspection_type ='$insp_type'  ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company=="" AND $insp_date!="" AND $insp_type==""){
      $querym = "SELECT * from inspection  WHERE inspection_date ='$insp_date'  ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company=="" AND $insp_date!="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE inspection_date ='$insp_date' AND inspection_type ='$insp_type'  ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company!="" AND $insp_date=="" AND  $insp_type==""){
      $querym = "SELECT * from inspection  WHERE company ='$company'  ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company!="" AND  $insp_date=="" AND $ $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE company = '$company' AND inspection_type ='$insp_type'  ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company!="" AND  $insp_date!="" AND $insp_type==""){
      $querym = "SELECT * from inspection  WHERE company = '$company' AND inspection_date ='$insp_date'  ORDER BY inspection_date DESC ";
    }else if($pn=="" AND $company!="" AND  $insp_date!="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE company = '$company' AND  inspection_date ='$insp_date'  ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company=="" AND  $insp_date=="" AND $insp_type==""){
      $querym = "SELECT * from inspection  WHERE plateno = '$pn' ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company=="" AND  $insp_date=="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE plateno = '$pn' AND inspection_type ='$insp_type'  ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company=="" AND  $insp_date!="" AND $insp_type==""){
      $querym = "SELECT * from inspection  WHERE plateno = '$pn' AND inspection_date ='$insp_date'   ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company=="" AND  $insp_date!="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE plateno = '$pn' AND  (inspection_date ='$insp_date' AND inspection_type ='$insp_type')  ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company!="" AND  $insp_date=="" AND $insp_type==""){
      $querym = "SELECT * from inspection  WHERE plateno = '$pn' AND company = '$company'  ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company!="" AND  $insp_date=="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE (plateno = '$pn' AND company = '$company') AND  inspection_type ='$insp_type'  ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company!="" AND  $insp_date!="" AND $insp_type==""){
      $querym = "SELECT * from inspection  WHERE (plateno = '$pn' AND company = '$company') AND  inspection_date ='$insp_date'   ORDER BY inspection_date DESC ";
    }else if($pn!="" AND $company!="" AND $insp_date!="" AND $insp_type!=""){
      $querym = "SELECT * from inspection  WHERE (plateno = '$pn' AND company = '$company') AND  (inspection_date ='$insp_date' AND inspection_type ='$insp_type')  ORDER BY inspection_date DESC ";
    }?>
    <div class="row">
         <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
           <?php
             if($company=="")
               $company="";
             else
               $company.="<i class='fa fa-angle-double-right' aria-hidden='true'></i>";
             if($insp_date=="")
               $insp_date="";
             else
               $insp_date.="<i class='fa fa-angle-double-right' aria-hidden='true'></i>";
             if($pn=="")
               $pn="";
             if($insp_type=="")
               $insp_type="";
             else
               $insp_type.="<i class='fa fa-angle-double-right' aria-hidden='true'></i>";
             if($company=="" AND $pn=="" AND $insp_type=="" AND $insp_date=="")
               echo "<strong><p style='font-size:24px;'>Search result for: All</p></strong> ";
             else
            echo "<p><strong style='font-size:24px;'>Search result for: </strong>".$company." ".$pn." ".$insp_date." ".$insp_type."</p>";
            ?>
         </div>
      </div>
    <?php
    }else{
    $querym = "SELECT * from inspection   ORDER BY inspection_date DESC ";
    }
    $ma=mysqli_query($conn,$querym) or die(mysqli_error($conn));
    if(mysqli_num_rows($ma)>0)
        {
    while($row=mysqli_fetch_array($ma))
        {
        $model=$row['model'];
        $plateno=$row['plateno'];
        $inspection_date=$row['inspection_date'];
        $nextdate=$row['nxt_inspection_date'];
        $intava=explode(',',$row['int_okay']);
        $intnotava=explode(',',$row['int_notokay']);
        $extava=explode(',',$row['ex_okay']);
        $extnotava=explode(',',$row['ex_notokay']);
        $inspby=$row['inspected_by'];
        $insp_type=$row['inspection_type'];
        $odometer=$row['odometer_reading'];
       // $kmbservice=$row['serviced_at_odo'];
        $comment=$row['comments'];
        $type=$row['inspection_type'];
        $idd=$row['id'];
        $driver=$row['driver'];
        $company=$row['company'];
        ?>        
             <div class='col-sm-12 col-md-12 col-lg-5 mb-3' id=''>
                            <div class='box shadow'>
                            <h3 class='text-capitalize'><?php echo $plateno." | ".$inspection_date?></h3>
                            <ul>
                                <li class='text-start'><span class='fw-bold'>Inspection_type : </span><?php echo $insp_type ?></li>
                                <li class='text-start'><span class='fw-bold'>Model : </span><?php echo $model ?></li>
                                <li class='text-start'><span class='fw-bold'>Driver : </span><?php echo  $driver ?></li>             
                                <li class='text-start'><span class='fw-bold'>Odometer reading : </span><?php echo $odometer ?></li>   
                                <li class='text-start'><span class='fw-bold'>Inspection due date : </span><?php echo  $nextdate ?></li>
                                <li class='text-start'><span class='fw-bold'>Inspected by : </span><?php echo  $inspby ?></li>
                                <li class='text-start'><span class='fw-bold'>Inspection Type : </span><?php echo  $type ?></li>
                                <li class='text-start'><span class='fw-bold'>Company : </span><?php echo  $company ?></li>
                               <?php if($comment!=''){?>
                                <li class='text-start'><span class='fw-bold'>Remark : </span><?php echo  $comment ?></li><?php }?>
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne<?php echo $idd ?>">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?php echo $idd ?>" aria-expanded="false" aria-controls="flush-collapseOne<?php echo $idd ?>">
                    <span class='fw-bold'>Interior Compliant items</span>
                  </button>
                </h2>                                                                 
                 <div id="flush-collapseOne<?php echo $idd ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne<?php echo $idd ?>" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                    <div class="row">
                    <?php foreach($intava as $ia){?>
                      <div class="col-sm-6">
                      <li><?php echo $ia; ?> </li></div><?php }?>                  
                    </div>
                 </div>
                </div> 

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo<?php echo $idd ?>">        
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo<?php echo $idd ?>" aria-expanded="false" aria-controls="flush-collapseTwo<?php echo $idd ?>">
                   <span class='fw-bold'>Interior Non-Compliant items</span>
                  </button>
                </h2>      
                 <div id="flush-collapseTwo<?php echo $idd ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo<?php echo $idd ?>" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                  <div class="row">
                   <?php foreach($intnotava as $ina){?>
                    <div class="col-sm-6">
                   <li> <?php echo $ina;?> </li></div><?php }?>  
                  </div>
                 </div>
            </div> 

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree<?php echo $idd ?>">    
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree<?php echo $idd ?>" aria-expanded="false" aria-controls="flush-collapseThree<?php echo $idd ?>">
                    <span class='fw-bold'>Exterior Compliant items</span>
                  </button>
                </h2>      
              <div id="flush-collapseThree<?php echo $idd ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingThree<?php echo $idd ?>" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="row">
                      <?php foreach($extava as $ea){?>
                        <div class="col-sm-6">
                        <li> <?php  echo $ea; ?> </li></div><?php }?>   
                </div>
              </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour<?php echo $idd ?>"> 
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour<?php echo $idd ?>" aria-expanded="false" aria-controls="flush-collapseFour<?php echo $idd ?>">
                   <span class='fw-bold'>Exterior Non-compliant items</span>
                  </button>
                </h2>      
              <div id="flush-collapseFour<?php echo $idd ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingFour<?php echo $idd ?>" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="row">
                    <?php foreach($extnotava as $ena) {?>
                      <div class="col-sm-6">
                    <li> <?php echo $ena; ?> </li></div><?php }?>   
                </div>
              </div>
            </div>
          </div>
          <a href="pastinspection.php?asset=<?php echo $cata?>&pn=<?php echo $plateno?>&date=<?php echo $inspection_date?>&id=<?php echo $idd?>" class="btn btn-outline-primary rounded-pill">View Detail</a>
         </ul>
    </div>
 </div>                         
<?php
        }
    }else{
      echo' 
      <br><div class="col-xl-12" style="text-align: center;"><span data-feather="alert-triangle" style="color:red"><h3>NO results Found</h3></span></div>'; 
     }?>
    </div>
</div>
    </form>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
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
    function load()
    {
        
        const req = new XMLHttpRequest();
        req.onload = function(){//when the response is ready
        document.getElementById(type).innerHTML=this.responseText;
        }

        req.open("GET", "ajax.php?data="+e.innerHTML+"&type="+type);
        req.send();
    }


 </script> 

</body>

</html>
<?php }else{
  header("location:../index.php");
}