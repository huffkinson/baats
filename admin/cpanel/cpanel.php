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

	include('cpanelconn.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin CPanel</title>
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../css/datatables.min.css">
	<script src="../../jquery/jquery.min.js"></script>
	<script src="../../js/popper.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/datatables.min.js"></script>
</head>
<body>
<!-- navigation starts here -->
<div class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
	<a href="cpanel.php" class="navbar-brand">Admin CPanel</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active"><a href="cpanel.php" class="nav-link">Dashboard</a></li>
			<li class="nav-item"><a href="useraccounts.php" class="nav-link">Accounts</a></li>
			<li class="nav-item"><a href="logout.php" class="btn btn-md btn-outline-secondary">Log-out</a></li>
		</ul>
	</div>
</div>
<!-- navigation ends here -->

<!-- welcome banner starts here -->
<div class="my-spacer"></div>
<div class="container">
	<div class="row">
		<div class="col text-right">
			<h4><b>Welcome, <?php echo $_SESSION['user']; ?>!</b></h4>
		</div>
	</div>
	
</div>
<!-- welcome banner ends here -->

</body>
</html>