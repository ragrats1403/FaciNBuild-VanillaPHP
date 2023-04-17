<?php

session_start();

//Redirect to login page if not logged in
if (!isset($_SESSION['rolelevel'])) {
    header("Location: ../../../index.php");
    exit;
}

//Obtain users' $rolelevel
$rolelevel = $_SESSION['rolelevel'];

//Log any illegal transitions
if (!checkRoleLevel($rolelevel, $_SERVER['REQUEST_URI'])) {
    logError("Unauthorized access attempt by user with role level $rolelevel to URL " . $_SERVER['REQUEST_URI']);
    // Redirect to error page
    header("Location: ../../authentication/error.php");
    exit;
}

//Check if URL corresponds to $rolelevel

function checkRoleLevel($rolelevel, $url)
{
    switch ($rolelevel) {
        case 1:
            return preg_match("/^\/php\/admin\/(accounts|equipments|jobrequest|reservations|generatereports)\/.*$/", $url);
        case 2:
            return preg_match("/^\/php\/buildingdept\/(major|majoruser|minor|minoruser|reservation|generatereports)\/.*$/", $url);
        case 3:
            return preg_match("/^\/php\/facilitiesdept\/(equipments|major|minor|managereserve|reservations|generatereports)\/.*$/", $url);
        case 4:
            return preg_match("/^\/php\/user\/(major|minor|reservation)\/.*$/", $url);
        case 5:
            return preg_match("/^\/php\/cad\/(major|majoruser|minor|reservations)\/.*$/", $url);
        case 6:
            return preg_match("/^\/php\/pco\/(major|majoruser|minor|reservation|generatereports)\/.*$/", $url);
        case 7:
            return preg_match("/^\/php\/sao\/(major|majoruser|managereserve|minor|reservation|generatereports)\/.*$/", $url);
        default:
            return false;
    }
}

//Record error log
function logError($message)
{
    //Append error log to file
    $logFile = __DIR__ . "/../../logs/error.log";
    
    if (!file_exists($logFile)) {
        //Create file if it doesn't exist
        $logDir = dirname($logFile);
        if (!file_exists($logDir)) {
            //create folder if it doesn't exist
            mkdir($logDir, 0777, true);
        }
        touch($logFile);
        chmod($logFile, 0666);
    }
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' ' . htmlspecialchars($message, ENT_QUOTES) . "\n", FILE_APPEND);
}
