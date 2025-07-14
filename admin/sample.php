<?php 
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
  <link href="../image/Hagbeslogo.jpg" rel="icon">
  <link href="../image/Hagbeslogo.jpg" rel="touch-icon">

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
  border: 1px solid black; 
}

  </style>

</head>

<body>

 <?php include('../headersidebar.html');?>

  <main id="main" class="main">

     <div class="pagetitle text-center">
      <h1>Maintenance Schedule Control Sheet</h1>
    
    </div><!-- End Page Title -->


  <section class="section">
      <div class="row">
        <div class="col-lg-12">

          

              <!-- Default Table -->
                <div class="card">
                	<div class="card-header">  <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                 <i class="bi bi-plus">create rule</i>
              </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                 <i class="bi bi-plus">Generate workorder</i>
              </button>
               
                </li>
              </ul></div>
            <div class="card-body">
             
            
              <!-- Bordered Table -->
              <br><table class="table" border='1px'>
               
                <tbody >
                  <tr  border='1px'>
                  <th rowspan="3" style="text-align:center"  class="col-2" >Description</th>
                   <th rowspan="3" style="text-align:center" class="col-2" >Inspect/Replace Interval</th>
              <th style="text-align:center" class="col-6" colspan="12">service interval</th>      
                  </tr>
                   <?php                  
                    $sql ="SELECT * from rule where";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      
                    while($row = $result->fetch_assoc()) {
                      echo'

                  <tr>
                    <th colspan="2">'.$row['every_interval'].'</th>
                    <th colspan="2">10000</th>
                    <th colspan="2">15000</th>
                    <th colspan="2">20000</th>
                    <th colspan="2">25000</th>
                    <th colspan="2">30000</th>
                  </tr>';
                       }
              }
            }
               ?>
                  <tr>
                    <td colspan="2"> <input type="checkbox" class="form-check-input" value="5000"></td>              
                    <td colspan="2"> <input type="checkbox" class="form-check-input" value="10000"></td>
                    <td colspan="2"> <input type="checkbox" class="form-check-input" value="15000"></td>
                    <td colspan="2"> <input type="checkbox" class="form-check-input" value="20000"></td>
                    <td colspan="2"> <input type="checkbox" class="form-check-input" value="25000"></td>
                    <td colspan="2"> <input type="checkbox" class="form-check-input" value="30000"> </td>
                  </tr>
                  <tr>
                  <th colspan="14" style="text-align:center;background-color:#FF6347;">engine</th>
                  </tr>
                  <?php                  
                    $sql ="SELECT * from checked_item where `type`='engine'";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      
                    while($row = $result->fetch_assoc()) {
                      echo'
                  <tr>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['every_interval'].'</td>
                    <td><select id="inputState" class="form-select">
                    <option selected>R</option>
                    <option>C</option>
                  </select>
                </div></span></td>
                    <td><input type="checkbox" class="form-check-input" value="R"></td>
                    <td><span style="align:center">&#82;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#82;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#82;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#82;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#82;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                  </tr>';
                }
              }
            }
               ?>
                <tr>
                  <th colspan="14" style="text-align:center;background-color:#00BFFF;">air</th>
                  </tr>
                  <?php                  
                    $sql ="SELECT * from checked_item where `type`='air'";

                    $result = $conn->query($sql);
                    if ($result = $conn->query($sql)) {
                      
                    if ($result->num_rows > 0) {
                      
                    while($row = $result->fetch_assoc()) {
                      echo'
                  <tr>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['every_interval'].'</td>
                    <td><span style="align:center">&#67;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#67;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#67;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#67;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#67;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                    <td><span style="align:center">&#82;</span></td>
                    <td><input type="checkbox" class="form-check-input" value=""></td>
                  </tr>';
                }
              }
            }
               ?>
                <tr>
                  <th colspan="14" style="text-align:center;background-color:#FFA500;">transaxle</th>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                  </tr>
               <tr>
                  <th colspan="14" style="text-align:center;background-color:#A9A9A9;">wheels</th>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                  </tr>
                </tbody>
              </table>
              <!-- End Bordered Table -->
<div class="text-center">                
  <button class='btn btn-primary' name='submit'  type='submit'>Submit</button>
</div>


                    
</div>
</div>










 </main><!-- End #main -->

  
<?php include('../footer.html');?>

  


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