<?php include('../../../connection/connection.php');

$jobreqno = $_POST['jobreqno'];
$requino = $_POST['requino'];
$department = $_POST['department'];
$quantity = $_POST['quantity'];
$item = $_POST['item'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];

$sql = "UPDATE `majoreq` SET `requino`='$requino', `department`= '$department', `quantity`='$quantity',`item` = '$item' ,`description` = '$description' ,`purpose` = '$purpose' WHERE jobreqno = '$jobreqno'";
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
