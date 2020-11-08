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
	<title>Voucher</title>

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
				<h3><b>Vouchers</b></h3>
		</div>
		<div class="row justify-content-center">
				<a href="addnewvoucher.php" class="btn btn-sm btn-outline-success">Add New</a>

		</div>
		<div class="row my-spacer"></div>
		<!-- Table starts here -->
		<div class="row">
			<div class="col">
				<table class="table table-bordered table-striped table-sm" id="voucherTable">
					<thead class="thead-dark">
							<th>#</th>
							<th>To</th>
							<th align="center">Amount</th>
							<th align="center">Date</th>
							<th align="center">View</th>
							<th align="center">Edit</th>
							<th align="center">Print</th>
					</thead>
					<tbody>
						<?php
							
							$SQL = "SELECT * FROM tbl_voucher";

							$result = mysqli_query($connection, $SQL);

							while($row = mysqli_fetch_assoc($result)){?>
								<tr>
									<td><?php echo $row['voucher_id'];?></td>
									<td><?php echo $row['voucher_to'];?></td>
									<td align="right"><?php echo number_format($row['voucher_amt'],'2','.',',');?></td>
									<td><?php echo $row['voucher_date'];?></td>
									<td><a href="voucherdetails.php?id=<?php echo $row['voucher_id']; ?>" class="btn btn-sm btn-success">View</a></td>
									<td><button type="button" data-target="#EditVoucher<?php echo $row['voucher_id'];?>" data-toggle="modal" class="btn btn-sm btn-warning">Edit</button></td>
									<!-- <td><button type="button" data-target="#DeleteVoucher<?php echo $row['voucher_id'];?>" data-toggle="modal" class="btn btn-sm btn-danger">Delete</button></td> -->

									<td><a href="printvoucher.php?id=<?php echo $row['voucher_id']; ?>" target="_blank" class="btn btn-sm btn-secondary">Print</a></td>
								</tr>

<!-- Edit Modal Dialog -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="EditVoucher<?php echo $row['voucher_id']; ?>" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title">Edit Item</h2>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form" method="POST" action="editvoucher.php?id=<?php echo $row['voucher_id']; ?>">
					<div class="container">
						<div class="row form-group">
							<label class="control-label">TO</label>
							<input class="form-control" type="text" name="to" value="<?php echo $row['voucher_to']; ?>">
						</div>
						<div class="row form-group">
							<label class="control-label">Date</label>
							<input class="form-control" type="date" name="vdat" value="<?php echo $row['voucher_date']; ?>">
						</div>
					</div>
			</div>
			<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-primary">SAVE</a>
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Edit Modal Dialog -->
<!-- Delete Modal Dialog -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="DeleteVoucher<?php echo $row['voucher_id']; ?>" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title">Delete Item</h2>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<p>Are you sure to delete this?</p>
			</div>
			<div class="modal-footer">
				<a href="deletevoucher.php?id=<?php echo $row['voucher_id']; ?>" class="btn btn-sm btn-primary">OK</a>
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- Delete Modal Dialog -->
						<?php	}

						?>
						

					</tbody>
					<tfoot>
						<tr>
							<th>#</th>
							<th>To</th>
							<th>Amount</th>
							<th>Date</th>
							<th>View</th>
							<th>Edit</th>
							<!-- <th>Delete</th> -->
							<th>Print</th>
						</tr>
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