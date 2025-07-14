<?php 
session_start();
if($_SESSION['role']=="admin"){
  include ("controller.php");
$cata = $_GET['asset'];
$pnn=$_GET['pn'];
$date=$_GET['date'];  
$iid=$_GET['id'];
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TVS | Ticket Verification System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <?php 
  $comp = $_SESSION['company'];
  $sql= "select * from comp where name = '$comp'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">
<?php 
}
}
?>
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
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
  <link href="../font-awesome.min.css" rel="stylesheet">
  
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
[data-caption]{
  caption-side:top !important;
  
}


h4 {
  margin: 2rem 0rem 1rem;
}

  td, th {
    vertical-align: middle;
  }
  .card-header{
  height: 50px;

}
.notok,.ok,.doesnotexist{
    -webkit-appearance: initial;
    appearance: initial;
    width: 15px;
    height: 15px;
    border: 1px solid #9C9A9A;
    position: relative;
}
.notok:checked:after {
    /* Heres your symbol replacement */
    content: "X";
    color: red;
    /* The following positions my tick in the center, 
     * but you could just overlay the entire box
     * with a full after element with a background if you want to */
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
}
.ok:checked:after {
    /* Heres your symbol replacement */
    content: "\2713";
    color: green;
    /* The following positions my tick in the center, 
     * but you could just overlay the entire box
     * with a full after element with a background if you want to */
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
}
.doesnotexist:checked:after {
    /* Heres your symbol replacement ∄ */
    content: "–";
    color: green;
    /* The following positions my tick in the center, 
     * but you could just overlay the entire box
     * with a full after element with a background if you want to */
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
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
        <li class="breadcrumb-item"><a href="inspectionmanager.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>"><i class="fa fa-arrow-circle-o-left" style="font-size:36px;color:#87CEEB"></i></a></li>            
      </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="border: 2px solid  #fff; text-align: right;">
              <button class='btn btn-danger btn-sm deletebtn' type='button' name='deleteinsp' data-bs-toggle="modal" data-bs-target="#deleteinsp" name='deleteinsp'><i class='bi bi-trash'></i>Delete Inspection</button><br><br>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="card">
            <div class="card-header">             
                  <h5  class="text-white">Inspection Information</h5>                     
            </div>                            
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
                          <p style ="color:#012970;">Next Inspection Date:<?php echo "[".date("d M, Y",strtotime($row['nxt_inspection_date']."-2 days"))."<i class='bi bi-dash'></i>".date("d M, Y",strtotime($row['nxt_inspection_date']))."]";?></p>
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
      <form class="form-horizontal" action="edit.php?asset=<?php echo $cata;?>" method='post'>
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="border: 2px solid  #fff; text-align: right;">     
              <button name='updateckinsp' type='submit' class='btn btn-info btn-sm'><i class='fa fa-save'></i>Save Changes</button>
      </div>
    </div>
        <div class="col-lg-12">
            <div class="card">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">              
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" onclick="document.getElementById('exterior').classList.add('d-none');document.getElementById('interior').classList.remove('d-none')" role="tab" aria-controls="pills-profile" aria-selected="true">Internal Items</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"  onclick="document.getElementById('interior').classList.add('d-none');document.getElementById('exterior').classList.remove('d-none')" role="tab" aria-controls="pills-contact" aria-selected="false">External Items</button>
                </li>
              </ul> 
              <div class='tab-content pt-2' id='myTabContent'>
              <div class='tab-pane fade show active' id='pills-profile' role='tabpanel' aria-labelledby='profile-tab'>               
              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr> 
                  <th scope="col">#</th>               
                    <th scope="col" class="col-6">Item name</th>
                    <th scope="col" class="col-2">OK</th> 
                    <th scope="col" class="col-2">Needs Attention</th>
                    <th scope="col" class="col-2">N/A</th>              
                  </tr>
                </thead>
                <tbody>
                  <tr>                 
                <?php                 
              $sql = "SELECT * FROM inspection WHERE inspection_date = '$date' and plateno = '$pnn'" ;
                 
              $result = $conn->query($sql);
              $count=1;
               if ($result->num_rows > 0) {
         
                 while($row = $result->fetch_assoc()){
                   $_SESSION['inspid'] = $row['id']; 
                   $arrok=explode(',',$row['int_okay']); 
                   $arrnok=explode(',',$row['int_notokay']);
                   $arrna=explode(',',$row['int_not_available']); 
                   
                   $sql = "SELECT * FROM checklist_item WHERE type='interior'";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {                             
                   while($ro = $result->fetch_assoc()) {?>                                                                 
                <tr>
                <td><?php echo $count ?></td>
                <td><?php echo $ro['item_name']?></td>             
                <td><input class="ok" type="radio" name= <?php echo '"'.str_replace(' ','_',$ro['item_name']). '"'?> value="yes" <?php if(in_array($ro["item_name"].' ',$arrok) || in_array(' '.$ro["item_name"].' ',$arrok)){?> checked <?php }?>></td>                
              <td><input class="notok" type = "radio" name= <?php echo '"'.str_replace(' ','_',$ro['item_name']). '"'?> value="no" <?php  if(in_array($ro["item_name"].' ',$arrnok) || in_array(' '.$ro["item_name"].' ',$arrnok)){?> checked <?php }?>></td>              
             <td><input class="doesnotexist" type = "radio" name= <?php echo '"'.str_replace(' ','_',$ro['item_name']). '"'?> value="does not exist" <?php if(in_array($ro["item_name"].' ',$arrna) || in_array(' '.$ro["item_name"].' ',$arrna)){?> checked <?php }?>></td></tr>
                  <?php 
                  $count++;            
                  }  
                } 
            }                                   
                } else { echo "0 results"; }
               
              ?>                 
                </tbody>
              </table>        
            </div>                     
        <div class='tab-pane fade' id='pills-contact' role='tabpanel' aria-labelledby='contact-tab'>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>                
                    <th scope="col" class="col-6">Item name</th>
                    <th scope="col" class="col-2">OK</th> 
                    <th scope="col" class="col-2">Needs Attention</th>
                    <th scope="col" class="col-2">N/A</th>              
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  
                <?php                 

              $sql = "SELECT * FROM inspection WHERE inspection_date = '$date' and plateno = '$pnn'" ;
                 
              $result = $conn->query($sql);
              $count=1;
               if ($result->num_rows > 0) {
         
                 while($row = $result->fetch_assoc()){
                   $_SESSION['inspid'] = $row['id']; 
                   $arrok=explode(',',$row['ex_okay']); 
                   $arrnok=explode(',',$row['ex_notokay']);
                   $arrna=explode(',',$row['ex_not_available']); 
                   
                   $sql = "SELECT * FROM checklist_item WHERE type='exterior'";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {                             
                   while($ro = $result->fetch_assoc()) {?>                                                                 
                <tr><td><?php echo $count ?></td>
                    <td><?php echo $ro['item_name']?></td>             
                <td><input class="ok" type="radio" name= <?php echo '"'.str_replace(' ','_',$ro['item_name']). '"'?> value="yes" <?php if(in_array($ro["item_name"].' ',$arrok) || in_array(' '.$ro["item_name"].' ',$arrok)){?> checked <?php }?>></td>                
              <td><input class="notok" type = "radio" name= <?php echo '"'.str_replace(' ','_',$ro['item_name']). '"'?> value="no" <?php  if(in_array($ro["item_name"].' ',$arrnok) || in_array(' '.$ro["item_name"].' ',$arrnok)){?> checked <?php }?>></td>              
             <td><input class="doesnotexist" type = "radio" name= <?php echo '"'.str_replace(' ','_',$ro['item_name']). '"'?> value="does not exist" <?php if(in_array($ro["item_name"].' ',$arrna) || in_array(' '.$ro["item_name"].' ',$arrna)){?> checked <?php }?>></td></tr>
                  <?php  
                  $count++;           
                  }  
                } 
            }                                   
                } else { echo "0 results"; }
               
              ?> 
                                      
                
                </tbody>
              </table>
            
            </div>
          </div>
        </div>
            </div>
              </div>
            <div class="" id="interior">
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
          <td><h6 style ="color:#012970;"><?php echo $row['image'] ?></h6></td>
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
<div class="d-none" id="exterior">
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
        $id =  $_GET['id'];        
          $test = "SELECT * from ext_inspection where exinsp_id = '$id'";
           $result = mysqli_query($conn,$test);           
           if ($result->num_rows > 0) {
               $count = 1;
            while($row = $result->fetch_assoc()){      
                  ?>   
        <tr>
          <th scope="row"><?php echo $count?></th>        
          <td><h6 style ="color:#012970;"><?php echo $row['image'] ?></h6></td>
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

<div class="modal fade" id="deleteinsp" data-bs-backdrop='static'>
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
      <span class="modal-title" id="myModalLabel">Confirm Delete</span>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="edit.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&id=<?php echo $iid;?>" method="POST">
                    <div class="modal-body">
                    <div class="form-group"> 
                    <input type="hidden" name="delete_id" value="<?php echo $iid ?>" id="update_id">
                    <span>Are you sure you want to delete this inspection data?</span>                    
                     </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type = 'hidden' name = 'delete_id' value ="<?php echo  $iid ?>" > 
                      <a href="controller.php?asset=<?php echo $cata;?>&pn=<?php echo $pnn;?>&date=<?php echo $date;?>&id=<?php echo $iid;?>"><button type="submit" class="btn btn-danger" name="deleteinsp">Delete</button></a>
                      </form>
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