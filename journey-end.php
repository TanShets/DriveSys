<!DOCTYPE html>
<html>
<?php
	session_start();
	//if(isset($_SESSION['username'])){unset($_SESSION['username']);}
	//if(isset($_SESSION['password'])){unset($_SESSION['password']);}
	//session_destroy();
?>
<head>
	<title>Journey Ended</title>
	<link rel = "stylesheet" type = "text/css" href = "intery.css">
</head>
<body>
	<div class = "logout-1">
		<div class = "details">Journey Ended</div>
	</div>
	<form action = "logout.php" id = "pos">
		<button class= "submit" name = "login" value = "login">LOGOUT</button>
	</form>
</body>
</html>