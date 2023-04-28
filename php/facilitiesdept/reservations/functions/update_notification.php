<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "testdb";

$department = $_POST['department'];

// Connect to the database
$con = mysqli_connect($host, $user, $password, $db_name);

// Check for errors
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Receive request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // make is_read column to 1
  $sql = "UPDATE notif_data SET is_read = 1 where department = '$department'";
  
  // Execute sql statement
  if (mysqli_query($con, $sql)) {
    echo "All notifications marked as read.";
  } else {
    echo "Error updating notifications: " . mysqli_error($con);
  }
}

// Close database con
mysqli_close($con);