<?php
session_start();
include("include/nustatymai.php");

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index")) {
    header("Location: logout.php");
    exit;
}

// Redagavimo rėžimas
if (isset($_GET['edit'])) {
    $editdukID = $_GET['edit'];
    $editMode = true;

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
    $sql = "SELECT question,answer FROM " . TBL_DUK . " WHERE id = $editdukID";
    $result = mysqli_query($db, $sql);
    $dukData = mysqli_fetch_assoc($result);

} elseif (isset($_GET['remove'])) {
    $removedukID = $_GET['remove'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
    $sql = "DELETE FROM " . TBL_DUK . " WHERE id = $removedukID";
    $result = mysqli_query($db, $sql);
    header("Location: _DUKRedagavimas.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>DUK redagavimas</title>
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
        <h1>DUK</h1>

        <form method="post" action=" _DUKRedagavimas.php">
            <?php if (isset($editMode)): ?>
                <input type="hidden" name="editdukID" value="<?php echo $editdukID; ?>">
            <?php endif; ?>

		<label for="question">Klausimas</label>
		<textarea name="question" id="question" rows="1" cols="50"><?php
   		 if (isset($dukData['question']) ) {
        		echo $dukData['question'];
    		} elseif (isset($_POST['question'])) {
        		echo htmlspecialchars($_POST['question']);
    		} else {
        		echo '';
    		}
		?></textarea>
		<br>

		<label for="answer">Atsakymas</label>
		<textarea name="answer" id="answer" rows="1" cols="50"><?php
   		 if (isset($dukData['answer']) ) {
        		echo $dukData['answer'];
    		} elseif (isset($_POST['answer'])) {
        		echo htmlspecialchars($_POST['answer']);
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
            <th>Klausimas</th>
            <th>Atsakymas</th>
            <th>Veiksmai</th>

            <?php
            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	    mysqli_set_charset($db, "utf8");
            $sql = "SELECT id, question, answer FROM " . TBL_DUK;
            $result = mysqli_query($db, $sql);

            if (!$result || (mysqli_num_rows($result) < 1)) {
                echo "Klaida skaitant lentelę";
                exit;
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['question'] . "</td>
                        <td>" . $row['answer'] . "</td>
                        <td>
                           <a href=' _DUKRedagavimas.php?edit=" . $row['id'] . "'>Redaguoti</a>
                            <a href=' _DUKRedagavimas.php?remove=" . $row['id'] . "'>Ištrinti</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");

    $question = $_POST['question'];
    $answer = $_POST['answer'];

 if (empty($question) || empty($answer) ||  strlen($question) < 3 || strlen($answer) < 3) 
	{
       			echo "<p style='color: red;'>Netinkamas duomenų formatas. Duomenys turi būti sudaryti bent iš 3 simbolių.</p>";
    	} 
	else{

   		 if (isset($_POST['editdukID'])) {
       			 $editdukID = $_POST['editdukID'];
       			 $sql = "UPDATE " . TBL_DUK . " SET question = '$question', answer = '$answer' WHERE id = $editdukID";
    		} else {
        		$sql = "INSERT INTO " . TBL_DUK . " (question,answer) VALUES ('$question', '$answer')";
   		 }

    		$result = mysqli_query($db, $sql);

    		if ($result) {
        		header("Location:  _DUKRedagavimas.php");
        		exit();
    		} else {
        		echo "Duomenų bazės klaida." ; //. mysqli_error($db);
    		}
	}
}

?>

</body>
</html>




