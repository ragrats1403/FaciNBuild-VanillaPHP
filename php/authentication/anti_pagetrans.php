<?php

session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['rolelevel'])) {
    header("Location: ../../../index.php");
    exit;
}

// Obtain users' $rolelevel
$rolelevel = $_SESSION['rolelevel'];

// 不正な遷移が行われた場合には、ログに記録する
if (!checkRoleLevel($rolelevel, $_SERVER['REQUEST_URI'])) {
    logError("Unauthorized access attempt by user with role level $rolelevel to URL " . $_SERVER['REQUEST_URI']);
    // Redirect to error page
    header("Location: ../../authentication/error.php");
    exit;
}

/**
 * $rolelevelに対応するURLかどうかを確認する
 *
 * @param int $rolelevel ユーザーの$rolelevel
 * @param string $url 確認するURL
 * @return bool $rolelevelに対応するURLである場合にはtrue、そうでない場合にはfalseを返す
 */
function checkRoleLevel($rolelevel, $url)
{
    switch ($rolelevel) {
        case 1:
            return preg_match("/^\/php\/admin\/(accounts|equipments|jobrequest|reservations)\/.*$/", $url);
        case 2:
            return preg_match("/^\/php\/buildingdept\/(major|minor|reservation)\/.*$/", $url);
        case 3:
            return preg_match("/^\/php\/facilitiesdept\/(eqipments|reservation)\/.*$/", $url);
        case 4:
            return preg_match("/^\/php\/user\/(major|minor|reservation)\/.*$/", $url);
        case 5:
            return preg_match("/^\/php\/cad\/.*$/", $url);
        case 6:
            return preg_match("/^\/php\/pco\//", $url);
        case 7:
            return preg_match("/^\/php\/sao\/(major|reservation)\/.*$/", $url);
        default:
            return false;
    }
}

/**
 * エラーログを記録する
 *
 * @param string $message エラーメッセージ
 */
function logError($message)
{
    // エラーログをファイルに追記する
    $logFile = __DIR__ . "/../../logs/error.log";
    
    if (!file_exists($logFile)) {
        // ファイルが存在しない場合は作成する
        $logDir = dirname($logFile);
        if (!file_exists($logDir)) {
            // 親フォルダが存在しない場合は再帰的に作成する
            mkdir($logDir, 0777, true);
        }
        touch($logFile);
        chmod($logFile, 0666);
    }
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' ' . htmlspecialchars($message, ENT_QUOTES) . "\n", FILE_APPEND);
}
