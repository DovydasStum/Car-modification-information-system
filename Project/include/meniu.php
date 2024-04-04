<?php
// meniu.php  rodomas meniu pagal vartotojo rolę

if (!isset($_SESSION)) { header("Location: logout.php");exit;}
include("include/nustatymai.php");
$user=$_SESSION['user'];
$userlevel=$_SESSION['ulevel'];
$role="Svečias";
foreach($user_roles as $x=>$x_value)
	 {if ($x_value == $userlevel) $role=$x;}

echo '<style>
  .button-link {
    	display: inline-block;
    	padding: 10px 20px;
	background-color: white; 
    	color: black; 
    	text-decoration: none;
	border: 2px solid #d9718b; 
    	border-radius: 5px; 
    	margin: 5px;
	text-align: center;
    	transition: background-color 0.3s, color 0.3s;
	font-family: Arial, sans-serif;
  }

.button-link:hover {
    	background-color: grey; 
    	color: #ffffff; 
  }
</style>';


     	echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
        echo "<tr><td style='background-color: white; font-family: Arial, sans-serif;'>";
        echo "Prisijungęs vartotojas: <b>".$user."</b>     Rolė: <b>".$role."</b> <br>";
        echo "</td></tr><tr><td>";
	

	// ---------------------------------------------------------------------------------------------------------------------------	
	// 	Svečio sąsaja
	// ---------------------------------------------------------------------------------------------------------------------------

	if ($_SESSION['user'] == "guest") 
	{
		echo '<div> 
			<a href="_Tiuningas.php" class="button-link">Tiuningas</a>
			<a href="_Atsiliepimai.php" class="button-link">Atsiliepimai</a>
			<a href="_DUK.php" class="button-link">D.U.K</a>
		</div>';
	}


	// ---------------------------------------------------------------------------------------------------------------------------	
	// 	Nario sąsaja
	// ---------------------------------------------------------------------------------------------------------------------------

	if ($userlevel == 2) 
	{
		echo '<div> 
			<a href="_Automobiliai.php" class="button-link">Prekės</a>
			<a href="_Tiuningas.php" class="button-link">Tiuningas</a>
		</div>';

		echo '<div> 
			<a href="_Žinutės.php" class="button-link">Žinutės</a>
			<a href="_Užsakymai.php" class="button-link">Užsakymai</a>
		</div>';

		echo '<div>
			<a href="_Atsiliepimai.php" class="button-link">Atsiliepimai</a>
			<a href="_DUK.php" class="button-link">D.U.K</a>
		</div>';
	}


	// ---------------------------------------------------------------------------------------------------------------------------	
	// 	Tiekėjo sąsaja
	// ---------------------------------------------------------------------------------------------------------------------------

	if ($userlevel == 4) 
	{
		echo '<div> 
			<a href="_UžsakymaiEdit.php" class="button-link">Užsakymų valdymas</a>
			<a href="_ModifikacijųRedagavimas.php" class="button-link">Prekių redagavimas</a>
		</div>';
	}


	// ---------------------------------------------------------------------------------------------------------------------------	
	// 	Administratoriaus sąsaja
	// ---------------------------------------------------------------------------------------------------------------------------

	if ($userlevel == $user_roles[ADMIN_LEVEL] ) 
	{
		echo '<div> 
			<a href="_Automobiliai.php" class="button-link">Prekės</a>
			<a href="_Tiuningas.php" class="button-link">Tiuningas</a>
			<a href="_ŽinutėsAdmin.php" class="button-link">Žinutės</a>
			<a href="_Atsiliepimai.php" class="button-link">Atsiliepimai</a>
			<a href="_DUK.php" class="button-link">D.U.K</a>
		</div>';

		echo '<div> 
			<a href="_AutomobiliųRedagavimas.php" class="button-link">Automobilių redagavimas</a>
			<a href="_ModifikacijųRedagavimas.php" class="button-link">Prekių redagavimas</a>
			<a href="_DUKRedagavimas.php" class="button-link">D.U.K redagavimas</a>
			<a href="_AtsiliepimųRedagavimas.php" class="button-link">Atsiliepimų redagavimas</a>
		</div>';

		echo '<div> 
			<a href="_UžsakymaiEdit.php" class="button-link">Užsakymų valdymas</a>
			<a href="_Nariai.php" class="button-link">Narių valdymas</a>	
		</div>';
	}

	// ---------------------------------------------------------------------------------------------------------------------------

       echo "<br><br>";
	if ($_SESSION['user'] != "guest") 
	{
		echo '<div> 
			<a href="useredit.php" class="button-link">Redaguoti paskyrą</a>
			<a href="logout.php" class="button-link">Atsijungti</a>
		</div>';
	}
	else
	{
		echo '<div> 
			<a href="logout.php" class="button-link">Atsijungti</a>
		</div>';
	}
        echo "</td></tr></table>";
?>       
