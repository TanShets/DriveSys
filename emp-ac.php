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
				<tr><td>Name: </td><td><?php echo $_SESSION['account']['ename']; ?></td></tr>
				<tr><td>Designation: </td><td><?php echo $_SESSION['account']['edesignation']; ?></td></tr>
				<tr><td>Address: </td><td><?php echo $_SESSION['account']['eaddress']; ?></td></tr>
				<tr><td>Number: </td><td><?php echo $_SESSION['account']['ephone']; ?></td></tr>
			</table>
			<form action = "logout.php">
				<button class = "submit" name = "logout">Logout</button>
			</form>
			<p></p>
			<form action = "view-journey.php">
				<button class = "submit" name = "View">Go to Journey Entry</button>
			</form>
		</div>
	</div>
</body>
</html>
