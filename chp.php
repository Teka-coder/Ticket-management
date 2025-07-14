<?php
$err="";
 $success="";
 $notmatch="";
   if (isset($_POST['password']) && isset($_POST['newpassword'])
   && isset($_POST['renewpassword'])) {
   
   function validate($data){
      $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
   }
   
   $op = validate($_POST['password']);
   $np = validate($_POST['newpassword']);
   $c_np = validate($_POST['renewpassword']);
   
  if($np !== $c_np){
    $notmatch = "<i style='color:red;'>The confirmation password  does not match!</i>";
     //header("Location: changepass.php?error=The confirmation password  does not match");
   }else {
     // hashing the password
     $op = md5($op);
     $np = md5($np);
       $user = $_SESSION['username'];
   
       $sql = "SELECT password
               FROM account WHERE 
               username='$user' AND password='$op'";
       $result = mysqli_query($conn, $sql);
       if(mysqli_num_rows($result) === 1){
         
         $sql_2 = "UPDATE account
                   SET password='$np'
                   WHERE username='$user'";
         mysqli_query($conn, $sql_2);
         $success="<i style='color:green;'>Your password has been changed successfully!</i>";
         //header("Location: changepass.php?success=Your password has been changed successfully");
   
       }else {
        $err="<i style='color:red;'>Wrong Password!</i>";
         //header("Location: changepass.php?error=Incorrect password");
       }
   
   }
   } 
?>
 <div class="col-xl-10 justify-content-center">
          <div class="justify-content-center">
          <div class="card">
          <div class="card-header">
          <span class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</span>             
            </div>
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
                  <!-- Change Password Form -->
                  <form action="changepass.php" method="post">
                    <div class="row mb-3">
                      <label for="usernamee" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="usernamee" type="text" class="form-control" value="<?php echo $_SESSION['username'];?>" id="usernm" readonly>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                      <?php echo $notmatch ?>
   
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                      </div>
                      <?php echo $err;
                        echo $success?>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="change" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>
