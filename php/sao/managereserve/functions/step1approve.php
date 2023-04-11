<?php include('../../../connection/connection.php');


$id = $_POST['id'];

$preqcheck = "SELECT * from reservation where saostatus = 'Approved' AND reservationid = '$id'";
$checkresult = mysqli_query($con, $preqcheck);


if($row = mysqli_num_rows($checkresult) > 0)
{
    $sql = "UPDATE `reservation` SET `fdstatus` = 'Approved', `status` = 'Approved' WHERE reservationid = '$id'";
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
}
else{
    $sql = "UPDATE `reservation` SET `fdstatus` = 'Approved' WHERE reservationid = '$id'";
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
}

