<!DOCTYPE html>
<html>
<?php
	$error = "";
	session_start();
	//if(!empty($_SESSION['account'])){print_r($_SESSION['account']);}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "drivesys";
		$user1 = "";
		$pass1 = "";
		if(!empty($_POST['name'])){$user1 = $_POST['name'];}
		if(!empty($_POST['password'])){$pass1 = $_POST['password'];}
		$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

		if(!$hasStarted){
			die("Failed: ".mysqli_connect_error());
		}
		$cmd = "SELECT* FROM customer WHERE cusername = '$user1' AND cpassword = '$pass1'";

		$outcome = mysqli_query($hasStarted, $cmd);

		$vals = mysqli_fetch_array($outcome);
		if(is_array($vals) && isset($_POST['name']) && isset($_POST['password'])){
			//$_SESSION['username'] = $vals['username'];
			//$_SESSION['password'] = $vals['password'];
			$_SESSION['account'] = $vals;
			header("Location: Account.php");
				exit();
		}
		else{
			if(isset($_POST['name']) && isset($_POST['password'])){
				$error = "Incorrect Username or Password.";
			}
			elseif(isset($_POST['name'])){
				$error = "Enter the password first";
			}
			elseif (isset($_POST['password'])) {
				$error = "Enter the username";
			}
		}
	}

	function gotoCreate(){
		header('Location: Create.php');
		exit();
	}
?>
<head>
	<title>Login</title>
	<link rel = "stylesheet" type = "text/css" href = "interx.css">
</head>
<body>
	<div class = "Login">
		<form action = "login.php" method = "post" class = "login">
			<center><div id = "Title">CUSTOMER LOGIN</div></center>
			<div class = "details">
				<table>
					<td>Username: </td><td><input type="text"name="name" placeholder="Enter Username" class = "input-login"></td>
					<tr><td>Password: </td><td><input type="password"name="password"placeholder="Enter Password" class = "input-login"></td></tr>
				</table>
				<br>
				<div class = "Error"><?php echo "$error"; ?></div>
				<button type = "submit" class = "submit" name = "submit">Login</button>
			</div>
		</form>
		<form id = "goto" action="Create.php">
			<p></p>
			<br>
			<button class = "submit" name = "Create">Create Account</button>
		</form>
		<form id = "goto3" action="login_alt.php">
			<p></p>
			<br>
			<button class = "submit" name = "Create">Driver Login</button>
		</form>
	</div>
</body>
</html>