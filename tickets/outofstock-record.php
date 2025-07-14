<?php 
session_start();
if($_SESSION['role']=="edit" && isset($_SESSION['username']) && $_SESSION['username']!=''){
include ("../admin/recoredserver.php");

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
  if(isset($_SESSION['branch']))
  $comp = $_SESSION['branch'];
  $sql="SELECT * FROM account WHERE branch=?";
  $command=$conn->prepare($sql);
  $command->bind_param("s",$comp);
  $command->execute();
  $result = $command->get_result();
  if (!is_null($result)) { 
    while($row = $result->fetch_assoc()){
      $img = $row["logo"];
  ?>
  <link href="<?php echo '../image/'.$img?>" rel="icon">
  <link href="../image/gbglogo.png" rel="touch-icon">
<?php 
}
}
?>

 <?php include('css.php');?>

</head>
<body>
  <?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
 <?php include('side.php');?>
 <main id="main" class="main">
 <?php
 $check="select ticket_unique_id from tickets where id=?;";

 $cmd=$conn->prepare($check);
 $cmd->bind_param("s",$_GET["all_type1"]);
 $cmd->execute();
 $res=$cmd->get_result();
 if (isset($_GET['all_type1'])&& $res->num_rows>0) {
 $fetch="SELECT * from tickets WHERE id=? ORDER BY date_booked DESC";

 $com=$conn->prepare($fetch);
 $com->bind_param("s",$_GET["all_type1"]);
 $com->execute();
 $line=$com->get_result();
 if ($line->num_rows>0) {
 	$recd = $line->fetch_assoc();
   	$iname=$recd["ticket_unique_id"];
 }
 $com->execute();
 $history=$com->get_result();
   if ($history->num_rows>0) {
    $num=$history->num_rows;
   
 	?>
   <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Sell out Detail of Ticket: <?php echo "<b class='text-primary' >".ucfirst($iname)."</b>"; ?></span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
 <div class='row' data-aos="zoom-in">
          <div class="pp5 col-lg-12" >






          <div class="row">
    <?php
    $customername='';
    while ($record = $history->fetch_assoc()) {
        $recordid = $record["id"];
        $cond = $record["soldout_status"];
        $customername = $record["customer_name"];
    ?>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-2">
        <div class="card">
            <div class="card-body">
                <hr>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><span class="badge bg-dark rounded-pill"><?php echo $num ?></span></div>
                    </div>
                    <?php
                    if ($record["soldout_status"] == 'instock') {
                        echo '<span class="badge bg-success rounded-pill">Instock</span>';
                    } elseif ($record["soldout_status"] == 'soldout') {
                        echo '<span class="badge bg-warning rounded-pill">Soldout</span>';
                    } elseif ($record["soldout_status"] == 'notset') {
                        echo '<span class="badge bg-danger rounded-pill">Not Set</span>';
                    } else {
                        echo '<span class="badge bg-secondary rounded-pill">No condition</span>';
                    }
                    ?>
                </li>
                <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-2">
                <p class="card-text"><b>Status: </b><r style="text-align: left;"><?php echo $record["soldout_status"] ?></r></p>
                    <p class="card-text"><b>Ticket ID: </b><r style="text-align: left;"><?php echo $record["ticket_unique_id"] ?></r></p>
                    <p class="card-text"><b>Confirmed by: </b><r style="text-align: left;"><?php echo $record["sold_by"] ?></r></p>
                    <p class="card-text"><b>Remark: </b><r style="text-align: left;"><?php echo $record["soldout_remark"] ?></r></p>
                    
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"> <i class="card-text">As of: <i><?php echo date("M d, Y H:i:s", strtotime($record["date_booked"])) ?></i></i></div>
                        </div>
                        <span class="badge bg-primary rounded-pill"><i class="card-text">Ticket Type: <i><?php echo $record["general_remark"] ?></i></i></span>
                    </li>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-2" id="printableSection">
                 <img src='<?php echo '../QR_code/'.$record['QR_plain']?>' class="card-img-top" alt="<?php echo  ucfirst($record["QR_plain"]);?>" width="100%" >
                </div>
                </div>
                <button class="btn btn-primary mt-3" onclick="printPDF()">Print</button>
            </div>
        </div>
    </div>
    <?php
        $num--;
    }
    ?>
</div>





</div>
 </section>
    <?php 
}
}
else{
  echo "<script>alert('Changes with Id:".$_GET["all_type1"]." not found');
  javascript:history.go(-1);

  </script>";
     
}
  ?>
      </main>
       
  
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>
 <script>



function printPDF() {
    const printableContent = document.getElementById('printableSection').innerHTML;
    const bookedto = "<?php echo $customername; ?>";
    // Define custom header and footer
    const customHeader = `
        <header style="text-align: center; margin-bottom: 20px;">
            <h1>BTSC Anniversary Ticket</h1>
            <p>Generated on: ${new Date().toLocaleString()}</p>
             <p>Booked To: ${bookedto}</p>
        </header>
    `;
    const customFooter = `
        <footer style="text-align: center; margin-top: 20px; font-size: 12px;">
            <p>&copy; 2024 Breakthrough Trading S.C. - Confidential</p>
        </footer>
    `;

    // Create a new window for printing
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Breakthrough Trading S.C.</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                header, footer { position: relative; }
                footer { position: fixed; bottom: 0; width: 100%; }
                img { max-width: 100%; height: auto; }
            </style>
        </head>
        <body>
            ${customHeader}
            <div>${printableContent}</div>
            ${customFooter}
        </body>
        </html>
    `);

    printWindow.document.close();

    // Wait for content (including images) to load before printing
    printWindow.onload = () => {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}


    // function printPDF() {
    //     window.print();
    // }
</script>

</body>

</html>

<?php }else{
  header("location:../logout.php");
}