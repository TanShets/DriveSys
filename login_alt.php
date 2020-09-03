<!DOCTYPE html>
<html>
<?php
	$error = "";
	session_start();
	$vals = "";
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "drivesys";
		$id = $_POST['id'];
		$dlicense = $_POST['dlicense'];
		$cmd = "";
		$out = "";
		$new_val = "";
		$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

		if(!$hasStarted){
			die("Failed: ".mysqli_connect_error());
		}

		if(!empty($_POST['dlicense'])){
			$cmd = "SELECT * FROM driver WHERE did = '$id' AND dlicense = '$dlicense'";
			$out = mysqli_query($hasStarted, $cmd);
			$vals = mysqli_fetch_array($out);
			if(is_array($vals) && isset($_POST['id']) && isset($_POST['dlicense'])){}
			else{
				$error = "Invalid credentials";
			}
		}
		else{
			$cmd1 = "SELECT * FROM admin WHERE aid = '$id'";
			$cmd2 = "SELECT * FROM emp WHERE eid = '$id'";
			$out1 = mysqli_query($hasStarted, $cmd1);
			$out2 = mysqli_query($hasStarted, $cmd2);
			$vals = mysqli_fetch_array($out1);
			$vals2 = mysqli_fetch_array($out2);
			if(is_array($vals) && isset($_POST['id'])){
				$_SESSION['account'] = $vals;
				$_SESSION['status'] = 1;
				header("Location: adminhome.php");
					exit();
			}
			elseif(is_array($vals2) && isset($_POST['id'])){
				$_SESSION['account'] = $vals2;
				$_SESSION['status'] = 0;
				header("Location: emp-ac.php");
					exit();
			}
			else{
				$error = "Invalid credentials";
			}
		}
		/*
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
		*/
		//print_r($vals);
	}

	function gotoCreate(){
		header('Location: Create.php');
		exit();
	}
?>
<head>
	<title>Login</title>
	<link rel = "stylesheet" type = "text/css" href = "interx.css">
	<link rel = "stylesheet" type = "text/css" href = "interw.css">
</head>
<body>
	<div>
		<form action = "login_alt.php" method = "post" class = "login2">
			<center><div id = "Title">DRIVER/EMP. LOGIN</div></center>
			<div class = "details">
				<table>
					<td>Registration No.: </td><td><input type="text"name="id" placeholder="Enter Reg. No." class = "input-login"></td>
					<tr><td>Driving License No.: </td><td><input type="text"name="dlicense"placeholder="If the user is a Driver" class = "input-login"></td></tr>
				</table>
				<br>
				<div class = "Error"><?php echo "$error"; ?></div>
				<button type = "submit" class = "submit" name = "submit">Login</button>
			</div>
		</form>
		<form id = "goto2" action="login.php">
			<p></p>
			<br>
			<button class = "submit" name = "Create">Back to Customer Login</button>
		</form>
	</div>
</body>
</html>