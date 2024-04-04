<?php
//nustatymai.php
define("DB_SERVER", "localhost");
define("DB_USER", "stud");
define("DB_PASS", "stud");
define("DB_NAME", "project");
define("TBL_USERS", "users");
define("TBL_CARS", "cars");
define("TBL_MODS", "modifications");
define("TBL_REVIEWS", "reviews");
define("TBL_DUK", "duk");
define("TBL_MESSAGES", "messages");
define("TBL_ORDERS", "orders");
define("TBL_STATUS", "order_status");

$user_roles=array(     
	"Svečias"=>"1",
	"Narys"=>"2",
	"Administratorius"=>"3",
	"Tiekėjas"=>"4");   
define("DEFAULT_LEVEL","Narys");  // kokia rolė priskiriama kai registruojasi
define("ADMIN_LEVEL","Administratorius");  // kas turi vartotojų valdymo teisę
define("UZBLOKUOTAS","255");      // vartotojas negali prisijungti kol administratorius nepakeis rolės
$uregister="both";  // kaip registruojami vartotojai
// self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai
// * Email Constants - 
define("EMAIL_FROM_NAME", "Demo");
define("EMAIL_FROM_ADDR", "demo@ktu.lt");
define("EMAIL_WELCOME", false);
