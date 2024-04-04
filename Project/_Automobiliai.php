<?php
// Pateikia modifikuojamų automobilių sąrašą (svečiui) ir galimas modifikacijas (nariui ir administratoriui)

session_start();
include("include/nustatymai.php");

// Sesijos kontrolė
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location:logout.php");exit;}

$userlevel=$_SESSION['ulevel'];
$role="Svečias";

foreach($user_roles as $x=>$x_value)
	if ($x_value == $userlevel) $role=$x;

?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Prekės</title>
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
            <h1>Automobiliai</h1>


<?php
$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($db, "utf8");

echo "<form method='POST' action=''>";
echo "<label>Gamintojas</label>";
echo "<select name='manufactor'>";
$sql = "SELECT DISTINCT manufactor FROM " . TBL_CARS;
$result = mysqli_query($db, $sql);
	if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Klaida skaitant lentelę"; exit;}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['manufactor'] . "'>" . $row['manufactor'] . "</option>";
}
echo "</select>";
echo "<input type='submit' name='submit_manufacturer' value='Patvirtinti gamintoją'>";
echo "</form>";


if (isset($_POST['submit_manufacturer'])) {
    	$selectedManufacturer = $_POST['manufactor'];

    	echo "<form method='POST' action=''>";
	echo "<input type='hidden' name='manufactor' value='$selectedManufacturer'>";
   	echo "<label>Modelis</label>";
   	echo "<select name='model'>";
	$sql = "SELECT model FROM " . TBL_CARS . " WHERE manufactor = '$selectedManufacturer'";
    	$result = mysqli_query($db, $sql);
   	while ($row = mysqli_fetch_assoc($result)) {
        	echo "<option value='" . $row['model'] . "'>" . $row['model'] . "</option>";
   	 }
    	echo "</select>";
    	echo "<input type='submit' name='submit_model' value='Patvirtinti modelį'>";
    	echo "</form>";

	echo "Tarpinis pasirinkimas:<br>";
	echo "Gamintojas: $selectedManufacturer<br>";
}


if (isset($_POST['submit_model'])) {
   	 $selectedManufacturer = $_POST['manufactor'];
    	$selectedModel = $_POST['model'];

    	echo "<form method='POST' action=''>";
    	echo "<input type='hidden' name='manufactor' value='$selectedManufacturer'>";
    	echo "<input type='hidden' name='model' value='$selectedModel'>";
   	echo "<label>Pagaminimo metai</label>";
   	echo "<select name='year'>";
    	$sql = "SELECT year FROM " . TBL_CARS . " WHERE manufactor = '$selectedManufacturer' AND model = '$selectedModel'";
    	$result = mysqli_query($db, $sql);
   	 while ($row = mysqli_fetch_assoc($result)) {
        	echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
    	}
    	echo "</select>";
    	echo "<input type='submit' name='submit_year' value='Patvirtinti pagaminimo metus'>";
    	echo "</form>";

	echo "Tarpinis pasirinkimas:<br>";
	echo "Gamintojas: $selectedManufacturer<br>";
    	echo "Modelis: $selectedModel<br>";
}


if (isset($_POST['submit_year'])) {
    	$selectedManufacturer = $_POST['manufactor'];
    	$selectedModel = $_POST['model'];
    	$selectedYear = $_POST['year'];

    	echo "Pilnas pasirinkimas:<br>";
    	echo "Gamintojas: $selectedManufacturer<br>";
    	echo "Modelis: $selectedModel<br>";
    	echo "Pagaminimo metai: $selectedYear<br>";
    	echo "<tr>";
	echo "<td>";
	if ($userlevel == 2 || $userlevel == 3) 
	{
		echo "<div style='text-align: center;'>
    		<form method='POST' action=''>
                	<input type='hidden' name='model' value='$selectedModel'>
                	<input type='hidden' name='manufactor' value='$selectedManufacturer'>
			<input type='hidden' name='year' value='$selectedYear'>
                	<input type='submit' name='show_mods' value='Rodyti prekes'>
		 </form>
		</div>";
		echo "</td>";
   		echo "</tr>";
       	}
	else if ($userlevel < 2) 
	{
    		echo "<br>";
		echo "<div style='text-align: center;'>
   			 Prisijunkite, norėdami matyti prekes.
		</div>";
       	}	
}


if (isset($_POST['buy_button']) || isset($_POST['order_button'])) {
    	$selectedItem = $_POST['selected_item'];
    	$selectedItemId = $_POST['selected_item_id'];
    	$selectedPrice = $_POST['selectedPrice'];
     	$selectedDelivery = $_POST['selectedDelivery'];
	$selectedMan = $_POST['selectedMan'];
	$selectedModel = $_POST['selectedModel'];
	$selectedYear= $_POST['selectedYear'];


	echo "Jūs pasirinkote: $selectedItem<br>";

        echo "<form method='POST' action=''>
           	 <input type='hidden' name='confirmed_item' value='$selectedItem'>
           	 <input type='hidden' name='confirmed_item_id' value='$selectedItemId'>
	     	 <input type='hidden' name='selectedPrice' value='$selectedPrice'>
              	 <input type='hidden' name='selectedDelivery' value='$selectedDelivery'>
		 <input type='hidden' name='selectedMan' value='$selectedMan'>
		 <input type='hidden' name='selectedModel' value='$selectedModel'>
		 <input type='hidden' name='selectedYear' value='$selectedYear'>
           	 <button type='submit' name='confirm_button'>Patvirtinti</button>
          </form>";
}


if (isset($_POST['confirm_button'])) {
     	$confirmedItem = $_POST['confirmed_item'];
    	$confirmedItemId = $_POST['confirmed_item_id'];
    	$user = $_SESSION['user']; 
    	$selectedPrice = $_POST['selectedPrice'];
	$selectedDelivery = $_POST['selectedDelivery'];
	$selectedMan = $_POST['selectedMan'];
	$selectedModel = $_POST['selectedModel'];
	$selectedYear= $_POST['selectedYear'];


    $sql = "INSERT INTO " . TBL_ORDERS . " (user, modification_name, car_data, price, delivery, status) 
            VALUES ('$user', '$confirmedItem', '$selectedMan $selectedModel $selectedYear', '$selectedPrice', '$selectedDelivery', '1')";

    $result = mysqli_query($db, $sql);

     if ($result) {
       	 echo "Jūs patvirtinote pasirinkimą: $confirmedItem<br>";
     } else {
        	echo "Duomenų bazės klaida." ; //. mysqli_error($db);
     }
}

?>

<?php

if (isset($_POST['show_mods'])) {
    	$model = $_POST['model'];
    	$manufactor = $_POST['manufactor'];
	$year = $_POST['year'];

    	$mods_sql = "SELECT id,name,price,count,delivery,car_manufactor,car_model,car_year FROM " . TBL_MODS . " 
		WHERE car_model = '$model' 
		AND car_manufactor = '$manufactor' AND car_year = '$year'";

    	$mods_result = mysqli_query($db, $mods_sql);

	if (!$mods_result || (mysqli_num_rows($mods_result) < 1))  
	{
		echo "<br>". "Automobiliui " . $manufactor. " " . $model . " " . $year. " prekių nėra."; exit;
	}
	else
	{
		echo "<br>". "Prekės automobiliui " . $manufactor. " " . $model . " " . $year. ":<br>";
		echo "<br>". "Prekės sandelyje"."<br>";

		echo "<table class='center' border='1' cellspacing='0' cellpadding='3' style='text-align: left'>";
		echo "<tr>";
    		echo "<th>". "Pavadinimas". "</th>";
		echo "<th>". "Kaina". "</th>";
		echo "<th>". "Likutis". "</th>";
	        echo "<th>". "Pristatymas". "</th>";
		echo "<th>". "Pirkti". "</th>";
		echo "</tr>";

    		while ($mod = mysqli_fetch_assoc($mods_result)) {
			if ($mod['count'] > 0)
			{
				echo "<tr>";
    				echo "<td>" . $mod['name'] . "</td>";
    				echo "<td style='text-align: right'>" . number_format($mod['price'], 2) . "</td>";
   				echo "<td style='text-align: right'>" . $mod['count'] . "</td>";
				echo "<td style='text-align: right'>" . $mod['delivery'] . "</td>";
				echo "<td>
                		<form method='POST' action=''>
                    			<input type='hidden' name='selected_item' value='" . $mod['name'] . "'>
                    			<input type='hidden' name='selected_item_id' value='" . $mod['id'] . "'>
                                	<input type='hidden' name='selectedPrice' value='" . $mod['price'] . "'>
                                	<input type='hidden' name='selectedDelivery' value='" . $mod['delivery'] . "'>
					<input type='hidden' name='selectedMan' value='" . $mod['car_manufactor'] . "'>
					<input type='hidden' name='selectedModel' value='" . $mod['car_model'] . "'>
					<input type='hidden' name='selectedYear' value='" . $mod['car_year'] . "'>
                    			<button type='submit' name='buy_button'>Pirkti</button>
                		</form>
             			 </td>";
        			echo "</tr>";
			}
		}
		echo "</table>";
		echo "<br>";

		$mods_sql1 = "SELECT id,name,price,count,delivery,car_manufactor,car_model,car_year FROM " . TBL_MODS . " WHERE car_model = '$model' 
			AND car_manufactor = '$manufactor' AND car_year = '$year' AND count = 0";
		$mods_result1= mysqli_query($db, $mods_sql1);
		if (mysqli_num_rows($mods_result1)  > 0)
		{
			echo "<br>". "Užsakomos prekės"."<br>";
			echo "<table class='center' border='1' cellspacing='0' cellpadding='3' style='text-align: left'>";
			echo "<tr>";
    			echo "<th>". "Pavadinimas". "</th>";
			echo "<th>". "Kaina". "</th>";
			echo "<th>". "Likutis". "</th>";
	        	echo "<th>". "Pristatymas". "</th>";
			echo "<th>". "Užsakyti". "</th>";
			echo "</tr>";		
		
			while ($mod1 = mysqli_fetch_assoc($mods_result1)) {
				if ($mod1['count']  == 0)
				{
					echo "<tr>";
    					echo "<td>" . $mod1['name'] . "</td>";
    					echo "<td style='text-align: right'>" . number_format($mod1['price'], 2) . "</td>";
   					echo "<td style='text-align: right'>" . $mod1['count'] . "</td>";
					echo "<td style='text-align: right'>" . $mod1['delivery'] . "</td>";
					 echo "<td>
               				 <form method='POST' action=''>
                    				<input type='hidden' name='selected_item' value='" . $mod1['name'] . "'>
                    				<input type='hidden' name='selected_item_id' value='" . $mod1['id'] . "'>
	                                	<input type='hidden' name='selectedPrice' value='" . $mod1['price'] . "'>
                               			 <input type='hidden' name='selectedDelivery' value='" . $mod1['delivery'] . "'>
						<input type='hidden' name='selectedMan' value='" . $mod1['car_manufactor'] . "'>
						<input type='hidden' name='selectedModel' value='" . $mod1['car_model'] . "'>
						<input type='hidden' name='selectedYear' value='" . $mod1['car_year'] . "'>
                    				<button type='submit' name='order_button'>Užsakyti</button>
                			</form>
             				</td>";
        				echo "</tr>";
				}
			}
			echo "</table>";
			echo "<br>";
		}
	}
}
?>

</table>
</body>
