<?php 
// define('DB_HOST', 'localhost'); 
// define('DB_USERNAME', 'root'); 
// define('DB_PASSWORD', ''); 
// define('DB_NAME', 'ENTER_DB_NAME');


$serveur="localhost";
$user="********";
$pw="********";
$bdname="id18767507_localisation_pfe";  

$db = new PDO("mysql:host=$serveur;dbname=$bdname", $user, $pw);

// date_default_timezone_set('Asia/Karachi');

// Connect with the database 
// $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME); 
 
// Display error if failed to connect 
// if ($db->connect_errno) { 
//     echo "Connection to database is failed: ".$db->connect_error;
//     exit();
// }