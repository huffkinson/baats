<?php
	session_start();
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
				<li class="nav-item active">
					<a href="#" class="nav-link">Dashboard</a>
				</li>
				<li class="nav-item">
					<a href="company.php" class="nav-link">Company Listing</a>
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

	<!-- assets section starts here -->
	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="card bg-primary text-light">
					<div class="card-body">
						<h5 class="card-title">Company Listing</h5>
						<div class="text-right">
							<a href="company.php" class="btn btn-light">View</a>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="card bg-success text-light">
					<div class="card-body">
						<h5 class="card-title">Pending Payroll</h5>
						<div class="text-right">
							<a href="#" class="btn btn-light">View</a>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="card bg-danger text-light">
					<div class="card-body">
						<h5 class="card-title">Payroll Settings</h5>
						<div class="text-right">
							<a href="#" class="btn btn-light">View</a>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>

	<!-- script section starts here -->
	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>
</body>
</html>