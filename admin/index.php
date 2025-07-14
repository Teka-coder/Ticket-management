<?php 
//header("location:../index.php");
?>
<?php 
session_start();
if($_SESSION['role']=="admin" && isset($_SESSION['username']) && $_SESSION['username']!=''){
include ("recoredserver.php");
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
  $sql= "select * from account where branch = '$comp'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { 
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
  <link href="../assets/css/customcss.css" rel="stylesheet">
</head>
<body>
<?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
       <?php 
      $query = "SELECT * from tickets GROUP BY soldout_status";
      $command=$conn->prepare($query);
      $command->execute();
      $result = $command->get_result();
      if (!is_null($result)) { 

        $count=1;              
        while($row = $result->fetch_assoc()) {
          $label1 = $row['soldout_status']; 
          if($label1=='soldout'){
$link1='outstock.php';
          }else{
            $link1='instock.php';
          }

        ?>    
      <li class="nav-item">
        <a class="nav-link " href="<?php echo $link1?>">
          <i class="bi bi-grid"></i>
          <span><?php echo  ucfirst($label1);?></span>
        </a>
      </li>
  <?php  }
      }
$query2 = "SELECT * from tickets GROUP BY checkin_status";
$command2=$conn->prepare($query2);
$command2->execute();
$result2 = $command2->get_result();
if (!is_null($result2)) { 
    $count2=1;              
    while($row2 = $result2->fetch_assoc()) {
      $label2= $row2['checkin_status'];
      if($label2=='checkedin'){
$label2='Used';
$link2='used.php';
      } else{
        $link2='pending.php';
      }
    ?>
  <li class="nav-item">
        <a class="nav-link " href="<?php echo $link2?>">
          <i class="bi bi-grid"></i>
          <span><?php echo  ucfirst($label2).' Tickets';?></span>
        </a>
      </li>
<?php  }

}

          ?>
       <?php 
            $soldstatus='soldout';
      $query = "SELECT COUNT(*) AS s from tickets WHERE soldout_status=?";
      $command=$conn->prepare($query);
      $command->bind_param('s',$soldstatus);
      $command->execute();
      $result = $command->get_result();
      

                     
        $row = $result->fetch_assoc();
          $sales = $row['s']; 
        
    
        ?>  
    <?php 
            $soldstatus='soldout';
      $query = "SELECT SUM(price) AS total_price
FROM tickets
WHERE soldout_status = ?;
";
      $command=$conn->prepare($query);
      $command->bind_param('s',$soldstatus);
      $command->execute();
      $result = $command->get_result();
      

                     
        $row = $result->fetch_assoc();
          $revenue = $row['total_price']; 
        
    
        ?>   
         <?php 
      $query = "SELECT SUM(price) AS total_price
FROM tickets;
";
      $command=$conn->prepare($query);
      $command->execute();
      $result = $command->get_result();              
        $row = $result->fetch_assoc();
          $total = $row['total_price']; 
          ?> 
          <?php 
      $query = "SELECT COUNT(*) AS t from tickets";
      $command=$conn->prepare($query);
      $command->execute();
      $result = $command->get_result();
      

                     
        $row = $result->fetch_assoc();
          $tickets = $row['t']; 
        
          $salespercent = round(($sales / $tickets) * 100, 2);
          $revenuepercent = round(($revenue / $total) * 100, 2);
          $ticketspercent = round(-(($sales / $tickets) * 100), 2);
          
        ?>  
          <?php 
            $soldstat='instock';
      $queryi = "SELECT COUNT(*) AS it
FROM tickets
WHERE soldout_status = ?;
";
      $commandi=$conn->prepare($queryi);
      $commandi->bind_param('s',$soldstat);
      $commandi->execute();
      $resulti = $commandi->get_result();             
        $rowi = $resulti->fetch_assoc();
          $it = $rowi['it'];  ?>  
  </aside>
 <main id="main" class="main">
    <section>
 <div class="card">          
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->      	
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Ticket Verification System<span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>
   </div>
   </section>
   <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
               
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Sales <span>| Not specified</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $sales?></h6>
                      <span class="text-success small pt-1 fw-bold"><?php echo $salespercent?>%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
          
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| Not specified</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <small>ETB <?php echo $revenue?></small>
                      <span class="text-success small pt-1 fw-bold"><?php echo $revenuepercent?>%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">
          
              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Tickets <span>| Not specified</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                     <small><?php echo $it.' ';?><code>/</code><?php echo ' '.$tickets?></small>
                      <span class="text-danger small pt-1 fw-bold"><?php echo $ticketspercent?>%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Analysis <span>/Not specified</span></h5>
                  <?php

// SQL query
$query = "
    SELECT 
        'Total' AS category, COUNT(*) AS count, DATE(date_inserted) AS date 
    FROM tickets
    GROUP BY DATE(date_inserted)
    UNION
    SELECT 
        'SoldOut' AS category, COUNT(*) AS count, DATE(date_booked) AS date 
    FROM tickets
    WHERE soldout_status = 'soldout'
    GROUP BY DATE(date_booked)
    UNION
    SELECT 
        'CheckedIn' AS category, COUNT(*) AS count, DATE(checkin_time) AS date 
    FROM tickets
    WHERE checkin_status = 'checkedin'
    GROUP BY DATE(checkin_time)
";

$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->get_result();
// Organize data for chart
$chartData = [
    // 'Total' => [],
    'SoldOut' => [],
    'CheckedIn' => []
];

foreach ($data as $row) {
    $chartData[$row['category']][] = [
        'x' => $row['date'], 
        'y' => $row['count']
    ];
}

// Send data to JavaScript
echo "<script>const chartData = " . json_encode($chartData) . ";</script>";
?>

              <!-- Line Chart -->
<div id="reportsChart"></div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Use the chartData variable from PHP
  const chartSeries = [
    // {
    //   name: 'Total Tickets',
    //   data: chartData.Total
    // },
    {
      name: 'Sold Out Tickets',
      data: chartData.SoldOut
    },
    {
      name: 'Used Tickets',
      data: chartData.CheckedIn
    }
  ];

  // Render the chart
  new ApexCharts(document.querySelector("#reportsChart"), {
    series: chartSeries,
    chart: {
      height: 350,
      type: 'area',
      toolbar: { show: false },
    },
    markers: {
      size: 4
    },
    colors: ['#4154f1', '#2eca6a', '#ff771d'],
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.3,
        opacityTo: 0.4,
        stops: [0, 90, 100]
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2
    },
    xaxis: {
      type: 'datetime',
    },
    tooltip: {
      x: {
        format: 'dd/MM/yyyy' // Show date in tooltip
      }
    }
  }).render();
});
</script>


                </div>

              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                    <li><a class="dropdown-item" href="#">Not specified</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Sales Personells <span>| Not specified</span></h5>
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total sells</th>
                      </tr>
                    </thead>
                    <tbody>
                 <?php 
   
  
$queryu = "SELECT 
        account.first_name, 
        account.last_name, 
        account.status,
        account.username AS salesperson_name, 
        COUNT(tickets.id) AS total_sold_tickets
    FROM 
        account
    LEFT JOIN 
        tickets 
    ON 
        account.username = tickets.sold_by
    WHERE 
        account.role = 'edit'
        AND tickets.soldout_status = 'soldout'
    GROUP BY 
        account.username, account.first_name, account.last_name, account.status
    ORDER BY 
        total_sold_tickets DESC
";

      $commandu=$conn->prepare($queryu);
      $commandu->execute();
      $resultu = $commandu->get_result();
      if (!is_null($resultu)) { 
$badge='bg-secondary';
        $co=1;              
        while($rowu = $resultu->fetch_assoc()) {
          $first= $rowu["first_name"];
          $last= $rowu['last_name']; 
          $userstatus = $rowu['status']; 
          $totsells=$rowu['total_sold_tickets'];
          if($rowu['status']=='1'){
            $badge='bg-success';
$userstatus='Active';
          }else{
            $badge='bg-danger';
            $userstatus='Inactive';
          }
          ?>

<tr>
                        <th scope="row"><a href="#"><?php echo $co?></a></th>
                        <td><?php echo $first." ".$last?></td>
                        <td><span class="badge <?php echo $badge?>"><?php echo $userstatus?></span></td>
                        <td><?php echo $totsells?></td>
                    </tr>
<?php
$co++;
        }
    }
        ?>  
                
                      
                     
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->


 <!-- Top Selling -->
 <?php


// SQL query to fetch required metrics
$query = "SELECT 
        COUNT(*) AS total_tickets,
        SUM(price) AS total_revenue,
        SUM(CASE WHEN soldout_status = 'instock' THEN 1 ELSE 0 END) AS instock_count,
          SUM(CASE WHEN soldout_status = 'soldout' THEN 1 ELSE 0 END) AS outstock_count,
        SUM(CASE WHEN general_remark = 'VIP' AND soldout_status='soldout' THEN 1 ELSE 0 END) AS vip_count,
        SUM(CASE WHEN general_remark = 'Normal Ticket' AND soldout_status='soldout' THEN 1 ELSE 0 END) AS nt_count,
        SUM(CASE WHEN general_remark = 'Normal Ticket' AND soldout_status='soldout' THEN price ELSE 0 END) AS nt_revenue,
        SUM(CASE WHEN general_remark = 'VIP' AND soldout_status='soldout' THEN price ELSE 0 END) AS vip_revenue,
          SUM(CASE WHEN soldout_status='soldout' THEN price ELSE 0 END) AS grand_revenue
    FROM tickets
";

// Execute the query
$result = $conn->query($query);

// Fetch the data
if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = [
        'total_tickets' => 0,
        'total_revenue' => 0,
        'instock_count' => 0,
        'outstock_count' => 0,
        'vip_count' => 0,
        'nt_count' => 0,
        'nt_revenue' => 0,
        'vip_revenue' => 0,
        'grand_revenue' => 0,
    ];
}
?>

<!-- Displaying the data in the table -->
<div class="col-12">
    <div class="card top-selling overflow-auto">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
        </div>

        <div class="card-body pb-0">
            <h5 class="card-title">Sales Grand View <span>| Time</span></h5>

            <table class="table table-borderless" id="salesTable">
                <thead>
                    <tr>
                        <th scope="col">Tot. Ticket</th>
                        <th scope="col">Available</th>
                        <th scope="col">Out</th>
                        <th scope="col">NT sales</th>
                        <th scope="col">VIP sales</th>
                        <th scope="col">NT Revenue</th>
                        <th scope="col">VIP Revenue</th>
                        <th scope="col">Target</th>
                        <th scope="col">Grand Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $data['total_tickets']; ?></td>
                        <td><?php echo $data['instock_count']; ?></td>
                        <td><?php echo $data['outstock_count']; ?></td>
                        <td><?php echo $data['nt_count']; ?></td>
                        <td><?php echo $data['vip_count']; ?></td>
                        <td>ETB<?php echo number_format($data['nt_revenue'], 2); ?></td>
                        <td>ETB<?php echo number_format($data['vip_revenue'], 2); ?></td>
                        <td>ETB<?php echo number_format($data['total_revenue'], 2); ?></td>
                        <td>ETB<?php echo number_format($data['grand_revenue'], 2); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Save Buttons -->
            <div class="mt-3 text-end">
                <button class="btn btn-primary" onclick="saveAsPDF()">Save as PDF</button>
                <button class="btn btn-success" onclick="saveAsExcel()">Save as Excel</button>
                <!-- <button class="btn btn-info" onclick="printTable()">Print</button> -->
            </div>
        </div>
    </div>
</div>
<!-- End Top Selling -->





          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Not specified</a></li>
                <li><a class="dropdown-item" href="#">Not specified</a></li>
                <li><a class="dropdown-item" href="#">Not specified</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Sales <span>| Not specified</span></h5>

              <div class="activity">
              <?php
$soldstatus = 'soldout'; 
$query = "SELECT * from tickets WHERE soldout_status=? ORDER BY date_booked DESC LIMIT 5";
$command = $conn->prepare($query);
$command->bind_param('s', $soldstatus);
$command->execute();
$result = $command->get_result();

if (!is_null($result)) { 
    $count = 1;              
    while ($row = $result->fetch_assoc()) {
        $soldby = $row["sold_by"];
        $salestime = $row['date_booked'];
        $ticket = $row['ticket_unique_id'];
        $customer = $row['customer_name'];
        
        // Assign a class based on the count
        $badgeClass = 'text-danger'; // Default class
        if ($count % 3 === 1) {
            $badgeClass = 'text-success'; // Class for counts 1, 4, 7, etc.
        } elseif ($count % 3 === 2) {
            $badgeClass = 'text-warning'; // Class for counts 2, 5, 8, etc.
        }

        ?>
        <div class="activity-item d-flex">
            <div class="activite-label"><?php echo date('Y-m-d H:i:s', strtotime($salestime)); ?></div>
            <i class='bi bi-circle-fill activity-badge <?php echo $badgeClass; ?> align-self-start'></i>
            <div class="activity-content">
                <?php echo $customer ?> <a href="#" class="fw-bold text-dark"><?php echo $ticket ?></a> <?php echo $soldby ?>
            </div>
        </div>
        <?php
        $count++; // Increment the count for the next iteration
    }
}
?>

          <!-- End activity item-->

              </div>

            </div>
          </div><!-- End Recent Activity -->

<!-- Budget Report -->
<div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Not specified</a></li>
                <li><a class="dropdown-item" href="#">Not specified</a></li>
                <li><a class="dropdown-item" href="#">Not specified</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Target Vs Branch<span>| Not specified</span></h5>
<?php 


// Define total ticket price
$totalTickets = 500;
//$ticketPrice = 100; // Example price per ticket
//$allocatedBudget = $totalTickets * $ticketPrice;

// Fetch data for sales personnel
$query = "SELECT 
        sold_by AS salesname,
        COUNT(CASE WHEN soldout_status = 'soldout' THEN sold_by ELSE 0 END) AS actual_sell
    FROM tickets GROUP BY sold_by
";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->get_result();

// Organize data for chart
$chartIndicators = [];
$chartAllocated = [];
$chartActual = [];
$person='';
foreach ($data as $row) {
    $person=$row['salesname'];
    if($row['salesname']==''){
$person='unsold';
    }
    $chartIndicators[] = ['name' => $person, 'max' => $totalTickets];
    $chartAllocated[] = $totalTickets;
    $chartActual[] = (int)$row['actual_sell'];
}

// Send data to JavaScript
echo "<script>
    const chartIndicators = " . json_encode($chartIndicators) . ";
    const chartAllocated = " . json_encode($chartAllocated) . ";
    const chartActual = " . json_encode($chartActual) . ";
</script>";
?>
             <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
    legend: {
      data: ['Allocated Tickets', 'Actual Sales']
    },
    radar: {
      indicator: chartIndicators // Dynamically set radar indicators
    },
    series: [{
      name: 'Tickets vs Sales',
      type: 'radar',
      data: [
        {
          value: chartAllocated, // Allocated Budget
          name: 'Allocated Tickets'
        },
        {
          value: chartActual, // Actual Spending
          name: 'Actual Sales'
        }
      ]
    }]
  });
});
</script>

            </div>
          </div><!-- End Budget Report -->

  <!-- Website Traffic -->
  <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Not specified</a></li>
                <li><a class="dropdown-item" href="#">Not specified</a></li>
                <li><a class="dropdown-item" href="#">Not specified</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
            <h5 class="card-title">Ticket Traffic</h5>
              <h6 class="card-title">VIP vs Normal <span>| <small><?php echo 'Target '.$total.' ETB'?></small></span></h6>
<?php  

// Fetch ticket counts based on stock status and general remark
$queryt = "SELECT 
        COUNT(CASE WHEN soldout_status = 'soldout' AND general_remark = 'VIP' THEN 1 END) AS soldout_vip,
        COUNT(CASE WHEN soldout_status = 'soldout' AND general_remark = 'Normal Ticket' THEN 1 END) AS soldout_normal,
        COUNT(CASE WHEN soldout_status = 'instock' AND general_remark = 'VIP' THEN 1 END) AS instock_vip,
        COUNT(CASE WHEN soldout_status = 'instock' AND general_remark = 'Normal Ticket' THEN 1 END) AS instock_normal
    FROM tickets
";

$stmtt = $conn->prepare($queryt);
$stmtt->execute();
$resultt = $stmtt->get_result();

// Prepare data for the chart
foreach($resultt as $res){
    $chartData = [
        ['value' => (int)$res['soldout_vip'], 'name' => 'Soldout VIP'],
        ['value' => (int)$res['soldout_normal'], 'name' => 'Soldout Normal'],
        ['value' => (int)$res['instock_vip'], 'name' => 'In-stock VIP'],
        ['value' => (int)$res['instock_normal'], 'name' => 'In-stock Normal']
    ];
}


// Pass data to JavaScript
echo "<script>const trafficChartData = " . json_encode($chartData) . ";</script>";
?>
            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  echarts.init(document.querySelector("#trafficChart")).setOption({
    tooltip: {
      trigger: 'item'
    },
    legend: {
      top: '5%',
      left: 'center'
    },
    series: [{
      name: 'Ticket Types',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: '18',
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: trafficChartData // Use the data fetched from PHP
    }]
  });
});
</script>
<!-- JavaScript Functions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script>
    const genby="<?php echo $_SESSION['username'];?>";
    function saveAsPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Define header and footer text
    const companyName = "Breakthrough Trading S.C";
    const currentDate = new Date().toLocaleDateString();
    const footerText = `Generated by: ${genby}`;

    // Add header
    doc.setFontSize(12);
    doc.setFont("helvetica", "bold");
    doc.text(companyName, 10, 10); // Header on top-left
    doc.setFontSize(10);
    doc.setFont("helvetica", "normal");
    doc.text(`Date: ${currentDate}`, 180, 10, { align: 'right' }); // Header on top-right

    // Add table
    doc.autoTable({
        html: '#salesTable',
        startY: 20, // Space for header
    });

    // Add footer
    const pageHeight = doc.internal.pageSize.height; // Page height for dynamic positioning
    doc.setFontSize(10);
    doc.text(footerText, 10, pageHeight - 10); // Footer on bottom-left
    doc.text(`Page 1`, 180, pageHeight - 10, { align: 'right' }); // Footer on bottom-right (Page Number)

    // Save the PDF
    doc.save('sales_data.pdf');
}


    // Save Table as Excel
    function saveAsExcel() {
        let table = document.getElementById('salesTable');
        let workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, 'sales_data.xlsx');
    }

    // // Print the Table
    // function printTable() {
    //     let printContents = document.getElementById('salesTable').outerHTML;
    //     let originalContents = document.body.innerHTML;
    //     document.body.innerHTML = printContents;
    //     window.print();
    //     document.body.innerHTML = originalContents;
    // }
</script>

            </div>
          </div><!-- End Website Traffic -->






        </div><!-- End Right side columns -->

      </div>
    </section>
  </main>
   <?php include('../footer.html');?>


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

    function showAlert(){
    var myText='Not available yet';
    alert(myText);
  }     
</script>

</body>

</html>

<?php }else{
  header("location:../logout.php");
}
