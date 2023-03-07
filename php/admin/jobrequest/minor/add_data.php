<?php include('../../../connection/connection.php');


$department = $_POST['department'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$itemname = $_POST['itemname'];
$description = $_POST['description'];
$purpose = $_POST['purpose'];
$renderedby = $_POST['renderedby'];
$daterendered = $_POST['daterendered'];
$confirmedby = $_POST['confirmedby'];
$dateconfirmed = $_POST['dateconfirmed'];



$sql = "INSERT INTO `minorjreq` (`department`,`datesubmitted`,`item`,`item_desc`,`purpose`,`renderedby`,`daterendered`,`confirmedby`,`dateconfirmed`) VALUES ('$department','$date','$quantity','$itemname','$description',' $purpose', '$renderedby', '$daterendered', '$confirmedby', '$dateconfirmed')";
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
