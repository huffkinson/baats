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
	<title>Dashboard | Reports</title>
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
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">Main Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="reports.php">Reports</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ar-reports.php">Account Receivable</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="paymentsummary.php">Payment Summary</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="cashdisbursement.php">Cash Disbursement</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- navigation ends here -->

	<!-- report album starts here: three column section per row-->
	<div class="container-fluid">
		<?php include('reportfunctions.php'); ?>
		<div class="row">
			<!-- card 1 starts here -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
				<div class="card shadow-lg"><i class=""></i>
					<div class="card-body bg-danger text-light">
						<h4 class="card-title my-compressed"><i class="fas fa-calculator text-light"></i> Account Receivable</h4>
						<div class="d-flex justify-content-start">
							Total Amount: &nbsp;&nbsp;<b><?php echo ' Php '.get_total_ar(); ?></b>
						</div>
			          	<div class="d-flex justify-content-end">
				            <a href="ar-reports.php" type="button" class="btn btn-sm btn-light text-dark text-white">View</a>
			          	</div>
					</div>
				</div>
			</div>
			<!-- card 1 ends here -->

			<!-- card 2 starts here -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
				<div class="card shadow-lg">
					<div class="card-body bg-success text-light">
						<h4 class="card-title my-compressed"><i class="fas fa-list"></i> Payment Summary</h4>
						<div class="d-flex justify-content-start">
							Total Amount: &nbsp;&nbsp;<b><?php echo ' Php '.get_total_collection(); ?></b>
						</div>
			          	<div class="d-flex justify-content-end">
				            <a href="paymentsummary.php" type="button" class="btn btn-sm btn-light text-dark text-white">View</a>
			          	</div>
					</div>
				</div>
			</div>
			<!-- card 2 ends here -->

			<!-- card 3 starts here -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
				
				<div class="card shadow-lg">
					<div class="card-body bg-warning text-light">
						<h4 class="card-title my-compressed"><i class="fas fa-shopping-cart text-light"></i> Cash Disbursement</h4>
						<div class="d-flex justify-content-start">
							Total Amount: &nbsp;&nbsp;<b><?php echo ' Php '.get_total_voucher(); ?></b>
						</div>
			          	<div class="d-flex justify-content-end">
				            <a href="cashdisbursement.php" type="button" class="btn btn-sm btn-light text-dark text-white">View</a>
			          	</div>
					</div>
				</div>
				
			</div>
			<!-- card 3 ends here -->

			<!-- card 4 starts here -->
			<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
				<div class="card shadow-lg">
					<div class="card-body bg-primary text-light">
						<h4 class="card-title my-compressed"><i class="fas fa-sticky-note"></i> Cash Receipts</h4>
						<div class="d-flex justify-content-start">
							<br>&nbsp;
						</div>
			          	<div class="d-flex justify-content-end">
				            <a href="#" type="button" class="btn btn-sm btn-light text-dark text-white">View</a>
			          	</div>
					</div>
				</div>
			</div> -->
			<!-- card 4 ends here -->
		</div>
	</div>
	<!-- report album ends here: three column section per row -->
	
</body>
</html>