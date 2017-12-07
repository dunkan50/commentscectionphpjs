<?php

// session_start();

// include 'connect.php';

// $first = $_POST['first'];
// $last = $_POST['last'];
// $uid = $_POST['uid'];
// $pwd = $_POST['pwd'];

// //encrpting the password
// $pwdencrpt = password_hash($pwd, PASSWORD_BCRYPT);

// //upload data to the database

// $up = "INSERT INTO user (firstname, lastname, uid, pwd) VALUES ('$first', '$last', '$uid', '$pwdencrpt')";
// $db = $conn -> query($up);
// header("Location:../index.php?uploadok");



if (isset($_POST['upload'])) {
    $file = $_FILES['image'];

    //breaking down the image properties
    $filename = $file['name'];
    $filetmp = $file['tmp_name'];
    $filesize = $file['size'];
    $fileerror = $file['error'];
    $filetype = $file['type'];

    //getting the file extension
    //making sure we just have images no doument etc
    $fileext = explode('.', $filename);
    //change everthig to small letters
    $extlower = strtolower(end($fileext));

    //setting the required formats
    $fileformart = array('jpg', 'jpeg', 'png', 'raw');

    //function
    if (in_array($extlower, $fileformart)) {
        if ($fileerror === 0) {
            if ($filesize < 10000000) {

                //connecting to the db
                $db = mysqli_connect("localhost","root","","userinfo");
                //workig withthe data we getting
                $filenewname = uniqid ('',true).".".$extlower;
                $filedestination = '../uploads/'.$filenewname;
                move_uploaded_file($filetmp, $filedestination);
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $uid = $_POST['uid'];
                $pwd = $_POST['pwd'];

                $pwdencrypt = password_hash ($pwd, PASSWORD_BCRYPT);
                

                $up = "INSERT INTO users (images,firstname,lastname,uid,pwd) VALUES ('$filenewname','$firstname','$lastname','$uid','$pwdencrypt')";

                mysqli_query($db, $up);
                

                header("Location:../index.php?uploadsucessful");


            }else{
                echo "the file as too big, pic a smaller version.";
            }
        }else{
            echo "There was an error uploading the file";
        }
    }else{
        echo "The file you are trying to upload is not in the correct fomart";
        echo "</ br>";
        echo "Please try files withe a jpg, jpeg, png, raw extention.";
    }
}
?>