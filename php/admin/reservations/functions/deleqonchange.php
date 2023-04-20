<?php include('../../../connection/connection.php');

$eventname = $_POST['eventname'];
$actualdate = $_POST['actualdate'];
$datesubmitted = $_POST['datesubmitted'];
$timestart = $_POST['timestart'];
$timeend = $_POST['timeend'];
$sql = "DELETE FROM eqreservation 
        WHERE eventname='$eventname' 
        AND dateofusage ='$actualdate' 
        AND datesubmitted ='$datesubmitted'
        AND timestart ='$timestart'
        AND timeend ='$timeend'";
$query = mysqli_query($con, $sql);
if ($query == true) 
{
    $data = array(
       'status'=>'success',
      
   );
   echo json_encode($data);
}
else
{
    $data = array(
       'status'=>'failed',
     
   );

   echo json_encode($data);
}
