<?php
// _procNariaidb.php   admino nurodytus pakeitimus padaro DB
// $_SESSION['ka_keisti'] kuriuos vartotojus, $_SESSION['pakeitimai'] į kokį userlevel
	
session_start();
// cia sesijos kontrole: tik is _procNariai
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "_procNariai"))
{ header("Location: logout.php");exit;}

include("include/nustatymai.php");
include("include/functions.php");
$_SESSION['prev'] = "_procNariaidb";

$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$i=0;$levels=$_SESSION['pakeitimai'];
foreach ($_SESSION['ka_keisti'] as $user)
  {$level=$levels[$i++];
   if ($level == -1) {
    $sql = "DELETE FROM ". TBL_USERS. "  WHERE  username='$user'";
				         if (!mysqli_query($db, $sql)) {
                   echo " DB klaida šalinant vartotoją: " . $sql . "<br>" . mysqli_error($db);
		               exit;}
   } else {
    $sql = "UPDATE ". TBL_USERS." SET userlevel='$level' WHERE  username='$user'";
				         if (!mysqli_query($db, $sql)) {
                   echo " DB klaida keičiant vartotojo įgaliojimus: " . $sql . "<br>" . mysqli_error($db);
		               exit;}
  }}
$_SESSION['message']="Pakeitimai atlikti sėkmingai";
header("Location:_Nariai.php");exit;
