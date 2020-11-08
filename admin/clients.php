<?php
	session_start();
	
	if (!isset($_SESSION['user'])) {
		?>
		<script type="text/javascript">
			alert("You are not logged in.");
			location="logout.php";
		</script>
		<?php
	}
	if ($_SESSION['level']!="admin") {
		?>
		<script type="text/javascript">
			alert("Unauthorised user not allowed");
			location="logout.php";
		</script>
		<?php
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Clients</title>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">
	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>

</head>
<body>
	<!-- navigation bar starts here -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
		<a class="navbar-brand" href="index.php">BOACTS</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Dashboard</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="clients.php">Clients</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">SOA</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="soapending.php">Pending</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="soaapproved.php">Approved</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="soaprinting.php">Printing</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="charges.php">Charges</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="voucher.php">Vouchers</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="collection.php">Collections</a>
				</li>
				<li class="nav-item">
					<a href="logout.php"><button type="button" class="btn btn-md btn-outline-secondary"> Sign out</button></a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- navigation ends here -->
	<!-- title section -->
	<div class="container">
		<div class="row justify-content-center">
			<h2><b>Client List</b></h2>
		</div>
		<div class="row justify-content-center">
			<!-- <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddNew">Add New</button> -->
			<a href="#AddNew" class="btn btn-primary btn-sm" data-toggle="modal">Add New</a>
			<!-- add new modal -->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="AddNew" tabindex="-1" aria-hidden="true">
				<!-- modal dialog -->
				<div class="modal-dialog modal-md modal-dialog-scrollable">
					<!-- modal content -->
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<h4 class="modal-title">Add New Client</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- end of header -->
						<!-- body -->
						<div class="modal-body">
							<div class="container-fluid">
							<form class="form" method="POST" action="addclient.php">
								<div class="row form-group">
									<label class="control-label">Client ID</label>
									<input type="text" class="form-control" name="client_id">
								</div>
								<div class="row form-group">
									<label class="control-label">Full Name</label>
									<input type="text" class="form-control" name="client_name">
								</div>
								<div class="row form-group">
									<label class="control-label">VAT Type</label>
									<input type="text" class="form-control" name="client_vat_type">
									<!-- <input type="text" class="form-control" name="client_name"> -->
								</div>
								<div class="row form-group">
									<label class="control-label">RDO</label>
									<input type="text" class="form-control" name="client_rdo">
								</div>
								<div class="row form-group">
									<label class="control-label">TIN</label>
									<input type="text" class="form-control" name="client_tin">
								</div>
								<div class="row form-group">
									<label class="control-label">Tradename</label>
									<input type="text" class="form-control" name="client_trade_name">
								</div>
								<div class="row form-group">
									<label class="control-label">Line of Business</label>
									<input type="text" class="form-control" name="client_line_of_business">
								</div>
								<div class="row form-group">
									<label class="control-label">Address</label>
									<input type="text" class="form-control" name="client_address">
								</div>
								<div class="row form-group">
									<label class="control-label">Email</label>
									<input type="email" class="form-control" name="client_email">
								</div>
							</div>
						</div>
						<!-- end of body -->
						<!-- footer -->
						<div class="modal-footer">
								<button type="submit" class="btn btn-primary btn-sm">Save</button>
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							</form>
						</div>
						<!-- end of footer -->
					</div>
					<!-- end of modal content -->
				</div>
				<!-- end of modal dialog -->
			</div>
			<!-- end of add new modal -->
		</div>
	</div>
	<!-- end of title section -->
	
	<!-- start of client listing -->
	<div class="container-fluid">
		<div class="container">
			<!-- start of client table -->
			<table class="table table-striped table-bordered table-hover table-sm" id="data-table">
				<thead class="thead-dark">

						<th>ID</th>
						<th>Full Name</th>
						<th>VAT Type</th>
						<th>RDO</th>
						<th>TIN</th>
						<th>Tradename</th>
						<th>Line of Business</th>
						<th>Address</th>
						<th>Email</th>
						<th>Edit</th>
						<th>Delete</th>

				</thead>
				<tbody>
					<?php
						include('conn.php');

						$SQL = "SELECT * FROM tbl_client";

						$result = mysqli_query($connection, $SQL);

						while($row=mysqli_fetch_assoc($result)){

							?>
							<tr>
								<td><?php echo $row['client_id']; ?></td>
								<td><?php echo $row['client_name']; ?></td>
								<td><?php echo $row['client_vat_type']; ?></td>
								<td><?php echo $row['client_rdo']; ?></td>
								<td><?php echo $row['client_tin']; ?></td>
								<td><?php echo $row['client_trade_name']; ?></td>
								<td><?php echo $row['client_line_of_business']; ?></td>
								<td><?php echo $row['client_address']; ?></td>
								<td><?php echo $row['client_email']; ?></td>
								<td><button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#EditModal<?php echo $row['client_id']?>">Edit</button></td>
			<!-- edit modal -->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="EditModal<?php echo $row['client_id']?>" tabindex="-1" aria-hidden="true">
				<!-- modal dialog -->
				<div class="modal-dialog modal-md modal-dialog-scrollable modal-modified">
					<!-- modal content -->
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<h4 class="modal-title">Edit Client</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- end of header -->
						<!-- body -->
						<div class="modal-body">
							<div class="container-fluid">
							<form class="form" method="POST" action="editclient.php">
								<div class="row form-group">
									<label class="control-label">Client ID</label>
									<input type="text" class="form-control" name="client_id" value="<?php echo $row['client_id'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">Full Name</label>
									<input type="text" class="form-control" name="client_name" value="<?php echo $row['client_name'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">VAT Type</label>
									<input type="text" class="form-control" name="client_vat_type" value="<?php echo $row['client_vat_type'];?>">
									<!-- <input type="text" class="form-control" name="client_name"> -->
								</div>
								<div class="row form-group">
									<label class="control-label">RDO</label>
									<input type="text" class="form-control" name="client_rdo" value="<?php echo $row['client_rdo'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">TIN</label>
									<input type="text" class="form-control" name="client_tin" value="<?php echo $row['client_tin'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">Tradename</label>
									<input type="text" class="form-control" name="client_trade_name" value="<?php echo $row['client_trade_name'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">Line of Business</label>
									<input type="text" class="form-control" name="client_line_of_business" value="<?php echo $row['client_line_of_business'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">Address</label>
									<input type="text" class="form-control" name="client_address" value="<?php echo $row['client_address'];?>">
								</div>
								<div class="row form-group">
									<label class="control-label">Email</label>
									<input type="text" class="form-control" name="client_email" value="<?php echo $row['client_email'];?>">
								</div>
							</div>
						</div>
						<!-- end of body -->
						<!-- footer -->
						<div class="modal-footer">
								<button type="submit" class="btn btn-primary btn-sm">Save</button>
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							</form>
						</div>
						<!-- end of footer -->
					</div>
					<!-- end of modal content -->
				</div>
				<!-- end of modal dialog -->
			</div>
			<!-- end of edit modal -->
								<td><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#DeleteModal<?php echo $row['client_id'];?>">Delete</button></td>
								<!-- delete modal -->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="DeleteModal<?php echo $row['client_id'];?>" tab-index="-1" aria-hidden="true">
				<!-- modal dialog starts here -->
				<div class="modal-dialog modal-md">
					<!-- modal content starts here -->
					<div class="modal-content">
						<!-- modal header starts here -->
						<div class="modal-header">
							<h4 class="modal-title">Delete Client</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- modal header ends here -->
						<!-- modal body starts here -->
						<div class="modal-body">
							<div class="container">
								Are you sure to delete this client?<br>
								<?php echo $row['client_name'];?>
							</div>
						</div>
						<!-- modal body ends here -->
						<!-- modal footer starts here -->
						<div class="modal-footer">
							<a href="deleteclient.php?id=<?php echo $row['client_id'];?>" class="btn btn-danger btn-sm">Delete</a>
							<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
						</div>
						<!-- modal footer ends here -->
					</div>
					<!-- modal content ends here -->
				</div>
				<!-- modal dialog ends here -->
			</div>
								<!-- end of delete modal -->
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
			<!-- end of client table -->
		</div>
	</div>
	<!-- end of client listing -->
	
</body>
<script type="text/javascript">
	
	$('#data-table').DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});

</script>
</html>