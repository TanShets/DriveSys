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
	$dname = "";
	$ppoint = "";
	$did = "";
	$destination = "";
	$new_val = "";
	$ended = "";
	if(isset($_SESSION['journey']) && !empty($_SESSION['journey'])){
		$did = $_SESSION['journey']['did'];
		$ppoint = $_SESSION['journey']['ppoint'];
		$destination = $_SESSION['journey']['destination'];
		$cmd = "SELECT dname FROM driver WHERE did = '$did'";
		$out = mysqli_query($connection, $cmd);
		$new_val = mysqli_fetch_array($out);
		print_r($_SESSION['journey']);
		$dname = $new_val['dname'];
		$tofill = 0;

		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$mainServe = "localhost";
			$mainuser = "root";
			$mainpass = "";
			$dbname = "drivesys";
			$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

			if($hasStarted == NULL || !$hasStarted){
				die("Failed: ".mysqli_connect_error());
			}

			if(!empty($_POST['isend']) && $_POST['isend'] == "ended"){
				$dtime = date("H:i:s");
				$cid = $_SESSION['journey']['cid'];
				$cmd1 = "UPDATE journey SET dtime = '$dtime', jcomplete = 1 WHERE cid = '$cid' AND did = '$did'";
				$out1 = mysqli_query($connection, $cmd1);
				$tofill = 1;
			}
			elseif(!empty($_POST['isend']) && $_POST['isend'] == "rating"){
				$rating = $_POST['rating'];
				$cid = $_SESSION['journey']['cid'];
				$cmd2 = "UPDATE journey SET rating = '$rating' WHERE cid = '$cid' AND did = '$did'";
				$out2 = mysqli_query($connection, $cmd2);
				header("Location: journey-end.php");
					exit();
			}
		}
	}
?>
<head>
	<title>Your Journey has started!</title>
	<link rel = "stylesheet" type = "text/css" href = "intery.css">
	<link rel = "stylesheet" type = "text/css" href = "interw.css">
</head>
<body>
	<div class = "logout-1">
		<div class = "details3">Journey has started!</div>
		<div class = "details3">Driver Name: <?php echo $dname; ?></div>
		<div class = "details3">From: <?php echo $ppoint; ?></div>
		<div class = "details3">To: <?php echo $destination; ?></div>
	</div>
	<?php
		if($tofill == 1){
			echo "\n<form action = \"journey.php\" method = \"post\">";
			echo "\n<input type = \"hidden\" name = \"isend\" value = \"rating\">";
			echo "\n<input type = \"number\" name = \"rating\" step = \"0.1\" class = \"input-login\">";
			echo "\n<button type = \"submit\" class = \"submit\" name = \"submit\">Give Rating</button>";
			echo "\n</form>";
		}
	?>
	<form action = "journey.php" method = "post" id = "pos">
		<input type="hidden" name = "isend" value="ended">
		<button class= "submit" name = "submit">End Journey</button>
	</form>
	<p></p>
	<form action = "logout.php" method = "post">
		<button class= "submit" name = "submit">LOGOUT</button>
	</form>
</body>
</html>