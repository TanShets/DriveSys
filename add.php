<!DOCTYPE html>
<html>
<?php
	$error = array(
		"name" => "",
		"designation" => "",
		"dlicense" => "",
		"address" => "",
		"number" => ""
	);
	$no_of_errors = 0;
	session_start();
	$formtype = "";
	$stat = array(
		"designation" => "disabled",
		"dlicense" => "disabled"
	);
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "drivesys";
		$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

		if($hasStarted == NULL || !$hasStarted){
			die("Failed: ".mysqli_connect_error());
		}
		$acctype = "";

		if(!empty($_POST['formtype'])){
			$formtype = $_POST['formtype'];
			if($formtype == "2"){
				if(!empty($_POST['acctype'])){
					$acctype = $_POST['acctype'];
					define("c", $acctype);
					if($acctype == "driver"){
						$stat['dlicense'] = "";
					}
					else{
						$stat['designation'] = "";
					}
				}
			}
			elseif($formtype == "1"){
				$name1 = mysqli_real_escape_string($hasStarted, $_POST['name']);
				$check = $_POST['check'];
				if($check == "1"){
					$designation1 = mysqli_real_escape_string($hasStarted, $_POST['designation']);
					$stat['designation'] = "";
				}
				elseif($check == "0"){
					$dlicense1 = mysqli_real_escape_string($hasStarted, $_POST['dlicense']);
					$stat['dlicense'] = "";
				}
				$address1 = mysqli_real_escape_string($hasStarted, $_POST['address']);
				$number1 = mysqli_real_escape_string($hasStarted, $_POST['number']);

				if($check == "0"){
					$cmd1 = "SELECT* FROM driver WHERE dlicense = '$dlicense1'";
					$out = mysqli_query($hasStarted, $cmd1);
					$vals = mysqli_fetch_array($out);
				}
				$pattern = "[a-Z]";

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

				if($check == "1" && (empty($_POST['designation']) || strlen($_POST['designation']) < 5)){
					$no_of_errors += 1;
					$error['designation'] = "Please enter a proper designation";
				}

				if($check == "0" && (empty($_POST['dlicense']) || strlen($_POST['dlicense']) < 10)){
					$no_of_errors += 1;
					$error['dlicense'] = "Please enter a proper license no.";
				}
				elseif($check == "0" && is_array($vals)){
					$no_of_errors += 1;
					$error['dlicense'] = "License No. already exists, try again.";
				}

				if(empty($_POST['address']) || strlen($_POST['address'] < 10)){
					$no_of_errors += 1;
					$error['address'] = "Enter a proper address";
				}

				if(empty($_POST['number']) || strlen($number1) != 10){
					$no_of_errors += 1;
					$error['number'] = "Enter the appropriate number";
				}

				//echo $no_of_errors;

				if($no_of_errors == 0){
					//$cmdx = "";
					if($check == "0"){
						$cmdx = "INSERT INTO driver(dname, dlicense, daddress, dphone) VALUES('$name1', '$dlicense1', '$address1', '$number1')";
						$outx = mysqli_query($hasStarted, $cmdx);
					}
					elseif($check == "1"){
						$cmdx = "INSERT INTO emp(ename, edesignation, eaddress, ephone) VALUES('$name1', '$designation1', '$address1', '$number1')";
						$outx = mysqli_query($hasStarted, $cmdx);
					}
					else{
						$cmdx = "";
					}

					if($cmdx != ""){
						if($check == "0"){
							$cmdy = "SELECT* FROM driver WHERE dname = '$name1' AND dlicense = '$dlicense1' AND daddress = '$address1' AND dphone = '$number1'";
						}
						elseif($check == "1"){
							$cmdy = "SELECT* FROM emp WHERE ename = '$name1' AND edesignation = '$designation1' AND eaddress = '$address1' AND ephone = '$number1'";
						}
						else{
							$cmdy = "";
						}
						$outy = mysqli_query($hasStarted, $cmdy);
						$new_val = mysqli_fetch_array($outy);
						print_r($new_val);
						if(is_array($new_val)){
							header("Location: adminhome.php");
							exit();
						}
					}
				}
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
		<div class = "Create">
			<center><div id = "Title-2">ADD TO DRIVESYS</div></center>
			<form action = "add.php" method = "post" class = "detailsx">
				<input type="hidden" name = "formtype" value = "2">
				<table id = "table1">
					<td><div id = "tab"><select class = "input-create1" name = "acctype">
						<option value="driver">Driver</option>
						<option value="emp">Employee</option>
					</select></div></td>
					<td><button type = "submit" class = "submit" name = "submit">Select</button></td>
				</table>
			</form>
			<form action = "add.php" method = "post" class = "details">
				<table>
					<tr><td>Name: </td><td><div id = "tab"><input type="text" name="name"placeholder="Enter your name" class = "input-create"></div></td></tr>
					<td>Designation: </td><td><div id = "tab"><input type="text"name="designation" placeholder="Enter Employee Designation" class = "input-create" <?php echo $stat['designation']; ?>></div></td>
					<tr><td>D.License No.: </td><td><div id = "tab"><input type="text"name="dlicense"placeholder="Enter D. License No." class = "input-create" <?php echo $stat['dlicense']; ?>></div></td></tr>
					<tr><td>Address: </td><td><div id = "tab"><textarea type="text" name="address"placeholder="X place, X road, X City" class = "input-create"></textarea></div></td></tr>
					<tr><td>Contact No.: </td><td><div id = "tab"><input type="number" name="number"placeholder="Enter your number" class = "input-create"></div></td></tr>
				</table>
				<p></p>
				<input type="hidden" name="check" value = <?php 
					if($stat['designation'] == ""){ echo "1"; }
					elseif($stat['dlicense'] == ""){ echo "0"; }
				?>>
				<input type = "hidden" name = "formtype" value = "1">
				<button type = "submit" class = "submit" name = "submit">Create Account</button>
			</form>
		</div>
	</div>
	<div class = "Create-2">
		<table id = "gappy">
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['name']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['designation']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['dlicense']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['address']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['number']; ?></div>
			</div></td></tr>
		</table>
	</div>
</body>
</html>