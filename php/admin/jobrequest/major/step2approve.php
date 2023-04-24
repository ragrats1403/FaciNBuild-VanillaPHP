<?php include('../../../connection/connection.php');

$id = $_POST['id'];
$reqno = $_POST['reqno'];
$dept = $_POST['dept'];
$feedb = $_POST['feedb'];
$pcoapprovedby = $_POST['pcoapprovedby'];
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

$sql = "UPDATE `majoreq` SET `pcoapprovedby` = '$pcoapprovedby', `pcostatus`= 'Approved', `requino` = '$reqno', `feedback` = '$feedb', `status` = 'Pending'  WHERE jobreqno = '$id'";
$query = mysqli_query($con, $sql);


$message = "Property Custodians Office approved your Job Request with requistion no: ".$reqno."!\nYou can check your request status at Major Job Request Section.";
$message2 = "You successfully approved a Major Job Request from ".$dept." with Job Request No. ".$id." and Requisition No: ".$reqno."";
if ($query == true) {
    $sql2 = "INSERT INTO `requisition` (`jobreqno`) VALUES ('$id')";
    $query2 = mysqli_query($con, $sql2);
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$dept', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotif2 = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message2', 'Property Custodians Office', '$formatted_date','0')";
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
