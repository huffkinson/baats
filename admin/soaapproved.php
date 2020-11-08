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
	<title>SOA Approved</title>
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
			<h2><b>SOA Approved List</b></h2>
		</div>
		
	</div>
	<!-- end of title section -->
	<div class="my-spacer"></div>
	<!-- start of client listing -->
	<div class="container-fluid">
		<div class="container">
			<!-- start of table -->
			<table class="data-table table">
				<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Client Name</th>
						<th>Date</th>
						<th align="center">Amount</th>
						<th align="center">Details</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$SQL = "SELECT * FROM tbl_soa WHERE soa_status='approved' and archived='no'";
						$result = mysqli_query($connection, $SQL);
						$count = 1;
						while($row=mysqli_fetch_assoc($result)){
							?>
							<tr>
								<td><?php echo $count; ?></td>
								<td><?php echo $row['soa_note1']; ?></td>
								<td><?php echo $row['soa_date']; ?></td>
								<td class="text-danger" align="right"><b><?php echo number_format($row['soa_total_amount'],'2','.',','); ?></b></td>
								<td><a href="soadetails2.php?id=<?php echo $row['soa_id']; ?>" class="btn btn-sm btn-warning">Details</a></td>
							</tr>
							<?php
							$count++;
						}
					?>
				</tbody>
			</table>
			<!-- end of table -->
		</div>
	</div>
	<!-- end of client listing -->
	
</body>

<script type="text/javascript">
	$('.data-table').DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});
</script>
</html>