<?php
	// include 'login.php';
	session_start();



	//upload function for the user data	
	//may have some permisiion 
	//solved!!!!
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
					$uploadcheck =move_uploaded_file($filetmp, $filedestination);

					//move_uploaded_file check
					if ($uploadcheck == true){

						$firstname = $_POST['firstname'];
						$lastname = $_POST['lastname'];
						$uid = $_POST['uid'];
						$pwd = $_POST['pwd'];
						
						$pwdencrypt = password_hash ($pwd, PASSWORD_BCRYPT);
						
						
						$up = "INSERT INTO users (images,firstname,lastname,uid,pwd) VALUES ('$filenewname','$firstname','$lastname','$uid','$pwdencrypt')";
						
						mysqli_query($db, $up);
						// echo $uploadcheck;
						$_SESSION['user'] = $row['uid'];
						
						header("Location:../index.php?uploadsucessful");
		
					}else{
						echo "error uploading file";
					}
	
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
	//end uploadfunction

	//login operations
	if(isset($_POST['login'])){
		$db = mysqli_connect("localhost","root","","userinfo");
		
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		
		
		//decryption stuff
		$up = "SELECT * FROM users WHERE uid='$uid'";
		$conn = $db->query($up);
		$row = $conn->fetch_assoc();
		$encryptedpwd = $row['pwd'];
		$decrtypt = password_verify ($pwd, $encryptedpwd);
		
		if ($decrtypt == 0) {
			// header("Location:../index.php?error=wrongpassword");
			echo "wrong password!!";
			// exit();
		}else{
			$up = "SELECT * FROM users WHERE uid='$uid' AND pwd='$encryptedpwd'";
			$conn = $db ->query($up);
			
			if (!$row = $conn->fetch_assoc()){
				echo "Your username or password is incorrect.";
			}else{ 
				//  $_SESSION['user']; 
				// define  ($_SESSION['user'] = $row['uid']); 
				$_SESSION['user'] = $row['uid'];
				// header("Location:index.php?loginsucessfull");
				
				
			}
			
		}
	}
	
	//end

	
	function get_comments() {
		require 'connect.php';
		$result =  mysqli_query($connect, "SELECT * FROM `parents` ORDER BY `date` DESC");
		$row_cnt = mysqli_num_rows($result);

		//trying to get personal user id		
		$db = mysqli_connect("localhost","root","","userinfo");
		$row = "SELECT * FROM users";
		$id = $db->query($row);
		$row2 = $id->fetch_assoc();
		$_SESSION['user']= $row2['uid'];

		//

		foreach($result as $item) {
			$date = new dateTime($item['date']);
			$date = date_format($date, 'M j, Y | H:i:s');
			$user = $_SESSION['user'];
			$comment = $item['text'];
			$par_code = $item['code'];

	       		echo '<div class="comment" id="'.$par_code.'">'
					.'<p class="user">'.$user.'</p>&nbsp;'
					.'<p class="time">'.$date.'</p>'
					.'<p class="comment-text">'.$comment.'</p>&nbsp '
					.'<a class="link-reply" id="reply" name="'.$par_code.'">Reply</a>';
				$chi_result = mysqli_query($connect, "SELECT * FROM `children` WHERE `par_code`='$par_code' ORDER BY `date` DESC");
				$chi_cnt = mysqli_num_rows($chi_result);

				if($chi_cnt == 0){
				} else {
					echo '<a class="link-reply" id="children" name="'.$par_code.'"><span id="tog_text">replies</span> ('.$chi_cnt.')</a>'
						.'<div class="child-comments" id="C-'.$par_code.'">';

					foreach($chi_result as $com) {
						$chi_date = new dateTime($com['date']);
						$chi_date = date_format($chi_date, 'M j, Y | H:i:s');
						$chi_user = $_SESSION['user'];
						$chi_com = $com['text'];
						$chi_par = $com['par_code'];

						echo '<div class="child" id="'.$par_code.'-C">'
								.'<p class="user">'.$chi_user.'</p>&nbsp;'
								.'<p class="time">'.$chi_date.'</p>'
								.'<p class="comment-text">'.$chi_com.'</p>'
							.'</div>';
					}
					echo '</div>';
				}
				echo '</div>';
		}
	}

	//getting all the comments 
	function get_total() {
		require 'connect.php';
		$result = mysqli_query($connect, "SELECT * FROM `parents` ORDER BY `date` DESC");
		$row_cnt = mysqli_num_rows($result);
		echo '<h1>All Comments ('.$row_cnt.')</h1>';
	}
	//end

	//logout function
	
	if (isset($_POST["logout"])) {
		session_start();
		session_destroy();
		header("Location: index.php");
		exit();
	}
	   
	//end

	//making each comment different
	function generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characterLength = strlen($characters);
		$randomString = '';

		for($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $characterLength - 1)];
		}
		return $randomString;
	}
	//end
?>