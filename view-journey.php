<!DOCTYPE html>
<html>

<?php
    session_start();
?>
<head>
<title>AdminView</title>
<link href = "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel = "stylesheet">
</head>

<body>

<center><h2>All Journeys</h2></center>


<?php
    //include("connection.php");
    $mainServe = "localhost";
    $mainuser = "root";
    $mainpass = "";
    $dbname = "drivesys";
    $hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);
    //$cmd = "SELECT * FROM user";
    $cmd = "CREATE OR REPLACE VIEW journeys AS SELECT* FROM customer INNER JOIN journey USING(cid)";
    $out = mysqli_query($hasStarted, $cmd);
    $cmd = "CREATE OR REPLACE VIEW journeysx AS SELECT* FROM driver INNER JOIN journeys USING(did)";
    $out = mysqli_query($hasStarted, $cmd);
    $cmd1 = "SELECT* FROM journeysx";
    $out1 = mysqli_query($hasStarted, $cmd1);
    $i = 1;
?>


<br>
<table align="center" border="1px" style="width:800px; line-height:20px;">
    <tr>
        <th><center>Sr. No.</center></th>
        <th><center>Date</center></th>
        <th><center>cid</center></th>
        <th><center>C.Name</center></th>
        <th><center>did</center></th>
        <th><center>D.Name</center></th>
        <th><center>P.Point</center></th>
        <th><center>Destination</center></th>
        <th><center>Pickup Time</center></th>
        <th><center>Drop-off Time</center></th>
    </tr>

    <?php
        while($rows = mysqli_fetch_assoc($out1))
        {
    ?>
            <tr>
                <td><center><?php echo $i; $i++; ?></center></td>
            <td><center><?php echo $rows['jdate']; ?></center></td>
                <td><center><?php echo $rows['cid']; ?></center></td>
                <td><center><?php echo $rows['cname']; ?></center></td>
                <td><center><?php echo $rows['did']; ?></center></td>
                <td><center><?php echo $rows['dname']; ?></center></td>
                <td><center><?php echo $rows['ppoint']; ?></center></td>
                <td><center><?php echo $rows['destination']; ?></center></td>
                <td><center><?php echo $rows['ptime']; ?></center></td>
                <td><center><?php echo $rows['dtime']; ?></center></td>
    <?php        
        }
    ?>

</table>
    <br><br>
    <center><form action=<?php if($_SESSION['status'] == 1){ echo "\"adminhome.php\""; }else{ echo "\"emp-ac.php\""; } ?>><button title="Logout" type = "Logout" name = "logout">Back</button></form></center>
    <br><br>
    <center><form action="logout.php"><button title="Logout" type = "Logout" name = "logout">Logout</button></form></center>
</body>
</html>  