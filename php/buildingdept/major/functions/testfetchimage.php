<?php
include('../../../connection/connection.php');

$sql = "SELECT image FROM image WHERE id='1' LIMIT 1";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($query);

$imageData = base64_encode($row['image']);

header("Content-type: application/json");
echo json_encode(array(
    "status" => "success",
    "image" => $imageData
));
?>