<?php
session_start(); // Always call session_start() at the very beginning

error_reporting(E_ALL);       // Report all errors
ini_set('display_errors', 0); // Display errors

// Check if the session variables are set and not empty before using them
if (isset($_SESSION['role']) && $_SESSION['role'] == "edit" && isset($_SESSION['username']) && $_SESSION['username'] != '') {
    include ("../recoredserver.php");
    include "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TVS | Ticket Verification System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="../image/gbglogo.png" rel="touch-icon">
    <?php include('css.php'); ?>
</head>

<body>
    <?php include('../headersidebar.php'); ?>
    <?php include('side.php'); ?>

    <main id="main" class="main">
        <div class="card">
            <div class="row">
                <div class="pagetitle">
                    <br>
                    <h1 class="decorated"><span>Ticket Registration<span></h1>
                    <?php if (isset($_SESSION["completed"])) { 
                        $ses = $_SESSION['completed'];
                    ?>
                        <script type="text/javascript">
                            alert('<?php echo $ses; ?>');
                            window.location="index.php";
                        </script>
                    <?php } elseif (isset($_SESSION["notposted"])) {
                        $ses = $_SESSION["notposted"];
                    ?>
                        <script type="text/javascript">
                            alert('<?php echo $ses; ?>');
                            window.location="index.php";
                        </script>
                    <?php }
                    unset($_SESSION['completed']);
                    unset($_SESSION['notposted']);
                    ?>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 mt-3" style="padding-bottom: 15px;">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssetForm" type="button">Add New Ticket</button>
        </div>

        <?php 
        $sql = "SELECT * FROM tickets ORDER BY date_inserted DESC LIMIT 16;";
        $cmd = $conn->prepare($sql);
        $cmd->execute();
        $result = $cmd->get_result();
        ?>
        
        <div class="modal fade" id="addAssetForm" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ticket Registration Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body" id='cardBody'>
                                        <?php include('add-items-form-view.php');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class='row' data-aos="zoom-in">
                <?php 
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $qr_code_image = $row["QR_plain"];
                        $name = $row["customer_name"];
                        $status = $row["soldout_status"];
                ?>
                        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="card text-center p-2">
                                <div class="card-header">
                                    <?php
                                    if ($row["soldout_status"] == 'instock') {
                                        echo '<span class="badge bg-success">'.$row["soldout_status"].'</span>';
                                    } elseif ($row["soldout_status"] == 'notset') {
                                        echo '<span class="badge bg-warning">'.$row["soldout_status"].'</span>';
                                    } elseif ($row["soldout_status"] == 'soldout') {
                                        echo '<span class="badge bg-danger">'.$row["soldout_status"].'</span>';
                                    } else {
                                        echo '<span class="badge bg-primary">'.$row["soldout_status"].'</span>';
                                    }
                                    ?>
                                    <span class="badge border-info border-1 text-info"><?php echo date("M d, Y",strtotime($row["date_inserted"]));?></span>
                                    <span class="badge border-secondary border-1 text-secondary"><?php echo ucfirst($row["checkin_status"])?></span>
                                    <span class="badge border-light border-1 text-black-50"><?php echo $row["ticket_unique_id"]?></span>
                                </div>
                                <img src='<?php echo '../QR_code/'.$qr_code_image?>' class="card-img-top" alt="<?php echo ucfirst($row["QR_plain"]);?>" width="100%">
                                <div class="card-body">
                                    <h5 class="card-title"> <?php echo ucfirst($row["customer_name"]);?></h5>
                                    <a class="btn btn-primary" href='<?php echo "update-items-form-view.php?update_item=".$row["id"];?>'>Sell Out</a>
                                </div>
                            </div>
                        </div>
                <?php 
                    }
                } else { 
                ?>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <h3>No items found</h3>
                    </div>
                <?php 
                }
                ?>
            </div>
        </section>
    </main>

    <?php include('../footer.html'); ?>

    <!-- Vendor JS Files -->
    <?php include('script.php'); ?>

</body>

</html>

<?php
} else {
    header("location:../logout.php");
    exit(); // Make sure to call exit after redirecting
}
?>
