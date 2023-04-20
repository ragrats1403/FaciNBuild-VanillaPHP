<?php include('../../../connection/connection.php');



$id = $_POST['id'];
$dept = $_POST['dept'];
$feedb = $_POST['feedb'];

// Set the default timezone of the server
date_default_timezone_set('Asia/Manila');

// Get the current datetime in the server timezone
$date = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

// Set the timezone to your local timezone
$date->setTimezone(new DateTimeZone(date_default_timezone_get()));

// Format the date in your local timezone
$formatted_date = $date->format('Y-m-d H:i:s');

$sql = "UPDATE `majoreq` SET `cadstatus`='Declined', `status`='Declined', `feedback` = '$feedb' WHERE jobreqno = '$id'";

$message = "Campus Academic Directors Office declined your Job Request with Job Request no: ".$id."!\nYou can check your request status at Major Job Request Section.";
$message2 = "You successfully declined a Major Job Request from ".$dept." with Job Request No. ".$id."";
$query = mysqli_query($con, $sql);

if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$dept', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotif2 = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message2', 'Campus Academic Directors Office', '$formatted_date','0')";
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
