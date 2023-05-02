<?php
include('../../connection/connection.php');

$datestart = isset($_POST['datestart']) ? $_POST['datestart'] : "";
$dateend = isset($_POST['dateend']) ? $_POST['dateend'] : "";
$sql = "SELECT * FROM `minorjreq` WHERE 1=1";

if (!empty($datestart) && !empty($dateend)) {
    $sql .= " AND `datesubmitted` BETWEEN '$datestart' AND '$dateend'";
}

$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY `" . $column . "` " . $order;
} else {
    $sql .= " ORDER BY minorjobid ASC";
}

if (isset($_POST['length']) && $_POST['length'] != -1 && isset($_POST['start']) && isset($_POST['length'])) {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT " . $start . ", " . $length;
}

$data = array();

$run_query = mysqli_query($con, $sql);
$filtered_rows = mysqli_num_rows($run_query);
$filtered_rows = $filtered_rows - 1;
while ($row = mysqli_fetch_assoc($run_query)) {
    $subarray = array();
    $subarray[] = $row['minorjobid'];
    $subarray[] = $row['department'];
    $subarray[] = $row['section'];
    $subarray[] = $row['datesubmitted'];
    $subarray[] = $row['purpose'];
    $subarray[] = $row['daterendered'];
    $subarray[] = $row['dateconfirmed'];
    $subarray[] = $row['status']; 
    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows + 1,
);

echo json_encode($output);
