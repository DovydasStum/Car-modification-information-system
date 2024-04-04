<?php
session_start();
include("include/nustatymai.php");

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index")) {
    header("Location: logout.php");
    exit;
}

$ManufactorError = '';
$ModelError = '';
$YearError = '';
?>

<?php

// Redagavimo rėžimas
if (isset($_GET['edit'])) {
    $editCarID = $_GET['edit'];
    $editMode = true;

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT manufactor, model, year FROM " . TBL_CARS . " WHERE id = $editCarID";
    $result = mysqli_query($db, $sql);
    $carData = mysqli_fetch_assoc($result);

} elseif (isset($_GET['remove'])) {
    $removeCarID = $_GET['remove'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "DELETE FROM " . TBL_CARS . " WHERE id = $removeCarID";
    $result = mysqli_query($db, $sql);
    header("Location: _AutomobiliųRedagavimas.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $manufactor = $_POST['manufactor'];
    $model = $_POST['model'];
    $year = $_POST['year'];

	if (empty($manufactor) || strlen($manufactor) < 4) {
		$ManufactorError = "Netinkamas duomenų formatas. Markė turi būti sudaryta iš bent 4 simbolių.";
    	} 
	else if (empty($model) ||  strlen($model) < 4) {
		$ModelError = "Netinkamas duomenų formatas. Modelis turi būti sudarytas iš bent 4 simbolių.";
    	} 
	else if (empty($year) || !is_numeric($year) || strlen($year) != 4 ||
			$year <= 1900 || $year > date('Y')) {
		$YearError = "Netinkamas metų formatas.";
    	} 
   	else{
		if (isset($_POST['editCarID'])) {
        		$editCarID = $_POST['editCarID'];
        		$sql = "UPDATE " . TBL_CARS . " SET manufactor = '$manufactor', model = '$model', year = '$year' WHERE id = $editCarID";
    		} else {
        		$sql = "INSERT INTO " . TBL_CARS . " (manufactor, model, year) VALUES ('$manufactor', '$model', '$year')";
		}

    		$result = mysqli_query($db, $sql);

    		if ($result) {
       			 header("Location:  _AutomobiliųRedagavimas.php");
       			 exit();
   		 } else {
       			 echo "Duomenų bazės klaida.";
   		 }
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Automobiliai</title>
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
        <h1>Automobiliai</h1>
	
        <form method="post" action=" _AutomobiliųRedagavimas.php">
            <?php if (isset($editMode)): ?>
                <input type="hidden" name="editCarID" value="<?php echo $editCarID; ?>">
            <?php endif; ?>

          	<label for="manufactor">Markė</label>
		<textarea name="manufactor" id="manufactor" rows="1" cols="30"><?php
    		if (isset($carData['manufactor'])) {
        		echo $carData['manufactor'];
    		} elseif (isset($_POST['manufactor'])) {
        		echo htmlspecialchars($_POST['manufactor']);
    		} else {
       		 	echo '';
    		}
		?></textarea>
		<br>

          	<label for="model">Modelis</label>
		<textarea name="model" id="model" rows="1" cols="30"><?php
    		if (isset($carData['model'])) {
        		echo $carData['model'];
    		} elseif (isset($_POST['model'])) {
        		echo htmlspecialchars($_POST['model']);
    		} else {
       		 	echo '';
    		}
		?></textarea>
		<br>

          	<label for="year">Metai</label>
		<textarea name="year" id="year" rows="1" cols="30"><?php
    		if (isset($carData['year'])) {
        		echo $carData['year'];
    		} elseif (isset($_POST['year'])) {
        		echo htmlspecialchars($_POST['year']);
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
	<tr>
            <th>Markė</th>
            <th>Modelis</th>
            <th>Pagaminimo metai</th>
            <th>Veiksmai</th>
	</tr>

            <?php
            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT id, manufactor, model, year FROM " . TBL_CARS;
            $result = mysqli_query($db, $sql);

            if (!$result || (mysqli_num_rows($result) < 1)) {
                echo "Klaida skaitant lentelę";
                exit;
            }

	    echo "<p style='color: red;'>$ManufactorError</p>";
	    echo "<p style='color: red;'>$ModelError</p>";
	    echo "<p style='color: red;'>$YearError</p>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['manufactor'] . "</td>
                        <td>" . $row['model'] . "</td>
                        <td style='text-align:right'>" . $row['year'] . "</td>
                        <td>
                           <a href=' _AutomobiliųRedagavimas.php?edit=" . $row['id'] . "'>Redaguoti</a>
                            <a href=' _AutomobiliųRedagavimas.php?remove=" . $row['id'] . "'>Ištrinti</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>




