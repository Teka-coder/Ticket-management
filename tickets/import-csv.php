<?php
session_start();
include "../connection.php";
include "../phpqrcode/qrlib.php";
// $deleterecords = "TRUNCATE TABLE items"; //empty the table of its current records
// $command=$conn->query($deleterecords);
if(isset($_POST['import'])) {
$regby=mysqli_real_escape_string($conn, $_SESSION["username"]);
    if((isset($_FILES['csvfile']) && is_array( $_FILES['csvfile']))) {

        $csv = $_FILES['csvfile'];

        if(isset($csv['tmp_name']) && !empty($csv['tmp_name'])) {

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $csv['tmp_name']);
            finfo_close($finfo);

            $allowed_mime = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

            if(in_array($mime, $allowed_mime) && is_uploaded_file($csv['tmp_name'])) {
 $f = fopen($csv['tmp_name'], 'r');
 fgetcsv($f);
 //$query=FALSE;
                 $newdata = array();
                 $duplicated="";
                 $inserted=0;
                 $count=0;
                 $empty=0;
                while(($data = fgetcsv($f, 1000, ",")) !== FALSE) {
        
                    $qr = $data[0];
                    $s="select * from tickets where ticket_unique_id=?;";
                  
                    $c=$conn->prepare($s) or die(mysqli_connect_error());
                    $c->bind_param("s",$qr);
                    $c->execute();
                    $q=$c->get_result();
                    if (empty($data[0]) || empty($data[1]) ) {
                      $empty=$empty+1;
                      continue;
                    }
                    if ($q->num_rows > 0) {
                     // echo "An item with ".$qr." is already exist <br>";
                      $count=$count+1;
                      $duplicated.=$qr.'';
                      continue;
                    }
                    $ticketid=$data[0]; 
                     // Remove commas from the price field
    $ticketprice = str_replace(',', '', $data[1]);
                    //$ticketprice=$data[1];
                    $generalremark=$data[2];
   
    $qrplain="Ticket_".$data[0];
    $tempDir = "C:\\wamp64\www\\tvs\QR_code\\";
    $fileNamepng = $qrplain.'.png';
   // $qrcode = 'Ticket_'.md5($qrplain);
    $pngAbsoluteFilePath = $tempDir.$fileNamepng;
    
    //if (!file_exists($pngAbsoluteFilePath)) {
        // QRcode::png($qrcode, $pngAbsoluteFilePath);
        QRcode::png($qrplain, $pngAbsoluteFilePath, 'H', 4, 4);
        $urlRelativeFilePath = $fileNamepng;
  
         $sql="INSERT INTO tickets(ticket_unique_id,price,general_remark,qr_code,inserted_by,qr_plain) VALUES(?,?,?,?,?,?)";

    // echo $sql;
          
           $cmd=$conn->prepare($sql);
           $cmd->bind_param("ssssss",$ticketid,$ticketprice,
          $generalremark,$qrplain,
          $regby,$fileNamepng);
          $cmd->execute();
            $inserted=$inserted+1; 
                }
                //echo $duplicated;
//  $_SESSION['completed']=''.$inserted.' row inserted'.'<br>Total:'.$count.' records are not imported because of Duplication. Check again the following ID;'.' '.$duplicated.'<br>'.$empty." Rows with empty Ticket ID are found!";
$_SESSION['completed']=''.$inserted.' row inserted';
header( "location:".$_SERVER['HTTP_REFERER']); 
 fclose($f);
    
            }
             else {
  $_SESSION['notposted']="Ooops! The file type is not allowed!";
 header( "location:".$_SERVER['HTTP_REFERER']);  
}  
        }
       
    }
    else {
  $_SESSION['notposted']="Ooops! The file type is empty!";
 header( "location:".$_SERVER['HTTP_REFERER']);  
}  
}
       else {
  $_SESSION['notposted']="Ooops! Post error!";
 header( "location:".$_SERVER['HTTP_REFERER']);  
}

?>





       
    
    