<!DOCTYPE html>
<html>
<?php
	$error = array(
		"username" => "",
		"password" => "",
		"cpassword" => "",
		"name" => "",
		"email" => "",
		"address" => "",
		"number" => ""
	);
	$no_of_errors = 0;
	session_start();
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "drivesys";
		$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

		if($hasStarted == NULL || !$hasStarted){
			die("Failed: ".mysqli_connect_error());
		}
		$user1 = mysqli_real_escape_string($hasStarted, $_POST['username']);
		$pass1 = mysqli_real_escape_string($hasStarted, $_POST['password']);
		$cpass1 = mysqli_real_escape_string($hasStarted, $_POST['cpassword']);
		$name1 = mysqli_real_escape_string($hasStarted, $_POST['name']);
		$email1 = mysqli_real_escape_string($hasStarted, $_POST['email']);
		$address1 = mysqli_real_escape_string($hasStarted, $_POST['address']);
		$number1 = mysqli_real_escape_string($hasStarted, $_POST['number']);

		$cmd1 = "SELECT* FROM customer WHERE cusername = '$user1'";
		$cmd2 = "SELECT* FROM customer WHERE cemail = '$email1'";
		$out_username = mysqli_query($hasStarted, $cmd1);
		$out_email = mysqli_query($hasStarted, $cmd2);

		$vals_username = mysqli_fetch_array($out_username);
		$vals_email = mysqli_fetch_array($out_email);
		$pattern = "[a-Z]";

		if(empty($_POST['username'])){
			$no_of_errors += 1;
			$error['username'] = "Please enter a username";
		}
		elseif(is_array($vals_username)){
			$no_of_errors += 1;
			$error['username'] = "Username already exists, try another one";
		}
		elseif(strlen($user1) < 4){
			$no_of_errors += 1;
			$error['username'] = "Invalid Username";
		}

		if(empty($_POST['email'])){
			$no_of_errors += 1;
			$error['email'] = "Please enter an email";
		}
		elseif(is_array($vals_email)){
			$no_of_errors += 1;
			$error['email'] = "Email already in use, try another one";
		}
		elseif(strlen($email1) < 6 || !filter_var($email1, FILTER_VALIDATE_EMAIL)){
			$error['email'] = "Invalid email";
			$no_of_errors += 1;
		}

		if(empty($_POST['password'])){
			$no_of_errors += 1;
			$error['password'] = "Please enter a password";
		}
		elseif(strlen($pass1) < 6){
			$no_of_errors += 1;
			$error['password'] = "Password too short, Please enter atleast 6 characters.";	
		}

		if(empty($_POST['cpassword'])){
			$no_of_errors += 1;
			$error['cpassword'] = "Please confirm password";
		}
		elseif($cpass1 != $pass1){
			$no_of_errors += 1;
			$error['cpassword'] = "Password and confirmation are not the same";	
		}

		if(empty($_POST['name']) || strlen($name1) < 3){
			$no_of_errors += 1;
			$error['name'] = "Please enter your name";
		}
		elseif(strlen($name1) < 3){
			$no_of_errors += 1;
			$error['name'] = "Name too short";
		}
		elseif(!preg_match("/[a-zA-Z]+/", $name1, $match)){
			$no_of_errors += 1;
			$error['name'] = "Please enter a proper name";
		}

		if(empty($_POST['address']) || strlen($_POST['address'] < 10)){
			$no_of_errors += 1;
			$error['address'] = "Enter a proper address";
		}

		if(empty($_POST['number']) || strlen($number1) != 10){
			$no_of_errors += 1;
			$error['number'] = "Enter the appropriate number";
		}

		if($no_of_errors == 0){
			$cmd = "INSERT INTO customer(cusername, cpassword, cemail, caddress, cphone, cname) VALUES('$user1', '$pass1', '$email1', '$address1', '$number1', '$name1')";
			$out1 = mysqli_query($hasStarted, $cmd);
			if(!$out1 || !$out2){
				echo "ERROR: Could not execute $sql. " . mysqli_error($hasStarted);
			}
			$cmdx = "SELECT* FROM customer WHERE cusername = '$user1' AND cpassword = '$pass1'";
			$out2 = mysqli_query($hasStarted, $cmdx);
			$new_val = mysqli_fetch_array($out2);

			if(is_array($new_val)){
				$SESSION['account'] = $new_val;
				header("Location: login.php");
				exit();
			}
		}
	}

	function gotoCreate($event){
		header('Location: Create.php');
		exit();
	}
?>
<head>
	<title>Create Customer Account</title>
	<link rel = "stylesheet" type = "text/css" href = "interx.css">
	<link rel = "stylesheet" type = "text/css" href = "interw.css">
</head>
<body>
	<div>
		<form action = "Create.php" method = "post" class = "Create">
			<center><div id = "Title-2">CREATE CUSTOMER ACCOUNT</div></center>
			<div class = "details">
				<table>
					<td>Username: </td><td><div id = "tab"><input type="text"name="username" placeholder="Enter Username" class = "input-create"></div></td>
					<tr><td>Password: </td><td><div id = "tab"><input type="password"name="password"placeholder="Enter Password" class = "input-create"></div></td></tr>
					<tr><td>Confirm Password: </td><td><div id = "tab"><input type="password"name="cpassword"placeholder="Confirm Password" class = "input-create"></div></td></tr>
					<tr><td>Name: </td><td><div id = "tab"><input type="text" name="name"placeholder="Enter your name" class = "input-create"></div></td></tr>
					<tr><td>Email: </td><td><div id = "tab"><input type="email" name="email"placeholder="this.example@site.com" class = "input-create"></div></td></tr>
					<tr><td>Address: </td><td><div id = "tab"><textarea type="text" name="address"placeholder="X place, X road, X City" class = "input-create"></textarea></div></td></tr>
					<tr><td>Contact No.: </td><td><div id = "tab"><input type="number" name="number"placeholder="Enter your number" class = "input-create"></div></td></tr>
				</table>
				<p></p>
				<button type = "submit" class = "submit" name = "submit">Create Account</button>
			</div>
		</form>
	</div>
	<div class = "Create-2">
		<table id = "gappy">
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['username']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['password']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['cpassword']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['name']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['email']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['address']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['number']; ?></div>
			</div></td></tr>
		</table>
	</div>
</body>
</html>