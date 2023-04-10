<?php include('../../../connection/connection.php');
$eventname = $_POST['eventname'];
$actualdate = $_POST['actualdate'];
$datesubmitted = $_POST['datesubmitted'];
$timestart = $_POST['timestart'];
$timeend = $_POST['timeend'];
    $sql = "SELECT * FROM eqreservation 
            WHERE eventname='$eventname' 
            AND dateofusage ='$actualdate' 
            AND datesubmitted ='$datesubmitted'
            AND timestart ='$timestart'
            AND timeend ='$timeend'";

$data = array();
$query = mysqli_query($con,$sql);
//$row = mysqli_fetch_assoc($query);
while ($row = mysqli_fetch_assoc($query)) {
    $subarray = array();
    $subarray[] = $row['eqname'];
    $subarray[] = $row['quantity'];
    $data[] = $subarray;
    
}
echo json_encode($data);
