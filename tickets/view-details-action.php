  <?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
include ("../pad/recoredserver.php");
include "../connection.php";
 
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
  $comp = $_SESSION['company'];
  $sql="SELECT * FROM comp WHERE name=?";
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
 <?php
 $check="select id from items where id=?;";
 $cmd=$conn->prepare($check) or die(mysqli_connect_error($conn));
 $cmd->bind_param("s",$_GET["view_item"]);
 $cmd->execute();
 $res=$cmd->get_result();
if (isset($_GET['view_item'])&& $res->num_rows>0) {
 
  $sql="SELECT statuslist.description as status_desc,item_holder.holder_name,asset.category,warehouse.warehouse_code,
 items.company,
 items.department,
 items.created_at,
 items.created_by,
 items.QR_code,
 items.id,
 items.description,
 items.item_name,
 items.acquisition_date,
 items.acquisition_value,
 items.current_value,
 items.item_condition,
 items.manufactures_SN,
 items.tag_or_pn,
 items.expected_lifecycle,
 items.custodian FROM items INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id INNER JOIN item_holder on item_holder.id=items.custodian where items.id=?";
 $comm=$conn->prepare($sql) or die(mysqli_connect_error($conn));
 $comm->bind_param("s",$_GET["view_item"]);
 $comm->execute();
 $result=$comm->get_result();

  if ($result->num_rows>0) {
     while($row = $result->fetch_assoc()){
     $qr_code_image=$row["QR_code"];
  ?>
 <main id="main" class="main">
    <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Detail view of <?php echo $row["item_name"]?><span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">
          <div class="pp5 col-lg-12" >
          <div class="row">
         
  <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-2">
    <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $row["item_name"]?></h5>
          </div>
            
            <div class="card-body">
               <p class="card-text"><b>Item name: </b><r style="text-align: left;"><?php echo $row["item_name"]?></r></p>
               <p class="card-text"><b>Asset type: </b><r style="text-align: left;"><?php echo $row["category"]?></r></p>
               <p class="card-text"><b>Company/Branch: </b><r style="text-align: left;"><?php echo $row["company"]?></r></p>
               <p class="card-text"><b>Warehouse: </b><r style="text-align: left;"><?php echo $row["warehouse_code"]?></r></p>
               <p class="card-text"><b>Department: </b><r style="text-align: left;"><?php echo $row["department"]?></r></p>
               <p class="card-text"><b>Registerd by: </b><r style="text-align: left;"><?php echo $row["created_by"]?></r></p>
               <p class="card-text"><b>Registerd at: </b><r style="text-align: left;"><?php echo $row["created_at"]?></r></p>
               <p class="card-text"><b>Manufacture's SN: </b><r style="text-align: left;"><?php echo $row["manufactures_SN"]?></r></p>
               <p class="card-text"><b>TAG or plate No.: </b><r style="text-align: left;"><?php echo $row["tag_or_pn"]?></r></p>
               <p class="card-text"><b>Expected life cycle: </b><r style="text-align: left;"><?php echo $row["expected_lifecycle"]?></r></p><p class="card-text"><b>Current value: </b><r style="text-align: left;"><?php echo $row["current_value"]?></r></p>
               <p class="card-text bg bg-warning"><b>Current user/Custodian: </b><r style="text-align: left;"><?php echo $row["holder_name"]?></r></p>
               <p class="card-text"><b>Condition: </b><r style="text-align: left;"><?php echo $row["item_condition"]?></r></p>
               <p class="card-text"><b>Acquisition value: </b><r style="text-align: left;"><?php echo $row["acquisition_value"]?></r></p>
               <p class="card-text"><b>Acquisition date: </b><r style="text-align: left;"><?php echo $row["acquisition_date"]?></r></p>
               <p class="card-text"><b>Status: </b><r style="text-align: left;"><?php echo $row["status_desc"]?></r></p>
             <!--  <a class="badge bg-danger"  href='<?php echo "delete-items-action.php?delete_item=".$row["id"];?>'>
                            <i class="bx bx-trash"></i>
                          </a> -->
                             <a class="badge bg-info" href='<?php echo "update-items-form-view.php?update_item=".$row["id"];?>'>
                            <i class="bx bx-edit"></i>
                          </a>
                        
            </div>
             </div>
           </div>
        


            <!--  <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3"> -->
 <div class="col-lg-8 col-xl-8 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class=" nav-item"><a type="button" class=" btn nav-link active"   onclick="toggle(this)" id='tab1' data-toggle="tab">Accessory List</a></li>
                         <li class=" nav-item"><a type="button" class=" btn nav-link"   id='tab0' onclick="toggle(this)" data-toggle="tab">Components</a></li>
                         <li class=" nav-item"><a type='button 'class=" btn nav-link"   id='tab2' onclick="toggle(this)" data-toggle="tab">Transfer History</a></li>
                         <li class=" nav-item"><a type='button 'class=" btn nav-link"   id='tab3' onclick="toggle(this)" data-toggle="tab">Update history</a></li>
                         <li class=" nav-item"><a type='button 'class=" btn nav-link"   id='tab4' onclick="toggle(this)" data-toggle="tab">QR code</a></li>
                   
                    </ul>
                </div><!-- /.card-header -->

    <div class="card-body">
       <div class="tab-content">
       <div class="tabs active tab-pane" id="accessory_list">
     <!--  <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5"> -->
            <?php 
 $stmt= "SELECT statuslist.description,accessories.accessory_name,accessories.created_at,accessories.created_by,accessories.accessory_status,accessories.accessory_SN,accessories.tag_or_pn,accessories.id from accessories INNER JOIN statuslist on accessories.accessory_status=statuslist.id WHERE accessories.tag_or_pn=? ORDER BY accessories.created_at DESC";
  $tot_sql="select count(*) as c from accessories where tag_or_pn=?;";
 $comma=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
 $comma->bind_param("s",$_GET['view_item']);
 $comma->execute();
 $resu=$comma->get_result();
  $counting=$resu->fetch_assoc();
 $total=$counting["c"];

  $commd=$conn->prepare($stmt) or die(mysqli_connect_error($conn));
  $commd->bind_param("s",$_GET['view_item']);
  $commd->execute();
  $record=$commd->get_result();
  ?>
            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo ucfirst($row["item_name"]);?> Accessory List</h5>
          </div>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                     <!-- <th scope="col">TAG|PN</th> -->
                    <th scope="col">Serial No.</th>
                     <th scope="col">Status</th>
                    <th scope="col">Registerd by</th>
                    <th scope="col">Registerd at</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record->num_rows > 0) {  
                  while($rec = $record->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $rec["id"];?></th>
                    <td><?php echo $rec["accessory_name"];?></td>
                   <!--  <td><?php echo $rec["tag_or_pn"];?></td> -->
                    <td><?php echo $rec["accessory_SN"];?></td>
                    <td>
                      <?php
                     if ($rec["description"] == 'Active') {
                      echo '<span class="bg bg-success">Active</span>';
                    }elseif ($rec["description"] == 'Maintenance required') {
                      echo '<span class="bg bg-warning">Maintenance req.</span>';
                      } 
                     elseif ($rec["description"] == 'Out of use') {
                      echo '<span class="bg bg-danger">Out of use</span>';
                      }
                      else {
                       echo ' <span class="badge bg-secondary text-dark">No status</span>';
                       // <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Waiting">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      }
                  
                    ?>
                    </td>
                     <td><?php echo $rec["created_by"];?></td>
                      <td><?php echo $rec["created_at"];?></td>
                  </tr>
                  <?php
                }}
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="7">No record found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div> 
        </div>
       <div class="tabs tab-pane" id="components">
     <!--  <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5"> -->
            <?php 
 $stmt2= "SELECT * from components WHERE item_qr=? ORDER BY created_at DESC";
  $tot_sql2="select count(*) as c from components where item_qr=?;";
 $comm2=$conn->prepare($tot_sql2) or die(mysqli_connect_error($conn));
 $comm2->bind_param("s",$_GET['view_item']);
 $comm2->execute();
 $resu2=$comm2->get_result();
 $counting2=$resu2->fetch_assoc();
 $total2=$counting2["c"];

  $commd2=$conn->prepare($stmt2) or die(mysqli_connect_error($conn));
  $commd2->bind_param("s",$_GET['view_item']);
  $commd2->execute();
  $record2=$commd2->get_result();
  ?>
            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo ucfirst($row["item_name"]);?> Components</h5>
          </div>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total2; ?></p>
             <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                     <th scope="col">Description</th>
                    <th scope="col">Registerd by</th>
                    <th scope="col">Registerd at</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record2->num_rows > 0) {  
                  while($rec2 = $record2->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $rec2["id"];?></th>
                    <td><?php echo $rec2["component_name"];?></td>
                    <td><?php echo $rec2["component_desc"];?></td>
                     <td><?php echo $rec2["created_by"];?></td>
                      <td><?php echo $rec2["created_at"];?></td>
                  </tr>
                  <?php
                }}
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="7">No components found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div> 
        </div>
<div class="tabs tab-pane" id="update_history">      
               <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff">Change's List</h5>
          </div>
                    <?php 
 $stmt2= "SELECT history.*,items.item_name from history INNER JOIN items on items.id=history.item WHERE history.item=? ORDER BY history.updated_at DESC";
 $tot_sql="select count(*) as c from history where item=?;";
 $comm=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
 $comm->bind_param("s",$_GET['view_item']);
 $comm->execute();
 $resu=$comm->get_result();
  $counting=$resu->fetch_assoc();
  $total=$counting["c"];

  $commd2=$conn->prepare($stmt2) or die(mysqli_connect_error($conn));
  $commd2->bind_param("s",$_GET['view_item']);
  $commd2->execute();
  $record2=$commd2->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                     <th scope="col">Item Name</th>
                    <th scope="col">Changed By</th>
                     <th scope="col">Changed At</th>
                      <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record2->num_rows > 0) {
                  $count=1;  
                  while($rec2 =$record2->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count ?></th>
                     <td><?php echo $rec2["item_name"];?></td>
                    <td><?php echo $rec2["updated_by"];?></td>
                    <td><?php echo $rec2["updated_at"];?></td>
                    <td><a class="badge bg-dark" href='<?php echo "history-detail-view.php?view_history=".$rec2["id"];?>'>
                            Detail<i class="bi bi-eye"></i>
                          </a></td>
                  </tr>
                  <?php
                  $count++;
                }
              }
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="7">No change found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>        
  </div>

  <div class="tabs tab-pane" id="transfer_history">    
 <!--  <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5"> -->
            <?php 
 $stmt= "SELECT * from item_transaction WHERE item_transaction.item=? ORDER BY item_transaction.created_at DESC";
 $tot_sql="select count(*) as c from item_transaction where item=?;";
 $comm=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));
 $comm->bind_param("s",$_GET['view_item']);
 $comm->execute();
 $resu=$comm->get_result();
 $counting=$resu->fetch_assoc();
 $total=$counting["c"];


  $commd=$conn->prepare($stmt) or die(mysqli_connect_error($conn));
  $commd->bind_param("s",$_GET['view_item']);
  $commd->execute();
  $record=$commd->get_result();
  ?>
            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo ucfirst($row["item_name"]);?> Transfer List</h5>
          </div>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Transaction#</th>
                    <th scope="col">Transfered By</th>
                     <th scope="col">Transfered At</th>
                      <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record->num_rows > 0) {
                  $count=1;  
                  while($rec = $record->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count ?></th>
                    <td><?php echo $rec["created_by"];?></td>
                    <td><?php echo $rec["created_at"];?></td>
                    <td><a class="badge bg-dark" href='<?php echo "transaction-detail-view.php?view_transfer=".$rec["id"];?>'>
                            Detail<i class="bi bi-eye"></i>
                          </a></td>
                  </tr>
                  <?php
                  $count++;
                }}
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="7">No transfer history found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div> 
                         
    </div>                                    
      <div class="tabs tab-pane col-sm-12 col-md-6 col-lg-4 col-xl-4" id="scan_qrcode">
                <div class="card text-center p-0">
                 <div class="card-header" style="background: #093c73!important;">
                 <h4 style="color: #fff">QR code</h4>
            </div>
                 <img src='<?php echo '../QR_code/'.$qr_code_image ?>' class="card-img-top" alt="<?php echo  ucfirst($row["QR_code"]);?>" width="100%">
                 <div class="card-body">
              <h5 class="card-title"> <?php echo  ucfirst($row["item_name"]);?></h5>
             
 <?php
                     if ($row["status_desc"] == 'Active') {
                      echo '<span class="badge bg-success">'.$row["status_desc"].'</span>';
                      }
                      elseif ($row["status_desc"] == 'Maintenance required') {
                         echo '<span class="badge bg-warning">'.$row["status_desc"].'</span>';
                      } 
                     elseif ($row["status_desc"] == 'Out of use') {
                        echo '<span class="badge bg-danger">'.$row["status_desc"].'</span>';
                      }
                      else {
                        echo '<span class="badge bg-primary">'.$row["status_desc"].'</span>';
                      }
                  
                    ?>
             
            </div>
          </div>
             </div>
               <!-- /.tab-panes -->
              </div>
                    <!-- /.tab-content -->
                 </div><!-- /.card-body -->
                        </div>
                                <!-- /.nav-tabs-custom -->
                           
            <?php 
}
 }
?>
        </div>          
           
           
         </div>
       </div>
 </section>



    </main>
    

     <?php 
}
  else{
  echo "<script>alert('An item with Id:".$_GET["view_item"]." not found');
  javascript:history.go(-1);

  </script>";
     
}
// else {
//   echo' 
//       <div style="padding-top: 15px; text-align:center;" class="col-sm-3 col-md-6 col-lg-12 col-xl-12">
//       <span data-feather="alert-triangle" style="color:red;text-align:center;">
//       <section class="trashsection">
//   <span class="trash">
//       <span></span>
//       <i></i>
//     </span>
// </section>
//       <h1>NO items found</h3>
//       </span>
//       </div>';
//     }
?>
      <?php include('../footer.html');?>
      <?php include('script.php');?>

</body>

</html>

         


          <?php
 }
else{
  header("location:../index.php");
}
?>








<script type="text/javascript">
    function remove_active(){
    var elements=document.getElementsByClassName("tabs"); /// divs 
    //alert(elements.length)
    for(let el of elements)
      el.classList.remove("active");
for(let i=0;i<=4;i++)
   document.getElementById('tab'+i).classList.remove("active") // li
  }
  function toggle(e){
  if(e.id=='tab1'){
  remove_active();
   e.classList.add('active');
    document.getElementById('accessory_list').classList.add("active")
  }else if(e.id=='tab2'){
     remove_active();
     e.classList.add('active');
    document.getElementById('transfer_history').classList.add("active")
}
else if(e.id=='tab3'){
        remove_active();
     e.classList.add('active');
      document.getElementById('update_history').classList.add("active")
}
else if(e.id=='tab4'){
      remove_active();
     e.classList.add('active');
     document.getElementById('scan_qrcode').classList.add('active')
}
else if(e.id=='tab0'){
      remove_active();
     e.classList.add('active');
     document.getElementById('components').classList.add('active')
}
}
</script>