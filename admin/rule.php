<?php 
session_start();
if($_SESSION['role']=="pad"){
$cata = $_GET['asset'];
$ppn=$_GET['pn'];
$odo=$_GET['odometer'];
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
th, td {
  border: 1px solid grey; 
}
.card-header{
    background-color: #87CEEB !important;
    height: 50px;
  }
  h5{
    color:white;
  }

  </style>
</head>


<body>

 <?php include('../headersidebar.php');?>

 <?php include('sidebar.php');?>


  <main id="main" class="main">
  <div class="pagetitle text-center">
      <h1>Vehicle Maintenance Sheet</h1>
      <nav>
        <ol class="breadcrumb">
          <li><a href="inde.php?asset=<?php echo $cata;?>">Back</a></li>         
        </ol>
      </nav>
      <nav>      
    </div>
    <div class="col-lg-12">
     <div class="card">
            <div class="card-header"> 
            <span class="text-white">Vehicle</span>                    
               </div>
            <div class="card-body">
       <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">          
              <?php    
    $plateno=$ppn;
          $sql ="SELECT MAX(odometer_reading) as odo,model,plateno,driver,company from inspection WHERE  plateno = '$plateno' limit 1 ";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {                     
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                     //$odo = $row['odo']; 
                     $date = date('Y-m-d');             
              echo'
              <div class="col-lg-4">
            <span  style ="color:#012970;">Model:&nbsp'. $row["model"].'</span><br>
            <span style ="color:#012970;">Plate No:&nbsp'. $row["plateno"].'</span>
                   
        </div>
           <div class="col-lg-4">
          <span style ="color:#012970;">Driver:&nbsp'. $row["driver"].'</span><br>
          <span style ="color:#012970;">Company:&nbsp'. $row["company"].'</span>
                   
        </div>
           <div class="col-lg-4">
            <span style ="color:#012970;">Date:&nbsp '.$date.'</span><br>
            <span style ="color:#012970;">Current Millage:&nbsp'.$odo.'</span>
            </div>';
          }
        }  
      }
    
            ?>
                         
        </div>
      </div>
    </section>                       
          </div>

        </div>
      </div> 
       <div class="card">
                  <div class="card-header"> <ul class="nav nav-pills card-header-pills">
                  <h5> Items That Should be checked</h5>
               </div>
           
            
             <div class="card-body">         
              <form action="rule.php?asset=<?php echo $cata; ?>&pn=<?php echo $ppn;?>&odometer=<?php echo $odo;?>" method="POST">
              <br><table class="table datatable" border='1px'>
                <thead class="table-primary">
                <tbody>
                   <tr border='1px'>
                   <th style="text-align:center"  class="col-2" >ID</th>
                   <th style="text-align:center"  class="col-2" >Type</th>
                   <th style="text-align:center" class="col-2" >Description</th>
                   <th  style="text-align:center" class="col-2" >Action to be taken</th>
                   <th  style="text-align:center" class="col-2" >km reading</th>               
                   <th colspan="2"  style="text-align:center" class="col-2" >job</th>          
                  </tr>
                </tbody>
              </thead>

                   <?php  
                 
                     $chk = 0; 
                     $query ="SELECT MAX(odometer_reading) as odo,model,plateno,driver,company from inspection WHERE  plateno = '$plateno'";                     
                     $res = $conn->query( $query); 
                      
                   if ($res->num_rows > 0) {
                   while($row = $res->fetch_assoc()) {
                       
                       //$odo = $row['odo'];
                       //$_SESSION['odo']=$odo;
                    $sql ="SELECT * from pmsrule";                  
                    if ($result = $conn->query($sql)) {
                                          
                    if ($result->num_rows > 0) {
                                         
                       while($ro = $result->fetch_assoc()) {
                      $id = $ro['id'];
                      $type =$ro['type'];
                      $description= $ro['type-description'];
                      $interval = $ro['every_interval'];
                      $at = $ro['at'];
                      $action = $ro['action'];
                      $checkstatus = "";

                      if($interval!=""){
                    $checkstatus =  $action."&nbsp every &nbsp".  
                       $interval.'&nbsp km';
                       $start=  $interval; }
                    if($ro['every_interval']!= '' )
                        if($odo>=$ro['every_interval'] AND $odo % $ro['every_interval'] == 0 ) {                         
                      echo'
                    <tr>
                    <th >'.$id.'</th>
                    <th >'.$type.'</th>
                    <td >'.$description.'</td>
                    <td >'. $checkstatus.'</td><td>'
                     .$odo.'&nbsp km</td><td>
                    <input type="radio" name="'.$ro['id'].'"  value="done" required>done</td>
                    <td ><input type="radio" name="'.$ro['id'].'" value="notdone" required>not done</td>
                  </tr>';
                       }
                     
                     if($at!=""){
                      $checkstatus =  $action."&nbsp at &nbsp".  
                       $at.'&nbsp km';
                       //$start=  $interval; 

                     //if($row['odometer_km_reading']==$ro['at']) {
                        if($odo==$ro['at']) {
                      echo'
                    <tr>
                     <th >'.$id.'</th>
                    <th>'.$type.'</th>
                    <td>'.$description.'</td>
                    <td>'.$checkstatus.'</td><td>'
                   // .$row['odometer_km_reading'].'</td><td>
                    .$odo.'&nbsp km</td><td>
                    <input type="radio" name="'.$ro['id'].'" value="done" required>done</td>
                    <td ><input type="radio" name="'.$ro['id'].'" value="notdone" required>not done</td>
                  </tr>';
                       

                 }     
              }
            }
         }
       }
      }
    }
      

  
               ?>
                   </tr>
                </tbody>
              </table>
             
</div>
</div>
 <div class="text-center">                
  <button class='btn btn-primary align-items-center justify-content-center' name='msubmit'  type='submit'>submit</button>
</div>
</form>
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


</body>
</html>
<?php }else{
  header("location:../index.php");
}
