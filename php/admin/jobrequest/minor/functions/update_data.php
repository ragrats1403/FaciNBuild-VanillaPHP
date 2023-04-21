<?php include('../../../../connection/connection.php');


$id = $_POST['id'];
$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$sect = $_POST['sect'];
$feedback = $_POST['feedback'];
$notedby = $_POST['notedby'];
$approvedby = $_POST['approvedby'];
$requestedby = $_POST['requestedby'];






$sql = "UPDATE `minorjreq` SET `department` = '$department',`datesubmitted`='$date', `quantity`= '$quantity',`item_desc` = '$description', `purpose` = '$purpose', `section` = '$sect', `feedback` = '$feedback', `notedby` = '$notedby', `requestedby` = '$requestedby', `approvedby` = '$approvedby' WHERE minorjobid = '$id'";
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
