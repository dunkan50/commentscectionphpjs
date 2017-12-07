<?php
require_once 'php/connect.php'; 
require_once 'php/functions.php'; 
// require_once 'php/login.php';
// session_start();
?>
<!doctype html>
<html>
	<head>
		<title> Comment System trial1</title>
		<meta charset="UTF-8" lang="en-US">
		<link rel="stylesheet" href="style.css">
		<script src="js/jquery.js"></script>
		<script src="js/global.js"></script>
	</head>
	<body>
		<div class="page-container">
			<?php 
				get_total();
				require_once 'php/check_com.php';
			?>
			<form action="" method="post" class="main">
				<label>enter a brief comment</label>
				<textarea class="form-text" name="comment" id="comment" placeholder="say something...."></textarea>
				<br />
				<?php
				echo "<input type='submit' class='form-submit' name='new_comment' value='post'>";
				echo "<input type='submit' 	 name='logout' value='logout'>";
				echo "<p class='signin-link'>
				<a href='php/login.php'> longin </a> or <a href='php/signin.php'>sign up</a> to comment.
				</p>";
				echo $_SESSION['user'];	
				?>
				<!--
				<input type="submit" class="form-submit" name="new_comment" value="post">
				<br />
				<br />
				<p class="signin-link">
				<a href="php/login.php"> longin </a> or <a href="php/signin.php">singup</a> to comment.
				</p>
				-->
			</form>
			<?php get_comments(); ?>
		</div>
	</body>
</html>