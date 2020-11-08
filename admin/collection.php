<?php
	session_start();
	include('functions.php');
	
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

	$soalist = '';
	$clientlist = '';

	$SQL = "SELECT soa_id FROM tbl_soa ORDER BY soa_id ASC";
	$result = mysqli_query($connection, $SQL);

	while($row = mysqli_fetch_assoc($result)){
		$soalist .= '<option value="'.$row['soa_id'].'">';
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Collection</title>
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/brands.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/solid.min.css">

	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>

	<style>
		.my-frames{ 
			/*border-radius: 5px;*/
			/*box-shadow: 0px 0px 5px 1px grey;*/
			padding-top: 5px;
			padding-bottom: 5px;
		}
	</style>
	
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
				<li class="nav-item">
					<a class="nav-link" href="charges.php">Charges</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="voucher.php">Vouchers</a>
				</li>
				<li class="nav-item active">
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
	<!-- Title Section -->
	<div class="container">
		<div class="row justify-content-center">
			<h3><b>Collection</b></h3>
		</div>
	</div>

	<!-- Buttons Section -->
	<div class="container">
		<div class="row justify-content-center">
			<a href="add_new-collection.php" class="btn btn-sm btn-outline-success">Add New</a>
		</div>
	</div>

	<div class="container my-spacer"></div>
	<!-- Table Section -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col">
				<table class="collection-table table table-bordered table-sm">
					<thead class="thead-dark">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Client</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Date Posted</th>
							<th class="text-center">Description</th>
							<th class="text-center">View</th>
							<th class="text-center">Edit</th>
							<!-- <th class="text-center">Print</th> -->
						</tr>
					</thead>
					<tbody>
						<?php
							$SQL = "SELECT * FROM tbl_collection order by collection_id desc";
							$count = 1;

							$result = mysqli_query($connection, $SQL);

							while($row = mysqli_fetch_assoc($result)){

								?>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo getClientName($row['client_id']); ?></td>
									<td align="right"><?php echo number_format($row['collection_amount'],'2','.',','); ?></td>
									<td align="center"><?php echo $row['posting_date']; ?></td>
									<td><?php echo $row['remarks']; ?></td>
									<td align="center"><a href="#ViewDetails<?php echo $row['collection_id']; ?>" class="btn btn-sm btn-secondary" data-toggle="modal">View</a></td>
<!-- View Collection Modal Dialog starts here -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true" id="ViewDetails<?php echo $row['collection_id']; ?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title">View CR# <?php echo $row['collection_id']; ?></label>
				<button class="close" data-dismiss="modal">&times</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form class="form">
						<div class="form-group">
							<label class="control-label">Posting Date</label>
							<input class="form-control" type="date" name="posting_date" value="<?php echo $row['posting_date']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Date Collected</label>
							<input class="form-control" type="date" name="collection_date" value="<?php echo $row['collection_date']; ?>">
						</div>
						<div class="form-group">	
							<label class="control-label">Collected by</label>
							<input class="form-control" type="text" name="collection_by" value="<?php echo $row['collected_by']; ?>">
						</div>
						<div class="form-group">	
							<label class="control-label">Remitted to</label>
							<input class="form-control" type="text" name="remitted_to" value="<?php echo $row['remitted_to']; ?>">
						</div>
						<div class="form-group">	
							<label class="control-label">OR #</label>
							<input class="form-control" type="text" name="or_id" value="<?php echo $row['or_no']; ?>">
						</div>
				</div>
			</div>
			<div class="modal-footer">
					<!-- <button type="submit" class="btn btn-sm btn-primary">Save</button> -->
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- View Collection Modal Dialog ends here -->
									<td align="center"><a href="#EditDetails<?php echo $row['collection_id']; ?>" class="btn btn-sm btn-warning" data-toggle="modal">Edit</a></td>
<!-- Edit Collection Modal Dialog starts here -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true" id="EditDetails<?php echo $row['collection_id']; ?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title">Edit CR# <?php echo $row['collection_id']; ?></label>
				<button class="close" data-dismiss="modal">&times</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form class="form" method="POST" action="editcollection.php?id=<?php echo $row['collection_id']; ?>">
						<div class="form-group">
							<label class="control-label">Posting Date</label>
							<input class="form-control" type="date" name="posting_date" value="<?php echo $row['posting_date']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Date Collected</label>
							<input class="form-control" type="date" name="collection_date" value="<?php echo $row['collection_date']; ?>">
						</div>
						<div class="form-group">	
							<label class="control-label">Collected by</label>
							<input class="form-control" type="text" name="collection_by" value="<?php echo $row['collected_by']; ?>">
						</div>
						<div class="form-group">	
							<label class="control-label">Remitted to</label>
							<input class="form-control" type="text" name="remitted_to" value="<?php echo $row['remitted_to']; ?>">
						</div>
						<div class="form-group">	
							<label class="control-label">OR #</label>
							<input class="form-control" type="text" name="or_id" value="<?php echo $row['or_no']; ?>">
						</div>
				</div>
			</div>
			<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Edit Collection Modal Dialog ends here -->
									<!-- <td><a href="printcollection.php?id=<?php echo $row['collection_id']; ?>" target="_blank" class="btn btn-sm btn-primary">Print</a></td> -->
								</tr>
								<?php
								$count++;
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Client</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Date Posted</th>
							<th class="text-center">View</th>
							<th class="text-center">Edit</th>
							<th class="text-center">Print</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
<script>
	$(".collection-table").DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});
</script>
</html>