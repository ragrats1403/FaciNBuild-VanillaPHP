<?php include('../../../connection/connection.php');


$id = $_POST['id'];
$dept = $_POST['dept'];
$feedb = $_POST['feedb'];

/*
bdstatus
cadstatus
pcostatus
*/
date_default_timezone_set('Asia/Manila');

// Get the current datetime in the server timezone
$date = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

// Set the timezone to your local timezone
$date->setTimezone(new DateTimeZone(date_default_timezone_get()));

// Format the date in your local timezone
$formatted_date = $date->format('Y-m-d H:i:s');

$message = "Student Affairs Office declined your Reservation Request with Request no: ".$id."!\nYou can check your request status at Reservation Section.";
$message2 = "You successfully declined a Reservation Request from ".$dept." with Request No. ".$id."";
$sql = "UPDATE `reservation` SET `saostatus` = 'Declined', `status` = 'Declined', `feedback` = '$feedb' WHERE reservationid = '$id'";
$query = mysqli_query($con, $sql);


if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$dept', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotif2 = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message2', 'Student Affairs Office', '$formatted_date','0')";
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
