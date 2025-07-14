<?php 
session_start();
if($_SESSION['role']=="admin"){
//include ("recoredserver.php");
include ("controller.php");
$_SESSION['cata'] = $_GET['asset'];
$cata = $_SESSION['cata'];
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title> TVS | Ticket Verification System </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../image/gbglogo.png" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">


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
  <div class="pagetitle text-center" >
      <h1>Ticket Verification System</h1>
      <nav>
    </div><!-- End Page Title -->
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
<div class="col-md-12">
<form action ="controller.php?asset=<?php echo $cata ?>" method = "POST">
    <?php if(isset($_SESSION['status']))
           echo  $_SESSION['status']    ?>
<table class="table  datatable">
<thead>
 <tr>
   <th scope="col">#</th>
   <th scope="col">User name</th>
   <th scope="col">Role</th>
   <th scope="col">Branch</th>
   <th scope="col">Activation</th>
   <th scope="col">Operations</th>
 </tr>
</thead>
<?php   
  $sql ="SELECT * from account";
   
   $result = $conn->query($sql);
   if ($result = $conn->query($sql)) {
     
   if ($result->num_rows > 0) {
     $cou=1;  
   while($row = $result->fetch_assoc()) {  ?>
                                                                               
  <tr><td style ='color:#012970;'><?php echo $cou ?></td>
  <td style ='color:#012970;'><?php echo $row["username"] ?></td>
  <td style ='color:#012970;'><?php echo $row["role"] ?></td>
  <td style ='color:#012970;'><?php echo $row["company"] ?></td>
   <?php if($row['status'] == 1){?>
  <td><div class='form-check form-switch align-item-center'><input  data-bs-toggle="modal" data-bs-target="#dstatus" value ="1" class='form-check-input' type='checkbox' checked disabled>Activated</div></td>
   <?php }else {?>
  <td><div class='form-check form-switch align-item-center'><input  data-bs-toggle="modal" data-bs-target="#astatus" value ="0" class='form-check-input' type='checkbox' disabled>Deactivated</div></td>
  <?php  
  }
  ?>
   <td style ='color:#012970;'><button class='btn btn-info btn-sm editbtn' type='button' name='edit'><i class='fa fa-edit ' style='color:white'>Edit</i></button>
  <button class='btn btn-info btn-sm resetbtn' type='button' name='reset'><i class='fa fa-reset resetbtn' style='color:white'>Reset Password</i></button></td></tr> 
   <!--<td  style ='color:#012970;'><button class='btn btn-danger btn-sm deletebtn' type='button' name='delete'><i class='bi bi-trash'></i></button></td>-->
 <?php  $cou++; }
 }else { echo "0 results"; }
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
                            <!--<a href="javascript:void(0)" class="add-more-form float-end btn btn-primary btn-sm">ADD MORE</a>-->
                        </h4>
                    </div>
                    <?php  
                   if(isset($_POST['save_multiple_data']))
{
    $name = $_POST['name'];
    $passw = $_POST['pass'];
    $rolee = $_POST['role'];
    $com = $_POST['company'];
    $stat = $_POST['status'];
    if($stat == '')
    $stat = 0;

    $user_query = "SELECT * FROM account WHERE username='$name' ";
    $user_query_run = mysqli_query($conn, $user_query);
    if(mysqli_num_rows($user_query_run) > 0)
    {
        echo "User name Already Taken. Please Try Another one.";       
    }
  else{
    foreach($name as $index => $names)
    {
        $s_name = $names;
        $s_role = $rolee[$index];
        $_passw = md5($passw[$index]);
        $s_com = $com[$index];
        $status = $stat[$index];
        
     
        $query = "INSERT INTO account (username,password,role,company,status) VALUES ('$s_name','$_passw','$s_role','$s_com','$status')";
        $query_run = mysqli_query($conn, $query);
    }
}
  echo $s_name.$s_role.$_passw.$s_com.$status; 

    if($query_run)
    {
       echo "Data Inserted Successfully";
             
    }
    else
    {
       echo "Data Not Inserted";
         
    }
}


                    ?>
                    <div class="card-body">

                        <form action="account.php?asset=<?php echo $cata ?>" method="POST">
                    
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
                                            <select class="form-select" name="company[]" id="floatingSelect" aria-label="Floating label select example" value="Vehicle" required>
                                            <option value="">Select Company</option>                                                                                         
                                            <?php       
                                            $query ="SELECT * FROM `comp`";
                                              $res = $conn->query($query);                                                                                          
                                              if($res->num_rows > 0){
                                                while($ro = $res->fetch_assoc()){                                                
                                              echo '
                                                  <option value="'.$ro['Name'].'">'.$ro['Name'].'</option>';                                                
                                                 }
                                                }       
                                                ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <br><label for="">Activate</label>
                                           <input type='checkbox' name='status' value= 1>
                                        </div>
                                    </div>

                                </div>
                            </div>
                           
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="account.php?asset=<?php echo $cata;?>" method="POST">

                    <div class="modal-body">

                    <!--<input type="hidden" name="update_id" id="update_id">-->

                        <div class="form-group">
                            <label> User Name </label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Enter Name" readonly>
                            </div>

                        <div class="form-group">
                            <label> Role </label>                           
                            <select class="form-select" name="role" id="role" aria-label="Floating label select example">
                            <option id="role"></option>                                                                                                                                
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

                        <div class="form-group">
                            <label> Company </label>
                            <select class="form-select" name="company" id="company" aria-label="Floating label select example">
                            <option id="company"></option>                                                                                                                                      
                                            <?php       
                                            $query ="SELECT * FROM `comp`";
                                              $res = $conn->query($query);                                                                                          
                                              if($res->num_rows > 0){
                                                while($ro = $res->fetch_assoc()){                                                
                                              echo '
                                                  <option value="'.$ro['Name'].'">'.$ro['Name'].'</option>';                                                
                                                 }
                                                }       
                                                ?>
                                        </select>
                        </div>

                         <div class="form-group">
                            <br><label> Status: </label>
                            <input type="Radio" name="stat" value= "1" id="astatus">Activate
                            <input type="Radio" name="stat" value= "0" id="dstatus">Deactivate
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

    <!--Reset Password -->
    
    <div class="modal fade" id="resetp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Reset Password</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                  <form action="account.php?asset=<?php echo $cata;?>" method="POST">                              
                    <div class="modal-body">
                        <h6> Do you want to reset the password for this user?? </h6>

                        <div class="form-group">
                        <label> User Name </label>
                        <input type="text" name="namee" id="namee" class="form-control" readonly>
                        </div>

                    <div class="modal-footer">
                      
                    <button type="submit" name="resetpass" class="btn btn-primary"> Yes! Reset it. </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>                      
                    </div>
                </form>

            </div>
        </div>
                </div> 
    <!------------------->



    <!-- status deactivation -->
    <div class="modal fade" id="dstatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Deactivate An Account</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="controller.php" method="POST">

                    <div class="modal-body">
                        <input type="hidden" name="status_id" id="status_id">
                        <h6> Are you sure you want to Deactivate this Account ??</h6>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" name="deactivateaccount" class="btn btn-primary"> Yes! Deactivate it. </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
                       
                    </div>
                </form>

            </div>
        </div>
                </div>

                 <!-- status activation -->
    <div class="modal fade" id="astatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Activate An Account</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="controller.php" method="POST">

                    <div class="modal-body">
                        <input type="hidden" name="status_id" id="status_id">
                        <h6> Are you sure you want to Activate this Account ??</h6>
                    </div>

                    <div class="modal-footer">
                    <button type="submit" name="activateaccount" class="btn btn-primary"> Yes! Activate it. </button>
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
  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>-->

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
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <label for="">Company</label>\
                                            <select name="company[]" class="form-select" id="floatingSelect" aria-label="Floating label select example" value="Vehicle">\
                                             <option value="">Select Company</option>\
                                            </select>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <br>\
                                            <button type="button" class="remove-btn btn btn-danger btn-sm">Remove</button>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>');
            });
            

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

               //$('#update_id').val(data[0]);
                $('#name').val(data[1]);
                $('#role').val(data[2]);             
                $('#company').val(data[3]);              
               // $('#astatus').val(data[4]);
                //$('#dstatus').val(data[5]);              
            });
        });
    </script>

     <script>
        $(document).ready(function () {
            $('.resetbtn').on('click', function () {
                $('#resetp').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);
                $('#namee').val(data[1]);
                //$('#delete_id').val(data[1]);
                
            });
        });
    </script>
</body>

</html>
<?php }else{
  header("location:../index.php");
}