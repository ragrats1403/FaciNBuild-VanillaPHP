<?php
 include('connection.php');

 $q = "select * from login";

$quer = mysqli_query($con, $q);
$count = mysqli_num_rows($quer);

echo "$count Records Found";

echo '<th>Username</th>';
echo '<th>Password</th>';
echo '<th>Privilege Level</th>';
echo '<th>Action</th>';
echo '</tr>';
while($datarow = mysqli_fetch_row($quer))
{
  echo "<tr>";
  echo "<td> $datarow[0] </td><td> $datarow[1] </td><td> $datarow[2] </td>";
  echo "<td> <a href= ''>Edit</a>   |   <a href= ''>Delete</a> </td>"; 
  echo "</tr>";
}
    

?>
<style type = "text/css">
table, th, td {
  border-collapse: collapse;
  border: 1px solid #ccc;
  line-height: 1.5;   

}
table.phptable th {
    width: 150px;
    padding: 10px;
    font-weight: bold;
    vertical-align: top;
    background: #3f3f3f;
    color: #ffffff;
}

table.phptable td {
    width: 350px;
    padding: 10px;
    vertical-align: top;
}

tr:nth-child(even) {
    background: #d9d9d9;
}


</style>