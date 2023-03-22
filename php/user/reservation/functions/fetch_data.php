<?php include('../../../../connection/connection.php');

$sql = "select * FROM minorjreq";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE minorjobid like '%" . $search_value . "%' ";
    $sql .= " OR department like '%" . $search_value . "%' ";
    $sql .= " OR section like '%" . $search_value . "%' ";
    $sql .= " OR datesubmitted like '%" . $search_value . "%' ";
    $sql .= " OR status like '%" . $search_value . "%' ";
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
    $subarray[] = $row['section'];
    $subarray[] = $row['datesubmitted'];
    $subarray[] = $row['status']; 
    $subarray[] = '<a href= "javascript:void();" data-id="' . $row['minorjobid'] . '" class ="btn btn-sm btn-info editBtn">More Info</a> <a href= "javascript:void();" data-id="' . $row['minorjobid'] . '" class ="btn btn-sm btn-danger btnDelete">Delete</a>';
    $data[] = $subarray;
}


$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows + 1,

);

echo json_encode($output);
