<?php
session_start();
include("include/nustatymai.php");

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index")) {
    header("Location: logout.php");
    exit;
}

$NameError = '';
$ManufactorError = '';
$ModelError = '';
$YearError = '';
$PriceError = '';
$CountError = '';
$DeliveryError = '';

?>


<?php

// Redagavimo rėžimas
if (isset($_GET['edit'])) {
    $editModID = $_GET['edit'];
    $editMode = true;

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
    $sql = "SELECT name, car_manufactor, car_model, car_year, price, count, delivery FROM " . TBL_MODS . " WHERE id = '$editModID'";
    $result = mysqli_query($db, $sql);
    $modData = mysqli_fetch_assoc($result);

// Šalinimo rėžimas
} elseif (isset($_GET['remove'])) {
    $removeModID = $_GET['remove'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
    $sql = "DELETE FROM " . TBL_MODS . " WHERE id = '$removeModID'";
    $result = mysqli_query($db, $sql);
    //header("Location: _ModifikacijųRedagavimas.php");
    //exit();
}

// Pridėjimo rėžimas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");

    $name = $_POST['name'];
    $car_manufactor = $_POST['car_manufactor'];
    $car_model = $_POST['car_model'];
    $car_year = $_POST['car_year'];
    $price= floatval($_POST['price']);
    $count = $_POST['count'];
    $delivery = $_POST['delivery'];

	if (empty($name) || strlen($name) < 4) 
	{
			$NameError = "Netinkamas duomenų formatas. Pavadinimas turi būti sudarytas iš bent 4 simbolių.";
    	} 
	else if (empty($car_manufactor) || strlen($car_manufactor) < 4) 
	{
			$ManufactorError = "Netinkamas duomenų formatas. Gamintojas turi būti sudarytas iš bent 4 simbolių.";
    	} 
	else if (empty($car_model)  || strlen($car_model) < 2) 
	{
			$ModelError = "Netinkamas duomenų formatas. Modelis turi būti sudarytas iš bent 2 simbolių.";
    	} 
	else if (empty($car_year) || !is_numeric($car_year) || strlen($car_year) != 4 ||
			$car_year <= 1900 || $car_year > date('Y')) 
	{
			$YearError = "Netinkamas metų formatas.";
    	} 
	else if (empty($price) || !is_numeric($price)) 
	{
			$PriceError = "Netinkamas kainos formatas.";
    	} 
	else if (!isset($count) || !is_numeric($count) || $count < 0) 
	{
			$CountError = "Netinkamas kiekio formatas.";
    	} 

	else if (empty($delivery) ||  strlen($delivery) < 3) 
	{
			$DeliveryError = "Netinkamas duomenų formatas. Duomenys apie pristatymą turi būti sudaryti iš bent 3 simbolių.";
    	} 

	else {
   		 if (isset($_POST['editModID'])) {
       			 $editModID = $_POST['editModID'];
        		$sql = "UPDATE " . TBL_MODS . " SET name = '$name', car_manufactor = '$car_manufactor', car_model = '$car_model', 
         		car_year = '$car_year', price = '$price', count = '$count', delivery = '$delivery'  WHERE id = '$editModID'";

   		 } else {
        		$sql = "INSERT INTO " . TBL_MODS . " (name, car_manufactor, car_model, car_year,price,count,delivery) 
					VALUES ('$name', '$car_manufactor', '$car_model', '$car_year', '$price','$count','$delivery')";
    		}

   		 $result = mysqli_query($db, $sql);

   		 if ($result) {
       			 header("Location:  _ModifikacijųRedagavimas.php");
       			 exit();
    		} else {
       			 echo "Duomenų bazės klaida."; //. mysqli_error($db);
    		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Prekių redagavimas</title>
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
        <h1>Prekės</h1>

       
        <form method="post" action=" _ModifikacijųRedagavimas.php">
            <?php if (isset($editMode)): ?>
                <input type="hidden" name="editModID" value="<?php echo $editModID; ?>">
            <?php endif; ?>

	    <label for="name">Pavadinimas</label>
            <textarea name="name" id="name" rows="1" cols="30"><?php
		if (isset($modData['name']))	
			echo $modData['name'];
		elseif (isset($_POST['name']))
			echo htmlspecialchars($_POST['name']);
		else echo '';
 		?></textarea>
            <br>
		
          	<label for="car_manufactor">Markė</label>
		<textarea name="car_manufactor" id="car_manufactor" rows="1" cols="30"><?php
    		if (isset($modData['car_manufactor'])) {
        		echo $modData['car_manufactor'];
    		} elseif (isset($_POST['car_manufactor'])) {
        		echo htmlspecialchars($_POST['car_manufactor']);
    		} else {
       		 	echo '';
    		}
		?></textarea>
		<br>

                <label for="car_model">Modelis</label>
		<textarea name="car_model" id="car_model" rows="1" cols="30"><?php
    		if (isset($modData['car_model'])) {
       			 echo $modData['car_model'];
   		 } elseif (isset($_POST['car_model'])) {
        		echo htmlspecialchars($_POST['car_model']);
   		 } else {
        		echo '';
   		 }
		?></textarea>
		<br>

		<label for="car_year">Metai</label>
		<textarea name="car_year" id="car_year" rows="1" cols="30"><?php
    		if (isset($modData['car_year'])) {
       			 echo $modData['car_year'];
   		 } elseif (isset($_POST['car_year'])) {
        		echo htmlspecialchars($_POST['car_year']);
    		} else {
       			 echo '';
    		}
		?></textarea>
		<br>

	     <label for="price">Kaina</label>
		<textarea name="price" id="price" rows="1" cols="30"><?php
   		 if (isset($modData['price'])) {
        		echo $modData['price'];
    		} elseif (isset($_POST['price'])) {
        		echo htmlspecialchars($_POST['price']);
    		} else {
        		echo '';
    		}
		?></textarea>
		<br>

	    <label for="count">Kiekis</label>
		<textarea name="count" id="count" rows="1" cols="30"><?php
   		 if (isset($modData['count'])) {
       			 echo $modData['count'];
    		} elseif (isset($_POST['count'])) {
       			 echo htmlspecialchars($_POST['count']);
    		} else {
        		echo '';
    		}
		?></textarea>
		<br>

	    <label for="delivery">Pristatymo terminas</label>
		<textarea name="delivery" id="delivery" rows="1" cols="30"><?php
   		 if (isset($modData['delivery'])) {
       			 echo $modData['delivery'];
   		 } elseif (isset($_POST['delivery'])) {
        		echo htmlspecialchars($_POST['delivery']);
    		} else {
        		echo '';
    		}
		?></textarea>
		<br>
                <br>

            <input type="submit" value="<?php echo isset($editMode) ? 'Atnaujinti' : 'Pridėti'; ?>">
        </form>

        <br>

        <table class="center" border="1" cellspacing="0" cellpadding="3" style="text-align: left;color:black;font-family: Arial, sans-serif;">
	    <th>Pavadinimas</th>
            <th>Skirta markei</th>
            <th>Skirta modeliui</th>
            <th>Automobilio pagaminimo metai</th>
	     <th>Kaina</th>
	     <th>Kiekis</th>
	    <th>Pristatymas</th>
            <th>Veiksmai</th>

            <?php
            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		mysqli_set_charset($db, "utf8");
            $sql = "SELECT id, name, car_manufactor, car_model, car_year, price, count,delivery FROM " . TBL_MODS;
            $result = mysqli_query($db, $sql);

            if (!$result || (mysqli_num_rows($result) < 1)) {
                echo "Klaida skaitant lentelę";
                exit;
            }

	    echo "<p style='color: red;'>$NameError</p>";
	    echo "<p style='color: red;'>$ManufactorError</p>";
	    echo "<p style='color: red;'>$ModelError</p>";
	    echo "<p style='color: red;'>$YearError</p>";
	    echo "<p style='color: red;'>$PriceError</p>";
	    echo "<p style='color: red;'>$CountError</p>";
	    echo "<p style='color: red;'>$DeliveryError</p>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
			<td>" . $row['name'] . "</td>
                        <td>" . $row['car_manufactor'] . "</td>
                        <td>" . $row['car_model'] . "</td>
                        <td style='text-align: right'>" . $row['car_year'] . "</td>
                        <td style='text-align: right'>" . number_format($row['price'], 2) . "</td>
                        <td style='text-align: right'>" . $row['count'] . "</td>
		        <td style='text-align: right'>" . $row['delivery'] . "</td>
                        <td>
                           <a href='_ModifikacijųRedagavimas.php?edit=" . $row['id'] . "'>Redaguoti</a>
                            <a href='_ModifikacijųRedagavimas.php?remove=" . $row['id'] . "'>Ištrinti</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>




</body>
</html>




