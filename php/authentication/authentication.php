<?php
//session starts
session_start();
include('../connection/connection.php');
//
$username = $_POST['user'];
$password = $_POST['pass'];

$_SESSION['user'] = $username;

//connect to database
$host = "localhost";
$user = "root";
$password = "";
$db_name = "testdb";

$con = new mysqli($host, $user, $password, $db_name);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT rolelevel, password FROM users WHERE username = ?";
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("s", $param_username);
    $param_username = $_SESSION['user'];
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($rolelevel, $password);
        $stmt->fetch();
        if($_POST['pass'] == $password){

        //Admin
        if ($rolelevel == 1) {
            header("Location: ../admin/accounts/admin_account.php");
            exit;
        }
        //Building
        if ($rolelevel == 2) {
            header("Location: ../buildingdept/buildingdeptdashboard.php");
            exit;
        }
        //Building
        if ($rolelevel == 3) {
            header("Location: ../facilitiesdept/facilitiesdashboard.php");
            exit;
        }
        //User
        if ($rolelevel == 4) {
            header("Location: ../user/userdashboard.php");
            exit;
        }
        //CAD
        if ($rolelevel == 5) {
            header("Location: ../cad/majorjobreqlist.php");
            exit;
        }
        //PCO
        if ($rolelevel == 6) {
            header("Location: ../pco/majorjobreqlist.php");
            exit;
        }
        //SAO
        if ($rolelevel == 7) {
            header("Location: ../sao/saodashboard.php");
            exit;
        }
        
    } 
    else {
        session_destroy();
        $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = '../login.php';
            </script>";
        echo $alert;
    }
}
    //close statement
    $stmt->close();
}
//close connection
$con->close();
?>