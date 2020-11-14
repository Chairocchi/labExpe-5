<?php include("php/dbconnect.php"); ?>

	<?php include("php/head.php"); ?>
		<link href="css/ui.css" rel="stylesheet" />
		<link href="css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />	
		<link href="css/datepicker.css" rel="stylesheet" />	
		<link href="css/datatable/datatable.css" rel="stylesheet" />
		   
		<script src="js/jquery-1.10.2.js"></script>	
		<script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
	    <script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
	 
		<script src="js/dataTable/jquery.dataTables.min.js"></script>
		
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

								<li><a href="index.php"><i class="fa fa-dashboard "></i>Dashboard</a></li>
								
								<li><a href="student.php"><i class="fa fa-users "></i>Student</a></li>
								
								<li><a href="fees.php"><i class="fa fa-usd "></i>Fees</a></li>
								
								<li><a class="active-menu" href="report.php"><i class="fa fa-file-text "></i>Report </a></li>
								
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
							<h1 class="page-head-line">Report  
							
							</h1>

						</div>
					</div>
					

	<div class="row" style="margin-bottom:20px;">
		<div class="col-md-12">
			<fieldset class="scheduler-border" >
				<legend  class="scheduler-border">Search:</legend>
				<form class="form-inline" role="form" id="searchform">
					<div class="form-group">
						<label for="email">Name</label>
						<input type="text" class="form-control" id="student" name="student">
					</div>
				  
					<div class="form-group">
						<label for="email"> Date Of Joining </label>
						<input type="text" class="form-control" id="doj" name="doj" >
					</div>
				  
					<div class="form-group">
						<label for="email"> Branch </label>
						<select  class="form-control" id="branch" name="branch" >
							<option value="" >Select Branch</option>
								<?php						// view from table
									$sql = "select * from branch where branch = '2' & delete_status='0' order by branch.branch asc";
									$q = $conn->query($sql);
								
									while($r = $q->fetch_assoc()) {
										echo '<option value="'.$r['id'].'"  '.(($branch==$r['id'])?'selected="selected"':'').'>'.$r['branch'].'</option>';
									}
								?>
						</select>
					</div>
				  
					<button type="button" class="btn btn-success btn-sm" id="find" > Find </button>
					<button type="reset" class="btn btn-danger btn-sm" id="clear" > Clear </button>
				</form>
			</fieldset>

		</div>
	</div>

	<script type="text/javascript">
	$(document).ready( function() {

		
	/******************/	
		 $("#doj").datepicker({
			 
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'mm/yy',
			onClose: function(dateText, inst) {
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
			}
		});

		$("#doj").focus(function () {
			$(".ui-datepicker-calendar").hide();
			$("#ui-datepicker-div").position({
				my: "center top",
				at: "center bottom",
				of: $(this)
			});
		});

	/*****************/
		
	$('#student').autocomplete({
					source: function( request, response ) {
						$.ajax({
							url : 'ajx.php',
							dataType: "json",
							data: {
							   name_startsWith: request.term,
							   type: 'report'
							},
							 success: function( data ) {
							 
								 response( $.map( data, function( item ) {
								
									return {
										label: item,
										value: item
									}
								}));
							}
							
							
							
						});
					}


				  });
		

	$('#find').click(function () {
	mydatatable();
			});


	$('#clear').click(function () {

	$('#searchform')[0].reset();
	mydatatable();
			});
			
	function mydatatable()
	{
			
		$("#subjectresult").html('<table class="table table-striped table-bordered table-hover" id="tSortable22"><thead><tr><th>Name/Contact</th><th>Fees</th><th>Balance</th><th>Branch</th><th>DOJ</th><th>Action</th></tr></thead><tbody></tbody></table>');
				  
			$("#tSortable22").dataTable({
							'sPaginationType' : 'full_numbers',
							"bLengthChange": false,
				"bFilter": false,
				"bInfo": false,
				
							'bProcessing' : true,
							'bServerSide': true,
							'sAjaxSource': "datatable.php?"+$('#searchform').serialize()+"&type=report",
							'aoColumnDefs': [{
								'bSortable': false,
								'aTargets': [-1] /* 1st one, start by the right */
							}]
			});


	}

	////////////////////////////
	 $("#tSortable22").dataTable({
					 
					  'sPaginationType' : 'full_numbers',
					  "bLengthChange": false,
					  "bFilter": false,
					  "bInfo": false,
					  
					  'bProcessing' : true,
					  'bServerSide': true,
					  'sAjaxSource': "datatable.php?type=report",
					  
					  'aoColumnDefs': [{
					  'bSortable': false,
					  'aTargets': [-1] /* 1st one, start by the right */
				  }]
				});

	///////////////////////////		


		
	});


	function GetFeeForm(sid)
	{

	$.ajax({
				type: 'post',
				url: 'getfeeform.php',
				data: {student:sid,req:'2'},
				success: function (data) {
				  $('#formcontent').html(data);
				  $("#myModal").modal({backdrop: "static"});
				}
			  });


	}

	</script>


			

	<style>
	#doj .ui-datepicker-calendar
	{
	display:none;
	}

	</style>

	<!-- Print Details -->
	<style>
	@media screen {
		#printSection {
			display: none;
		}
	}

	@media print {
		body * {
			visibility:hidden;
		}
		#printSection, #printSection * {
			visibility:visible;
		}
		#printSection {
			position:absolute;
			left:0;
			top:0;
		}
	}
	</style>

	<script>
	document.getElementById("btnPrint").onclick = function () {
		printElement(document.getElementById("printThis"));
		
		var modThis = document.querySelector("#printSection .modifyMe");
		modThis.appendChild(document.createTextNode(" ======= Nothing Follows ======="));
		
		window.print();
	}

	function printElement(elem) {
		var domClone = elem.cloneNode(true);
		
		var $printSection = document.getElementById("printSection");
		
		if (!$printSection) {
			var $printSection = document.createElement("div");
			$printSection.id = "printSection";
			document.body.appendChild($printSection);
		}
		
		$printSection.innerHTML = "";
		
		$printSection.appendChild(domClone);
	}
	</script>
	<!-- end of Print Details -->
			
			<div class="panel panel-default">
							<div class="panel-heading">
								Manage Fees  
							</div>
							<div class="panel-body">
								<div class="table-sorting table-responsive" id="subjectresult">
									<table class="table table-striped table-bordered table-hover" id="tSortable22">
										<thead>
											<tr>
											  
												<th>Name/Contact</th>                                            
												<th>Fees</th>
												<th>Balance</th>
												<th>Branch</th>
												<th>DOJ</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						 
		
		<!-------->
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
				<div id="printThis">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Fee Report</h4>
					</div>
					<div class="modifyMe">
					<div class="modal-body" id="formcontent">
					
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					  <button type = "button" class = "btn btn-success" onclick = "window.print();" id="btnPrint"><span class="glyphicon glyphicon-print"></span> Print</button>
					</div>
					</div>
				</div>
				</div>
			</div>
		</div>

		
		<!--------->
					
				
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
