<?php include('../../../connection/connection.php');


$id = $_POST['id'];
$dept = $_POST['dept'];
$feedb = $_POST['feedb'];
$approvedby = $_POST['approvedby'];
$section = $_POST['section'];
$notedby = $_POST['notedby'];
/*
bdstatus
cadstatus
pcostatus
*/
// Set the default timezone of the server
date_default_timezone_set('Asia/Manila');

// Get the current datetime in the server timezone
$date = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

// Set the timezone to your local timezone
$date->setTimezone(new DateTimeZone(date_default_timezone_get()));

// Format the date in your local timezone
$formatted_date = $date->format('Y-m-d H:i:s');


$sql = "UPDATE `minorjreq` SET `notedby` = '$notedby', `section` = '$section', `approvedby` = '$approvedby', `bdstatus` = 'Approved', `status`='Approved', `feedback` = '$feedb' WHERE minorjobid = '$id'";
$query = mysqli_query($con, $sql);
$message = "Building Department approved your Job Request with Job Request no: ".$id."!\nYou can check your request status at Minor Job Request Section.";
$message2 = "You successfully approved a Minor Job Request from ".$dept." with Job Request No. ".$id."";
if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$dept', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotif2 = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message2', 'Building Department', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif2);
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
