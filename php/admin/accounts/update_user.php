<?php include('../../connection/connection.php');

$id = $_POST['id'];
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$rolelevel = $_POST['rolelevel'];

$sql = "UPDATE `users` SET `department` = '$name',`username`='$username', `password`= '$password', `rolelevel`='$rolelevel' WHERE id = '$id'";
$query = mysqli_query($con, $sql);

if ($query == true) {
    $data = array(
        'status' => 'success',
    );
    echo json_encode($data);
} else {
    $data = array(
        'status' => 'failed',
    );
    echo json_encode($data);
}
