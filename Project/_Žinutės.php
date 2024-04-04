<?php
// Pateikia žinučių skiltį skaitymui ir rašymui (nariui ir administratoriui)

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
        <title>Žinutės</title>
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
            <h1>Žinutės</h1>

<table class="center"  border="1" cellspacing="0" cellpadding="3"  style="text-align: left">
		<th>Siuntėjas</th>
		<th>Žinutė</th>
		<th>Data</th>
	</tr>


<?php
$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($db, "utf8");
$sql = "SELECT sender, receiver, message, timestamp "
     . "FROM " . TBL_MESSAGES . " WHERE receiver = '" . mysqli_real_escape_string($db, $_SESSION['user']) . "' 
	OR sender = '" . mysqli_real_escape_string($db, $_SESSION['user']) . "'";

    	$result = mysqli_query($db, $sql);
	while($row = mysqli_fetch_assoc($result))
	{
		$time = date("Y-m-d G:i", strtotime($row['timestamp']));

		echo "<tr>
		<td>".$row['sender']."</td>
		<td>".$row['message']."</td>
		<td  style='text-align: right'>".$time."</td>
		</tr>";
	} 
?>
</table>
<br>

<?php
	// Žinutės rašymas
	if ($userlevel == 2) 
	{
    		echo "<form method='POST' action='_Žinutės.php'> 
       			 <label for='message'>Jūsų žinutė administratoriui:</label>
			<textarea name='message' id='message' rows='3' cols='30' >" . (isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '')  .  "</textarea>
       			 <br>
       			 <input type='submit' value='Pateikti'>
    		</form>";
	}


// Naujo įrašo talpinimas į db
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	mysqli_set_charset($db, "utf8");

	$sender = $_SESSION['user'];
	if ($sender == null)
		$sender = "sender";
	$receiver = "admin"; 
	$message= $_POST['message']; 
	$timestamp = date("Y-m-d G:i");

	if (empty($message)) {
       		echo "<p style='color: red;'>Žinutė negali būti tuščia.</p>";
    	} 
	elseif (strlen($message) < 3) {
        	echo "<p style='color: red;'>Žinutė turi būti bent 3 simbolių ilgio.</p>";
    	}
	else{
    		$sql = "INSERT INTO " . TBL_MESSAGES . " (sender,receiver, message) VALUES ('$sender', '$receiver', '$message')";
    		$result = mysqli_query($db, $sql);

		if ($result) {
       	 		echo "Išsaugota.";
			header("Location: _Žinutės.php");   
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