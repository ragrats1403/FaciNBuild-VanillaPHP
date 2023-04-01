<?php

$host = "localhost";
$user = "root";
$password = "";
$db_name = "testdb";

// Connect to the database
$con = mysqli_connect($host, $user, $password, $db_name);

// Check for errors
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Query the database for unread notifications
$sql = "SELECT * FROM notif_data WHERE is_read = 0 ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);

// Fetch the results as an array of associative arrays
$notifications = array();
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}

// Return the notifications as JSON
header("Content-Type: application/json");
echo json_encode($notifications);
