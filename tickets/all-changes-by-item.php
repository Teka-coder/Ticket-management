<?php 
session_start();
if($_SESSION['role']=="pad"||"admin"||"hq"||"edit"){
include ("../pad/recoredserver.php");

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
  $sql= "select * from comp where name = '$comp'";
  $sql="SELECT * FROM comp WHERE name=?";
  $command=$conn->prepare($sql) or die(mysqli_connect_error($conn));
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
 $check="select item from history where item=?;";
 $cmd=$conn->prepare($check) or die(mysqli_connect_error($conn));
 $cmd->bind_param("s",$_GET["all_changes"]);
 $cmd->execute();
 $res=$cmd->get_result();
 if (isset($_GET['all_changes'])&& $res->num_rows>0) {
  $fetch="SELECT items.item_name as Item_name, history.change_log,history.item,history.id, history.updated_by, history.updated_at FROM history INNER JOIN items on history.item=items.id WHERE history.item=? ORDER BY history.updated_at DESC;";
 
 $history=$conn->prepare($fetch) or die(mysqli_connect_error($conn));
 $history->bind_param("s",$_GET["all_changes"]);
 $history->execute();
 $line=$history->get_result();
 if ($line->num_rows>0) {
 	$recd = $line->fetch_assoc();
   	$iname=$recd["Item_name"];
 }
 $history->execute();
 $all=$history->get_result();
   if ($all->num_rows>0) {
    $num=$all->num_rows;
   
 	?>
   <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>All Change's Detail of <?php echo "<b class='text-primary' >".ucfirst($iname)."</b>"; ?></span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
 <div class='row' data-aos="zoom-in">
          <div class="pp5 col-lg-12" >
<div class="row">
  <?php
   while($record = $all->fetch_assoc()){
     $recordid=$record["id"];
     $logg=$record["change_log"];
     $logs=explode(":_:",$logg);
     ?>
   <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-2">
    <div class="card">
            <div class="card-body">
              <h5 > <span class="badge bg-success rounded-pill"><?php echo $num ?></span></h5>
                <div class="row">

     
               <i class="card-text"><i style="text-align: left;"><?php echo "<b><u>Changes:</u></b><br>";?></i></i>
               <?php
               $ii=1;
               foreach($logs as $eachlog){
                if($eachlog!=''){?>
              <i><?php echo $num.".".$ii.". ".$eachlog;?>.</i><br>
               <?php } $ii++;}?>
              <i class="card-text"><b>As of:</b><i style="text-align: left;"><?php echo date("M d, Y H:i:s",strtotime($record["updated_at"]))?></i></i>

             <hr>
         
         
          
</div>
            </div>
          </div>
        </div>
        <?php
        $num--;
      }?>
      </div>
</div>
 </section>
    <?php 
}
}
else{
  echo "<script>alert('Changes with Id:".$_GET["all_changes"]." not found');
  javascript:history.go(-1);

  </script>";
     
}
  ?>
      </main>
       
  
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../index.php");
}