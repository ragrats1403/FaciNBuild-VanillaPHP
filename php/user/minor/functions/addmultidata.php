<?php include('../../../connection/connection.php');


$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$requestedby = $_POST['requestedby'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$multinum = $_POST['multinum'];

date_default_timezone_set('Asia/Manila');


$sql = "INSERT INTO `minorjreq` (`department`,`datesubmitted`, `quantity`, `requestedby`,`item_desc`,`purpose`, `bdstatus`,`status`) VALUES ('$department','$date','$quantity','$requestedby','$description',' $purpose','Pending', 'Pending')";
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




?>