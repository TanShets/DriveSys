<!DOCTYPE html>
<html>
<?php
	session_start();
	if(isset($_SESSION['username'])){unset($_SESSION['username']);}
	if(isset($_SESSION['password'])){unset($_SESSION['password']);}
	session_destroy();
?>
<head>
	<title>Logged Out</title>
	<link rel = "stylesheet" type = "text/css" href = "intery.css">
</head>
<body>
	<div class = "logout-1">
		<div class = "details">Logged out Successfully!</div>
	</div>
	<form action = "login.php" id = "pos">
		<button class= "submit" name = "login" value = "login">Back To Login Page</button>
	</form>
</body>
</html>