<?php 
session_start();
include('../connection.php');
if($_GET['type'] == 'counted')
{
    $perfect=0;
    $imperfect=0;
    $vehcountedy=0;
    $sql2y ="select * from `vehicle` where company='".$_GET['data']."'";
    $result2y = $conn1->query($sql2y);
    $vehcountedy = $result2y->num_rows;  
    $sql ="select * from `inspection` where company='".$_GET['data']."'";
    $result = $conn->query($sql);
    $counted = $result->num_rows;
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()){
        if($row['int_notokay'] =='' && $row['ex_notokay'] =='')
            $perfect++;
            else 
            $imperfect++;      
        }
    }
    echo '
    <h5 class="card-title">Total Inspection Conducted<span>| '.$_GET['data'].'</span></h5>                
    <ul class="list-group list-group-flush" id="counted">     
    <li class="list-group-item d-flex justify-content-between  align-items-center"><i class="bi bi-search me-1 text-primary">Total Inspection</i>                  
    <span class="badge bg-primary rounded-pill">'.$counted.'</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-star me-1 text-success">Perfect Inspection</i>
    <span class="badge bg-primary rounded-pill">'.$perfect.'/'.$counted.'</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-exclamation-octagon me-1 text-danger">Faulty Inspection</i>
    <span class="badge bg-primary rounded-pill"> '.$imperfect.'/'.$counted.'</span>
    </li>   
    </ul>             
    ';
}
elseif($_GET['type'] == 'vehcounted'){   
    $sql2 ="select * from `vehicle` where company='".$_GET['data']."'";
    $result2 = $conn1->query($sql2);
    $vehcounted = $result2->num_rows;
    $inspected=0;
    $notinspected=0;   
    if ($result2->num_rows > 0) { 
    while($row2 = $result2->fetch_assoc()){
        $plate = $row2['plateno'];
    $query="select * from `inspection` where MONTH(inspection_date)=MONTH(NOW())";
    $result3 = $conn->query($query); 
    if ($result3->num_rows > 0) { 
        while($row3 = $result3->fetch_assoc()){  
            if($row3['plateno']==$row2['plateno'])
            $inspected++;
    //$inspected = $result3->num_rows; 
   // $notinspected = $vehcounted - $inspected;               
        }
        $notinspected = $vehcounted - $inspected; 
        if($vehcounted == $inspected)
        $status ='Compeleted';
        else
        $status ='Not Compeleted';
    }

}
    }
    echo'
    <h5 class="card-title">This month vehicle status<span>| '.$_GET['data'].'</span></h5>
    <li class="list-group-item d-flex justify-content-between  align-items-center"><i class="ri-roadster-line me-1 text-primary">Total Vehicle</i>                  
    <span class="badge bg-primary rounded-pill">'.$vehcounted.'</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-star me-1 text-success">Inspected Vehicle</i>
    <span class="badge bg-primary rounded-pill">'.$inspected.'</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-exclamation-octagon me-1 text-danger">Uninspected Vehicle</i>
    <span class="badge bg-primary rounded-pill">'. $notinspected.'</span>
    </li>
    <li class="list-group-item text-center"><strong>Inspection Status:</strong>&nbsp
    <span class=""> '.$status.'</span>
    </li>              
    ';
}
elseif($_GET['type'] == 'maincounted'){
    $compeleted=0;
    $notcompeleted=0;  
$sql3="select * from `maintenance` where company='".$_GET['data']."' GROUP BY update_date";
$result4 = $conn->query($sql3);
    $maincounted = $result4->num_rows;
    if ($result4->num_rows > 0) { 
        while($row4 = $result4->fetch_assoc()){
        if($row4['job_status']!='notdone')
        $compeleted++;
        elseif($row4['job_status']!='done')
        $notcompeleted++;
        }
        }
echo ' <h5 class="card-title">Total Maintenance Conducted<span>| '.$_GET['data'].'</span></h5>
<ul class="list-group list-group-flush" id="maincounted">
<li class="list-group-item d-flex justify-content-between  align-items-center"><i class="bi bi-wrench me-1 text-primary">Total Maintenance</i>                  
<span class="badge bg-primary rounded-pill">'.$maincounted.'</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-star me-1 text-success">Compeleted</i>
<span class="badge bg-primary rounded-pill">'.$compeleted.'</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-exclamation-octagon me-1 text-danger">Not Compeleted</i>
<span class="badge bg-primary rounded-pill">'.$notcompeleted.'</span>
</li>';
}
elseif($_GET['type'] == 'date'){  
echo '<h5 class="card-title text-center">Inspection Summary<span>| '.$_GET['data'].'</span></h5>
<div class="col-lg-12">
<div class="row">
<div class="col d-flex align-items-center">
<span class="btn btn-primary disabled">Company list <i class="bi bi-arrow-right"></i> Inspection done/Total vehicle</span> 
</div>
<br></div></div><br>
';
$sql5="select * from vehicle GROUP BY company";
$result6 = $conn1->query($sql5);
if ($result6->num_rows > 0){                 
  while($row6 = $result6->fetch_assoc()){
 if($_GET['data']== 'This month'){     
$sql4 = "select * from `inspection` where MONTH(inspection_date) = MONTH(NOW()) and YEAR(inspection_date) = YEAR(NOW()) and company = '".$row6['company']."'";
$result5 = $conn->query($sql4);
$var = $result5->num_rows; 
$que ="select * from `vehicle` where company='".$row6['company']."'";
$res = $conn1->query($que);
$vehnum = $res->num_rows;
echo'
<div class="col-lg-6">
<div class="row">
<div class="col">
<span class="column btn disabled">'.$row6['company'].'<i class="bi bi-arrow-right"></i>'.$var.'/'.$vehnum.'</span>  
</div>
</div>
</div>
'; 
 }
 elseif($_GET['data']== 'Previous month'){
    $sql6 = "select * from `inspection` where MONTH(inspection_date) = MONTH(now() - interval 1 month) and YEAR(inspection_date) = YEAR(now()- interval 1 month) and company = '".$row6['company']."'";
    $result7 = $conn->query($sql6);
    $pvar = $result7->num_rows;
    $que2 ="select * from `vehicle` where company='".$row6['company']."'";
    $res2 = $conn1->query($que2);
    $vehnum2 = $res2->num_rows;      
    echo'  
    <div class="col-lg-12">
    <div class="row">
    <div class="col">
    <span class="column btn disabled">'.$row6['company'].'<i class="bi bi-arrow-right"></i>'.$pvar.'/'.$vehnum2.'</span>  
    </div>
    </div>
    </div>'; 
 }
 elseif($_GET['data']== 'This year'){
    $sql7 = "select * from `inspection` where YEAR(inspection_date) = YEAR(now()) and company = '".$row6['company']."'";
    $result8 = $conn->query($sql7);
    $yvar = $result8->num_rows;
    $que3 ="select * from `vehicle` where company='".$row6['company']."'";
    $res3 = $conn1->query($que3);
    $vehnum3 = $res3->num_rows;       
    echo'
    <div class="col-lg-12">
    <div class="row">
    <div class="col">
    <span class="column btn disabled">'.$row6['company'].'<i class="bi bi-arrow-right"></i>'.$yvar.'/'.$vehnum3.'</span>  
    </div>
    </div>
    </div>'; 
 }  
}
}
echo'</div>
</div>';
}
?>