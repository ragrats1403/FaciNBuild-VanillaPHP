<?php include('../../connection/connection.php');

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$rolelevel = $_POST['rolelevel'];




$sql = "INSERT INTO `users` (`username`,`password`,`rolelevel`,`department`) VALUES ('$username','$password','$rolelevel','$name')";
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
