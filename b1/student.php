<?php
	include("php/dbconnect.php");

	$errormsg = '';
	$action = "add";

	$id="";
	$name='';
	$joindate = '';
	$remark='';
	$contact='';
	$balance = 0;
	$fees='';
	$about = '';
	$branch='';
	$emailid='';


	if(isset($_POST['save'])) {

		$name = mysqli_real_escape_string($conn,$_POST['name']);
		$contact = mysqli_real_escape_string($conn,$_POST['contact']);
		$branch = mysqli_real_escape_string($conn,$_POST['branch']);
		$joindate = mysqli_real_escape_string($conn,$_POST['joindate']);
		$about = mysqli_real_escape_string($conn,$_POST['about']);
		$emailid = mysqli_real_escape_string($conn,$_POST['emailid']);


		if($_POST['action']=="add") {
			$remark = mysqli_real_escape_string($conn,$_POST['remark']);
			$fees = mysqli_real_escape_string($conn,$_POST['fees']);
			$advancefees = mysqli_real_escape_string($conn,$_POST['advancefees']);
			$balance = $fees-$advancefees;
 
			$q1 = $conn->query("INSERT INTO student (name,joindate,contact,about,emailid,branch,balance,fees) VALUES ('$name','$joindate','$contact','$about','$emailid','$branch','$balance','$fees')") ;
								
			$sid = $conn->insert_id;
  
			$conn->query("INSERT INTO  fees_transaction (stdid,paid,submitdate,transaction_remark) VALUES ('$sid','$advancefees','$joindate','$remark')") ;
    
			echo '<script type="text/javascript">window.location="student.php?act=1";</script>';
 
		} else if($_POST['action']=="update") {
			$id = mysqli_real_escape_string($conn,$_POST['id']);	
			$sql = $conn->query("UPDATE  student  SET  name = '$name', contact =  '$contact', branch  = '$branch',
			joindate = '$joindate', about = '$about', emailid = '$emailid' WHERE  id  = '$id'");
			echo '<script type="text/javascript">window.location="student.php?act=2";</script>';
		}

	}


	if(isset($_GET['action']) && $_GET['action']=="delete") {

		$conn->query("UPDATE  student set delete_status = '1'  WHERE id='".$_GET['id']."'");	
		header("location: student.php?act=3");

	}

	$action = "add";
	
	if(isset($_GET['action']) && $_GET['action']=="edit" ) {
		$id = isset($_GET['id'])?mysqli_real_escape_string($conn,$_GET['id']):'';

		$sqlEdit = $conn->query("SELECT * FROM student WHERE id='".$id."'");
			
		if($sqlEdit->num_rows) {
			$rowsEdit = $sqlEdit->fetch_assoc();
			extract($rowsEdit);
			$action = "update";
		} else {
			$_GET['action']="";
		}

	}


	if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1") {
		$errormsg = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Student Add successfully</div>";
	
	} else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2") {
		$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Success!</strong> Student Edit successfully</div>";
	
	} else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3") {
		$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Student Delete successfully</div>";
	
	}

?>

	<?php include("php/head.php"); ?>
		<link href="css/ui.css" rel="stylesheet" />
		<link href="css/datepicker.css" rel="stylesheet" />	
		<script src="js/jquery-1.10.2.js"></script>
		<script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>	
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

							<li><a href="index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
							
							<li><a class="active-menu" href="student.php"><i class="fa fa-users"></i>Student</a></li>
							
							<li><a href="fees.php"><i class="fa fa-usd"></i>Fees</a></li>
							
							<li><a href="report.php"><i class="fa fa-file-text"></i>Report </a></li>
							
							<li><a href="setting.php"><i class="fa fa-cogs"></i>Setting</a></li>
							
							
							<li><a href="logout.php" onclick="return confirm('Are you sure?')"><i class="fa fa-power-off "></i>Logout</a></li>
							
						</ul>
					</div>
				</nav>
				<!-- /. NAV SIDE  -->
				
				<div id="page-wrapper">
					<div id="page-inner">
						<div class="row">
							<div class="col-md-12">
								<h1 class="page-head-line">Students  
								<?php
								echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
								' <a href="student.php" class="btn btn-primary btn-sm pull-right">Back 
								<i class="glyphicon glyphicon-arrow-right"></i></a>':'<a href="student.php?action=add" class="btn btn-primary btn-sm pull-right">
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
						
							<div class="col-sm-10 col-sm-offset-1">
					   <div class="panel panel-primary">
								<div class="panel-heading">
								   <?php echo ($action=="add")? "Add Student": "Edit Student"; ?>
								</div>
								<form action="student.php" method="post" id="signupForm1" class="form-horizontal">
								<div class="panel-body">
								<fieldset class="scheduler-border" >
								 <legend  class="scheduler-border">Personal Information:</legend>
								<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Name* </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>"  />
										</div>
									</div>
								<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Contact* </label>
										<div class="col-sm-10">
											<input type="number" class="form-control" id="contact" name="contact" value="<?php echo $contact;?>" maxlength="11" />
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
											
											while($r = $q->fetch_assoc())
											{
											echo '<option value="'.$r['id'].'"  '.(($branch==$r['id'])?'selected="selected"':'').'>'.$r['branch'].'</option>';
											}
											?>									
											
											</select>
										</div>
								</div>
								
								
								<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">DOJ* </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="joindate" name="joindate" value="<?php echo  ($joindate!='')?date("Y-m-d", strtotime($joindate)):'';?>" style="background-color: #fff;" readonly />
										</div>
									</div>
								 </fieldset>
								
								
									<fieldset class="scheduler-border" >
								 <legend  class="scheduler-border">Fee Information:</legend>
								<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Total Fees* </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="fees" name="fees" value="<?php echo $fees;?>" <?php echo ($action=="update")?"disabled":""; ?>  />
										</div>
								</div>
								
								<?php
								if($action=="add")
								{
								?>
								<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Advance Fee* </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="advancefees" name="advancefees" readonly   />
										</div>
								</div>
								<?php
								}
								?>
								
								<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Balance </label>
										<div class="col-sm-10">
											<input type="text" class="form-control"  id="balance" name="balance" value="<?php echo $balance;?>" disabled />
										</div>
								</div>

									
									<?php
								if($action=="add")
								{
								?>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Password">Fee Remark </label>
										<div class="col-sm-10">
									<textarea class="form-control" id="remark" name="remark"><?php echo $remark;?></textarea >
										</div>
									</div>
								<?php
								}
								?>
									
									</fieldset>
									
									 <fieldset class="scheduler-border" >
								 <legend  class="scheduler-border">Optional Information:</legend>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Password">About Student </label>
										<div class="col-sm-10">
									<textarea class="form-control" id="about" name="about"><?php echo $about;?></textarea >
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Email Id </label>
										<div class="col-sm-10">
											
											<input type="text" class="form-control" id="emailid" name="emailid" value="<?php echo $emailid;?>"  />
										</div>
									</div>
									</fieldset>
								
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
					
				$( "#joindate" ).datepicker({
					dateFormat:"yy-mm-dd",
					changeMonth: true,
					changeYear: true,
					yearRange: "1970:<?php echo date('Y');?>"
				});	
				

				
				if($("#signupForm1").length > 0) {
				 
					 <?php if($action=='add')
					{
					 ?>
				 
					$( "#signupForm1" ).validate( {
						rules: {
							name: "required",
							joindate: "required",
							emailid: "email",
							branch: "required",
							
							contact: {
								required: true,
								digits: true
							},
							
							fees: {
								required: true,
								digits: true
							},
							
							
							advancefees: {
								required: true,
								digits: true
							},
						
							
						},
					<?php
					} else
					{
					?>
					
					$( "#signupForm1" ).validate( {
						rules: {
							name: "required",
							joindate: "required",
							emailid: "email",
							branch: "required",
							
							
							contact: {
								required: true,
								digits: true
							}
							
						},
					
					
					
					<?php
					}
					?>
						
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
				
				
				
				$("#fees").keyup( function(){
				$("#advancefees").val("");
				$("#balance").val(0);
				var fee = $.trim($(this).val());
				if( fee!='' && !isNaN(fee))
				{
				$("#advancefees").removeAttr("readonly");
				$("#balance").val(fee);
				$('#advancefees').rules("add", {
					max: parseInt(fee)
				});
				
				}
				else{
				$("#advancefees").attr("readonly","readonly");
				}
				
				});

				
				$("#advancefees").keyup( function(){
				
				var advancefees = parseInt($.trim($(this).val()));
				var totalfee = parseInt($("#fees").val());
				if( advancefees!='' && !isNaN(advancefees) && advancefees<=totalfee)
				{
				var balance = totalfee-advancefees;
				$("#balance").val(balance);
				
				}
				else{
				$("#balance").val(totalfee);
				}
				
				});
				
				
			</script>


					   
				<?php
				}else{
				?>
				
				 <link href="css/datatable/datatable.css" rel="stylesheet" />
				 
				
				 
				 
				<div class="panel panel-default">
					<div class="panel-heading">Manage Student</div>
					<div class="panel-body">
						<div class="table-sorting table-responsive">
							<table class="table table-striped table-bordered table-hover" id="tSortable22">
								<thead>
									<tr>
										<th>#</th>
										<th>Name/Contact</th>
										<th>DOJ</th>
										<th>Fees</th>
										<th>Balance</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php    // This is the view table
										$sql = "select * from student where branch= '1' & delete_status='0'";
										$q = $conn->query($sql);
										$i=1;
										while($r = $q->fetch_assoc())
										{
											echo '<tr '.(($r['balance']>0)?'class="danger"':'').'>
												<td>'.$i.'</td>
												<td>'.$r['name'].'<br/>'.$r['contact'].'</td>
												<td>'.date("d M y", strtotime($r['joindate'])).'</td>
												<td>'.$r['fees'].'</td>
												<td>'.$r['balance'].'</td>
												<td>
													<a href="student.php?action=edit&id='.$r['id'].'" class="btn btn-success btn-xs">
													<span class="glyphicon glyphicon-edit"></span></a>
													
													<a onclick="return confirm(\'Are you sure you want to delete this record\');
													" href="student.php?action=delete&id='.$r['id'].'" class="btn btn-danger btn-xs">
													<span class="glyphicon glyphicon-remove"></span></a> </td>
													
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
						"bLengthChange": true,
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