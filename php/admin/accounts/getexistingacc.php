<?php include('../../connection/connection.php');
$department = $_POST['department'];
$sql = "SELECT COUNT(department) as countnum FROM `users` WHERE department = '$department'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
