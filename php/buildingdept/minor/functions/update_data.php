<?php include('../../../connection/connection.php');


$id = $_POST['id'];
$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$itemname = $_POST['itemname'];
$description = $_POST['description'];
$section = $_POST['section'];
$purpose = $_POST['purpose'];
$feedback = $_POST['feedback'];



$sql = "UPDATE `minorjreq` SET `department` = '$department',`datesubmitted`='$date', `quantity`= '$quantity', `item`='$itemname',`item_desc` = '$description', `section` = '$section',`purpose` = '$purpose', `feedback` = '$feedback' WHERE minorjobid = '$id'";
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
