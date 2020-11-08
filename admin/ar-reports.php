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
	include('reportfunctions.php');
	$date_today = date_create(date("y-m-d"));
	$SQL = "";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Receivable | Reports</title>
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
				<li class="nav-item">
					<a class="nav-link" href="reports.php">Reports</a>
				</li>
				<li class="nav-item active">
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

	<!-- account receivable title starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="my-frames">
				<h2><b>Accounts Receivable</b></h2>
			</div>
		</div>
	</div>
	<!-- account receivable title ends here -->

	<!-- search bar starts here -->
	<div class="container">
		<div class="row justify-content-center">
			
				<div class="my-frames">
					<form class="form form-inline" method="post" action="ar-reports.php">
						<div class="form-group">
							<label class="control-label">Filters:</label>&nbsp;&nbsp;
						</div>
						<div class="form-group">
							&nbsp;<input type="text" name="client" placeholder="Enter Client Name or ID...">&nbsp;
						</div>
						<div class="form-group">
							&nbsp;&nbsp;<label class="control-label">Date 1</label>&nbsp;
							<input class="form-control-sm" type="date" name="date1">
						</div>
						<div class="form-group">
							&nbsp;&nbsp;<label class="control-label">Date 2</label>&nbsp;
							<input class="form-control-sm" type="date" name="date2">
						</div>
						<div class="form-group">
							&nbsp;&nbsp;<input class="btn btn-sm btn-primary" type="submit" name="submit" value="Submit">
						</div>
					</form>
				</div>
			
		</div>
	</div>
	<!-- search bar title ends here -->
	<div class="my-spacer"></div>
	<!-- results section starts here -->
	<div class="container">
		<div class="row">
			<?php

				if(isset($_POST['submit'])){
					include('ar-reportsection.php');
				}

			?>
		</div>
	</div>
	<!-- results section ends here -->

	<!-- back to reports dashboard starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="my-frames">
				<a href="reports.php" class="btn btn-md btn-outline-primary">Return to Reports Dashboard</a>
			</div>
		</div>
	</div>
	<!-- back to reports dashboard ends here -->
	
</body>

</html>