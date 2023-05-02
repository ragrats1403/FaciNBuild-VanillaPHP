<?php include('../../../connection/connection.php');
$date = $_POST['date'];
$facility = $_POST['facility'];
$sql = "SELECT timestart, timeend FROM reservations WHERE facility='$facility' AND actualdateofuse = '$date'";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);

$data = array();

$run_query = mysqli_query($con, $sql);
$filtered_rows = mysqli_num_rows($run_query);
$filtered_rows = $filtered_rows -1;
while ($row = mysqli_fetch_assoc($run_query)) {
    $subarray = array();
    $subarray[] = $row['timestart'];
    $subarray[] = $row['timeend'];
    $data[] = $subarray;
}

echo json_encode($subarray);
