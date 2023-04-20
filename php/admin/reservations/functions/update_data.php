<?php include('../../../connection/connection.php');

//variables
$id = $_POST['id'];
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


//notify to admin using notification
//conflict checking section start

$sql = "UPDATE `reservation` SET `eventname` = '$eventname', `facility` = '$faci', `requestingparty` = '$reqparty', `purposeofactivity` = '$purpose', `datefiled` = '$datefiled', `actualdateofuse` = '$actualdate', `timestart` = '$timein', `timeend` = '$timeout', `participants` = '$numparticipants', `stageperformers` = '$stageperf', `adviser` = '$adviser', `chairperson` = '$chairman' WHERE reservationid = '$id'";
//conflict checking section end
//$sql = "INSERT INTO `reservation` (`eventname`, `facility`, `requestingparty`, `purposeofactivity`, `datefiled`, `actualdateofuse`, `timestart`, `timeend`, `participants`, `stageperformers`, `adviser`, `chairperson`, `status`, `fdstatus`, `saostatus`) VALUES ('$eventname','$faci','$reqparty',' $purpose', '$datefiled', '$actualdate', '$timein', '$timeout', '$numparticipants', '$stageperf', '$adviser', '$chairman', 'Pending', 'Pending', 'Pending')";
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
?>