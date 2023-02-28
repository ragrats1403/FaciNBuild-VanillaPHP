<?php include('../../../connection/connection.php');
$minorjobid = $_POST['minorjobid'];
$sql = "SELECT * FROM minorjreq WHERE minorjobid='$minorjobid' LIMIT 1";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
