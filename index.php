<?php
	include("dbconnect.php");
	
	$msg = "";
	
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = sha1($_POST['password']); // Encrypt password with sha1() function.
		$userType = $_POST['userType'];
		
		$sql = "SELECT * FROM user WHERE username=? AND password=? AND user_type=?";
		$stmt=$conn->prepare($sql);
		$stmt->bind_param("sss",$username,$password,$userType);
		$stmt->execute();
		$result = $stmt->get_result();
		//$row = $result->fetch_assoc();
		
		
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			
			session_regenerate_id();
			$_SESSION['username'] = $row['username'];
			$_SESSION['role'] = $row['user_type'];
			session_write_close();
		
			if($result->num_rows==1 && $_SESSION['role']=="admin") {
				header("location:admin.php");
			
			} else if($result->num_rows==1 && $_SESSION['role']=="b1") {
				header("location:b1/index.php");
			
			} else if($result->num_rows==1 && $_SESSION['role']=="b2") {
			header("location:b2/index.php");
			} else {
				$msg = "Incorrect username/password. Please try again.";
			}
		
		} else {
			$msg = "Incorrect username/password. Please try again.";
		}
		
		
	}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Normalis Novum University</title>
		<link rel="icon" type="image/png" href="img/logo.png"/>
		<link rel = "stylesheet" href = "css/style.css"/>
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
		integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
	</head>
	
	<body>
		<input type="radio" checked id="toggle--login" name="toggle" class="ghost" />
		<input type="radio" id="toggle--signup" name="toggle" class="ghost" />

		<img class="logo framed" src="img/logo.png" alt="NNU logo" />

		<form class="form form--login framed" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="username" name="username" placeholder="Username" class="input input--top" required />
			<input type="password" name="password" placeholder="Password" class="input" required />
			
			<div class="form-group lead">
				<label for="userType">I'm from:</label>
				<input type="radio" name="userType" value="b1" class="custom-radio" required /> &nbsp;b1 &nbsp; | &nbsp;
				<input type="radio" name="userType" value="b2" class="custom-radio" required /> &nbsp;b2 &nbsp; | &nbsp;
				<input type="radio" name="userType" value="admin" class="custom-radio" required /> &nbsp;Admin
			</div>
			
			<input type="submit" name="login" class="input input--submit"  />
			<label for="toggle--signup" class="text text--small text--centered">New? <b>Sign up</b></label>
			<h5 class="text-danger text-center"><?php echo $msg; ?></h5>
			
		</form>
  
		<form class="form form--signup framed" action="#">
			<h2 class="text text--centered text--omega">Sign up <b>if you're one</b> with</br>the employees</h2>

			<input type="email" placeholder="Email" class="input input--top" />
			<input type="password" placeholder="Password" class="input" />
			<input type="text" placeholder="Username" class="input" />
			<input type="submit" value="Sign up" class="input input--submit" />
    
			<label for="toggle--login" class="text text--small text--centered">Not new? <b>Log in</b></label>
		</form>

		<div class="photo-cred">
			<a class="text text--small" title="Check out their blog." href="https://www.pexels.com/photo/back-to-school-flatlay-5088013/" target="_blank">Photo by <b>Olia Danilevich</b></a>
		</div>

		<div class="fullscreen-bg"></div>
	</body>
</html>