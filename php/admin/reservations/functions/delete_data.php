<?php include('../../../connection/connection.php');

$id = $_POST['id'];

$sql = "DELETE FROM `reservation` WHERE reservationid ='$id' and `status` = 'Pending' OR `status` = 'Declined'";
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
