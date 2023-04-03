<?php include('../../../connection/connection.php');

//variables

$eventname = $_POST['eventname'];
$datesubmitted = $_POST['datesubmitted'];
$dateofusage = $_POST['dateofusage'];
$timestart = $_POST['timestart'];
$timeend = $_POST['timeend'];
$quantity = $_POST['quantity'];
$facility = $_POST['facility'];
$eqid = $_POST['eqid'];
$eqname = $_POST['eqname'];
/*$renderedby = $_POST['renderedby'];
$daterendered = $_POST['daterendered'];
$confirmedby = $_POST['confirmedby'];
$dateconfirmed = $_POST['dateconfirmed'];*/

//conflict checking section start




//conflict checking section end


$sql = "INSERT INTO `eqreservation` (`eventname`, `datesubmitted`, `dateofusage`, `timestart`, `timeend`, `quantity`, `facility`, `eqid`, `eqname`) VALUES ('$eventname','$dateofusage','$datesubmitted',' $timestart', '$timeend', '$quantity', '$facility', '$eqid', '$eqname')";
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