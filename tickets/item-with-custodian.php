 <?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
include ("../pad/recoredserver.php");

// if (isset($_GET['manage_items'])) {
//   $id = intval($_GET['delete_item']);
//   $adn = "DELETE FROM  items  WHERE id = ?";
//   echo $adn;
//   $stmt = $mysqli->prepare($adn);
//   $stmt->bind_param('i', $id);
//   $stmt->execute();
//   $stmt->close();

//   if ($stmt) {
//     $info = "Items Deleted";
//   } else {
//     $err = "Try Again Later";
//   }
// }
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

  <!-- Google Fonts -->
 
 <?php include('css.php');?>



</head>
<body>
  <?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
 <?php include('side.php');?>
 <main id="main" class="main">
    <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">

            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff">Employees and their Assets</h5>
          </div>
                    <?php 
 $stmt= "select it.*,
      sender_wh.warehouse_code as fw,
      receiver_wh.warehouse_code as tw,
      sender_custo.holder_name as fc,
      receiver_custo.holder_name as tc,
      items.item_name
from item_transaction it
join warehouse sender_wh
on it.from_warehouse=sender_wh.id
join warehouse receiver_wh
on it.to_warehouse=receiver_wh.id
join item_holder sender_custo
on it.from_custodian=sender_custo.id
JOIN item_holder receiver_custo
on it.to_custodian=receiver_custo.id
JOIN items
on it.item=items.id
GROUP BY it.to_custodian ORDER BY it.created_at DESC;";
 // $tot_sql="select count(*) as c from item_transaction;";
 // $cmd=$conn->prepare($tot_sql);
 // $cmd->execute();
 // $res=$cmd->get_result();
 //  $counting=$res->fetch_assoc();
 // $total=$counting["c"];

 $comm=$conn->prepare($stmt);
 $comm->execute();
 $record=$comm->get_result();
  ?>
           <div class="card-body">
             <p><code>Listed by Employee</code></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                      <th scope="col">Custodian Name</th>
                     <th scope="col">Recently Received</th>
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
                     <td><?php echo $rec["tc"];?></td>
                     <td><?php echo $rec["item_name"];?></td>
                    <td><?php echo $rec["created_by"];?></td>
                    <td><?php echo $rec["created_at"];?></td>
                    <td><a class="badge bg-dark" href='<?php echo "employee-vs-item-details.php?custodian=".$rec["to_custodian"];?>'>
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
                    <th scope="row " class="text-center"  colspan="6">No transfer history found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>

</section>
 <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">

            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff">Item With No Transfer History</h5>
          </div>
                    <?php
                    $val=0; 
 $stmt2= "SELECT statuslist.description as status_desc,statuslist.value,item_holder.holder_name,asset.category,warehouse.warehouse_code,
 items.company,
 items.department,
 items.created_at,
 items.created_by,
 items.QR_code,
 items.id,
 items.item_status,
 items.description,
 items.item_name,
 items.acquisition_date,
 items.acquisition_value,
 items.current_value,
 items.item_condition,
 items.manufactures_SN,
 items.tag_or_pn,
 items.QR_plain,
 items.expected_lifecycle,
 items.custodian FROM items INNER JOIN item_holder on items.custodian=item_holder.id INNER JOIN statuslist on items.item_status=statuslist.id INNER JOIN warehouse on items.warehouse=warehouse.id INNER JOIN asset on items.category=asset.id WHERE Affected=? ORDER BY items.created_at DESC;";
  $tot_sql2="select count(*) as c from items WHERE Affected=?;";
 $cmd2=$conn->prepare($tot_sql2);
 $cmd2->bind_param("s",$val);
 $cmd2->execute();
 $res2=$cmd2->get_result();
 $counting2=$res2->fetch_assoc();
 $total2=$counting2["c"];

  $comm2=$conn->prepare($stmt2);
  $comm2->bind_param("s",$val);
  $comm2->execute();
  $record2=$comm2->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total2; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item</th>
                    <th scope="col">Location/User</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered At</th>
                    <th scope="col">Registered By</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record2->num_rows > 0) {
                  $count=1;
                    $btn=$link=$option=$stat=$icon=$value=$id_val=$name="";  
                  while($rec2 = $record2->fetch_assoc()){
                           if ($rec2["value"]==3 or $rec2["value"]==2) {
                              $otag="<button class='btn btn-secondary'";
                              $ctag="</button>";
                              $option="Reset status";
                              $value="value='".$rec2['item_name']."'";
                              $id_val="id='".$rec2["id"]."'";
                              $link="onclick='resetStatus(this)'";
                              $name="name='item-with-custodian.php'";
                              $icon="bi-question-lg";
                              
                            }
                            else {
                              $otag="<a class='btn btn-dark'";
                              $ctag="</a>";
                              $option="Transfer";
                              $link="href='asset-transaction-form.php?id=".$rec2["id"]."'";
                              $icon="bi-arrow-left-right";
                            
                            }
                            if ($rec2["value"]==1) {
                              $stat="bg-success";
                            }else if ($rec2["value"]==2) {
                              $stat="bg-warning";
                            }else if ($rec2["value"]==3) {
                              $stat="bg-danger";
                            }
                            else{
                              $stat="bg-white";
                            }
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count?></th>
                     <td><?php echo $rec2["item_name"];?></td>
                     <td><?php echo $rec2["holder_name"];?></td>
                    <td><i class="text-white p-1 <?php echo $stat;?>"><?php echo $rec2["status_desc"];?></i></td>
                    <td><?php echo $rec2["created_at"];?></td>
                     <td><?php echo $rec2["created_by"];?></td>
                    <td><?php echo $otag?><?php echo $link;?> <?php echo $value." ".$id_val." ".$name?>>
                            <?php echo $option;?><i class="bi <?php echo $icon;?>"></i>
                          <?php echo $ctag?></td>
                  </tr>
                  <?php
                  $count++;
                }
              }
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="7">No untransfer item found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>

</section>
           </main>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
  <?php include('script.php');?>
</body>

</html>

<?php }else{
  header("location:../index.php");
}
?>

