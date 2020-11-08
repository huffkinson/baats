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
	<title>Add New Voucher</title>
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

	<!-- Add New Voucher details starts here -->
	<div class="container">
		<div class="row">
			<div class="col-8">
				<form method="POST" action="addvoucher.php">
					<div class="form-group">
						<label class="control-label">FROM</label>
						<input list="default" id="from" class="form-control" type="text" name="from" value="BOTE ACCOUNTING AND TAXATION SERVICES">
						<datalist id="default">
							<option value="BOTE ACCOUNTING AND TAXATION SERVICES">
						</datalist>
					</div>
					<div class="form-group">
						<label class="control-label">TO</label>
						<input id="to" class="form-control" type="text" name="to">
					</div>
					<div class="form-group">
						<label class="control-label">DATE</label>
						<input id="vdate" class="form-control" type="date" name="vdate" value="2020-01-01">
					</div>
					<div class="form-group">
						<input type="submit" name="proceed" class="btn btn-sm btn-outline-success" value="Save & Proceed">
						<input type="submit" name="cancel" class="btn btn-sm btn-outline-danger" value="Cancel">		
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Add New Voucher details ends here -->

</body>
</html>