<?php include('../../../connection/connection.php');

$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$item = $_POST['item'];
$section = $_POST['section'];
$description = $_POST['description'];


$sql = "INSERT INTO `majoreq` (`department`,`date`,`quantity`,`item`,`description`,`purpose`,`status`,`bdstatus`,`cadstatus`,`pcostatus`) VALUES ('$department','$date','$quantity','$item','$description','$purpose','Pending','Pending','Pending','Pending')";
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
