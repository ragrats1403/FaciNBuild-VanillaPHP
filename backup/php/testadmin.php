<?php echo file_get_contents("adminpage.html");
    session_start();
    if (isset($_SESSION['user']) && $_SESSION['user'] == 1)
    {
        header("Location: testhomepage.html");
        
    }
    else if(isset($_SESSION['user']) && $_SESSION['user'] == 2)
    {
        header("Location: adminpage.html");
    }
    else{
        header("Location: index.php");
        die();
       
    }
?>