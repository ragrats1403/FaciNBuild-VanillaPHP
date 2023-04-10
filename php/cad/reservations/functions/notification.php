<?php
include('../../../connection/connection.php');

$department = $_POST['department'];
// Check for errors
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Query the database for unread notifications
$sql = "SELECT * FROM notif_data WHERE is_read = 0 and department = '$department' ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);
// Fetch the results as an array of associative arrays


// Return the notifications as JSON
//header("Content-Type: application/json");
$arr = array();
while ($row = mysqli_fetch_assoc($result)) {
    $arr[] = $row;
}
echo json_encode($arr);
