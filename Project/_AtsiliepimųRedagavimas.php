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
    $sql = "DELETE FROM " . TBL_REVIEWS . " WHERE id = $removeID";
    $result = mysqli_query($db, $sql);
    header("Location: _AtsiliepimųRedagavimas.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Atsiliepimų redagavimas</title>
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
        <h1>Atsiliepimai</h1>
        <br>

       <table class="center" border="1" cellspacing="0" cellpadding="3" style="text-align: justify;color:black;font-family: Arial, sans-serif;">
            <th>Naudotojas</th>
            <th>Atsiliepimas</th>
	    <th>Parašymo data</th>
            <th>Veiksmai</th>

            <?php
            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	    mysqli_set_charset($db, "utf8");
            $sql = "SELECT id, text, username,date FROM " . TBL_REVIEWS;
            $result = mysqli_query($db, $sql);

            if (!$result || (mysqli_num_rows($result) < 1)) {
                echo "Klaida skaitant lentelę";
                exit;
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['text'] . "</td>
			<td>" . $row['date'] . "</td>
                        <td>
                            <a href=' _AtsiliepimųRedagavimas.php?remove=" . $row['id'] . "'>Ištrinti</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>




