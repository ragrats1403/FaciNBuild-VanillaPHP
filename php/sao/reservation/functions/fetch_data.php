<?php include('../../../connection/connection.php');
$dpt = $_POST['dpt'];
$sql = "select * FROM reservation WHERE requestingparty = '$dpt'";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " OR reservationid like '%" . $search_value . "%' AND requestingparty = '$dpt'";
    $sql .= " OR requestingparty like '%" . $search_value . "%' AND requestingparty = '$dpt'";
    $sql .= " OR facility like '%" . $search_value . "%' AND requestingparty = '$dpt'";
    $sql .= " OR eventname like '%" . $search_value . "%' AND requestingparty = '$dpt'";
    $sql .= " OR datefiled like '%" . $search_value . "%' AND requestingparty = '$dpt'";
    $sql .= " OR actualdateofuse like '%" . $search_value . "%' AND requestingparty = '$dpt'";
    $sql .= " OR status like '%" . $search_value . "%' AND requestingparty = '$dpt'";
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
    $subarray[] = date('M j, Y h:iA', strtotime($row['datefiled']));
    $subarray[] = $row['actualdateofuse'];
    $subarray[] = $row['status'];
    if($row['status'] == 'Pending')
    {
        $subarray[] = '<a href= "javascript:void();" data-id="' . $row['reservationid'] . '" class ="btn btn-sm btn-info editBtn" >More Info</a> <a href= "javascript:void();" data-id="' . $row['reservationid'] . '" class ="btn btn-sm btn-danger deleteBtn">Delete</a>';
    }
    else{
        $subarray[] = '<a href= "javascript:void();" data-id="' . $row['reservationid'] . '" class ="btn btn-sm btn-info editBtn" >More Info</a>';
    }
    
    $data[] = $subarray;
    
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows + 1,

);

echo json_encode($output);
