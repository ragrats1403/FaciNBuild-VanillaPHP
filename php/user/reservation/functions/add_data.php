<?php include('../../../connection/connection.php');

//variables

$eventname = $_POST['eventname'];
$datefiled = $_POST['datefiled'];
$actualdate = $_POST['actualdate'];
$timein = $_POST['timein'];
$timeout = $_POST['timeout'];
$reqparty = $_POST['reqparty'];
$department = $_POST['department'];
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

//conflict checking section start




//conflict checking section end


$sql = "INSERT INTO `reservation` (`department`, `eventname`, `facility`, `requestingparty`, `purposeofactivity`, `datefiled`, `actualdateofuse`, `timestart`, `timeend`, `participants`, `stageperformers`, `adviser`, `chairperson`, `status`, `fdstatus`, `saostatus`) VALUES ('$department','$eventname','$faci','$reqparty',' $purpose', '$datefiled', '$actualdate', '$timein', '$timeout', '$numparticipants', '$stageperf', '$adviser', '$chairman', 'Pending', 'Pending', 'Pending')";
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