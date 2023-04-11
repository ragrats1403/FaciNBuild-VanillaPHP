<?php include('../../../connection/connection.php');


$id = $_POST['id'];
$aoid = $_POST['aoid'];


/*
bdstatus
cadstatus
pcostatus
*/
$sql = "UPDATE `minorjreq` SET `bdstatus` = 'Declined', `status`='Declined' WHERE minorjobid = '$aoid'";
$query = mysqli_query($con, $sql);

if ($query == true) {
    $sql = "UPDATE `reservation` SET `fdstatus` = 'Declined', `saostatus` = 'Declined', `status` = 'Declined' WHERE reservationid = '$id'";
    $query2 = mysqli_query($con, $sql);

    if ($query2 == true) {
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
} else {
    $data = array(
        'status' => 'failed',
    );
    echo json_encode($data);
}
