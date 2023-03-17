<?php include('../../connection/connection.php');
$sql = "SELECT facilityname FROM facility";
$query = mysqli_query($con,$sql);

while($row = mysqli_fetch_assoc($query)){
    $name[] = $row['facilityname'];

}
echo json_encode($name);


//echo json_encode($row);
