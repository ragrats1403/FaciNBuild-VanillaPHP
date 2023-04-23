<?php
include('../../../connection/connection.php');
    $sql = "SELECT MAX(requino) as totalno FROM requisition";
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);
    echo json_encode($row);
?>