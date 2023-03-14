<?php
$host = "localhost";
$user = "root";
$password = '';
$db_name = "testdb";
$con = mysqli_connect($host, $user, $password, $db_name);
//notification bell con
$sql = "select * FROM notif_data";
$query = mysqli_query($con, $sql);
$count_all_rows = mysqli_num_rows($query);
echo $count_all_rows;
/*
if($result->num_rows > 0){
    //output data of each row
    while($row = $result->fetch_assoc()){
        echo "id: " . $row["id"]. " - Notification: " . $row["description"];
    }
}
else{
    echo "0 results";
}
*/
$con->close();
?>