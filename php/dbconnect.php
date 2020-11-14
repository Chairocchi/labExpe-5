<?php
	//error_reporting(0);
	session_start();

	//DEFINE("BASE_URL","http://localhost/labExpe-5/");

	date_default_timezone_set('Asia/Hong_Kong'); 

	//Development Connection
	//$conn = new mysqli("localhost", "root", "", "labexpe");

	define('DB_SERVER','localhost');
	define('DB_USER','root');
	define('DB_PASS' ,'');
	define('DB_NAME', 'labexpe');
	$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	 }
 ?>