<?php 
session_start();
if($_SESSION['role']=="pad"){
  if(isset($_GET['asset']))
    $cata = $_GET['asset'];
  else
    $cata = $_SESSION['cata'];
  if(isset($_GET['pn']))
    $ppn=$_GET['pn']; 
  else if(isset($_GET['asset2'])){  
    $cata = $_GET['asset2'];
    $ppn=$_GET['pn2']; 
  } 
  else
    $ppn=$_SESSION["inspect"];

include ("recoredserver.php");
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AIS | Asset Inspection System</title>
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
  .card-header{
    background-color: #87CEEB !important;
  }
  h4{
    color:white;
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
</head>

<body>

 <?php include('../headersidebar.php');?>
 <?php include('sidebar.php');?>
 <main id="main" class="main">

    <div class="pagetitle text-center">
      <h1>Vehicle Inspection Form</h1>
      <nav>      
    </div>
    <div class="col-lg-12 noPrint">
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
            
    if(isset($_SESSION["added"])) echo "<script>alert('".$_SESSION["inspect"]."')</script>";
        //  $plateno=$_SESSION["inspect"];
    else
    $plateno=$ppn;
          $sql ="SELECT * from vehicle  where plateno = '$plateno' ";
                    $result = $conn1->query($sql);
                    if ($result = $conn1->query($sql)) {                     
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                     // $iid=$row['id'];   
          $date = date('Y-m-d');
          if($row['type']='managerial'){
          $query5 = "SELECT MAX(odometer_reading) as odo,serviced_at_odo from inspection WHERE  plateno = '$plateno' AND inspection_date=(SELECT MAX(inspection_date))";
          $res5 = $conn->query($query5) or die(mysqli_error($conn)); }
          elseif($row['type']='work'){
            $query5 = "SELECT MAX(datee) as maxdate,MAX(kmatend) as wodoo from actualreport where platenumber = '$plateno'";
            $res5 = $conn1->query($query5) or die(mysqli_error($conn1)); 
          }                       
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
            <span style ="color:#012970;">Type:&nbsp'.$row['type'].'</span><br>';
           
            if($row1 = $res5->fetch_assoc()) {
            if ($row1["odo"]!="") {
            echo'<span style ="color:#012970;">Previous Millage:&nbsp'.$row1["odo"] .'</span>';
          }
          if(isset($_SESSION['newinsp'])){
          $minn=0;
          $smin=0;       
          if($row['type']=='managerial')
          $smax=0;
          else{
          $test = "SELECT MAX(kmatend) as kmp from actualreport where platenumber = '$ppn'";
          $re = $conn1->query($test) or die(mysqli_error($conn1));
          if($ro = $re->fetch_assoc()) {
            $smax = $ro['kmp'];
          
          }
        }}
          else{
          $minn=$row1["odo"];
          $smin=$row1["serviced_at_odo"];
         //$smax=$row1["odo"];}}
        echo'</div>';
        }
        }
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
          <div>
            <form action ="insp_form.php?asset=<?php echo $cata ?>&pn=<?php echo $ppn;?>&date=<?php echo (isset($_SESSION['date']))? $_SESSION['date']:'';?>" method = "POST" onsubmit="validate();"> 
             <section class="section">
               <div class="row">
             <div class="col-lg-6 noPrint">
            <div class="card">
            <div class="card-header"> 
            <span class="text-white">Current Odometer Reading</span>                    
               </div>
            <div class="card-body">
            <div class ="<?php echo (isset($_SESSION['added']))? 'd-none':''; ?>">
            <label class="col-sm-2 col-form-label" ></label>
            <div class="">
                <small class='error_odometer' style='color:red;'></small>
              <input type="number"  style="width:100%;" class="form-control" value="<?php echo (isset($_SESSION['added']))? $_SESSION['odo']:'' ?>" name="odometer" id="inputText" required min="<?php echo $minn;?>">
            </div>
          </div>
                  </div>
                  </div>
                  </div>
                  <div class="col-lg-6 noPrint">
            <div class="card">
            <div class="card-header"> 
            <span class="text-white">Last Serviced Odometer Reading</span>                    
               </div>
            <div class="card-body">
            <div class ="<?php echo (isset($_SESSION['added']))? 'd-none':''; ?>">
            <label class="col-sm-2 col-form-label" ></label>
            <div class="">
                <small class='error_odometer' style='color:red;'></small>
              <input type="number"  style="width:100%;" class="form-control" value="<?php echo (isset($_SESSION['added']))? $_SESSION['odo']:'' ?>" name="serviced" id="inputText" required min="<?php echo $smin;?>">
            </div>
          </div>
                  </div>
                  </div>
    </div>
    </div>

      <div class="row">
        <div class="col-lg-12">
              <div class="card">
                 <div class="card-header"><span class="text-white">Interior Item</span></div>
            <div class="card-body">
         
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
                $sql = "SELECT * FROM checklist_item WHERE type='interior'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
            
                  $count=1;              
                while($row = $result->fetch_assoc()) {

                echo  
                '<tr><td>'. $count. '</td><td>'      
                . $row["item_name"].'</td><td>
                <input class="ok" type="radio" name= "'.str_replace(' ','_',$row['item_name']). '" value="yes" required></td><td>
               
                <input class="notok" type = "radio" name= "'.str_replace(' ','_',$row['item_name']).'" value="no" required></td><td>
                <input class="doesnotexist" type = "radio" name= "'.str_replace(' ','_',$row['item_name']).'" value="does not exist" required></td>
                ';  
                $count++;           
                  }
                 
                
                } else { echo "0 results"; }
               
              ?> 
                                      
                
                </tbody>
              </table>
            
            </div>
          </div>
        </div>

             
  <div class="col-lg-12">

     <div class="card">
                 <div class="card-header"> <span class="text-white">Exterior Items</span></div>
            <div class="card-body">
              <!-- Table with stripped rows -->
              <table class="table Borderedtable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="col-6">Item name</th>
                    <th scope="col"  class="col-2">Ok</th>
                    <th scope="col"  class="col-2">Needs Attention</th>
                    <th scope="col" class="col-2">N/A</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    
                           <?php
                    $query = "SELECT * FROM checklist_item WHERE type = 'exterior'";
                    $resu = $conn->query($query);
                    if ($resu->num_rows > 0) {
                    $count=1; 
                    while($ro = $resu->fetch_assoc()) {
                    echo  
                    '<tr><td>'.$count. '</td><td>'
                    . $ro["item_name"].'</td><td>

                    <input class="ok" type = "radio" name= "'.$ro['item_name'].'"  value="yes" required></td><td>
                   
                    <input class="notok" type = "radio" name = "'.$ro['item_name'].'"  value="no" required></td><td>
                    <input class="doesnotexist" type = "radio" name= "'.$ro['item_name'].'" value="does not exist" required></td>';                 
                        $count++; 
                      }
                    
                    } else { echo "0 results"; }
                   
                  ?> 

                  </tr>
              
                </tbody>
              </table>
             </div> 
        </div>
      </div>
    </div>
             
 
          <br><div>
      <textarea class="control noPrint" name="note" placeholder="write general information about the vehicle" id="floatingTextarea" style="width:100%;"></textarea>
    </div><br>
                       
<div class="text-center noPrint">             
 <button class='btn btn-success align-items-center justify-content-center' name='submit'  style="width:50%;"  type='submit'>Next<i class="bi bi-arrow-right"></i></button>
</div>
   
      </div>   
      </section>         
 </form> 
    
  </main>

  <?php include('../footer.html');
     if(isset($_SESSION['added'])){
        unset($_SESSION['added']);
        unset($_SESSION['odo']);
     }
     if(isset($_SESSION['selected'])){
      unset($_SESSION['selected']);
      unset($_SESSION['']);    
   }
    if(isset($_SESSION['newinsp'])){
      unset($_SESSION['newinsp']);
    } 

  ?>
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

     $('.check_odometer').keyup(function(e){

   var odo = $('.check_odometer').val();
        $.ajax({
       type: "POST",
       url: "recoredserver.php",
       data: {
           "check_btn":1,
           "odometer_id": odo
       },
          success: function(response){
            alert(hello);
            $('.error_odometer').text(response);

          }
     });
         
  });

});

</script>
</body>
</html>
<?php }else{
  header("location:../index.php");
}