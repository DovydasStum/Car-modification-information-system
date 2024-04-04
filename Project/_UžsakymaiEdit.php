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
    header("Location: _UžsakymaiEdit.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	mysqli_set_charset($db, "utf8");
    	foreach ($_POST['ordstat'] as $orderId => $selectedStatusId) {
       		$orderId = mysqli_real_escape_string($db, $orderId);
		$selectedStatusId = mysqli_real_escape_string($db, $selectedStatusId);

		$updateSql = "UPDATE " . TBL_ORDERS . " SET status = '$selectedStatusId' WHERE id = '$orderId'";
        	$updateResult = mysqli_query($db, $updateSql);

        	if (!$updateResult) {
            		echo "Duomenų bazės klaida.";
       		 }
    	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Užsakymų valdymas</title>
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
            <th>Pirkėjas</th>
	    <th>Prekė</th>
            <th>Automobilio duomenys</th>
            <th>Kaina</th>
	    <th>Pristatymo laikas</th>
	    <th>Užsakymo data</th>
            <th>Užsakymo būsena</th>
	    <th>Pakeisti būseną</th>
	   <th>Patvirtinti būseną</th>
 	   

<?php
            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	    mysqli_set_charset($db, "utf8");
    	    $sql = "SELECT o.id, o.user, o.modification_name, o.car_data, o.price, o.delivery,o.timestamp, s.value AS ordstat
            FROM " . TBL_ORDERS . " o
            JOIN " . TBL_STATUS . " s ON o.status = s.id";
            $result = mysqli_query($db, $sql);

            if (!$result || (mysqli_num_rows($result) < 1)) {
                echo "Klaida skaitant lentelę";
                exit;
            }

	$statusOptions = array();
	$statusQuery = mysqli_query($db, "SELECT id, value FROM " . TBL_STATUS);
	while ($statusRow = mysqli_fetch_assoc($statusQuery)) {
    		$statusOptions[] = $statusRow;
	}

       while ($row = mysqli_fetch_assoc($result)) {
		echo "<form method='POST' action=''>
    		<tr>";
                echo "<tr>
			<td>" . $row['user'] . "</td>
                        <td>" . $row['modification_name'] . "</td>
                        <td>" . $row['car_data'] . "</td>
                        <td style='text-align: right'>" . number_format($row['price'], 2) . "</td>
			<td>" . $row['delivery'] . "</td>
			<td>" . $row['timestamp'] . "</td>
			<td>" . $row['ordstat'] . "</td>
			<td>
            		<select name='ordstat[" . $row['id'] . "]'>";
			foreach ($statusOptions as $status) {
  				$selected = ($status['id'] == $row['status']) ? 'selected' : '';
    				echo "<option value='{$status['id']}' $selected>{$status['value']}</option>";
			}
			echo "</select>
       			</td>
			<td><input type='submit' value='Patvirtinti'></td>			
                        <td>
                        <a href=' _UžsakymaiEdit.php?remove=" . $row['id'] . "'>Ištrinti</a>
                        </td>					
		</tr>";
		echo "</form>";
            }
?>

</table>
</div>
</body>
</html>




