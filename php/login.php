<?php
   session_start();     
?>
<html>
    <head><title>login</title></head>
    <body>
        <?php
        if (isset($_SESSION['id'])) {
            echo "You are already logged in";           
            
            
            }else{
                echo "<form method='POST' action='functions.php'>
                <input type='text' name='uid' value='' placeholder='Username'> 
                <input type='password' name='pwd' value='' placeholder='Password'>
                <input type='submit' name='login' value='Log in'>                                     
                </form>";
                // header("Location:index.php?loginfaijerjreled");
            }
        ?>
        
        
        

        
    </body>
</html>
