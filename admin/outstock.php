<?php 
session_start();
if($_SESSION['role']=="admin" && isset($_SESSION['username']) && $_SESSION['username']!=''){
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
  $sql= "select * from comp where branch = '$comp'";
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

  <!-- Google Fonts -->
 
 <?php include('css.php');?>



</head>
<body>
  <?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
 <?php include('side.php');?>
 <main id="main" class="main">
  <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Out of Stock records<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
<section class="section">
<div class="row">

<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
<?php
$val='soldout'; 
 $stmt= "SELECT * from tickets WHERE soldout_status=?  ORDER BY date_booked DESC";
$tot_sql="select count(*) as c, SUM(price) AS tot_price from tickets where soldout_status=?;";
  $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));;
  $tot_cmd->bind_param("s",$val);
  $tot_cmd->execute();
  $resu=$tot_cmd->get_result();
  $counting=$resu->fetch_assoc();
  $total=$counting["c"];
  $totprice=$counting['tot_price'];
  $result = $conn->prepare($stmt) or die(mysqli_connect_error($conn));
  $result->bind_param("s",$val);
  $result->execute();
  $record=$result->get_result();
  ?>
            <div class="card">
            <div class="card-header text-center p-0 card-header bg-dark">
  <h5 class="card-title text-white">Out Of Stock List</h5>
</div>
<div class="card-body">
  <p><code>Total</code>: <?php echo $total; ?></p>
  <button id="exportExcel" class="btn btn-success">Export to Excel</button>
  <button id="exportPDF" class="btn btn-danger">Export to PDF</button>

  <table id="outOfStockTable" class="table table-bordered border-primary">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Ticket ID</th>
        <th scope="col">Customer Name</th>
        <th scope="col">Transaction Ref.</th>
        <th scope="col">Customer Phone</th>
        <th scope="col">Ticket Type</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($record->num_rows > 0) {
        $ct = 1;
        while ($rec = $record->fetch_assoc()) { ?>
          <tr>
            <th scope="row"><?php echo $ct; ?></th>
            <td><?php echo $rec["ticket_unique_id"]; ?></td>
            <td><?php echo $rec["customer_name"]; ?></td>
            <td><?php echo $rec["transaction_ref"]; ?></td>
            <td><?php echo $rec["customer_phone"]; ?></td>
            <td><?php echo $rec["general_remark"]; ?></td>
          </tr>
      <?php
          $ct++;
        }
      } else { ?>
        <tr>
          <th scope="row" class="text-center" colspan="5">No record found</th>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>


        </div>
</div>
</div> 
            
</section>
</main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
 const loggedInUser = "<?php echo $_SESSION['username']; ?>";
 const totalprice = "<?php echo $totprice; ?>";
  // Export to Excel
  document.getElementById("exportExcel").addEventListener("click", () => {
      const table = document.getElementById("outOfStockTable");
      const wb = XLSX.utils.table_to_book(table);
      XLSX.writeFile(wb, "OutOfStockList.xlsx");
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script>
  document.getElementById("exportPDF").addEventListener("click", () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();

    // Add header
    pdf.setFontSize(12);
    pdf.text(`Generated By: ${loggedInUser}`, 14, 10);
    pdf.text("Company Name: Breakthrough Trading S.C", 14, 16);
    pdf.text(`Total Sales: ${totalprice} ETB`, 14, 22);
    pdf.text("Date: " + new Date().toLocaleDateString(), 14, 28);

    // Use autoTable
    pdf.autoTable({
      html: "#outOfStockTable",
      theme: "grid",
      headStyles: { fillColor: [40, 40, 40] },
      margin: { top: 30 },
      styles: { fontSize: 8 },
      columnStyles: {
        3: { cellWidth: 0 }, // Hide the "Action" column
      },
    });

    // Save the PDF
    pdf.save("OutOfStockList.pdf");
  });
</script>


 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../logout.php");
}