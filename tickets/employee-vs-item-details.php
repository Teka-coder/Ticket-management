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
<style type="text/css">
  .shape{    
  border-style: solid; border-width: 0 140px 80px 0; float:right; height: 0px; width: 0px;
  -ms-transform:rotate(300deg); /* IE 9 */
  -o-transform: rotate(300deg);  /* Opera 10.5 */
  -webkit-transform:rotate(300deg); /* Safari and Chrome */
  transform:rotate(300deg);
}
.item{
  background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.shape {
  border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}

.item-info { border-color: #5bc0de; }
.item-info .shape{
  border-color: transparent #5bc0de transparent transparent;
}

.shape-text{
  color:#fff; font-size:14px; font-weight:bold; position:relative; right:-40px; top:2px; white-space: nowrap;
  -ms-transform:rotate(30deg); /* IE 9 */
  -o-transform: rotate(360deg);  /* Opera 10.5 */
  -webkit-transform:rotate(30deg); /* Safari and Chrome */
  transform:rotate(30deg);
} 


</style>
 
 <?php include('css.php');?>



</head>
<body>
  <?php include('../headersidebar.php');?>

  <!-- ======= Sidebar ======= -->
 <?php include('side.php');?>
 <?php
 $check="select items.custodian,item_holder.holder_name from items inner join item_holder on item_holder.id=items.custodian where items.custodian=?;";
 $cmd=$conn->prepare($check);
 $cmd->bind_param("s",$_GET["custodian"]);
 $cmd->execute();
 $fetch_res=$cmd->get_result();
 if (isset($_GET['custodian'])&& $fetch_res->num_rows>0) {
 	$fetch=$fetch_res->fetch_assoc();
  ?>
 <main id="main" class="main">
 	<div class="card">
 		 <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>List of <?php echo $fetch["holder_name"]."'s Assets";?> </span></h1> 
         </div>
         
     </div>

 	 <section class="section">
      <!--<div class="container">  -->
      <!--    <div class='row' data-aos="zoom-in"> -->

            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo ucfirst($fetch["holder_name"])."'s";?> items</h5>
          </div>
  <?php 
 $stmt= "select items.*,statuslist.description as status_desc from items inner join statuslist on items.item_status=statuslist.id where items.custodian=? ORDER BY created_at DESC;";
  $stmt2= "select accessories.*,statuslist.description as status_desc2 from accessories inner join statuslist on accessories.accessory_status=statuslist.id where accessories.custodian=? ORDER BY created_at DESC;";
 $tot_sql="select count(*) as c from items WHERE custodian=?;";
 $tot_sql2="select count(*) as c from accessories WHERE custodian=?;";
 
 $com=$conn->prepare($tot_sql);
 $com->bind_param("s",$_GET["custodian"]);
 $com->execute();
 $res=$com->get_result();

 $com2=$conn->prepare($tot_sql2);
 $com2->bind_param("s",$_GET["custodian"]);
 $com2->execute();
 $res2=$com2->get_result();

 $counting=$res->fetch_assoc();
 $counting2=$res2->fetch_assoc();
 $total=$counting["c"];
 $total2=$counting2["c"];

  
  $cmd1=$conn->prepare($stmt);
  $cmd1->bind_param("s",$_GET["custodian"]);
  $cmd1->execute();
  $record=$cmd1->get_result();

  $cmd2=$conn->prepare($stmt2);
  $cmd2->bind_param("s",$_GET["custodian"]);
  $cmd2->execute();
  $record2=$cmd2->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                      <th scope="col">Items</th>
                    <th scope="col">Item status</th>
                      <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record->num_rows > 0) {
                  $count=1;  
                  while($rec =$record->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count ?></th>
                     <td><?php echo $rec["item_name"];?></td>
                    <td><?php echo $rec["status_desc"];?></td>
                    <td><a class="badge bg-dark" href='#'>
                            Action<i class="bi bi-eye"></i>
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
                    <th scope="row " class="text-center"  colspan="7">No Item found with this employee</th>
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
      <!--    <div class='row' data-aos="zoom-in"> -->

            <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo ucfirst($fetch["holder_name"])."'s";?> Accesories</h5>
          </div>
  <?php 
  $stmt2= "select accessories.*,statuslist.description as status_desc2 from accessories inner join statuslist on accessories.accessory_status=statuslist.id where accessories.custodian=? ORDER BY created_at DESC;";
 $tot_sql2="select count(*) as c from accessories WHERE custodian=?;";
 $cmd2=$conn->prepare($tot_sql2);
 $cmd2->bind_param("s",$_GET["custodian"]);
 $cmd2->execute();
 $res2=$cmd2->get_result();
 $counting2=$res2->fetch_assoc();
 $total2=$counting2["c"];


  $com2=$conn->prepare($stmt2);
  $com2->bind_param("s",$_GET["custodian"]);
  $com2->execute();
  $record2=$com2->get_result();
  //$row=$record->fetch_assoc();
  ?>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total2; ?></p>
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                      <th scope="col">Accessories</th>
                    <th scope="col">status</th>
                      <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($record2->num_rows > 0) {
                  $count=1;  
                  while($rec2 = $record2->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $count ?></th>
                     <td><?php echo $rec2["accessory_name"];?></td>
                    <td><?php echo $rec2["status_desc2"];?></td>
                    <td><a class="badge bg-dark" href='#'>
                            Action<i class="bi bi-eye"></i>
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
                    <th scope="row" class="text-center"  colspan="7">No Accessories found with this employee</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>

</section>
	<div class="card">
 		 <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Transfer History</span></h1> 
         </div>
         
     </div>
<section class="section">
	<?php
 	$sql="select it.*,
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
WHERE it.to_custodian=? ORDER BY it.created_at DESC;";
 	  $tot_sql="select count(*) as c from item_transaction where to_custodian=?;";
 
 $comm=$conn->prepare($tot_sql);
 $comm->bind_param("s",$_GET["custodian"]);
 $comm->execute();
 $resu=$comm->get_result();
 $counting=$resu->fetch_assoc();
 $total=$counting["c"];

 
 $comma=$conn->prepare($sql);
 $comma->bind_param("s",$_GET["custodian"]);
 $comma->execute();
 $result=$comma->get_result();

 	 if ($result->num_rows>0) {
     $ct=1;
     ?>
    <div class="card">
               
     <div class="row">

   
      <?php

$firstrow = $result->fetch_assoc();
$latest=$firstrow["id"];
?>
<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-2">
   
           <div class="item item-info">
        <div class="shape">
          <div class="shape-text">
            Recent<br>(<?php echo date("M d Y",strtotime($firstrow["created_at"]));?>)               
          </div>
        </div>
        <div class="item-content">
          <div class="card-header  text-center" style="background:  #3D4!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $firstrow["item_name"]?></h5>
           <span class="badge bg-success rounded-pill mb-1"><?php echo $ct ?></span>
          </div>           
           <div class="card-body">
             <p class="card-text"><b>Item name: </b><r style="text-align: left;"><?php echo $firstrow["item_name"]?></r></p>
               <p class="card-text"><b>From Company: </b><r style="text-align: left;"><?php echo $firstrow["from_comp"]?></r></p>
               <p class="card-text"><b>To Company: </b><r style="text-align: left;"><?php echo $firstrow["to_comp"]?></r></p>
                <p class="card-text"><b>From Department: </b><r style="text-align: left;"><?php echo $firstrow["from_dep"]?></r></p>
                 <p class="card-text"><b>To Department: </b><r style="text-align: left;"><?php echo $firstrow["to_dep"]?></r></p>
               <p class="card-text"><b>From Warehouse: </b><r style="text-align: left;"><?php echo $firstrow["fw"]?></r></p>
                <p class="card-text"><b>To Warehouse: </b><r style="text-align: left;"><?php echo $firstrow["tw"]?></r></p>
                 <p class="card-text"><b>From Custodian: </b><r style="text-align: left;" class="bg bg-danger"><?php echo $firstrow["fc"]?></r></p>
                <p class="card-text"><b>To Custodian: </b><r style="text-align: left;" class="bg bg-warning"><?php echo $firstrow["tc"]?></r></p>
                <?php
     $taken=explode(":_:",$firstrow["received_acc"]);
     ?>
     <p class="card-text"><b>Received Accessory: </b>
      <?php
      foreach($taken as $eachtaken){
                if($eachtaken!=''){
                 ?>
                 <r style="text-align: left;"><?php echo $eachtaken.',' ?></r>
                 <?php 
                }
              }
              ?>
              </p>
              <?php
 $left=explode(":_:",$firstrow["released_acc"]);
 ?>
 <p class="card-text"><b>Released Accessory: </b>
  <?php
      foreach($left as $eachleft){
                if($eachleft!=''){
                 ?>
                 <r style="text-align: left;"><?php echo $eachleft.',' ?></r>
                 <?php 
                }
              }
              ?>
              </p>
              <?php
$new=explode(":_:",$firstrow["new_added"]);
?>
<p class="card-text"><b>Newly added Accessory: </b>
  <?php
      foreach($new as $eachnew){
                if($eachnew!=''){
                 ?>
                   <r style="text-align: left;"><?php echo $eachnew.',' ?></r>
                 <?php 
                }
              }
     ?>
      </p>         
        <p class="card-text"><b>Transferred by: </b><r style="text-align: left;"><?php echo $firstrow["created_by"]?></r></p>
               <p class="card-text"><b>Transferred at: </b><r style="text-align: left;"><?php echo date("M d, Y",strtotime($firstrow["created_at"]));?></r></p>
            <a class="badge bg-secondary" href='<?php echo "view-details-action.php?view_item=".$firstrow["item"];?>'>
                            More info<i class="bi bi-eye"></i></a>
          </div>
        </div>
      </div>
   
</div>
       
          
<?php
//mysqli_data_seek($result, 0);
$ct=$ct+1;
       while($row = $result->fetch_assoc()){
     $item=$row["item_name"];
     if ($row["id"]==$latest) {
       continue;
     }
     ?>   
  <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-2">
    <div class="card">
      <div class="card-header  text-center p-0" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo $row["item_name"]?></h5>
           <span class="badge bg-success rounded-pill mb-1"><?php echo $ct ?></span>
          </div>
            
            <div class="card-body">
               <p class="card-text"><b>Item name: </b><r style="text-align: left;"><?php echo $row["item_name"]?></r></p>
               <p class="card-text"><b>From Company: </b><r style="text-align: left;"><?php echo $row["from_comp"]?></r></p>
               <p class="card-text"><b>To Company: </b><r style="text-align: left;"><?php echo $row["to_comp"]?></r></p>
                <p class="card-text"><b>From Department: </b><r style="text-align: left;"><?php echo $row["from_dep"]?></r></p>
                 <p class="card-text"><b>To Department: </b><r style="text-align: left;"><?php echo $row["to_dep"]?></r></p>
               <p class="card-text"><b>From Warehouse: </b><r style="text-align: left;"><?php echo $row["fw"]?></r></p>
                <p class="card-text"><b>To Warehouse: </b><r style="text-align: left;"><?php echo $row["tw"]?></r></p>
                 <p class="card-text"><b>From Custodian: </b><r style="text-align: left;" class="bg bg-danger"><?php echo $row["fc"]?></r></p>
                <p class="card-text"><b>To Custodian: </b><r style="text-align: left;" class="bg bg-warning"><?php echo $row["tc"]?></r></p>
                <?php
     $taken=explode(":_:",$row["received_acc"]);
     ?>
     <p class="card-text"><b>Received Accessory: </b>
      <?php
      foreach($taken as $eachtaken){
                if($eachtaken!=''){
                 ?>
                 <r style="text-align: left;"><?php echo $eachtaken.',' ?></r>
                 <?php 
                }
              }
              ?>
              </p>
              <?php
 $left=explode(":_:",$row["released_acc"]);
 ?>
 <p class="card-text"><b>Released Accessory: </b>
  <?php
      foreach($left as $eachleft){
                if($eachleft!=''){
                 ?>
                 <r style="text-align: left;"><?php echo $eachleft.',' ?></r>
                 <?php 
                }
              }
              ?>
              </p>
              <?php
$new=explode(":_:",$row["new_added"]);
?>
<p class="card-text"><b>Newly added Accessory: </b>
  <?php
      foreach($new as $eachnew){
                if($eachnew!=''){
                 ?>
                   <r style="text-align: left;"><?php echo $eachnew.',' ?></r>
                 <?php 
                }
              }
     ?>
      </p>         
        <p class="card-text"><b>Transferred by: </b><r style="text-align: left;"><?php echo $row["created_by"]?></r></p>
               <p class="card-text"><b>Transferred at: </b><r style="text-align: left;"><?php echo date("M d, Y",strtotime($row["created_at"]));?></r></p>
            <a class="badge bg-secondary" href='#'>
                            More info<i class="bi bi-eye"></i></a>
                        
            </div>
             </div>
           </div>
        <?php
        $ct++;
      }?>
          </div>
       </div>
 
 <?php
}
?>
</section>
 	
    </main>
    <?php 
}
else{
  echo "<script>alert('Item with c-Id:".$_GET["custodian"]." not found');
  javascript:history.go(-1);

  </script>";
     
}

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
for(let i=1;i<=4;i++)
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
}
</script>