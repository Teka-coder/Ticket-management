<?php 
session_start();

error_reporting(E_ALL);       // Report all errors
ini_set('display_errors', 0); // Display errors

if (!isset($_SESSION['username']) && !isset($_SESSION['role'])) {

    include("connection.php");

    $err = ""; // Error message initialization
    if (isset($_POST['login'])) { 
        // Sanitize user inputs
        $username = htmlspecialchars(trim($_POST['username']));
        $password = $_POST['password']; // Password will be hashed later
        
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM account WHERE username = ?");
        $stmt->bind_param("s", $username); // "s" denotes string type for username
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            // Fetch the user data
            $row = $result->fetch_assoc();
            $stored_password = $row['password']; // The hashed password stored in the DB
            $rol = $row['role'];
            $branch = $row['branch'];
            $status = $row['status'];

            // Verify the password
            if (password_verify($password, $stored_password)) { 
                // Correct password, start session and set session variables
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $rol;
                $_SESSION["branch"] = $branch; 
                
                // Redirect based on user role
                if ($_SESSION["role"] == "admin") {
                    if ($status == 1) {
                        header("Location: admin/index.php");
                    } else {
                        unset($_SESSION['username']);
                        unset($_SESSION['role']);
                        echo '<script>alert("Sorry, Your account has been deactivated!");</script>';
                    }
                } elseif ($_SESSION["role"] == "edit") { 
                    if ($status == 1) {
                        header("Location: tickets/index.php");
                    } else {
                        unset($_SESSION['username']);
                        unset($_SESSION['role']);
                        echo '<script>alert("Sorry, Your account has been deactivated!");</script>';
                    }
                }
            } else {
                // Incorrect password
                $err = "<i style='color:red;'>Wrong Username or Password!</i>";
            }
        } else {
            // No user found with the provided username
            $err = "<i style='color:red;'>Wrong Username or Password!</i>";
        }

        $stmt->close();
    }

    ?>
    <html>
    <!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Log in | TVS - Ticket Verification System</title>
        <link rel="icon" href="image/gbglogo.png">
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>

    <body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <div class="container" data-aos="fade-down" data-aos-easing="linear">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">TVS | Ticket Verification System</p>
                                    </div>             

                                    <form action="index.php" method="POST" class="row g-3 needs-validation" novalidate>
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
                                            <?php echo $err; ?>
                                        </div>

                                        <br><div class="col-12">
                                            <button class="btn btn-warning w-100 rounded-pill" type="submit" name="login">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <a href="https://btsc-cfs.com" class="btn btn-info text-white w-100 rounded-pill"><i class="bi bi-arrow-left"></i>Home</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main> 

    <?php include('footer.html'); ?> 

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
<?php
} else if ($_SESSION["role"] == "admin") {
    header("Location: admin/index.php");
} elseif ($_SESSION["role"] == "edit") {
    header("Location: tickets/index.php");
}
?>
