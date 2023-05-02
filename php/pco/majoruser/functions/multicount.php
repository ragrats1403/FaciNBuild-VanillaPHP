<?php include('../../../connection/connection.php');
$department = $_POST['department'];
$requestedby = $_POST['requestedby'];
$datesubmitted = $_POST['datesubmitted'];
$purpose = $_POST['purpose'];
$sql = "SELECT COUNT(*) as count
        FROM `multimajor` 
        WHERE department = '$department' 
        AND date = '$datesubmitted' 
        AND requestedby = '$requestedby' 
        AND purpose = '$purpose'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
