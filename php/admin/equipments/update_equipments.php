<?php include('../../connection/connection.php');
$id = $_POST['id'];
$eqname = $_POST['equipmentname'];
$quantity = $_POST['qty'];
$facility = $_POST['facility'];

$sql = "UPDATE `equipments` SET `equipmentname` = '$eqname',`quantity`='$quantity', `facility`= '$facility' WHERE id = '$id'";
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
