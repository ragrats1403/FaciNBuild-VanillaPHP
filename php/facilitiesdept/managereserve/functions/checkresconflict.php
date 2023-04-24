<?php
include('../../../connection/connection.php');

$datestart = $_POST['datestart'];
$dateend = $_POST['dateend'];
$actualdate = $_POST['actualdate'];
$facility = $_POST['facility'];

// convert date and time values to MySQL TIME format
$timestart = new DateTime($datestart);
$timeend = new DateTime($dateend);
$timestartStr = $timestart->format('Y-m-d H:i:s');
$timeendStr = $timeend->format('Y-m-d H:i:s');

$sql = "SELECT COUNT(*) AS tcount 
        FROM reservation 
        WHERE 
        actualdateofuse = '$actualdate' 
        AND fdstatus = 'Approved'
        AND facility = '$facility' 
        AND (
            ('$timestartStr' < timeend AND '$timeendStr' > timestart) OR
            ('$timestartStr' = timestart AND '$timeendStr' = timeend) OR
            ('$timestartStr' >= timestart AND '$timestartStr' < timeend) OR
            ('$timeendStr' > timestart AND '$timeendStr' <= timeend)
        )";

$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
?>