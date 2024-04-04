<?php
session_start();
include("include/nustatymai.php");

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index")) {
    header("Location: logout.php");
    exit;
}

// Redagavimo rėžimas
if (isset($_GET['remove'])) {
    $removeID = $_GET['remove'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
    $sql = "DELETE FROM " . TBL_ORDERS . " WHERE id = $removeID";
    $result = mysqli_query($db, $sql);
	
    $result = mysqli_query($db, $sql);
    header("Location: _Užsakymai.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Užsakymai</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
   	<table class="center" ><tr><td>
           	 <center><img src="include/topM.png"></center>
        </td></tr><tr><td>

   	 <table><tr>
		<td style='background-color: white; font-family: Arial, sans-serif;border:2px solid #d9718b';border-radius: 5px;'>
         		<a href="index.php">Grįžti</a>
      		</td></tr>
	</table>

	<div style="text-align: center;color:#d9718b;font-family: Arial, sans-serif;"> <br><br>
        <h1>Užsakymai</h1>
        <br>

       <table class="center" border="1" cellspacing="0" cellpadding="3" style="text-align: justify;color:black;font-family: Arial, sans-serif;">
	    <th>Prekė</th>
            <th>Automobilio duomenys</th>
            <th>Kaina</th>
	    <th>Pristatymo laikas</th>
            <th>Užsakymo būsena</th>
	    <th>Užsakymo data</th>
	    <th>Atšaukti</th>

 <?php
            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	    mysqli_set_charset($db, "utf8");
    	    $sql = "SELECT o.id, o.user, o.modification_name, o.car_data, o.price, o.delivery,o.timestamp, s.value AS ordstat
            FROM " . TBL_ORDERS . " o
            JOIN " . TBL_STATUS . " s ON o.status = s.id
            WHERE o.user = '{$_SESSION['user']}'";

            $result = mysqli_query($db, $sql);
            if (!$result || (mysqli_num_rows($result) < 1)) {
                echo "Klaida skaitant lentelę";
                exit;
            }

            while ($row = mysqli_fetch_assoc($result)) {
               		echo "<tr>
                        <td>" . $row['modification_name'] . "</td>
                        <td>" . $row['car_data'] . "</td>
                        <td style='text-align: right'>" . number_format($row['price'], 2) . "</td>
			<td>" . $row['delivery'] . "</td>
			<td>" . $row['ordstat'] . "</td> 
			<td>" . $row['timestamp'] . "</td> 
			<td>";
			if ($row['ordstat'] == "Pateiktas")
			{
                       		echo "<a href=' _Užsakymai.php?remove=" . $row['id'] . "'>Atšaukti</a>";
			}
			else
			{	
				echo "Negalima";
			}
			echo "</td></tr>";
            }
?>

</table>
</div>
</body>
</html>




