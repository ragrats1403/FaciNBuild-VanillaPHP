<?php
include('../../../connection/connection.php');

$date = isset($_POST['date']) ? $_POST['date'] : "";
$facility = isset($_POST['facility']) ? $_POST['facility'] : "";
$timein = isset($_POST['timein']) ? $_POST['timein'] : "";
$timeout = isset($_POST['timeout']) ? $_POST['timeout'] : "";

$timeinStr = date("H:i:s", strtotime($timein));
$timeoutStr = date("H:i:s", strtotime($timeout));

$sql = "SELECT * 
        FROM reservation 
        WHERE facility='$facility' 
        AND actualdateofuse = '$date' 
        AND status = 'Pending'
        AND (
            ('$timeinStr' < timeend AND '$timeoutStr' > timestart) OR
            ('$timeinStr' = timestart AND '$timeoutStr' = timeend) OR
            ('$timeinStr' >= timestart AND '$timeinStr' < timeend) OR
            ('$timeoutStr' > timestart AND '$timeoutStr' <= timeend)
        )";
$query = mysqli_query($con, $sql);

$subarray = array();
while ($row = mysqli_fetch_assoc($query)) {
    $timeInFormatted = date("h:i A", strtotime($row['timestart']));
    $timeOutFormatted = date("h:i A", strtotime($row['timeend']));

    $subarray[] = $timeInFormatted;
    $subarray[] = $timeOutFormatted;
    $subarray[] = $row['timestart'];
    $subarray[] = $row['timeend'];

}

echo json_encode($subarray);
?>
