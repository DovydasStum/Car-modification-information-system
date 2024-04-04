<?php
// Pateikia modifikuojamų automobilių sąrašą su tiuningo nuotraukomis

session_start();
include("include/nustatymai.php");

// Sesijos kontrolė
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location:logout.php");exit;}
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Automobilių tiuningas</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
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
            <h1>Automobilių tiuningas</h1>

<table class="center"  border="1" cellspacing="0" cellpadding="3">
	<tr>
    		<th>Gamintojas</th>
		<th>Modelis</th>
		<th style='text-align: right'>Pagaminimo metai</th>	
		<th>Tiuningas</th>
	</tr>

<?php
$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$sql = "SELECT manufactor, model, year "
            . "FROM " . TBL_CARS;

    $result = mysqli_query($db, $sql);
    if (!$result || (mysqli_num_rows($result) < 1))  
	{echo "Klaida skaitant lentelę"; exit;}

	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr>";
    		echo "<td>" . $row['manufactor'] . "</td>";
    		echo "<td>" . $row['model'] . "</td>";
   		echo "<td style='text-align:right'>" . $row['year'] . "</td>";
    		echo "<td>
           	<form method='POST' action=''>
                	<input type='hidden' name='model' value='" . $row['model'] . "'>
                	<input type='hidden' name='manufactor' value='" . $row['manufactor'] . "'>
			<input type='hidden' name='year' value='" . $row['year'] . "'>";
			if ($_SESSION['user'] != "guest") 
			{
                		echo "<input type='submit' name='show_mods' value='Rodyti'>";
			}
			else
			{
				echo "Prisijunkite, norėdami matyti.";
			}
           	 echo "</form></td></tr>";
	} 
?>
</table>


<?php

if (isset($_POST['show_mods'])) {
    	$model = $_POST['model'];
    	$manufactor = $_POST['manufactor'];
    	$year = $_POST['year'];
	
    	$imageFileName = strtolower($manufactor . '' . $model . '' . $year . '.jpeg');

    	echo "<br>". "Automobilis " . $manufactor. " " . $model . " " . $year. " po tiuningo:"."<br>";
        echo "<img src='tuningPhotos/$imageFileName' alt='Tiuningas šiam modeliui negalimas.' width='500'>";
}

?>

</table>
</body>
</html>



