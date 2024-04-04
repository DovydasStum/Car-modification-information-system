<?php
// Pateikia forumą skaitymui (svečiui) ir rašymui (nariui ir administratoriui)

session_start();
include("include/nustatymai.php");

$_SESSION['t_error']=""; 

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
        <title>Atsiliepimų forumas</title>
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
            <h1>Atsiliepimų forumas</h1>

	<table class="center"  border="1" cellspacing="0" cellpadding="3"  style="text-align: left">
    	    	<th>Naudotojas</th>
		<th>Atsiliepimas</th>
		<th>Data</th>
	</tr>


<?php
$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($db, "utf8");
$sql = "SELECT username,text,date "
            . "FROM " . TBL_REVIEWS;

    	$result = mysqli_query($db, $sql);
	if (!$result || (mysqli_num_rows($result) < 1))  
		{echo "Klaida skaitant lentelę"; exit;}

	while($row = mysqli_fetch_assoc($result))
	{
		$time = date("Y-m-d G:i", strtotime($row['date']));

		echo "<tr>
		<td>".$row['username']."</td>
		<td>".$row['text']."</td>
		<td  style='text-align: right'>".$time."</td>
		</tr>";
	} 
?>
</table><br>


<?php
	// Atsiliepimo rašymas
	if ($userlevel >= 2) {
    		echo "<form method='POST' action='_Atsiliepimai.php'>";

    		echo "<label for='review_text'>Jūsų atsiliepimas:</label>";
    		echo "<textarea name='text' id='text' rows='3' cols='30'>";
    		if (isset($_POST['text'])) {
        		echo htmlspecialchars($_POST['text']);
    		} else {
        		echo '';
    		}
    		echo "</textarea><br>";

    		echo "<input type='submit' value='Pateikti'>";
    		echo "</form>";
	}
	else
	{
		echo "Norėdami rašyti atsiliepimą, prisijunkite";
	}


	// Naujo įrašo talpinimas į db
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		mysqli_set_charset($db, "utf8");

		$username = $_SESSION['user'];
		if ($username == null)
			$username = "guest";

    		$text = $_POST['text']; 
		if (empty($text)) {
       			echo "<p style='color: red;'>Atsiliepimas negali būti tuščias.</p>";
    		} 
		elseif (strlen($text) < 3) {
        		echo "<p style='color: red;'>Atsiliepimas turi būti bent 3 simbolių ilgio.</p>";
    		}
		else {
    			$sql = "INSERT INTO " . TBL_REVIEWS . " (username, text) VALUES ('$username', '$text')";
    			$result = mysqli_query($db, $sql);

			if ($result) {			    			
				header("Location: _Atsiliepimai.php"); 
        			exit();			
    			} 
			else {
        			echo "Duomenų bazės klaida." ; //. mysqli_error($db);
   			 }
		}		
	}

?>

</div>
</body>
</html>


