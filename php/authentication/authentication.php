<?php
//session starts
session_start();
$_SESSION['flg']="ok";
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

$sql = "SELECT rolelevel, password FROM users WHERE username = ?";
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("s", $param_username);
    $param_username = $_SESSION['user'];
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($rolelevel, $password_db);
        $stmt->fetch();
        if ($password_input == $password_db) {
            switch ($rolelevel) {
                case 1:
                    header("Location: ../admin/accounts/admin_account.php"); //admin
                    break;
                case 2:
                    header("Location: ../buildingdept/buildingdeptdashboard.php"); //building department
                    break;
                case 3:
                    header("Location: ../facilitiesdept/facilitiesdashboard.php"); //facilities department
                    break;
                case 4:
                    header("Location: ../user/userdashboard.php"); //user
                    break;
                case 5:
                    header("Location: ../cad/majorjobreqlist.php"); //cad
                    break;
                case 6:
                    header("Location: ../pco/majorjobreqlist.php"); //pco
                    break;
                case 7:
                    header("Location: ../sao/saodashboard.php"); //sao
                    break;
                default:
                    session_destroy();
                    $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = '../login.php';
            </script>";
                    echo $alert;
                    break;
            }
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
