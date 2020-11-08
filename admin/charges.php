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
	
	include('conn.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>List of Charges</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script type="text/javascript" src="../jquery/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/popper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">
	<script src="../js/datatables.js"></script>
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
				<li class="nav-item">
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
				<li class="nav-item active">
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
	<div class="my-spacer"></div>
	<!-- Title header starts here -->
	<div class="container">
		<div class="row justify-content-center">
				<h3><b>Charges</b></h3>
		</div>
		<div class="row justify-content-center">
			<a href="#AddNew" data-toggle="modal" class="btn btn-sm btn-outline-success">Add New</a>
<!-- Add modal dialog starts here -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="AddNew" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add New Charges</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="addcharges.php">
					<div class="container form-group">
						<label class="control-label">Name</label>
						<input id="chargename" class="form-control" type="text" name="chargename">
					</div>
					<div class="container form-group">
						<label class="control-label">Description (optional)</label>
						<input id="chargedescription" class="form-control" type="text" name="chargedescription">
					</div>
			</div>
			<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-outline-success">Save</button>	
					<button class="btn btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>	
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Add modal dialog ends here -->
		</div>
		<div class="row my-spacer"></div>
		<!-- Table starts here -->
		<div class="row">
			<div class="col">
				<table class="table table-bordered table-striped table-sm" id="voucherTable">
					<thead class="thead-dark">
							<th>#</th>
							<th>Name</th>
							<th align="center">View</th>
							<th align="center">Edit</th>
							<th align="center">Delete</th>
					</thead>
					<tbody>
						<?php
							$SQL = "SELECT * FROM charges";
							$result = mysqli_query($connection, $SQL);
							while($row = mysqli_fetch_assoc($result)){?>
								<tr>
									<td><?php echo $row['chargeid'];?></td>
									<td><?php echo $row['chargename'];?></td>
									<td><a href="#viewcharges<?php echo $row['chargeid'];?>" class="btn btn-sm btn-success" data-toggle="modal">View</a></td>
									<td><a href="#editcharges<?php echo $row['chargeid'];?>" class="btn btn-sm btn-warning" data-toggle="modal">Edit</a></td>
									<td><a href="#deletecharges<?php echo $row['chargeid'];?>" class="btn btn-sm btn-danger" data-toggle="modal">Delete</a></td>
								</tr>
								<!-- view modal dialog starts here -->
								<div id="viewcharges<?php echo $row['chargeid'];?>" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">View Item#: <?php echo $row['chargeid'];?></h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<form class="form" method="POST" action="">
													<div class="container">
														<div class="row form-group">
															<label class="control-label">Name</label>
															<input class="form-control" type="text" name="chargename" value="<?php echo $row['chargename'];?>" disabled="true">
														</div>
														<div class="row form-group">
															<label class="control-label">Description (optional)</label>
															<input class="form-control" type="text" name="chargedescription" value="<?php echo $row['chargedescription'];?>" disabled="true">
														</div>
													</div>
											</div>
											<div class="modal-footer">
													<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<!-- view modal dialog ends here -->
								<!-- edit modal dialog starts here -->
								<div id="editcharges<?php echo $row['chargeid'];?>" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Edit Item#: <?php echo $row['chargeid'];?></h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<form class="form" method="POST" action="editcharges.php?id=<?php echo $row['chargeid'];?>">
													<div class="container">
														<div class="row form-group">
															<label class="control-label">Name</label>
															<input class="form-control" type="text" name="chargename" value="<?php echo $row['chargename']; ?>">
														</div>
														<div class="row form-group">
															<label class="control-label">Description (optional)</label>
															<input class="form-control" type="text" name="chargedescription" value="<?php echo $row['chargedescription']; ?>">
														</div>
													</div>
											</div>
											<div class="modal-footer">
													<button type="submit" class="btn btn-sm btn-primary">Save</button>
													<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<!-- edit modal dialog ends here -->
								<!-- delete modal dialog starts here -->
								<div id="deletecharges<?php echo $row['chargeid'];?>" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Delete</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<p>Are you sure you want to delete this?</p>
												<p><?php echo $row['chargename']; ?></p>
											</div>
											<div class="modal-footer">
												<a href="deletecharges.php?id=<?php echo $row['chargeid']; ?>" class="btn btn-sm btn-primary">YES</a>
												<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">NO</button>
											</div>
										</div>
									</div>
								</div>
								<!-- delete modal dialog ends here -->
						<?php	}?>
						
					</tbody>
					<tfoot>
						<th>#</th>
						<th>Name</th>
						<th align="center">View</th>
						<th align="center">Edit</th>
						<th align="center">Delete</th>
					</tfoot>
				</table>
			</div>
		</div>
		<!-- Table ends here -->
	</div>
	<!-- Title header ends here -->
</body>

<script>
	$("#voucherTable").DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});
</script>
</html>