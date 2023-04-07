<?php include('../../../connection/connection.php');
$dpt = $_POST['dpt'];
$sql = "select * FROM minorjreq where department = '$dpt'";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " OR minorjobid like '%" . $search_value . "%' AND department = '$dpt' ";
    $sql .= " OR department like '%" . $search_value . "%' AND department = '$dpt' ";
    $sql .= " OR section like '%" . $search_value . "%' AND department = '$dpt' ";
    $sql .= " OR datesubmitted like '%" . $search_value . "%' AND department = '$dpt' ";
    $sql .= " OR status like '%" . $search_value . "%' AND department = '$dpt' ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY '" . $column . "' " . $order;
} else {
    $sql .= "ORDER BY minorjobid ASC";
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
    $subarray[] = $row['minorjobid'];
    $subarray[] = $row['department'];
    $subarray[] = $row['datesubmitted'];
    $subarray[] = $row['status']; 
    $subarray[] = '<a href= "javascript:void();" data-id="' . $row['minorjobid'] . '" class ="btn btn-sm btn-info editBtn">More Info</a>';
    $data[] = $subarray;
}


$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows + 1,

);

echo json_encode($output);
