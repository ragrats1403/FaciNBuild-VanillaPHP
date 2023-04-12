<?php include('../../../connection/connection.php');

$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$item = $_POST['item'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];

date_default_timezone_set('Asia/Manila');

// Get the current datetime in the server timezone
$date = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

// Set the timezone to your local timezone
$date->setTimezone(new DateTimeZone(date_default_timezone_get()));

// Format the date in your local timezone
$formatted_date = $date->format('Y-m-d H:i:s');

$message = "You have submitted a Major Job Request and is now Pending for approval.";
$facilitiesDeptmesg = "".$department." submitted a Major Job Request and is waiting for Approval\nCheck them in Manage Job Requests!";
$saoDeptmesg = "".$department." submitted a Major Job Request and is waiting for Approval\nCheck them in Manage Job Requests!";
$adminDeptmesg = "".$department." submitted a Major Job Request and is waiting for Approval\nCheck them in Manage Job Requests!";
$caddeptmsg = "".$department." submitted a Major Job Request and is waiting for Approval\nCheck them in Manage Job Requests!";

$sql = "INSERT INTO `majoreq` (`department`,`date`,`quantity`,`item`,`description`,`purpose`,`status`,`bdstatus`,`cadstatus`,`pcostatus`) VALUES ('$department','$date','$quantity','$item','$description','$purpose','Pending','Pending','Pending','Pending')";
$query = mysqli_query($con, $sql);
if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$department', '$formatted_date','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotiffaci = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$facilitiesDeptmesg', 'Building Department', '$formatted_date','0')";
    $facinotifquery = mysqli_query($con, $sqlnotiffaci);
    $sqlnotifsao = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$saoDeptmesg', 'Property Custodians Office', '$formatted_date','0')";
    $saonotifquery = mysqli_query($con, $sqlnotifsao);
    $sqlnotifadmin = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$adminDeptmesg', 'Administrator', '$formatted_date','0')";
    $adminnotifquery = mysqli_query($con, $sqlnotifadmin);
    $sqlnotifcad = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$adminDeptmesg', 'Campus Academic Directors Office', '$formatted_date','0')";
    $cadnotifquery = mysqli_query($con, $sqlnotifcad);
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
