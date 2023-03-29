<?php

session_start();

// ログインしていない場合には、ログインページにリダイレクトする
if (!isset($_SESSION['rolelevel'])) {
    header("Location: ../../../index.php");
    exit;
}

// ユーザーの$rolelevelを取得する
$rolelevel = $_SESSION['rolelevel'];

// 不正な遷移が行われた場合には、ログに記録する
if (!checkRoleLevel($rolelevel, $_SERVER['REQUEST_URI'])) {
    logError("Unauthorized access attempt by user with role level $rolelevel to URL ".$_SERVER['REQUEST_URI']);
    // エラーページにリダイレクトする
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
function checkRoleLevel($rolelevel, $url) {
    switch ($rolelevel) {
        case 1:
            return preg_match("/^\/admin\//", $url);
        case 2:
            return preg_match("/^\/buildingdept\//", $url);
        case 3:
            return preg_match("/^\/facilitiesdept\//", $url);
        case 4:
            return preg_match("/^\/user\//", $url);
        case 5:
            return preg_match("/^\/cad\//", $url);
        case 6:
            return preg_match("/^\/pco\//", $url);
        case 7:
            return preg_match("/^\/sao\//", $url);    
        default:
            return false;
    }
}

/**
 * エラーログを記録する
 *
 * @param string $message エラーメッセージ
 */
function logError($message) {
    // エラーログをファイルに追記する
    file_put_contents("error.log", date("Y-m-d H:i:s")." ".$message."\n", FILE_APPEND);
}

?>
