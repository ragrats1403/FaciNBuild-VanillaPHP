<?php include('../../../connection/connection.php');

$id = $_POST['id'];

$sql = "DELETE FROM `eqreservation` WHERE eqresid ='$id'";
$query = mysqli_query($con, $sql);
if ($query == true) 
{
    $data = array(
       'status'=>'success',
      
   );
   echo json_encode($data);
}
else
{
    $data = array(
       'status'=>'failed',
     
   );

   echo json_encode($data);
}
