<?php
	session_start();
	include_once('conn.php');
	if (!isset($_SESSION['user'])) {
		?>
		<script type="text/javascript">
			alert("You are not logged in.");
			location="logout.php";
		</script>
		<?php
	}
	if ($_SESSION['level']!="user" && $_SESSION['level']!="admin") {
		?>
		<script type="text/javascript">
			alert("Unauthorised user not allowed");
			location="logout.php";
		</script>
		<?php
	}
	
	function getNumOfClients(){
		include('conn.php');

		$rows = 0;

		$SQL = "SELECT * FROM tbl_client";
		$result = mysqli_query($connection, $SQL);
		if ($result){
			$rows = mysqli_num_rows($result);
		}
		
		return $rows;
		mysqli_close($connection);
	}

	function getNumOfPending(){
		include('conn.php');

		$rows = 0;

		$SQL = "SELECT * FROM tbl_soa WHERE soa_status='pending'";
		$result = mysqli_query($connection, $SQL);
		if ($result){
			$rows = mysqli_num_rows($result);
		}
		
		return $rows;
		mysqli_close($connection);
	}

	function getNumOfApproved(){
		include('conn.php');

		$rows = 0;

		$SQL = "SELECT * FROM tbl_soa WHERE soa_status='approved'";
		$result = mysqli_query($connection, $SQL);
		if ($result){
			$rows = mysqli_num_rows($result);
		}
		
		return $rows;
		mysqli_close($connection);
	}

	function getNumOfVouchers(){
		include('conn.php');
		
		$rows = 0;

		$SQL = "SELECT * FROM tbl_voucher";
		$result = mysqli_query($connection, $SQL);
		if ($result){
			$rows = mysqli_num_rows($result);
		}
		
		return $rows;
		mysqli_close($connection);
	}

	function getNumOfPayments(){
		include('conn.php');

		$rows = 0;

		$SQL = "SELECT * FROM tbl_pay";
		$result = mysqli_query($connection, $SQL);
		if ($result){
			$rows = mysqli_num_rows($result);
		}
		
		return $rows;
		mysqli_close($connection);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to the Dashboard | Admin</title>

	<!-- bootstrap, styles, and scripts -->
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">
	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>

	<style>
		.card-height {
			height: 500px;
		}
	</style>


</head>
<body>
	<!-- navigation bar starts here -->
	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
		<a class="navbar-brand" href="index.php">Bote Accounting and Taxation Services</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
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
				</li>
				<li class="nav-item">
					<a class="nav-link" href="charges.php">Charges</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="voucher.php">Vouchers</a>
				</li>
				<li class="nav-item">
					<a href="logout.php"><button type="button" class="btn btn-md btn-outline-secondary"> Sign out</button></a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- navigation ends here -->

	<!-- album section -->
	<div class="album py-5 bg-dark">
	    <div class="container"> <!-- start of container -->
	    	
	      <div class="row"> <!-- start of row -->
	        <!-- start or album card 1 -->
	        <div class="col-md-4">
	          <div class="card mb-4 shadow-sm">
	            <div class="card-body">
		          <h2>Client Listing</h2>
		          <small class="text-muted">Total no. of records: <?php echo getNumOfClients(); ?></small>
		          <div class="d-flex justify-content-end">
			            <a href="clients.php" type="button" class="btn btn-sm bg-primary text-white">View</a>
			            <!-- <small class="text-muted">9 mins</small> -->
		          </div>
	            </div>
	          </div>
	        </div>
	        <!-- end of album card 1 -->

	        <!-- start or album card 2-->
	        <div class="col-md-4">
	          <div class="card mb-4 shadow-sm">
	            <div class="card-body">
		          <h2>Pending SOA</h2>
		          <small>Total no. of records: <?php echo getNumOfPending(); ?></small>
		          <div class="d-flex justify-content-end">
			            <a href="soapending.php" type="button" class="btn btn-sm bg-danger text-white">View</a>
			            <!-- <small class="text-muted">9 mins</small> -->
		          </div>
	            </div>
	          </div>
	        </div>
	      <!-- end of album card 2-->

	      <!-- start or album card 3-->
	        <div class="col-md-4">
	          <div class="card mb-4 shadow-sm">
	            <div class="card-body">
		          <h2>Approved SOA</h2>
		          <small>Total no. of records: <?php echo getNumOfApproved(); ?></small>
		          <div class="d-flex justify-content-end">
			            <a href="soaapproved.php" type="button" class="btn btn-sm bg-success text-white">View</a>
			            <!-- <small class="text-muted">9 mins</small> -->
		          </div>
	            </div>
	          </div>
	        </div>
	      <!-- end of album card 3-->
	      </div> <!-- end of row -->

	      <!-- start of row -->
	      <div class="row">
	      	<!-- start or album card 1-->
	        <div class="col-md-4">
	          <div class="card mb-4 shadow-sm">
	            <div class="card-body">
		          <h2>Vouchers</h2>
		          <small>Total no. of records: <?php echo getNumOfVouchers(); ?></small>
		          <div class="d-flex justify-content-end">
			            <a href="voucher.php" type="button" class="btn btn-sm bg-warning text-white">View</a>
			            <!-- <small class="text-muted">9 mins</small> -->
		          </div>
	            </div>
	          </div>
	        </div>
	      <!-- end of album card 1-->

	      <!-- start or album card 2-->
	        <div class="col-md-4">
	          <div class="card mb-4 shadow-sm">
	            <div class="card-body">
		          <h2>Collection</h2>
		          <small>Total no. of records: <?php echo getNumOfPayments(); ?></small>
		          <div class="d-flex justify-content-end">
			            <a href="soaapproved.php" type="button" class="btn btn-sm bg-secondary text-white">View</a>
			            <!-- <small class="text-muted">9 mins</small> -->
		          </div>
	            </div>
	          </div>
	        </div>
	      <!-- end of album card 2-->
	      </div>
	      <!-- end of row -->
	      
	      
	    </div> <!-- end of container -->
  </div>
<!-- this is the admin page -->
</body>
</html>