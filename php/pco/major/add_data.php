<?php include('../../connection/connection.php');

$requino = $_POST['requino'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$item = $_POST['item'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];

$sql = "INSERT INTO `majoreq` (`requino`,`department`,`date`,`quantity`,`item`,`description`,`purpose`,`status`,`bdstatus`,`cadstatus`,`pcostatus`) VALUES ('$requino','PCO','$date','$quantity','$item','$description','$purpose','Pending','Pending','Pending','Pending')";
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
