<?php 
session_start();
if($_SESSION['role']=="admin"){
include ("recoredserver.php");
$cata = $_SESSION['cata'] ;;
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title> AIS | Asset Inspection System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../image/Hagbeslogo.jpg" rel="icon">
  <link href="../image/Hagbeslogo.jpg" rel="touch-icon">


  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  
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

</head>

<body>

<?php include('headersidebar.php');?>
<?php include('sidebar.php');?>
  <main id="main" class="main">
  <div class="card">
            <div class="card-body">
              <h5 class="card-title">Manage Account</h5>

              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Account</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Create Account</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
<div class="col-md-8">
<form action ="controller.php" method = "POST">
    <?php if(isset($_SESSION['status']))
           echo  $_SESSION['status']    ?>
<table class="table">
<thead>
 <tr>
   <th scope="col">#</th>
   <th scope="col">User name</th>
   <th scope="col">Role</th>
   <th scope="col">Company</th>
   <th scope="col">Activation</th>
   <th scope="col">Edit</th>
 </tr>
</thead>
<?php
   //$km = $_SESSION['$servicekm']; 
  $sql ="SELECT * from account";
   
   $result = $conn->query($sql);
   if ($result = $conn->query($sql)) {
     
   if ($result->num_rows > 0) {
     $cou=1;  
   while($row = $result->fetch_assoc()) {  
    // $_SESSION['id'] =  $row['id'];                                                                        
   echo          
  "<tr><td  style ='color:#012970;'>".$cou. "</td><td style ='color:#012970;'>"

    . $row["username"] ."</td><td style ='color:#012970;'>"
   . $row["role"] . "</td>
   <td style ='color:#012970;'>"

    . $row["company"] ."</td>
   <td><div class='form-check form-switch align-item-center'><input class='form-check-input' type='checkbox' id='flexSwitchCheckChecked'></div></td>
   <td style ='color:#012970;'><button class='btn btn-info btn-sm editbtn' type='button' name='edit'><i class='fa fa-edit ' style='color:white'>Edit</i></button></tr>";
   $cou++;
  }
  // <td  style ='color:#012970;'><button class='btn btn-danger btn-sm deletebtn' type='button' name='delete'><i class='bi bi-trash'></i></button></td> 
 }
   else { echo "0 results"; }
  }
  
 ?>                     
</table>
</form>
  </div>
</div>


  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">              
  <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['status']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>
                            <a href="javascript:void(0)" class="add-more-form float-end btn btn-primary btn-sm">ADD MORE</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <form action="controller.php" method="POST">
                      
                            <div class="main-form mt-3 border-bottom">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="">User Name</label>
                                            <input type="text" name="name[]" class="form-control" required placeholder="Enter Name">
                                        </div>
                                    </div>                                
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="">Password</label>
                                            <input type="password" name="pass[]" class="form-control" required placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="">Role</label>                                        
                                            <select class="form-select" name="role[]" id="floatingSelect" aria-label="Floating label select example" value="Vehicle" required>
                                            <option value="">Select Role</option>                                                                                         
                                            <?php       
                                            $query ="SELECT * FROM `role`";
                                              $result = $conn->query($query);                                                                                          
                                              if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {                                                
                                              echo '
                                                  <option value="'.$row['role_type'].'">'.$row['role_type'].'</option>';
                                                 
                                                 }
                                                }       
                                                ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="">Company</label>
                                            <select class="form-select" name="role[]" id="floatingSelect" aria-label="Floating label select example" value="Vehicle" required>
                                            <option value="">Select Company</option>                                                                                         
                                            <?php       
                                            $query ="SELECT * FROM `comp`";
                                              $res = $conn1->query($query);                                                                                          
                                              if($res->num_rows > 0) {
                                                while($ro = $res->fetch_assoc()) {                                                
                                              echo '
                                                  <option value="'.$ro['Name'].'">'.$ro['Name'].'</option>';
                                                 
                                                 }
                                                }       
                                                ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="paste-new-forms"></div>

                            <button type="submit" name="save_multiple_data" class="btn btn-primary btn-sm">Register</button>
                           
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
                  </div>
                  </div>
                  </div>
                  </div>
    <!-- EDIT  -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="controller.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> User Name </label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Enter Name">
                        </div>

                        <div class="form-group">
                            <label> Role </label>
                            <input type="text" name="role" id="role" class="form-control"
                                placeholder="Enter Role">
                        </div>

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Edit Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>  
    <!-- delete -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"> Delete Data </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="controller.php" method="POST">

                    <div class="modal-body">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <h5> Do you want to Delete this Data ??</h5>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" name="deletedata" class="btn btn-primary"> Yes! Delete it. </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
                       
                    </div>
                </form>

            </div>
        </div>
                </div>
    </main>
  <?php include('../footer.html');?>
  <!--Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>


  <script>
        $(document).ready(function () {

            $(document).on('click', '.remove-btn', function () {
                $(this).closest('.main-form').remove();
            });
            
            $(document).on('click', '.add-more-form', function () {
                $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
                                <div class="row">\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <label for="">User Name</label>\
                                            <input type="text" name="name[]" class="form-control" required placeholder="Enter Name">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <label for="">password</label>\
                                            <input type="password" name="pass[]" class="form-control" required placeholder="Enter Phone password">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <label for="">Role</label>\
                                            <select class="form-select" name="role[]" id="floatingSelect" aria-label="Floating label select example" value="Vehicle">\
                                              <option value="">Select Role</option>\
                                            </select>\
                                        </div>\
                                    </div>\
                                    <div class=""col-md-4"\
                                        <div class="form-group mb-2">\
                                            <label for="">Company</label>\
                                            <select name="company[]" class="form-select" id="floatingSelect" aria-label="Floating label select example" value="Vehicle">\
                                             <option value="">Select Company</option>\
                                            </select>\
                                        </div>\
                                    </div>\
                                             <br>\
                                             <button type="button" class="remove-btn btn btn-danger btn-sm">Remove</button>\
                                </div>\
                                </div>');                               
            });

            <select class="form-select" name="role[]" id="floatingSelect" aria-label="Floating label select example" value="Vehicle" required>
                                            <option value="">Select Role</option>                                                                                         
                                            <?php       
                                            $query ="SELECT * FROM `role`";
                                              $result = $conn->query($query);                                                                                          
                                              if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {                                                
                                              echo '
                                                  <option value="'.$row['role_type'].'">'.$row['role_type'].'</option>';
                                                 
                                                 }
                                                }       
                                                ?>
                                        </select>
          
                                    

        });
    </script>
     <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#name').val(data[1]);
                $('#role').val(data[2]);
               
            });
        });
    </script>
     <script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#deletemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[1]);

            });
        });
    </script>
</body>

</html>
<?php }else{
  header("location:../index.php");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////login
<?php 
session_start();
if(!isset($_SESSION['username'])){
  include("connection.php");
?>
<html>
<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Log in | AIS - Asset Inspection System</title>
  <link rel="icon" href="image/Hagbeslogo.jpg">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

   <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
		<link href="assets/aos.css" rel="stylesheet">
		<script src="assets/aos.js"></script>

  
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<?php 
$err="";
if(isset($_POST['login'])) { 
  $username=$_POST['username'];
  $password=md5($_POST['password']);

  $test="SELECT * FROM account WHERE username='$username' and password='$password'";
  $re=mysqli_query($conn,$test) or die(mysqli_error($conn));

if(mysqli_num_rows($re)==1){

              while($row=mysqli_fetch_array($re)){  
                $username=$row['username'];
                $password=$row['password'];
                $rol=$row['role'];
                $company=$row['company'];
                $status=$row['status'];

                
              
              $_SESSION["username"] =$username;
              $_SESSION["password"] = $password;
              $_SESSION["role"] = $rol; 
              $_SESSION["company"] = $company;
              $_SESSION["status"] = $status;

                          
              if($_SESSION["role"]=="admin")
                header("location:admin/asset.php");
              else if($_SESSION["role"]=="pad"){
                if($_SESSION["status"] == 1)
                header("location:pad/asset.php");
                else{
                echo'<script>alert("Sorry, Your account has been deactivated");</script>';
                unset($_SESSION["status"]);
              }
              }
              else if($_SESSION["role"]=="hq"){
                if( $_SESSION["status"] == 1)
                header("location:hq/asset.php");
                else{
                echo'<script>alert("Sorry, Your account has been deactivated");</script>';
                unset( $_SESSION["status"]);
                }
              }
              }
}
else{ $err="<i style='color:red;'>Wrong Username or Password!</i>"; 
    }
}

    ?>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container" data-aos="fade-down" data-aos-easing="linear">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

             <div class="card mb-3" >
                <div class="card-body ">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">AIS | Asset Inspection System</p>
                  </div>

              

                 <form action ="index.php" method = "POST"  class="row g-3 needs-validation" novalidate>

                    <div class="col-12">                     
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required autofocus>
                         <div class="invalid-feedback">Please, enter your username!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key"></i></span>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                       <div class="invalid-feedback">Please, enter your password!</div>                   
                    </div>
                    <?php echo $err;?>
                    </div>

                   
                   <br><div class="col-12">
                     <button class="btn btn-primary w-100 rounded-pill" type="submit" name = "login">Login</button>
                    </div>
                    <div class="col-12">
                      <a href="http://portal.hagbes.com" class="btn btn-info text-white w-100 rounded-pill"><i class="bi bi-arrow-left"></i>Portal home</a>
                    </div>

                     <div class="col-12">
                     <!-- <button class="btn btn-primary w-100" type="submit">forgot password?</button>-->
                    </div>

                   <!-- <div class="col-12">
                      <button class="btn btn-primary w-100" text-align="center" type="submit">Home</button>
                    </div>-->
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>
      <?php include('footer.html');?>

    </div>
  </main>  
   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
<script>
  AOS.init({
  duration: 1500,
});
</script>
</html>
<?php }else if($_SESSION["role"]=="admin")
                header("location:admin/asset.php");
              else if($_SESSION["role"]=="pad")
                header("location:pad/asset.php");
            else if($_SESSION["role"]=="hq")
                header("location:hq/asset.php");