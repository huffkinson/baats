<?php
	session_start();

	$date_today = time();
	
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

	function getClients(){
		include('conn.php');
		$SQL = "SELECT * FROM tbl_client ORDER BY client_name ASC";

		$result = mysqli_query($connection, $SQL);

		$output = '';

		while($row = mysqli_fetch_assoc($result)){
			$output .='<option value="'.$row['client_id'].'">'.$row['client_name'].'</option>';
		}

		return $output;
	}

	function getSOA() {
		include('conn.php');
		$SQL = "SELECT * FROM tbl_soa ORDER BY soa_id ASC";

		$result = mysqli_query($connection, $SQL);

		$output = '';

		while($row = mysqli_fetch_assoc($result)){
			$output .='<option value="'.$row['soa_id'].'">';
		}

		return $output;
	}

	function getCollectors() {
		include('conn.php');
		$SQL = "SELECT * FROM tbl_collectors";

		$result = mysqli_query($connection, $SQL);

		$output = '';

		while($row = mysqli_fetch_assoc($result)){
			$output .='<option>'.$row['collector_name'].'</option>';
		}

		return $output;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add New Collection | Collection</title>
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
			border-radius: 5px;
			box-shadow: 0px 0px 5px 1px grey;
			padding: 5px 15px 5px 15px;
			margin-top: 10px;
		}
		.spacer {
			padding-top: 5px;
			padding-bottom: 5px;
			margin-top: 10px;
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
	<!-- title section starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<h2>Add New Collection</h2>
		</div>
	</div>
	<!-- title section ends here -->

	<div class="container">	
		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 my-frames">
				<form class="form" method="POST" action="addcollection.php">
					<div class="form-group row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<label class="control-label">Collection Date:</label>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
						<input class="form-control" type="date" name="collection_date" value="<?php echo date('Y-m-d',time()); ?>"></div>
					</div>
				
					<div class="form-group row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<label class="control-label">Posting Date:</label>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
							<input class="form-control" type="date" name="posting_date" value="<?php echo date('Y-m-d',time()); ?>">
						</div>
					</div>
				
					<div class="form-group row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<label class="control-label">Select Client</label>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
							<input class="form-control" list="clientlist" name="client_id">
							<datalist id="clientlist">
							<?php echo getClients(); ?>								
							</datalist>
						</div>
					</div>
										
					<div class="form-group row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<label class="control-label">Collected by:</label>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
							<select class="form-control" id="collected_by" name="collected_by">
								<?php echo getCollectors(); ?>
							</select>
							</div>	
					</div>
				
					<div class="form-group row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<label class="control-label">Remitted to:</label>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
							<select class="form-control" id="remitted_to" name="remitted_to">
								<?php echo getCollectors(); ?>
							</select>
						</div>
					</div>
				
					<div class="form-group row" align="center">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<a href="collection.php" class="btn btn-md btn-outline-danger">Cancel</a>&nbsp;&nbsp;
							<input class="btn btn-md btn-outline-success" type="submit" name="submit" value="Proceed">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	

</body>
</html>