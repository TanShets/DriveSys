<!DOCTYPE html>
<html>
	<?php
		session_start();
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "drivesys";
		$connection = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);
		if(!$connection){
			die("Failed: ".mysqli_connect_error());
		}
		$info = array(
			"formtype" => "",
			"adname" => "",
			"username" => "",
			"college" => "",
			"c_board" => "",
			"c_degree" => "",
			"c_cgpa" => "",
			"school" => "",
			"s_board" => "",
			"s_percent" => "",
			"jcollege" => "",
			"jc_board" => "",
			"jc_percent" => "",
			"pcollege" => "",
			"pc_board" => "",
			"pc_degree" => "",
			"pc_cgpa" => "",
			"mname" => "",
			"fname" => "",
			"projects" => "",
			"acourse" => "",
			"age" => "",
			"email" => "",
			"contact_no" => "",
			"j_exp" => "",
			"j_desc" => ""
		);
		$new_val1 = "";
		$temp1 = "";
		$new_val = "";
		$true_val = "";
		$new_val_car = "";
		//$cmd = "SELECT name FROM Users WHERE isAdmin = 1";
		$cmd = "SELECT* FROM driver";
		$out = mysqli_query($connection, $cmd);
		if(!$out){
			echo "ERROR: Could not execute $sql. " . mysqli_error($connection);
		}
		$new_val = mysqli_fetch_all($out);
		$_POST['formtype'] = "";
		$isDisabled = "";
		$isfound = 0;
		//print_r($did);
		if(!empty($new_val)){
			//$true_val = $new_val[$num];
			echo "Yes";
			if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['go'] == "0"){
				echo "no";
				$num = rand(0, count($new_val) - 1);
				echo $num."<br>";
				$did = $new_val[$num][0];
				print_r($did);
				$cmd_car = "SELECT * FROM driver INNER JOIN car USING (did) WHERE did = '$did';";
				$out_car = mysqli_query($connection, $cmd_car);
				$new_val_car = mysqli_fetch_array($out_car);
				$true_val = $new_val_car;
				//$info['adname'] = $_POST['adname'];
				$isfound = 1;
				$isDisabled = "";
				$ppoint = $_POST['ppoint'];
				$destination = $_POST['destination'];
				$ptime = date("H:i:s");
				$date = date("Y-m-d");
				$cid = $_SESSION['account']['cid'];
				$did = $true_val['did'];
				$cmdj = "INSERT INTO journey(cid, did, ppoint, destination, ptime, jdate) VALUES('$cid', '$did', '$ppoint', '$destination', '$ptime', '$date')";
				$out_j = mysqli_query($connection, $cmdj);
					$i = 0;
					echo "<p>Please wait while your driver comes to pick you up!</p>";
					echo "\n<p>Name: ".$true_val['dname']."</p>";
					echo "\n<p>Rating: ".$true_val['drating']."</p>";
					echo "\n<p>Car: ".$true_val['camodel']."</p>";
					echo "\n<p>Car No.: ".$true_val['calicense']."</p>";
					echo "\n<p>Contact: ".$true_val['dphone']."</p>";
					echo "\n<form action = \"view.php\" method = \"post\">";
					echo "\n<input type = \"hidden\"  name = \"go\" value = \"1\">";
					echo "\n<input type = \"hidden\"  name = \"date\" value = \"".$date."\">";
					echo "\n<input type = \"hidden\"  name = \"did\" value = \"".$did."\">";
					echo "\n<input type = \"hidden\"  name = \"ptime\" value = \"".$ptime."\">";
					echo "\n<button type = \"submit\" name = \"submit\">Begin</button>";
					echo "</form>";
			}
			elseif($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['go']) && $_POST['go'] == "1"){
				$i = 1;
				$did = "";
				$jcomplete = "";
				$ptime = "";
				$date = "";
				if(!empty($_POST['did'])){$did = $_POST['did'];}
				$cid = $_SESSION['account']['cid'];
				if(!empty($_POST['date'])){$date = $_POST['date'];}
				if(!empty($_POST['ptime'])){$ptime = $_POST['ptime'];}
				$cmd_j2 = "SELECT * FROM  journey WHERE cid = '$cid' AND did = '$did' and jcomplete = 0 AND jdate = '$date' AND ptime = '$ptime'";
				$out_j2 = mysqli_query($connection, $cmd_j2);
				if($i == 1 || $i == "1"){
					$val_j = mysqli_fetch_array($out_j2);
					$_SESSION['journey'] = $val_j;
					header("Location: journey.php");
						exit();
				}
			}
		}
	?>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "interz.css">
		<link rel = "stylesheet" type = "text/css" href = "interw.css">
		<title>View Resume <?php echo $_POST['formtype']; ?></title>
	</head>
	<body>
		<form action = "view.php" method = "post" class = "form3">
			<div class = "title2">Enter Pickup Point and Destination:</div>
			<table class = "details2" id = "t1">
				<tr>
					<td>Pickup Point: </td>
					<td id = "getwidth"><textarea class = "input-form" placeholder="Enter Pickup Point" name = "ppoint"></textarea></td>
				</tr>
				<tr>
					<td>Destination: </td>
					<td id = "getwidth"><textarea class = "input-form" placeholder="Enter Destination" name = "destination"></textarea></td>
				</tr>
			</table>
			<input type = "hidden" name = "go" value = "0">
			<button type = "submit" class = "submit3">Book</button>
		</form>
		<form action = "logout.php" class = "logout">
			<button class = "submit" name = "logout">Logout</button>
		</form>
		<p></p>
		<br>
		<?php
			
		?>
		<!--
		<form action = "view.php" method = "post" class = "form2">
			<div class="title">Resume</div>
			<div class="details">
				<table>
					<tr><td>Name: </td><td><div id = "tab"><input type="text"name="adname" class = "input-form" value = <?php echo '"'.$info['adname'].'"'; echo $isDisabled;?>></div></td>
					<td>Age: </td><td><div id = "tab"><input type="number"name="age" class = "input-form" value = <?php echo '"'.$info['age'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Email: </td><td><div id = "tab"><input type="text"name="email" class = "input-form" value = <?php echo '"'.$info['email'].'"'; echo $isDisabled;?>></div></td>
					<td>Contact No.: </td><td><div id = "tab"><input type="number"name="contact_no" class = "input-form" value = <?php echo '"'.$info['contact_no'].'" '; echo $isDisabled; ?>></div></td></tr>
					<tr><td>College Name: </td><td><div id = "tab"><input type="text"name="college" class = "input-form" value = <?php echo '"'.$info['college'].'"'; echo $isDisabled;?>></div></td>
					<td>College Board: </td><td><div id = "tab"><input type="text"name="c_board" class = "input-form" value = <?php echo '"'.$info['c_board'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Degree: </td><td><div id = "tab"><input type="text"name="c_degree" class = "input-form" value = <?php echo '"'.$info['c_degree'].'"'; echo $isDisabled;?>></div></td>
					<td>CGPA: </td><td><div id = "tab"><input type="number" step = "0.01" name="c_cgpa" class = "input-form" value = <?php echo '"'.$info['c_cgpa'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Job Experience: </td><td><div id = "tab"><input type="number"name="j_exp" placeholder = "In years" class = "input-form" value = <?php echo '"'.$info['j_exp'].'"'; echo $isDisabled;?>></div></td>
					<td>Job Description: </td><td><div id = "tab"><textarea type="text"name="j_desc" class = "input-form" rows = "3" <?php echo $isDisabled; ?>><?php echo $info['j_desc']; ?></textarea></div></td></tr>
					<tr><td>Post-Grad College: </td><td><div id = "tab"><textarea type="text"name="pcollege" class = "input-form" <?php echo $isDisabled; ?>><?php echo $info['pcollege']; ?></textarea></div></td>
					<td>Post-Grad Board: </td><td><div id = "tab"><input type="text"name="pc_board" class = "input-form" value = <?php echo '"'.$info['pc_board'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Post-Grad Degree: </td><td><div id = "tab"><input type="text"name="pc_degree" class = "input-form" value = <?php echo '"'.$info['pc_degree'].'"'; echo $isDisabled;?>></div></td>
					<td>Post-Grad CGPA: </td><td><div id = "tab"><input type="number"name="pc_cgpa" step = "0.01" class = "input-form" value = <?php echo '"'.$info['pc_cgpa'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>School Name: </td><td><div id = "tab"><input type="text"name="school" class = "input-form" value = <?php echo '"'.$info['school'].'"'; echo $isDisabled;?>></div></td>
					<td>School Board: </td><td><div id = "tab"><input type="text"name="s_board" class = "input-form" value = <?php echo '"'.$info['s_board'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>10th Percentage: </td><td><div id = "tab"><input type="number" name="s_percent" step = "0.01" class = "input-form" value = <?php echo '"'.$info['s_percent'].'"'; echo $isDisabled;?>></div></td>
					<td>Junior College: </td><td><div id = "tab"><input type="text"name="jcollege" class = "input-form" value = <?php echo '"'.$info['jcollege'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>J.C. Board: </td><td><div id = "tab"><input type="text"name="jc_board" class = "input-form" value = <?php echo '"'.$info['jc_board'].'"'; echo $isDisabled;?>></div></td>
					<td>12th Percentage: </td><td><div id = "tab"><input type="number" name="jc_percent" step = "0.01" class = "input-form" value = <?php echo '"'.$info['jc_percent'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Mother's Name: </td><td><div id = "tab"><input type="text"name="mname" class = "input-form" value = <?php echo '"'.$info['mname'].'"'; echo $isDisabled;?>></div></td>
					<td>Father's Name: </td><td><div id = "tab"><input type="text"name="fname" class = "input-form" value = <?php echo '"'.$info['fname'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Additional Course: </td><td><div id = "tab"><textarea type="text"name="acourse" class = "input-form" rows = "5" <?php echo $isDisabled;?>><?php echo $info['acourse']; ?></textarea></div></td>
					<td>Projects: </td><td><div id = "tab"><textarea type="text"name="projects" class = "input-form" rows = "5" <?php echo $isDisabled; ?>><?php echo $info['projects']; ?></textarea></div></td></tr>
				</table>
				<input type = "hidden" name = "form1" value = "proper">
				<input type="hidden" name="username" value = <?php echo $info['username']; ?>>      
				<button class = "submit" type = "submit" <?php echo $isDisabled; ?>>Submit</button>
			</div>
		</form>
	-->
	</body>
</html>