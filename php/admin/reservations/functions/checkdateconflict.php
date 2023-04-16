<?php include('../../../connection/connection.php');
$facility = $_POST['facility'];
$actualdate = $_POST['actualdate'];
$timestart = $_POST['timestart'];
$timeend = $_POST['timeend'];
$sql = "SELECT COUNT(actualdateofuse) AS countval 
        FROM `reservation` 
        WHERE actualdateofuse = '$actualdate' 
        AND status = 'Approved' 
        AND facility = '$facility' 
        AND DATE_FORMAT(timestart, \"%H:%i\") = '$timestart' 
        AND DATE_FORMAT(timeend, \"%H:%i\") = '$timeend'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);