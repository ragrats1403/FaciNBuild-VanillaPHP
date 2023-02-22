<?php      
    include('connection.php');  
    $username = $_POST['user'];  
    $password = $_POST['pass'];  
    
      
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($con, $username);  
        $password = mysqli_real_escape_string($con, $password); 
        
      
        $sql = "select *from login where username = '$username' and password = '$password'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        $rolesql = "SELECT roleid from login where username = '$username'";
        $roleresult = mysqli_query($con, $rolesql);
        //$rolerow = mysqli_fetch_array($roleresult, MYSQLI_ASSOC);
        $role = mysqli_fetch_row($roleresult);
          
        if($count == 1){
            if($role[0] == 1)
            {
            session_start();    
            $_SESSION['user'] = 1;
            echo "<h1><center> Login successful </center></h1>";
            header("location: homepage.php");
            }
            if($role[0] == 2)
            {
            session_start();
            $_SESSION['user'] = 2;
            echo "<h1><center> Login successful </center></h1>";
            header("location: testadmin.php");                 
            }
            
        }   
        else{
            $alert = "<script type='text/javascript'>alert('Login failed. Invalid username or password.');
            window.location = 'login.html';
            </script>";
            echo $alert;
        }     
?>  