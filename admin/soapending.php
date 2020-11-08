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

	$clientid = '';

	$SQL = "Select client_id from tbl_client";
	$result = mysqli_query($connection, $SQL);

	while($row=mysqli_fetch_assoc($result)){
		$clientid .= '<option value="'.$row['client_id'].'">';
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>SOA Pending</title>
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
				<li class="nav-item dropdown active">
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
	<div class="my-spacer"></div>
	<!-- title section -->
	<div class="container">
		<div class="row justify-content-center">
			<h3><b>SOA Pending List</b></h3>
		</div>
		<div class="row justify-content-center">
			<a href="#AddNewSoa" class="btn btn-sm btn-outline-success" data-toggle="modal">Add New</a>
			<?php include('addsoamodal.php'); ?>
		</div>
	</div>
	<!-- end of title section -->
	<div class="my-spacer"></div>

	<!-- start of client listing -->
	<div class="container-fluid">
		<div class="container">
			<!-- start of client table -->
			<table class="table table-striped table-bordered table-hover table-sm" id="data-table">
				<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Client Name</th>
						<th>Date</th>
						<th>Total Amount</th>
						<th>Details</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>Approve</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$SQL = "SELECT * FROM tbl_soa where soa_status='pending' and archived='no' order by soa_id desc";
						$result = mysqli_query($connection, $SQL);
						$count = 1;

						while($row=mysqli_fetch_assoc($result)){
					?>
						<tr>
							<td><?php echo $count; ?></td>
							<td><?php echo $row['soa_note1']; ?></td>
							<td><?php echo $row['soa_date']; ?></td>
							<td align="right"><b><?php echo number_format($row['soa_total_amount'],'2','.',','); ?></b></td>
							<td><a href="soadetails.php?id=<?php echo $row['soa_id']; ?>" class="btn btn-sm btn-primary">View</a></td>
							<td><a href="#EditModal<?php echo $row['soa_id']; ?>" class="btn btn-sm btn-warning" data-toggle="modal">Edit</a></td>
<!-- Edit Soa Modal Dialog starts here -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="EditModal<?php echo $row['soa_id']?>" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit SOA</h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form class="form" method="POST" action="editsoa.php?id=<?php echo $row['soa_id'];?>">
						<div class="row form-group">
							<label class="control-label">Select Client ID</label>
							<input list="clientlisting" class="form-control" name="client_id" value="<?php echo $row['client_id'];?>">
							<datalist id="clientlisting">
								<?php
									echo $clientid;
								?>									
							</datalist>
						</div>
						<div class="row form-group">
							<label for="soaDate" class="control-label">Select Date</label>
							<input class="form-control" type="date" value="2020-01-01" id="soaDate" name="soa_date">
						</div>
						<div class="row form-group">
							<label for="soaStatus" class="control-label">Status</label>
							<input id="soaStatus" type="text" class="form-control" name="soa_status" value="<?php echo $row['soa_status'];?>" disabled>
						</div>
				</div>
			</div>
			<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-sm">Save</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
					</form>
			</div>
		</div>
	</div>
</div>
<!-- Edit Soa Modal Dialog ends here -->
							<td><a href="#DeleteModal<?php echo $row['soa_id']; ?>" class="btn btn-sm btn-danger" data-toggle="modal">Delete</a></td><?php include('deletesoamodal.php');?>
							<td><a href="approvesoa.php?id=<?php echo $row['soa_id']; ?>" class="btn btn-sm btn-success">Approve</a></td>
						</tr>
					<?php
						$count++;
						} ?>
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