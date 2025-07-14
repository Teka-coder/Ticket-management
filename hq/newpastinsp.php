<?php 
session_start();
if($_SESSION['role']=="hq"){
include ("recoredserver.php");
$cata = $_GET['asset'];
$pnn=$_GET['pn'];
$date=$_GET['date'];  
$iid=$_GET['id'];
if(isset($_GET['type'])){
$type=$_GET['type'];
}
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
  
</head>
<style>
.card-header{

  height:60px;
}
h5,h6{
  color:black;
}
div.gallery {
  margin: 15px;
  border: 1px solid #ccc;
  float: left;
  width: 200px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  /*text-align: center;*/
}

  .card-header{
  background-color:#87CEEB !important;
  height:50px;
}
.container {
  padding: 2rem 0rem;
}

h4 {
  margin: 2rem 0rem 1rem;
}

  td, th {
    vertical-align: middle;
  }
</style>
<body>

 <?php include('../headersidebar.php');?>
 <?php include('sidebar.php');?>
 <main id="main" class="main">
 <div class="pagetitle">
      <h1>Past inspection data</h1>
      <nav>
        <ol class="breadcrumb">
          <?php if(isset($_GET['type'])){?>
        <li class="breadcrumb-item"><a href="inspection_rec.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&type=<?php echo $type;?>">Back</a></li>        
        <?php }
        else{?>
        <li class="breadcrumb-item"><a href="inspreport.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>">Back</a></li>
        <?php  }?>
      </ol>
      </nav>
    </div>

    <div class="col-lg-12">
      <div class="card">
            <div class="card-header">             
                  <h5  class="text-white">Inspection Information</h5>                     
            </div>
         <div class="card-body">                       
                   <?php 
                 $sql = "SELECT * FROM inspection WHERE inspection_date = '$date' and plateno = '$pnn' LIMIT 1" ;
                    
                 $result = $conn->query($sql);

                  if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()){
                      $_SESSION['inspid'] = $row['id'];
                      ?>                       
              <div class='tab-content pt-2' id='myTabContent'>
                <div class='tab-pane fade show active' id='pills-home' role='tabpanel' aria-labelledby='home-tab'>
                  <div class='col-lg-12'>
                    <div class='row'>  
                     <div class='col-lg-4'>
                         <p style ="color:#012970;">Vehicle Model:<?php echo $row['model']?></p>
                         <p style ="color:#012970;">Plate Number: <?php echo $row['plateno']?></p>
                     </div>
                     <div class='col-lg-4'>
                          <p style ="color:#012970;">Inspection Date: <?php echo $row['inspection_date']?></p>
                          <p style ="color:#012970;">Next Inspection Date:<?php echo $row['nxt_inspection_date']?></p>
                     </div>
                     <div class='col-lg-4'>     
                          <p style ="color:#012970;">Inspected By: <?php echo $row['inspected_by']?></p>
                          <p style ="color:#012970;">Driver: <?php echo $row['driver']?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <?php }
                  }?>          
          </div>
        </div>
      </div>

     <div class="col-lg-12">
     <div class="card">
            <div class="">  
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">              
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" onclick="document.getElementById('exterior').classList.add('d-none');document.getElementById('interior').classList.remove('d-none')" role="tab" aria-controls="pills-profile" aria-selected="true">Internal Items</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"  onclick="document.getElementById('interior').classList.add('d-none');document.getElementById('exterior').classList.remove('d-none')" role="tab" aria-controls="pills-contact" aria-selected="false">External Items</button>
                </li>
              </ul>
            </div>
            <div class="card-body">                       
                   <?php 
                 $sql = "SELECT * FROM inspection WHERE inspection_date = '$date' and plateno = '$pnn'" ;
                    
                 $result = $conn->query($sql);

                  if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()){
                      $_SESSION['inspid'] = $row['id'];
                      ?>                       
                <div class='tab-content pt-2' id='myTabContent'>
              <div class='tab-pane fade show active' id='pills-profile' role='tabpanel' aria-labelledby='profile-tab'>
                          
                           <h6 span class='badge bg-success text-light'>Availabel Items</span><h6>
                    <div class="row">
                           <?php 
                           $arr=explode(',',$row['int_okay']);                         
                           foreach($arr as $a){?>
                      <div class="col-sm-3"> 
                          <br><span class=''><?php echo $a?></span><br>
                      </div>
                          <?php  }  ?> 
                                             
                    </div>                     
                           <h6  span class='badge bg-danger text-light'>Not Availabel Items</span><h6>
                           <div class="row">                       
                         <?php 
                           $arr=explode(',',$row['int_notokay']);                        
                           foreach($arr as $a){?>
                     <div class="col-sm-2">
                         <br><span class='' ><?php echo $a?></span><br>
                     </div>
                          <?php  }
                        ?>
                       
                    </div>
                  </div>
                <div class='tab-pane fade' id='pills-contact' role='tabpanel' aria-labelledby='contact-tab'>
                  
                        
                           <h6 span class='badge bg-success text-light'>Availabel Items</span><h6>
                           <div class="row"> 
                          <?php 
                           $ex_ava=explode(',',$row['ex_okay']);
                           foreach($ex_ava as $e){?>
                           <div class="col-sm-3"> 
                         <br> <span class=''><?php echo $e?></span><br>
                           </div>
                          <?php  }
                        ?>
                        </div>

                       
                        <h6 span class='badge bg-danger text-light'>Not Availabel Items<h6>
                          <?php 
                           $ex_not=explode(',',$row['ex_notokay']);
                           foreach($ex_not as $ex){?>
                            <div class="col-sm-3">
                         <br> <span  class=''><?php echo $ex?></span><br> 
                         </div>
                          <?php  }
                        ?>   
                        
                        </div>
                         </div>                  
                  <?php   break;
                       }           
                  }                 
                ?>                        
              </div>
            </div>
          </div>
        </div>
 <div class="container" id="interior">
 <div class="card" id="interior">
    <div class="card-header text-white">Interior body inspection</div>
      <div class="card-body">
   <div class="col-lg-12">
  <div class="row">
    <div class="col-12">
    <table class="table table-image">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Status</th>
          <th scope="col">Damage Type</th>
          <th scope="col">Remark</th>        
        </tr>
      </thead>
      <tbody>
      <?php 
        $id =  $_GET['id'];;        
          $query = "SELECT * from int_inspection where insp_id = '$id'";
           $res = mysqli_query($conn,$query);           
           if ($res->num_rows > 0) {
               $count = 1;
            while($row = $res->fetch_assoc()){      
                  ?>   
        <tr>
          <th scope="row"><?php echo $count?></th>
          <td class="w-25">
          <a href="<?php echo $row['image'] ?>" data-toggle="lightbox" data-caption="<?php echo $row['name'] ?>" data-gallery="example-gallery">
               <img src="<?php echo $row['image'] ?>" class="img-fluid img-thumbnail" alt="" >
               </a> 
          </td>
          <td><h6 style ="color:#012970;"><?php echo $row['name'] ?></h6></td>
          <td><h6 style ="color:#012970;"><?php echo $row['status'] ?></h6></td>
          <td><h6 style ="color:#012970;"><?php echo $row['damage_type'] ?></h6></td>
          <td><h6 style ="color:#012970;"><?php echo $row['remark'] ?></h6></td>
        </tr>
        <?php $count++;
                 }
                
                      }?> 
      </tbody>
    </table>   
    </div>
  </div>
</div>
</div>
</div>
</div>
<div class="container d-none" id="exterior">
 <div class="card" id="exterior">
    <div class="card-header text-white">Exterior body inspection</div>
      <div class="card-body">
   <div class="col-lg-12">
  <div class="row">
    <div class="col-12">
    <table class="table table-image">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Status</th>
          <th scope="col">Damage Type</th>
          <th scope="col">Remark</th>        
        </tr>
      </thead>
      <tbody>
      <?php 
        $id =  $_GET['id'];;        
          $test = "SELECT * from ext_inspection where exinsp_id = '$id'";
           $result = mysqli_query($conn,$test);           
           if ($result->num_rows > 0) {
               $count = 1;
            while($row = $result->fetch_assoc()){      
                  ?>   
        <tr>
          <th scope="row"><?php echo $count?></th>
          <td class="w-25">
          <a href="<?php echo $row['image'] ?>" data-toggle="lightbox" data-caption="<?php echo $row['name'] ?>" data-gallery="example-gallery">
               <img src="<?php echo $row['image'] ?>" class="img-fluid img-thumbnail" alt="" >
               </a> 
          </td>
          <td><h6 style ="color:#012970;"><?php echo $row['name'] ?></h6></td>
          <td><h6 style ="color:#012970;"><?php echo $row['status'] ?></h6></td>
          <td><h6 style ="color:#012970;"><?php echo $row['damage_status'] ?></h6></td>
          <td><h6 style ="color:#012970;"><?php echo $row['remark'] ?></h6></td>
        </tr>
        <?php $count++;
                 }
                
                      }?> 
      </tbody>
    </table>   
    </div>
  </div>
</div>
</div>
</div>
</div>



</main>

<?php include('../footer.html');?>

 <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
 <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="../assets/vendor/chart.js/chart.min.js"></script>
 <script src="../assets/vendor/echarts/echarts.min.js"></script>
 <script src="../assets/vendor/quill/quill.min.js"></script>
 <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
 <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
 <script src="../assets/vendor/php-email-form/validate.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>

 <!-- Template Main JS File -->
 <script src="../assets/js/main.js"></script>
 <script>
 $('.popup').click(function(){
 var src=$(this).attr('src');
 $('.mm').modal('show');
 $('#popup-img').attr('src',src);
 });

</script>

</body>

</html>
<?php }else{
 header("location:../index.php");
}
