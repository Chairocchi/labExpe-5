<?php
	//error_reporting(0);
	session_start();

	//DEFINE("BASE_URL","http://localhost/labExpe-5/");

	date_default_timezone_set('Asia/Hong_Kong'); 

	//Development Connection
	/* 	define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS' ,'');
		define('DB_NAME', 'labexpe');
		$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME); 
	*/
	
	//Remote Connection
	define('DB_SERVER','klbcedmmqp7w17ik.cbetxkdyhwsb.us-east-1.rds.amazonaws.com');
	define('DB_USER','gyq4hcxyeqz6vqd4');
	define('DB_PASS' ,'zwkjsdv3wvyhw9o9');
	define('DB_NAME', 'ro2rqdi96z1gwj6j');
	$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME); 
	

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	 }
 ?>