<?php

ob_start();
session_start();
unset($_SESSION['rainbow_name']);
unset($_SESSION['rainbow_uid']);
unset($_SESSION['rainbow_username']);
echo '<script type="text/javascript">window.location="index.php"; </script>';

$message = "You have been logged out.";
		echo"<script type='text/javascript'> 
				alert('$message');
				window.location.href='index.php'; 
			</script>";
?>