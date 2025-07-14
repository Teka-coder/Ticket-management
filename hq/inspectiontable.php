<?php
session_start();
if($_SESSION['role']=="hq"){ 
  //$cata=$_SESSION['asset'];
  $startdate=$_GET['from_date'];
  $endtdate=$_GET['to_date'];
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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style>
  .card-header{
    background-color: #87CEEB !important;
    height: 50px;
  }
  h4{
    color:white;
  }

 .decorated{
     overflow: hidden;
     text-align: center;
 }
.decorated > span{
    position: relative;
    display: inline-block;
}
.decorated > span:before, .decorated > span:after{
    content: '';
    position: absolute;
    top: 50%;
    border-bottom: 2px solid;
    width: 200%;
    margin: 0 20px;
}
.decorated > span:before{
    right: 100%;
}
.decorated > span:after{
    left: 100%;
}
body{
    width: 100%;
    height: 100%;
	
	padding:50px;
	font-family: sans-serif;
}

*{
	box-sizing: border-box;
}

.table{
	width: 100%;
	border-collapse: collapse;
}

.table td,.table th{
  padding:12px 15px;
  border:1px solid #ddd;
  text-align: center;
  font-size:16px;
}

.table th{
	background-color: #87CEEB ;
	color:white;
}

.table tbody tr:nth-child(even){
	background-color: #f5f5f5;
}

/*responsive*/

@media(max-width: 500px){
	.table thead{
		display: none;
	}

	.table, .table tbody, .table tr, .table td{
		display: block;
		width: 100%;
	}
	.table tr{
		margin-bottom:15px;
	}
	.table td{
		text-align: right;
		padding-left: 50%;
		text-align: right;
		position: relative;
	}
	.table td::before{
		content: attr(data-label);
		position: absolute;
		left:0;
		width: 50%;
		padding-left:15px;
		font-size:15px;
		font-weight: bold;
		text-align: left;
	}
}

  </style>


</head>

<body>

 <?php include('../headersidebar.php');?>
<div class="pagetitle">
               <br><h1 class="decorated"><span>Inspection Report<span></h1>          
                </div>       
                       <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Catagory</th>
                                    <th>Model</th>
                                    <th>Plate No</th>
                                    <th>inspection date</th>
                                    <th>next inspection</th>
                                    <th>Available internal items</th>
                                    <th>Missing internal items</th>
                                    <th>Available external items</th>
                                    <th>Missing external items</th>
                                    <th>Inspected By</th>
                                    <th>Driver</th>
                                    <th>Current odometer reading</th>
                                    <th>km before next inspection</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
                                if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                {
                                    $from_date = $_GET['from_date'];
                                    $to_date = $_GET['to_date'];

                                    $query = "SELECT * FROM inspection WHERE inspection_date BETWEEN '$from_date' AND '$to_date' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $row)
                                        {
                                            ?>
                                            <tr>
                                                <td data-label="catagory"><?= $row['catagory']; ?></td>
                                                <td data-label="model"><?= $row['model']; ?></td>
                                                <td data-label="plateno"><?= $row['plateno']; ?></td>
                                                <td data-label="inspection date"><?= $row['inspection_date']; ?></td>
                                                <td data-label="next inspection"><?= $row['nxt_inspection_date']; ?></td>
                                                <td data-label="internal available item"><?= $row['int_okay']; ?></td>
                                                <td data-label="internal missing"><?= $row['int_notokay']; ?></td>
                                                <td data-label="external available"><?= $row['ex_okay']; ?></td>
                                                <td data-label="external missing"><?= $row['ex_notokay']; ?></td>
                                                <td data-label="inspected by"><?= $row['inspected_by']; ?></td>
                                                <td data-label="driver"><?= $row['driver']; ?></td>
                                                <td data-label="odometer"><?= $row['odometer_reading']; ?></td>
                                                <td data-label="km before service"><?= $row['km_beforenxt_service']; ?></td>
                                                <td data-label="note"><?= $row['comments']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "No Record Found";
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                 
</body>
</html>
<?php }else{
  header("location:../index.php");
}