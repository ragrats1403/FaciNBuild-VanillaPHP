<?php include('../../../connection/connection.php');

//variables
$eventname = $_POST['eventname'];
$datefiled = $_POST['datefiled'];
$actualdate = $_POST['actualdate'];
$timein = $_POST['timein'];
$timeout = $_POST['timeout'];
$reqparty = $_POST['reqparty'];
$purpose = $_POST['purpose'];
$numparticipants = $_POST['numparticipants'];
$stageperf = $_POST['stageperf'];
$adviser = $_POST['adviser'];
$chairman = $_POST['chairman'];
$faci = $_POST['faci'];



//notification message construct start
// Set the default timezone of the server
// Set the default timezone of the server
date_default_timezone_set('Asia/Manila');

// Get the current datetime in the server timezone
$adate = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
// Set the timezone to your local timezone
$adate->setTimezone(new DateTimeZone(date_default_timezone_get()));
// Format the date in your local timezone
$newdate = $adate->format('Y-m-d H:i:s');
// Format the date in your local timezone
$formatted_date = $adate->format('F d, Y g:iA');




// Get the actual date in the default timezone of the server
$actualdatestr = date('Y-m-d H:i:s', strtotime($actualdate));
$adate = new DateTime($actualdatestr);

// Format the actual date in the default timezone of the server
$aformatted_date = $adate->format('F d, Y');
    


$message = "You have submitted your facility reservation to use on \n".$aformatted_date." and is now Pending for approval!";
$facilitiesDeptmesg = "".$reqparty." submitted a facility reservation request to use on ".$aformatted_date." and is waiting for Approval\nCheck them in Manage Reservations!";
$saoDeptmesg = "".$reqparty." submitted a facility reservation request to use on ".$aformatted_date." and is waiting for Approval\nCheck them in Manage Reservations!";
$adminDeptmesg = "".$reqparty." submitted a facility reservation request to use on ".$aformatted_date." and is waiting for Approval\nCheck them in Manage Reservations!";
//notification message construct end
$sql = "INSERT INTO `reservation` (`eventname`, `facility`, `requestingparty`, `purposeofactivity`, `datefiled`, `actualdateofuse`, `timestart`, `timeend`, `participants`, `stageperformers`, `adviser`, `chairperson`, `status`, `fdstatus`, `saostatus`) VALUES ('$eventname','$faci','$reqparty',' $purpose', '$datefiled', '$actualdate', '$timein', '$timeout', '$numparticipants', '$stageperf', '$adviser', '$chairman', 'Pending', 'Pending', 'Pending')";
$query = mysqli_query($con, $sql);
if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$reqparty', '$newdate','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
    $sqlnotiffaci = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$facilitiesDeptmesg', 'Facilities Department', '$newdate','0')";
    $facinotifquery = mysqli_query($con, $sqlnotiffaci);
    $sqlnotifsao = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$saoDeptmesg', 'Student Affairs Office', '$newdate','0')";
    $saonotifquery = mysqli_query($con, $sqlnotifsao);
    $sqlnotifadmin = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$adminDeptmesg', 'Administrator', '$newdate','0')";
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