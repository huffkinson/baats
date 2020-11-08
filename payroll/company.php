<?php
	session_start();
	include('conn.php');
	/*echo $_SESSION['username'];
	echo $_SESSION['level'];
	
	if (!$_SESSION['logged']) {
		?>
		<script type="text/javascript">
			alert("You are not logged in.");
			location="logout.php";
		</script>
		<?php
	}*/
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Payroll Page | Bote Systems</title>
	<!-- bootstrap, styles, and scripts -->
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/brands.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/solid.min.css">

</head>
<body>
	<!-- navigation section starts here -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
		<a class="navbar-brand" href="dashboard.php">Payroll</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a href="dashboard.php" class="nav-link">Dashboard</a>
				</li>
				<li class="nav-item active">
					<a href="#" class="nav-link">Company Listing</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Payroll Process</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Payroll Settings</a>
				</li>
				<li class="nav-item">
					<a href="logout.php"><button type="button" class="btn btn-md btn-outline-secondary">Sign out</button></a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="my-spacer"></div>
	<!-- company listing starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-12 col-md-10">
				<h4 align="center">Company Listing</h4>
			</div>
		</div>
		<div class="row justify-content-center">
			<a href="#AddNew" class="btn btn-sm btn-success" data-toggle="modal">Add New</a>
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="AddNew" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h5>Add New Company</h5>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<form method="POST" action="addcompany.php">
								<div class="form-group">
									<label class="control-label">Company Name</label>
									<input class="form-control" type="text" name="company_name" placeholder="Enter Company Name" required>
								</div>
								<div class="form-group">
									<label class="control-label">Address</label>
									<input class="form-control" type="text" name="company_address" placeholder="Enter Company Address">
								</div>
								<div class="form-group">
									<label class="control-label">Contact Number</label>
									<input class="form-control" type="text" name="company_contactno" placeholder="Enter Contact Number">
								</div>
						</div>
						<div class="modal-footer">
								<button type="submit" class="btn btn-sm btn-primary">Save</button>
							</form>
							<a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-12 col-md-10">
				<table class="table datatable">
					<thead class="thead-dark">
						<th style="width: 5px;">#</th>
						<th>Company Name</th>
						<th style="width: 10%;">Edit</th>
						<th style="width: 10%;">View</th>
						<th style="width: 10%;">Archive</th>
					</thead>
					<tbody>
						<?php
							$sql = "select * from payroll_company where archived='no' order by company_id desc";
							$result = mysqli_query($connection, $sql);
							if(mysqli_num_rows($result)!=0){
								$count = 1;
								while($row=mysqli_fetch_assoc($result)){
									?>
									<tr>
										<td><?php echo $count;?></td>
										<td><?php echo $row['company_name'];?></td>
										<td><a href="#EditCompany<?php echo $row['company_id'];?>" class="btn btn-sm btn-success" data-toggle="modal">Edit</a></td>
<!-- edit modal dialog starts here -->
<div id="EditCompany<?php echo $row['company_id'];?>" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5>Edit Company</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="editcompany.php?id=<?php echo $row['company_id'];?>">
					<div class="form-group">
						<label class="control-label">Company Name</label>
						<input class="form-control" type="text" name="company_name" value="<?php echo $row['company_name'];?>" required>
					</div>
					<div class="form-group">
						<label class="control-label">Address</label>
						<input class="form-control" type="text" name="company_address" value="<?php echo $row['company_address'];?>">
					</div>
					<div class="form-group">
						<label class="control-label">Contact Number</label>
						<input class="form-control" type="text" name="company_contactno" value="<?php echo $row['company_contactno'];?>">
					</div>
			</div>
			<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
				</form>
				<a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>
										<td><a href="#ViewCompany<?php echo $row['company_id'];?>" class="btn btn-sm btn-warning" data-toggle="modal">View</a></td>
<!-- view modal dialog starts here -->
<div id="ViewCompany<?php echo $row['company_id'];?>" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5>View Company</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label">Company Name</label>
					<input class="form-control" type="text" name="company_name" value="<?php echo $row['company_name'];?>" required disabled>
				</div>
				<div class="form-group">
					<label class="control-label">Address</label>
					<input class="form-control" type="text" name="company_address" value="<?php echo $row['company_address'];?>" disabled>
				</div>
				<div class="form-group">
					<label class="control-label">Contact Number</label>
					<input class="form-control" type="text" name="company_contactno" value="<?php echo $row['company_contactno'];?>" disabled>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
										<td><a href="#ArchiveCompany<?php echo $row['company_id'];?>" class="btn btn-sm btn-danger" data-toggle="modal">Archive</a></td>
<!-- archive modal dialog starts here -->
<div id="ArchiveCompany<?php echo $row['company_id'];?>" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5>Archive Company</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				Are you sure to archive, <?php echo $row['company_name'];?>?
			</div>
			<div class="modal-footer">
				<a href="archivecompany.php?id=<?php echo $row['company_id'];?>" class="btn btn-sm btn-primary">Yes</a>
				<a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">No</a>
			</div>
		</div>
	</div>
</div>
									</tr>
									<?php
									$count++;
								}
							}
						?>
					</tbody>
					<tfoot>
						<th>#</th>
						<th>Company Name</th>
						<th>Edit</th>
						<th>View</th>
						<th>Archive</th>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	

	<!-- script section starts here -->
	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>
	<script type="text/javascript">
		$('.datatable').DataTable({
			lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
		});
	</script>
</body>
</html>