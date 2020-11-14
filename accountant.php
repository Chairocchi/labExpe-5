<?php
	include("php/dbconnect.php");
	//include("php/checklogin.php");
	$errormsg = '';
	$action = "add";

	$id="";
	$username='';
	$password='';
	$name='';
	$branch='';
	$joindate='';
	$dateBirth='';
	$salary='';
	
	if(isset($_POST['save'])) {
		$username = mysqli_real_escape_string($conn,$_POST['username']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);
		$name = mysqli_real_escape_string($conn,$_POST['name']);
		$branch = mysqli_real_escape_string($conn,$_POST['branch']);
		$joindate = mysqli_real_escape_string($conn,$_POST['joindate']);
		$dateBirth = mysqli_real_escape_string($conn,$_POST['dateBirth']);
		$salary = mysqli_real_escape_string($conn,$_POST['salary']);

		if($_POST['action']=="add") {
			$sql = $conn->query("INSERT INTO accountant (username,password,name,branch,joindate,dateBirth,salary) 
			VALUES ('$username','$password','$name','$branch','$joindate','$dateBirth','$salary')") ;
			
			echo '<script type="text/javascript">window.location="accountant.php?act=1";</script>';
	 
		} else if($_POST['action']=="update") {
			$id = mysqli_real_escape_string($conn,$_POST['id']);	
			$sql = $conn->query("UPDATE accountant SET username = '$username', name = '$name', branch  = '$branch', 
			joindate = '$joindate', salary = '$salary'  WHERE  id  = '$id'");
			
			echo '<script type="text/javascript">window.location="accountant.php?act=2";</script>';
		}
	}

	if(isset($_GET['action']) && $_GET['action']=="delete") {
		$conn->query("UPDATE  accountant set delete_status = '1'  WHERE id='".$_GET['id']."'");
		header("location: accountant.php?act=3");
	}

	$action = "add";
	
	if(isset($_GET['action']) && $_GET['action']=="edit" ) {
		$id = isset($_GET['id'])?mysqli_real_escape_string($conn,$_GET['id']):'';
		$sqlEdit = $conn->query("SELECT * FROM accountant WHERE id='".$id."'");
		
		if($sqlEdit->num_rows) {
			$rowsEdit = $sqlEdit->fetch_assoc();
			extract($rowsEdit);
			$action = "update";
		} else {
			$_GET['action']="";
		}
	}


	if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1") {
		$errormsg = "<div class='alert alert-success'><strong>Success!</strong> Accountant Added successfully</div>";
	
	} else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2") {
		$errormsg = "<div class='alert alert-success'><strong>Success!</strong> Accountant Edit successfully</div>";
	
	} else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3") {
		$errormsg = "<div class='alert alert-success'><strong>Success!</strong> Deleted Accountant successfully</div>";
		
	}

?>

	<?php include("php/head.php"); ?>
		<script src="js/jquery-1.10.2.js"></script>
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
					
						<li><a class="active-menu" href="accountant.php"><i class="fa fa-users "></i>Accountants</a></li>
						
						<li><a href="branch.php"><i class="fa fa-university "></i>Branch</a></li>
						
						<li><a href="student.php"><i class="fa fa-users "></i>Student</a></li>
						
						<li><a href="fees.php"><i class="fa fa-usd "></i>Fees</a></li>
						
						<li><a href="report.php"><i class="fa fa-file-text "></i>Report </a></li>
						
						<li><a href="setting.php"><i class="fa fa-cogs "></i>Setting</a></li>
						
						
						<li><a href="logout.php" onclick="return confirm('Are you sure?')"><i class="fa fa-power-off "></i>Logout</a></li>
						
					</ul>
				</div>
			</nav>
			<!-- /. NAV SIDE  -->
			
			<div id="page-wrapper">
				<div id="page-inner">
					<div class="row">
						<div class="col-md-12">
							<h1 class="page-head-line">Accountants  
								<?php
								echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
								'<a href="accountant.php" class="btn btn-primary btn-sm pull-right">Back 
									<i class="glyphicon glyphicon-arrow-right"></i></a>':'<a href="accountant.php?action=add" class="btn btn-primary btn-sm pull-right">
									<i class="glyphicon glyphicon-plus"></i> Add </a>';
								?>
							</h1>
						 
							<?php echo $errormsg; ?>
						</div>
					</div>		
	
			<?php 
			 if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
			 {
			?>
			
			<script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
					<div class="row">
					
						<div class="col-sm-8 col-sm-offset-2">
						<div class="panel panel-primary">
							<div class="panel-heading">
							   <?php echo ($action=="add")? "Add Accountant": "Edit Accountant"; ?>
							</div>
							<form action="accountant.php" method="post" id="signupForm1" class="form-horizontal">
								<div class="panel-body">
								
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Name </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>" required />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Username </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="username" name="username" value="<?php echo $username;?>" required />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Password">Password </label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="password" name="password" value="<?php echo $password;?>" required />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Branch* </label>
										<div class="col-sm-10">
											<select  class="form-control" id="branch" name="branch" >
											<option value="" >Select Branch</option>
											<?php
												$sql = "select * from branch where delete_status='0' order by branch.branch asc";
												$q = $conn->query($sql);
												
												while($r = $q->fetch_assoc()) {
													echo '<option value="'.$r['id'].'"  '.(($branch==$r['id'])?'selected="selected"':'').'>'.$r['branch'].'</option>';
												}
											?>									
											
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Confirm">Join Date </label>
										<div class="col-sm-10">
											<input type="date" class="form-control" id="joindate" name="joindate" value="<?php echo $joindate;?>" required />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Confirm">Date of birth </label>
										<div class="col-sm-10">
											<input type="date" class="form-control" id="dateBirth" name="dateBirth" value="<?php echo $dateBirth;?>" required />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Confirm">Salary</label>
										<div class="col-sm-10">
											<input type="number" class="form-control" id="salary" name="salary" value="<?php echo $salary;?>" required />
										</div>
									</div>
								
									<div class="form-group">
										<div class="col-sm-8 col-sm-offset-2">
										<input type="hidden" name="id" value="<?php echo $id;?>">
										<input type="hidden" name="action" value="<?php echo $action;?>">
										
											<button type="submit" name="save" class="btn btn-primary">Save </button>
										</div>
									</div> 
								   
								</div>
							</form>
						</div>
						</div>
					</div>
				  
		<script type="text/javascript">
			

			$( document ).ready( function () {			
				
				 if($("#signupForm1").length > 0)
			 {
				$( "#signupForm1" ).validate( {
					rules: {
						name: "required",
						branch: "required"				
						
					},
					messages: {
						name: "Please enter name",
						branch: "Please enter branch",
						
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );

						// Add `has-feedback` class to the parent div.form-group
						// in order to add icons to inputs
						element.parents( ".col-sm-10" ).addClass( "has-feedback" );

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
						$( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
						$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
					},
					unhighlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );
						$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
					}
				} );
				
				}
				
			} );
		</script>
 
			<?php
			} else{
			?>
			
			 <link href="css/datatable/datatable.css" rel="stylesheet" />
			 
			<div class="panel panel-default">
							<div class="panel-heading">
								Manage Branch  
							</div>
							<div class="panel-body">
								 <div class="table-sorting table-responsive">

									<table class="table table-striped table-bordered table-hover" id="tSortable22">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Username</th>
												<th>Branch</th>
												<th>Join Date</th>
												<th>Date of Birth</th>
												<th>Salary</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sql = "select * from accountant where delete_status='0'";
										$q = $conn->query($sql);
										$i=1;
										while($r = $q->fetch_assoc()) {
										echo '<tr>
												<td>'.$i.'</td>
												<td>'.$r['name'].'</td>
												<td>'.$r['username'].'</td>
												<td>'.$r['branch'].'</td>
												<td>'.$r['joindate'].'</td>
												<td>'.$r['dateBirth'].'</td>
												<td>'.$r['salary'].'</td>
												
												<td>
													<a href="accountant.php?action=edit&id='.$r['id'].'" class="btn btn-success btn-xs">
														<span class="glyphicon glyphicon-edit"></span></a>
												
													<a onclick="return confirm(\'Are you sure you want to delete this record\');" 
														href="accountant.php?action=delete&id='.$r['id'].'" class="btn btn-danger btn-xs">
														<span class="glyphicon glyphicon-remove"></span></a> 
												</td>
											</tr>';
											$i++;
										}
										?>
											
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						 
		<script src="js/dataTable/jquery.dataTables.min.js"></script>
		 <script>
			 $(document).ready(function () {
				 $('#tSortable22').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"bAutoWidth": true });
		
			 });
			 
		
		</script>
			
			<?php
			}
			?>
				
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
		
	</body>
</html>