<?php
// Pateikia dažniausiai užduodamus klausimus

session_start();
include("include/nustatymai.php");

// Sesijos kontrolė
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location:logout.php");exit;}

?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Dažniausiai užduodami klausimai (DUK)</title>
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
            <h1>Dažniausiai užduodami klausimai (DUK)</h1>

<table class="center"  border="1" cellspacing="0" cellpadding="3"  style='text-align: left'>
    	    	<th>Klausimas</th>
		<th>Atsakymas</th>
	</tr>


<?php
$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($db, "utf8");
$sql = "SELECT question,answer "
            . "FROM " . TBL_DUK;

    $result = mysqli_query($db, $sql);
	if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Klaida skaitant lentelę"; exit;}

	while($row = mysqli_fetch_assoc($result))
		{
		echo "<tr>
		<td>".$row['question']."</td>
		<td>".$row['answer']."</td>
		</tr>";
		} 
?>
</table>


