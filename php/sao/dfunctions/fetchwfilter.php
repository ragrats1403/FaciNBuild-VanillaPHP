<?php include('../../../php/connection/connection.php');
$facility = $_POST['facility'];
$sql = "SELECT * FROM reservation WHERE fdstatus = 'Approved' AND saostatus != 'Declined' AND actualdateofuse > now() AND facility = '$facility'";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);
//search

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY '" . $column . "' " . $order;
} else {
    $sql .= "ORDER BY reservationid ASC";
}



if ($_POST['length'] != -1) {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT " . $start . ", " . $length;
}

$data = array();
$run_query = mysqli_query($con, $sql);
$filtered_rows = mysqli_num_rows($run_query);
$filtered_rows = $filtered_rows -1;
while ($row = mysqli_fetch_assoc($run_query)) {
    $subarray = array();
    $subarray[] = $row['eventname'];
    $subarray[] = date("F j, Y", strtotime($row['actualdateofuse']));
    $subarray[] = date("h:i A", strtotime($row['timestart']));
    $subarray[] = date("h:i A", strtotime($row['timeend']));
    $subarray[] = $row['facility'];
    $subarray[] = $row['fdstatus'];
    $subarray[] = $row['saostatus'];
    $data[] = $subarray;
}


$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows + 1,

);

echo json_encode($output);
