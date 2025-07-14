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
 <?php
 $check="select id from history where id=?;";

 $cmd=$conn->prepare($check);
 $cmd->bind_param("s",$_GET["view_history"]);
 $cmd->execute();
 $res=$cmd->get_result();
 if (isset($_GET['view_history'])&&$res->num_rows>0) {
  $fetch="SELECT items.item_name as Item_name, history.change_log,history.item,history.id, history.updated_by, history.updated_at FROM history INNER JOIN items on history.item=items.id WHERE history.id=? ORDER BY history.updated_at ASC;";
 

 $command=$conn->prepare($fetch);
 $command->bind_param("s",$_GET["view_history"]);
 $command->execute();
 $history=$command->get_result();
   if ($history->num_rows>0) {
   $record = $history->fetch_assoc();
   $recordid=$record["id"];
     $logg=$record["change_log"];
     $logs=explode(":_:",$logg);
 	?>
 <main id="main" class="main">
   <div class="card">
               
     <div class="row">
        <!--<hr class="hline col-lg-6">  -->        
     <div class="pagetitle">
     <br>
     <h1 class="decorated"><span>Details of <?php echo "<b class='text-primary' > Change:".$recordid."</b>"; ?><span></h1> 
         </div>
          <!-- <hr class="hline col-lg-3">-->
         
     </div>

   </div>
   <section class="section">
      <!--<div class="container">  -->
         <div class='row' data-aos="zoom-in">     
 
<!-- <h5 class="card-title"><?php echo $fetch;?></h5> -->
<div class="row">
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="card-body">
              <h5> <span class="badge bg-success rounded-pill"><?php echo "ID: ".$record["item"] ?></span></h5>
                <div class="row">

     <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
               <i class="card-text"><i style="text-align: left;"><?php echo "<b>Changes:</b><br>";?></i></i>
               <?php
               $ii=1;
               foreach($logs as $eachlog){
                if($eachlog!=''){?>
              <i><?php echo $recordid.".".$ii.". ".$eachlog;?>.</i><br>
               <?php } $ii++;}?>
              <i class="card-text"><b>As of:</b><i style="text-align: left;"><?php echo date("M d, Y H:i:s",strtotime($record["updated_at"]))?></i></i>
<!-- <div class="d-flex" style="height: 200px;">
  <div class="vr">
    
  </div>
        </div> -->
             <hr>
             <a class="badge bg-secondary" href='<?php echo "view-details-action.php?view_item=".$record["item"];?>'>
                            More info<i class="bi bi-eye"></i></a>
           </div>
         
          
</div>
            </div>
          </div>
        </div>
   
      </div>




    </section>
      </main>
       <?php 
        
       }
       ?>
  <?php }
  else {
   echo "<script>alert('History with Id:".$_GET["view_history"]." not found');
  javascript:history.go(-1);

  </script>";
  }
  ?>
      <?php include('../footer.html');?>


  <!-- Vendor JS Files -->
 <?php include('script.php');?>

</body>

</html>

<?php }else{
  header("location:../index.php");
}