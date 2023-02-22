<?php echo file_get_contents("admin_account.php");
    $_SESSION['user'] = 2;
    if (isset($_SESSION['user']) && $_SESSION['user'] == 1)
    {
        header("Location: testhomepage.html");
        
    }
    else if(isset($_SESSION['user']) && $_SESSION['user'] == 2)
    {
        /*header("Location: ../../php/systemadministrator/accounts/admin_account.php");*/
        header("Location: ../../php/admin/accounts/admin_account.php");
    }
    else{
        header("Location: ../../index.php");
        die();
       
    }
?>