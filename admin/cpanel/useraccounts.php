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

	$SQL = "SELECT * FROM login ORDER BY id";
	$result = mysqli_query($connection, $SQL);
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Accounts | Admin CPanel</title>
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
			<li class="nav-item"><a href="cpanel.php" class="nav-link">Dashboard</a></li>
			<li class="nav-item active"><a href="useraccounts.php" class="nav-link">Accounts</a></li>
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
<!-- user accounts title starts here -->
<div class="container">
	<div class="row justify-content-center">
		<h2><b>User Accounts</b></h2>
	</div>
	<div class="row justify-content-center">
		<a href="#AddNewAccount" data-toggle="modal" class="btn btn-md btn-outline-success">Add New</a>
<!-- Add New modal dialog starts here -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true" id="AddNewAccount">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Add New User Account</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form" method="POST" action="useraccountsaction.php?op=add">
					<div class="form-group">
						<label class="control-label">Username</label>
						<input type="text" name="user" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Full Name</label>
						<input type="text" name="fullname" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Password</label>
						<input type="password" name="password" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Select User Level</label>
						<select class="form-control" name="level">
							<option value="admin">Admin</option>
							<option value="user">User</option>
						</select>
					</div>
			</div>
			<div class="modal-footer">
					<input type="submit" name="submit" class="btn btn-md btn-outline-primary" value="Save">
					<button type="button" class="btn btn-md btn-outline-danger" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Add New modal dialog ends here -->
	</div>
</div>
<!-- user accounts title ends here -->
<div class="my-spacer"></div>
<!-- user accounts table starts here -->
<div class="container">
	<div class="row">
		<div class="col-8 offset-2">
			<table class="table user-table">
				<thead>
					<tr>
						<th>#</th>
						<th>User's Full Name</th>
						<th>User Level</th>
						<th>View</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					while($row = mysqli_fetch_assoc($result)){
						?>
						<tr>
							<td><?php echo $count; ?></td>
							<td><?php echo $row['fullname']; ?></td>
							<td><?php echo $row['level']; ?></td>
							<td><a href="#View<?php echo $row['id'];?>" data-toggle="modal" class="btn btn-sm btn-outline-primary">View</a></td>
							<td><a href="#Edit<?php echo $row['id'];?>" data-toggle="modal" class="btn btn-sm btn-outline-warning">Edit</a></td>
							<?php include('useraccountsmodal.php'); ?>
						</tr>
						<?php
						$count++;

					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>#</th>
						<th>User's Full Name</th>
						<th>User Level</th>
						<th>View</th>
						<th>Edit</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<!-- user accounts table ends here -->
</body>
<script>
	$('.user-table').DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});
</script>
</html>