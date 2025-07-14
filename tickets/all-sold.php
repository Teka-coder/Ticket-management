<section class="section">
<div class="row">

<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
<?php
$val='soldout'; 
 $stmt= "SELECT * from tickets WHERE soldout_status=? AND sold_by=?  ORDER BY date_booked DESC";
$tot_sql="select count(*) as c from tickets where soldout_status=? AND sold_by=?;";
  $tot_cmd=$conn->prepare($tot_sql) or die(mysqli_connect_error($conn));;
  $tot_cmd->bind_param("ss",$val,$_SESSION['username']);
  $tot_cmd->execute();
  $resu=$tot_cmd->get_result();
  $counting=$resu->fetch_assoc();
  $total=$counting["c"];

  $result = $conn->prepare($stmt) or die(mysqli_connect_error($conn));
  $result->bind_param("ss",$val,$_SESSION['username']);
  $result->execute();
  $record=$result->get_result();
  ?>
            <div class="card">
      <div class="card-header  text-center p-0 card-header bg-dark">
           <h5 class="card-title text-white">Out Of Stock List</h5>
          </div>
           <div class="card-body">
             <p><code>Total</code>:<?php echo $total; ?></p>
             <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ticket ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Phone</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ( $record->num_rows>0) {  
                     $ct=$record->num_rows; 
                  while($rec = $record->fetch_assoc()){
                    ?>
                  <tr>
                    <th scope="row"><?php echo $ct;?></th>
                    <td><?php echo $rec["ticket_unique_id"];?></td>
                    <td><?php echo $rec["customer_name"];?></td>
                    <td><?php echo $rec["customer_phone"];?></td>
                    <td><a class="badge bg-dark" href='<?php echo "outofstock-record.php?all_type1=".$rec["id"];?>'>
                            Detail<i class="bi bi-eye"></i>
                          </a></td>
                  </tr>
                  <?php
                 $ct--;}}
                else
                {
                  ?>
                  <tr>
                    <th scope="row " class="text-center"  colspan="5">No record found</th>
                  </tr>
                    <?php
                }
                ?>
                  
                </tbody>
              </table>
           </div>
        </div>
</div>
</div> 
            
</section>