<?php include('../../../../connection/connection.php');


$id = $_POST['id'];
$confirmdate = $_POST['confirmdate'];
$confirmby = $_POST['confirmby'];


$sql = "UPDATE `minorjreq` SET `dateconfirmed` = '$confirmdate', `confirmedby` = '$confirmby'  WHERE minorjobid = '$id'";
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
