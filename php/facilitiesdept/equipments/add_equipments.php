<?php include('../../connection/connection.php');

$eqname = $_POST['equipmentname'];
$quantity = $_POST['qty'];
$facility = $_POST['facility'];




$sql = "INSERT INTO `equipments` (`equipmentname`,`quantity`,`facility`) VALUES ('$eqname','$quantity','$facility')";
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
