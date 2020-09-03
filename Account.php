<!DOCTYPE html>
<html>
<?php
	session_start();
	$mainServe = "localhost";
	$mainuser = "root";
	$mainpass = "";
	$dbname = "DriveSys";
	$connection = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);
	if(!$connection){
		die("Failed: ".mysqli_connect_error());
	}
?>
<head>
	<title>Welcome</title>
	<link rel = "stylesheet" type = "text/css" href = "interx.css">
</head>
<body>
	<div class = "account">
		<div class = "details">
			<table>
				<tr><td>Name: </td><td><?php echo $_SESSION['account']['cname']; ?></td></tr>
				<tr><td>Username: </td><td><?php echo $_SESSION['account']['cusername']; ?></td></tr>
				<tr><td>Email: </td><td><?php echo $_SESSION['account']['cemail']; ?></td></tr>
				<tr><td>Address: </td><td><?php echo $_SESSION['account']['caddress']; ?></td></tr>
				<tr><td>Number: </td><td><?php echo $_SESSION['account']['cphone']; ?></td></tr>
			</table>
			<form action = "logout.php">
				<button class = "submit" name = "logout">Logout</button>
			</form>
			<p></p>
			<form action = "view.php">
				<button class = "submit" name = "View">Go to View Page</button>
			</form>
		</div>
	</div>
</body>
</html>
