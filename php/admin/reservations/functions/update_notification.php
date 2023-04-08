<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "testdb";

// Connect to the database
$con = mysqli_connect($host, $user, $password, $db_name);

// Check for errors
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// POSTリクエストを受け取る
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // is_readカラムを1に更新するSQL文を作成する
  $sql = "UPDATE notif_data SET is_read = 1";
  
  // SQL文を実行する
  if (mysqli_query($con, $sql)) {
    echo "All notifications marked as read.";
  } else {
    echo "Error updating notifications: " . mysqli_error($con);
  }
}

// データベース接続を閉じる
mysqli_close($con);