<?php
	include('conn.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>SOA Printing</title>
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
	<!-- Title Section starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<h3><b>SOA Printing List</b></h3>
		</div>
		<div class="row">
			<div class="col">
				<table class="table table-bordered print-table table-sm">
					<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th class="text-center">Client Name</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Date</th>
							<th class="text-center">Print</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$SQL = "SELECT * FROM tbl_soa WHERE soa_status='approved' and archived='no'";
							$count = 1;
							$result = mysqli_query($connection, $SQL);
							while($row=mysqli_fetch_assoc($result)){
								?>
									<tr>
										<td><?php echo $count; ?></td>
										<td><?php echo $row['soa_note1']; ?></td>
										<td align="right"><?php echo number_format($row['soa_total_amount'],'2','.',','); ?></td>
										<td align="center"><?php echo $row['soa_date']; ?></td>
										<td align="center"><a onclick="open_and_reload('soaprint.php?id=<?php echo $row['soa_id'];?>')" href="#" class="btn btn-sm btn-success">Print</a></td>
									</tr>
								<?php
								$count++;
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th>#</th>
							<th class="text-center">Client Name</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Date</th>
							<th class="text-center">Print</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<!-- Title Section ends here -->
</body>
<script>
	$('.print-table').DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});

	function open_and_reload(url){
		window.open(url,'_blank');
		document.location="soaprinting.php";
	}
</script>
</html>