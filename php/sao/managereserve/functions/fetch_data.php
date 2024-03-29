<?php include('../../../connection/connection.php');

$sql = "SELECT * FROM reservation 
        WHERE saostatus IN ('Pending', 'Approved', 'Declined') 
        AND fdstatus NOT IN ('Pending', 'Declined')";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (reservationid = '" . $search_value . "' ";
    $sql .= " OR requestingparty LIKE '%" . $search_value . "%' ";
    $sql .= " OR facility LIKE '%" . $search_value . "%' ";
    $sql .= " OR eventname LIKE '%" . $search_value . "%' ";
    $sql .= " OR datefiled LIKE '%" . $search_value . "%' ";
    $sql .= " OR actualdateofuse LIKE '%" . $search_value . "%' ";
    $sql .= " OR saostatus LIKE '%" . $search_value . "%')";

}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY '" . $column . "' " . $order;
} else {
    $sql .= "ORDER BY reservationid DESC";
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
    $subarray[] = $row['reservationid'];
    $subarray[] = $row['eventname'];
    $subarray[] = $row['requestingparty'];
    $subarray[] = $row['facility'];
    $subarray[] = $row['datefiled'];
    $subarray[] = $row['actualdateofuse'];
    $subarray[] = $row['saostatus'];
    $subarray[] = '<a href= "javascript:void();" data-id="' . $row['reservationid'] . '" class ="btn btn-sm btn-info editBtn" >More Info</a> <a href= "javascript:void();" data-id="' . $row['reservationid'] . '" class ="btn btn-sm btn-danger deleteBtn">Delete</a>';
    $data[] = $subarray;
    
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows + 1,

);

echo json_encode($output);
