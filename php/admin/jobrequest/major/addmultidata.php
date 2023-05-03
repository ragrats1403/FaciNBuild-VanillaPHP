<?php include('../../../connection/connection.php');


$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$requestedby = $_POST['requestedby'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$multinum = $_POST['multinum'];
$departmenthead = $_POST['departmenthead'];

date_default_timezone_set('Asia/Manila');


$sql = "INSERT INTO `multimajor` (`department`,`date`, `quantity`, `requestedby`,`item_desc`,`purpose`, `multinum`, `departmenthead`) VALUES ('$department','$date','$quantity','$requestedby','$description','$purpose','$multinum', '$departmenthead')";
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