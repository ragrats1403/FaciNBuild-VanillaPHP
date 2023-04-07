<?php
//session starts
session_start();
$username = $_POST['user'];
$password_input = $_POST['pass'];
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

$sql = "SELECT rolelevel, department, password FROM users WHERE username = ?";
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("s", $param_username);
    $param_username = $_SESSION['user'];
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($rolelevel, $department, $password_db);
        $stmt->fetch();
        if ($password_input == $password_db) {
            $_SESSION['rolelevel'] = $rolelevel;
            $_SESSION['department'] = $department;
            switch ($rolelevel) {
                case '1': //admin
                    $folder = '../admin/reservations/admincalendar.php';
                    break;
                case '2': //building department
                    $folder = '../buildingdept/buildingcalendar.php';
                    break;
                case '3': //facilities department
                    $folder = '../facilitiesdept/reservations/facilitiescalendar.php';
                    break;
                case '4': //user
                    $folder = '../user/userdashboard.php';
                    break;
                case '5': //cad
                    $folder = '../cad/cadcalendarofactivities.php';
                    break;
                case '6': //pco
                    $folder = '../pco/pcocalendar.php';
                    break;
                case '7': //sao
                    $folder = '../sao/reservation/saocalendar.php';
                    break;
                default:
                    session_destroy();
                    $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = '../login.php';
            </script>";
                    echo $alert;
                    break;
            }
            header("Location: $folder");
            exit;
        } else {
            session_destroy();
            $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = '../login.php';
            </script>";
            echo $alert;
        }
    } else {
        session_destroy();
        $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
        window.location = '../login.php';
        </script>";
        echo $alert;
    }
    //close statement
    $stmt->close();
}
//close connection
$con->close();
