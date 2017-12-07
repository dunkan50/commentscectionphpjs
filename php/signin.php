<?php

?>
<html>
    <head>
        <title>Signin</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['id'])) {
            echo "You are already logged in";
                        
            }else{
                echo"
                <form method='POST' action='functions.php' enctype='multipart/form-data'>
                    
                    <div>
                        <input type='file' name='image' value=''>
    
                    </div>                
                    <div>
                        <p>First Name:</p><input type='text' name='firstname' value='' placeholder='First Name'>
                    </div>
                    <div>
                        <p>Last Name:</p><input type='text' name='lastname' value='' placeholder='Last Name'>
                    </div>
                    <div>
                        <p>User id:</p><input type='text' name='uid' value='' placeholder='User id'>
                    </div>
                    <div>
                        <p>Password:</p><input type='password' name='pwd' value='' placeholder='Password'>
                    </div>
                    <div>
                        <input type='submit' name='upload' value='Submit'>
                    </div>
                </form>";
               
                //header("Location:index.php?loginfailed");
            }
        ?>
        
    </body>


</html>




