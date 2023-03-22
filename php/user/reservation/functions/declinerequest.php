<?php include('../../../../connection/connection.php');


$id = $_POST['id'];


/*
bdstatus
cadstatus
pcostatus
*/
$sql = "UPDATE `minorjreq` SET `bdstatus` = 'Declined',`cadstatus`='Declined', `pcostatus`= 'Declined', `status`='Declined' WHERE minorjobid = '$id'";
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
