<?php
include('../connection/connection.php');
include('../process/adminsession.php');
$username = $_POST['user'];
$password = $_POST['pass'];


//to prevent from mysqli injection  
$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);

//account search
$sql = "select * from users where username = '$username' and password = '$password'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
//roleid search 
//Legend: Role ID 1 = Facilities Mgt, 2 = Building Mgt. 3= admin
$rolesql = "SELECT roleid from users where username = '$username'";
$roleresult = mysqli_query($con, $rolesql);
//$rolerow = mysqli_fetch_array($roleresult, MYSQLI_ASSOC);
$roleid = mysqli_fetch_row($roleresult);
//Role Level 1: User, 2: Working Student 3:Department Head 4: admin
$rolelvlsql = "SELECT rolelevel from users where username = '$username'";
$rolelvlresult = mysqli_query($con, $rolelvlsql);
//$rolelvlrow = mysqli_fetch_array($rolelvlresult, MYSQLI_ASSOC);
$rolelvl = mysqli_fetch_row($rolelvlresult);


if ($count == 1){
    //Facilities
    if($roleid[0] == 1){
        if($rolelvl[0] == 1){
            //Facilities Management User
            header("location: ../user/userreservation.php");
        }

        if($rolelvl[0] == 2){
            //facilities management working student
            header("location: ../workingstudent/workingstudenteq/workingequipment.php"); //temporary location
        }
        if($rolelvl[0] == 3){
            //facilities management department head
            header("location: ../departmenthead/deptheadeq/departmentheadeq.php"); //temporary location
        }
        
    }
    //Facilities Department
    if($rolerow[0] == 2){
        header("location: ../../buildingdept/dashboard.php");
        
    }
    //admin
    if($rolelvl[0] == 7){
        header("location: ../systemadministrator/accounts/admin_account.php");


    }
    //user 
    if($rolerow[0] == 4){
        header("location: ../user/userdashboard.php");
    }
    //CADS
    if($rolerow[0] == 5){
        header("location: ../cad/minorrreservation.ph");
    }
    //PCO
    if($rolerow[0] == 6){
        header("location: ../pco/minorreservation.ph ");
    }
    //SAO
    if($rolerow[0] == 7){
        header("location: ../../sao/reservation.php");
    }
}
else{
    $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = 'login.html';
            </script>";
    echo $alert;
}

/*
if ($count == 1) {
    if ($role[0] == 1) {
        session_start();
        $_SESSION['user'] = 1;
        echo "<h1><center> Login successful </center></h1>";
        header("location: homepage.php");
    }
    if ($role[0] == 2) {
        session_start();
        $_SESSION['user'] = 2;
        echo "<h1><center> Login successful </center></h1>";
        header("location: ../process/adminsession.php");
    }
} else {
    $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = 'login.html';
            </script>";
    echo $alert;
}
*/
