<?php include('../../../connection/connection.php');


$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$eventname = $_POST['eventname'];
$actualdate = $_POST['actualdate'];
$reqparty = $_POST['reqparty'];
$requestedby = $_POST['requestedby'];

date_default_timezone_set('Asia/Manila');

// Get the current datetime in the server timezone
$adate = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

// Set the timezone to your local timezone
$adate->setTimezone(new DateTimeZone(date_default_timezone_get()));

// Format the date in your local timezone
$formatted_date = $adate->format('Y-m-d H:i:s');

$message = "You have submitted a Minor Job Request and is now Pending for approval.";
$facilitiesDeptmesg = "".$department." submitted a Minor Job Request and is waiting for Approval\nCheck them in Manage Job Requests1";
$adminDeptmesg = "".$department." submitted a Minor Job Request and is waiting for Approval\nCheck them in Manage Job Requests!";


$sql = "INSERT INTO `minorjreq` (`department`,`datesubmitted`, `quantity`,`item_desc`,`purpose`, `bdstatus`,`status`,`eventname`,`reqsource`,`reservationdateuse`, `requestedby`) VALUES ('$department','$date','$quantity','$description',' $purpose','Pending','Pending',' $eventname',' $reqparty',' $actualdate', '$requestedby')";
$query = mysqli_query($con, $sql);
if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$department', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotiffaci = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$facilitiesDeptmesg', 'Building Department', '$formatted_date','0')";
    $facinotifquery = mysqli_query($con, $sqlnotiffaci);
    $sqlnotifadmin = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$adminDeptmesg', 'Administrator', '$formatted_date','0')";
    $adminnotifquery = mysqli_query($con, $sqlnotifadmin);
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