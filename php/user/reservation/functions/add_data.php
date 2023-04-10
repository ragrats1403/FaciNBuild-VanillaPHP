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
/*$renderedby = $_POST['renderedby'];
$daterendered = $_POST['daterendered'];
$confirmedby = $_POST['confirmedby'];
$dateconfirmed = $_POST['dateconfirmed'];*/

//notify to admin using notification
/*
$psql = "INSERT INTO reservation VALUES ('$eventname')";
if(mysqli_query($con, $psql)){
echo "New reservation request has arrived: " . $eventname;
}
else{
echo "Error: ". $psql . "<br>" . mysqli_error($con); 
}*/


//notification message construct start
$datestr = date('Y-m-d H:i:s');
$date = new DateTime($datestr);
$formatted_date = $date->format('F d, Y g:iA');

$actualdatestr = date($actualdate);
$adate = new DateTime($actualdatestr);
$aformatted_date = $adate->format('F d, Y');

$message = "You have submitted your facility reservation to use on \n".$aformatted_date."";


//notification message construct end


$sql = "INSERT INTO `reservation` (`eventname`, `facility`, `requestingparty`, `purposeofactivity`, `datefiled`, `actualdateofuse`, `timestart`, `timeend`, `participants`, `stageperformers`, `adviser`, `chairperson`, `status`, `fdstatus`, `saostatus`) VALUES ('$eventname','$faci','$reqparty',' $purpose', '$datefiled', '$actualdate', '$timein', '$timeout', '$numparticipants', '$stageperf', '$adviser', '$chairman', 'Pending', 'Pending', 'Pending')";
$query = mysqli_query($con, $sql);
if ($query == true) {
    $sqlnotif = "INSERT INTO `notif_data` (`message`, `department`, `created_at`, `is_read`) VALUES ('$message', '$reqparty', '$datestr','0')";
    $notifquery = mysqli_query($con, $sqlnotif);
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