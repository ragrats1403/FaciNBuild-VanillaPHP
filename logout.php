<?php   
//session_start(); //to ensure you are using same session
//session_destroy(); //destroy the session
//header("location: index.php"); //to redirect back to "index.php" after logging out
//exit();
//


// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finally, destroy the session.
session_destroy();

//Returning to the homepage.
header("Location:index.php");
exit();
?>