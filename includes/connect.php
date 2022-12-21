<?php
//session_start();

$db_server = "localhost";
$db_user = "mchrzanowski1";
$db_password = "Mrnugget1";
$database = "mchrzanowski1_readit";

$conn = new mysqli($db_server, $db_user, $db_password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} else {
	// echo "connection good";
}


//This stops SQL Injection in POST vars
foreach ($_POST as $key => $value) {
	$_POST[$key] = mysqli_real_escape_string($conn, $value);
}
//This stops SQL Injection in GET vars
foreach ($_GET as $key => $value) {
	$_GET[$key] = mysqli_real_escape_string($conn, $value);
}

if (!defined("BASE_URL")) {
	define("BASE_URL", "http://mchrzanowski1.dmitstudent.ca/dmit2503/new-readit/");
}
