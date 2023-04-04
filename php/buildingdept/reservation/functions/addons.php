<?php include('../../../connection/connection.php');


$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$itemname = $_POST['itemname'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$eventname = $_POST['eventname'];
$actualdate = $_POST['actualdate'];
$reqparty = $_POST['reqparty'];

/*$renderedby = $_POST['renderedby'];
$daterendered = $_POST['daterendered'];
$confirmedby = $_POST['confirmedby'];
$dateconfirmed = $_POST['dateconfirmed'];*/



$sql = "INSERT INTO `minorjreq` (`department`,`datesubmitted`, `quantity`, `item`,`item_desc`,`purpose`, `bdstatus`,`status`,`eventname`,`reqsource`,`reservationdateuse`) VALUES ('$department','$date','$quantity','$itemname','$description',' $purpose','Pending','Pending',' $eventname',' $reqparty',' $actualdate')";
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