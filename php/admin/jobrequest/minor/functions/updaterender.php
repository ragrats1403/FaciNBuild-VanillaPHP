<?php include('../../../connection/connection.php');


$id = $_POST['id'];
$renderdate = $_POST['renderdate'];
$renderedby = $_POST['renderedby'];



$sql = "UPDATE `minorjreq` SET `daterendered`='$renderdate', `renderedby` = '$renderedby' WHERE minorjobid = '$id'";
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
