<?php include('../../../connection/connection.php');
$department = $_POST['department'];
$requestedby = $_POST['requestedby'];
$datesubmitted = $_POST['datesubmitted'];
$purpose = $_POST['purpose'];
$multinum = $_POST['multinum'];
$sql = "SELECT * 
        FROM multiminor 
        WHERE department = '$department' 
        AND datesubmitted = '$datesubmitted' 
        AND requestedby = '$requestedby' 
        AND purpose = '$purpose'
        AND multinum = '$multinum'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);

