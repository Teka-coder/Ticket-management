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
 
$check="select id from item_transaction where id=?;";
$cmd=$conn->prepare($check) or die(mysqli_connect_error($conn));
$cmd->bind_param("s",$_GET["view_transfer"]);
$cmd->execute();
$res=$cmd->get_result();
if (isset($_GET['view_transfer'])&& $res->num_rows>0) {
 	$sql="SELECT * from (SELECT item_transaction.*,warehouse.warehouse_code as fw,item_holder.holder_name as fc,items.item_name FROM item_transaction INNER join item_holder on (item_transaction.from_custodian=item_holder.id) INNER JOIN warehouse on (item_transaction.from_warehouse=warehouse.id) INNER JOIN items on (items.id=item_transaction.item) WHERE item_transaction.id=?) as l INNER join (SELECT warehouse.warehouse_code as tw,item_holder.holder_name as tc FROM item_transaction INNER join item_holder on (item_transaction.to_custodian=item_holder.id) INNER JOIN warehouse on (item_transaction.to_warehouse=warehouse.id) WHERE item_transaction.id=? ) as r ORDER BY item_transaction.created_at DESC;";
 
 //echo "<div class='card'><h3>".$sql."</h3></div>";
  $com=$conn->prepare($sql) or die(mysqli_connect_error($conn));
  $com->bind_param("ss",$_GET["view_transfer"],$_GET["view_transfer"]);
  $com->execute();
  $resu=$com->get_result();
  if ($resu->num_rows>0) {
    $row = $resu->fetch_assoc();
    $id=$row["id"];
  ?>
 <main id="main" class="main">
    <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Detail View Of <?php echo "<b class='text-primary' > Transaction:".$id."</b>"; ?> <span></h1> 
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
      <div class="card-header  text-center" style="background:  #093c73!important;">
           <h5 class="card-title" style="color: #fff"><?php echo ucfirst($row["item_name"])?></h5>
           <span class="badge bg-success rounded-pill"><?php echo "ID: ".$row["id"] ?></span>
          </div>
            
            <div class="card-body">
               <p class="card-text"><b>Item name: </b><r style="text-align: left;"><?php echo $row["item_name"]?></r></p>
               <p class="card-text"><b>From Company: </b><r style="text-align: left;"><?php echo $row["from_comp"]?></r></p>
               <p class="card-text"><b>To Company: </b><r style="text-align: left;"><?php echo $row["to_comp"]?></r></p>
                <p class="card-text"><b>From Department: </b><r style="text-align: left;"><?php echo $row["from_dep"]?></r></p>
                 <p class="card-text"><b>To Department: </b><r style="text-align: left;"><?php echo $row["to_dep"]?></r></p>
               <p class="card-text"><b>From Warehouse: </b><r style="text-align: left;"><?php echo $row["fw"]?></r></p>
                <p class="card-text"><b>To Warehouse: </b><r style="text-align: left;"><?php echo $row["tw"]?></r></p>
                 <p class="card-text"><b>From Custodian: </b><r style="text-align: left;" class="badge bg bg-danger"><?php echo $row["fc"]?></r></p>
                <p class="card-text"><b>To Custodian: </b><r style="text-align: left;" class="badge bg bg-warning"><?php echo $row["tc"]?></r></p>
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
             <a class="badge bg-secondary" href='<?php echo "view-details-action.php?view_item=".$row["item"];?>'>
                            More info<i class="bi bi-eye"></i></a>
                        
            </div>
             </div>
           </div>
        


        <?php
        
     ?>
           
           
         </div>
       </div>
 </section>
 
    <section>
  
    </section>


    </main>
    <?php 
}
}
  else{
  echo "<script>alert('Transfer with Id:".$_GET["view_transfer"]." not found');
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
//       <h1>NO transfer history found</h3>
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