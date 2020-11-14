<?php
	include("php/dbconnect.php");
	$error = '';
	if(isset($_POST['save'])) {
		$oldpassword = mysqli_real_escape_string($conn,$_POST['oldpassword']);
		$newpassword = mysqli_real_escape_string($conn,$_POST['newpassword']);
		$sql = "select * from user where username= '".$_SESSION['username']."' and password='".sha1($oldpassword )."'";
		$q = $conn->query($sql);

		if($q->num_rows>0) {

			$sql = "update user set  password = '".sha1($newpassword)."' WHERE username = '".$_SESSION['username']."'";
			$r = $conn->query($sql);
			echo '<script type="text/javascript">window.location="setting.php?act=1"; </script>';
		} else {
			$error = '<div class="alert alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Error!</strong> Wrong old password
						</div>';
		}

	}

?>

	<?php include("php/head.php"); ?>
		<script src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
		
	</head>
	
	<body>
		<div id="wrapper">
			<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<p class="navbar-brand">Normalis Novum University</p>
				</div>

			</nav>
			<!-- /. NAV TOP  -->
			<nav class="navbar-default navbar-side" role="navigation">
				<div class="sidebar-collapse">
					<ul class="nav" id="main-menu">

						<li><a href="admin.php"><i class="fa fa-dashboard "></i>Dashboard</a></li>
				
						<li><a href="accountant.php"><i class="fa fa-users "></i>Accountants</a></li>
						
						<li><a href="branch.php"><i class="fa fa-university "></i>Branch</a></li>
							
						<li><a href="student.php"><i class="fa fa-users "></i>Student</a></li>
							
						<li><a href="fees.php"><i class="fa fa-usd "></i>Fees</a></li>
							
						<li><a href="report.php"><i class="fa fa-file-text "></i>Report </a></li>
						
						<li><a class="active-menu" href="setting.php"><i class="fa fa-cogs "></i>Setting</a></li>
							
							
						<li><a href="logout.php" onclick="return confirm('Are you sure?')"><i class="fa fa-power-off "></i>Logout</a></li>
							
					</ul>

				</div>
			</nav>
			<!-- /. NAV SIDE  -->
			
			<div id="page-wrapper">
				<div id="page-inner">
					<div class="row">
						<div class="col-md-12">
							<h1 class="page-head-line">Setting</h1>
						 
	<?php
	if(isset($_REQUEST['act']) &&  @$_REQUEST['act']=='1')
	{
	echo '<div class="alert alert-success">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Success!</strong> Password Change Successfully.
	</div>';

	}
	echo $error;
	?>
						</div>
					</div>
					<!-- /. ROW  -->
					<div class="row">
					
						<div class="col-sm-8 col-sm-offset-2">
				   <div class="panel panel-primary">
							<div class="panel-heading">
							  Change Password
							</div>
							<form action="setting.php" method="post" id="signupForm1" class="form-horizontal">
							<div class="panel-body">
							
							
							
							
							<div class="form-group">
									<label class="col-sm-4 control-label" for="Old">Old Password</label>
									<div class="col-sm-5">
										<input type="password" class="form-control" id="oldpassword" name="oldpassword"  />
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-4 control-label" for="Password"> New Password</label>
									<div class="col-sm-5">
										 <input class="form-control" name="newpassword" id="newpassword" type="password">
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-4 control-label" for="Confirm">Confirm Password</label>
									<div class="col-sm-5">
										   <input class="form-control" name="confirmpassword" type="password">
									</div>
								</div>
							
							<div class="form-group">
									<div class="col-sm-9 col-sm-offset-4">
										<button type="submit" name="save" class="btn btn-primary">Save </button>
									</div>
								</div>
							 
							   
							   
							 
							   
							 </div>
								</form>
								
							</div>
								</div>
				
				
					</div>
					<!-- /. ROW  -->

				
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
		<!-- /. WRAPPER  -->

		<div id="footer-sec">
				<p class="credits">Normalis Novum University | Brought To You By : 
				<a href="https://github.com/Chairocchi">Allen Garcia <span class="love">❤</span></p>
		</div>
	   
	  
		<!-- BOOTSTRAP SCRIPTS -->
		<script src="js/bootstrap.js"></script>
		<!-- METISMENU SCRIPTS -->
		<script src="js/jquery.metisMenu.js"></script>
		   <!-- CUSTOM SCRIPTS -->
		<script src="js/custom1.js"></script>
		
			<script type="text/javascript">
			

			$( document ).ready( function () {			
				
				$( "#signupForm1" ).validate( {
					rules: {
						oldpassword: "required",
					
						newpassword: {
							required: true,
							minlength: 6
						},
						
						confirmpassword: {
							required: true,
							minlength: 6,
							equalTo: "#newpassword"
						}
					},
					messages: {
						oldpassword: "Please enter your old password",
						
						newpassword: {
							required: "Please provide a password",
							minlength: "Your password must be at least 6 characters long"
						},
						confirmpassword: {
							required: "Please provide a password",
							minlength: "Your password must be at least 6 characters long",
							equalTo: "Please enter the same password as above"
						}
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );

						// Add `has-feedback` class to the parent div.form-group
						// in order to add icons to inputs
						element.parents( ".col-sm-5" ).addClass( "has-feedback" );

						if ( element.prop( "type" ) === "checkbox" ) {
							error.insertAfter( element.parent( "label" ) );
						} else {
							error.insertAfter( element );
						}

						// Add the span element, if doesn't exists, and apply the icon classes to it.
						if ( !element.next( "span" )[ 0 ] ) {
							$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
						}
					},
					success: function ( label, element ) {
						// Add the span element, if doesn't exists, and apply the icon classes to it.
						if ( !$( element ).next( "span" )[ 0 ] ) {
							$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
						}
					},
					highlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
						$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
					},
					unhighlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
						$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
					}
				} );
			} );
		</script>


	</body>
</html>
