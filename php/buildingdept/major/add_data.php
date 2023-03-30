<?php include('../../connection/connection.php');

$requino = $_POST['requino'];
$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$item = $_POST['item'];
$section = $_POST['section'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$outsource = $_POST['outsource'];

$sql = "INSERT INTO `majoreq` (`requino`,`department`,`date`,`quantity`,`item`,`section`,`description`,`purpose`,`outsource`,`status`,`bdstatus`,`cadstatus`,`pcostatus`) VALUES ('$requino','$department','$date','$quantity','$item','$section','$description','$purpose','$outsource','Pending','Pending','Pending','Pending')";
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
