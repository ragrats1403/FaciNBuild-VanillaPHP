<?php include('../../../connection/connection.php');
$eventname = $_POST['eventname'];
$actualdate = $_POST['actualdate'];
$reqsource = $_POST['reqsource'];
$sql = "SELECT * FROM minorjreq WHERE eventname='$eventname' AND reservationdateuse ='$actualdate' AND reqsource ='$reqsource' LIMIT 1";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
