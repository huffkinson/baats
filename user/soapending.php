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
	
	include('conn.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>SOA Pending</title>
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
	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
		<a class="navbar-brand" href="index.php">Bote Accounting and Taxation Services</a>
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
	<!-- title section -->
	<div class="container">
		<div class="row justify-content-center">
			<h2><b>SOA Pending List</b></h2>
		</div>
		<div class="row justify-content-center">
			<!-- <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddNew">Add New</button> -->
			<a href="#AddNew" class="btn btn-primary btn-sm" data-toggle="modal">Add New</a>
			<!-- add new modal -->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="AddNew" tabindex="-1" aria-hidden="true">
				<!-- modal dialog -->
				<div class="modal-dialog modal-md modal-dialog-scrollable">
					<!-- modal content -->
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<h4 class="modal-title">Add New SOA</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- end of header -->
						<!-- body -->
						<div class="modal-body">
							<div class="container-fluid">
							<form class="form" method="POST" action="addnewsoa.php">
								<div class="row form-group">
									<label class="control-label">Select Client ID</label>
									<input list="client_id" class="form-control" name="client_id">
									<datalist id="client_id">
										<?php
											$SQL = "Select client_id from tbl_client";
											$result = mysqli_query($connection, $SQL);

											while($rowid = mysqli_fetch_array($result)){
												extract($rowid);
												echo '<option value="'.$rowid['client_id'].'">';
											}
										?>									
									</datalist>
								</div>
								<div class="row form-group">
									<label for="soaDate" class="control-label">Select Date</label>
									<input class="form-control" type="date" value="2020-01-01" id="soaDate" name="soa_date">
								</div>
								<div class="row form-group">
									<label for="soaStatus" class="control-label">Status</label>
									<!-- <input id="soaStatus" type="text" class="form-control" name="soa_status"> -->
									<select id="soaStatus" name="soa_status" class="form-control">
										<option value="pending">pending</option>
									</select>
								</div>
							</div>
						</div>
						<!-- end of body -->
						<!-- footer -->
						<div class="modal-footer">
								<button type="submit" class="btn btn-primary btn-sm">Save</button>
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							</form>
						</div>
						<!-- end of footer -->
					</div>
					<!-- end of modal content -->
				</div>
				<!-- end of modal dialog -->
			</div>
			<!-- end of add new modal -->
		</div>
	</div>
	<!-- end of title section -->
	<div class="my-spacer"></div>
	<!-- start of client listing -->
	<div class="container-fluid">
		<div class="container">
			<!-- start of client table -->
			<table class="table table-striped table-bordered table-hover table-sm" id="data-table">
				<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Client Name</th>
						<th>Date</th>
						<th>Total Amount</th>
						<th>Details</th>
						<th>Edit</th>
						<!-- <th>Delete</th> -->
						<!-- <th>Approve</th> -->
					</tr>
				</thead>
				<tbody>
					<?php

						$SQL = "SELECT * FROM tbl_soa where soa_status='pending'";

						$result = mysqli_query($connection, $SQL);
						$count = 1;

						while($row=mysqli_fetch_assoc($result)){

							?>
							<tr>
								<td><?php echo $count; ?></td>
								<td><?php echo $row['soa_note1']; ?></td>
								<td><?php echo $row['soa_date']; ?></td>
								<td align="right"><b><?php echo number_format($row['soa_total_amount'],'2','.',','); ?></b></td>

								<td><a href="soadetails.php?id=<?php echo $row['soa_id']?>" class="btn btn-sm btn-primary">View</a></td>
								<td><button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#EditModal<?php echo $row['soa_id']?>">Edit</button></td>
<!-- edit modal -->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="EditModal<?php echo $row['soa_id']?>" tabindex="-1" aria-hidden="true">
				<!-- modal dialog -->
				<div class="modal-dialog modal-md modal-dialog-scrollable">
					<!-- modal content -->
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<h4 class="modal-title">Edit SOA</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- end of header -->
						<!-- body -->
						<div class="modal-body">
							<div class="container-fluid">
							<form class="form" method="POST" action="editsoa.php?id=<?php echo $row['soa_id'];?>">
								<div class="row form-group">
									<label class="control-label">Select Client ID</label>
									<input list="clientlisting" class="form-control" name="client_id" value="<?php echo $row['client_id'];?>">
									<datalist id="clientlisting">
										<?php
	                                    //$xcon = mysqli_connect('localhost','id12256582_bote','bote2020','id12256582_bote') or die();

										$xcon = mysqli_connect('localhost','root','','samplecrud') or die();
										
										$xsql = "Select client_id from tbl_client";
										$xquery = mysqli_query($xcon,$xsql);
										while($rowid = mysqli_fetch_array($xquery)){
											extract($rowid);
											echo '<option value="'.$rowid['client_id'].'"></option>';
										}
									?>									
								</datalist>
							</div>
								<div class="row form-group">
									<label for="soaDate" class="control-label">Select Date</label>
									<input class="form-control" type="date" value="2020-01-01" id="soaDate" name="soa_date">
								</div>
								<div class="row form-group">
									<label for="soaStatus" class="control-label">Status</label>
									<input id="soaStatus" type="text" class="form-control" name="soa_status" value="<?php echo $row['soa_status'];?>" disabled>
									<!-- <select id="soaStatus" name="soa_status" class="form-control">
										<option value="pending" disabled>pending</option>
									</select> -->
								</div>
							</div>
						</div>
						<!-- end of body -->
						<!-- footer -->
						<div class="modal-footer">
								<button type="submit" class="btn btn-primary btn-sm">Save</button>
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							</form>
						</div>
						<!-- end of footer -->
					</div>
					<!-- end of modal content -->
				</div>
<!-- end of modal dialog -->
								<!-- <td><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#DeleteModal<?php echo $row['soa_id'];?>">Delete</button></td> -->
<!-- delete modal -->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="DeleteModal<?php echo $row['soa_id'];?>" tab-index="-1" aria-hidden="true">
				<!-- modal dialog starts here -->
				<div class="modal-dialog modal-md">
					<!-- modal content starts here -->
					<div class="modal-content">
						<!-- modal header starts here -->
						<div class="modal-header">
							<h4 class="modal-title">Delete Client</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- modal header ends here -->
						<!-- modal body starts here -->
						<div class="modal-body">
							<div class="container">
								Are you sure to delete this client?<br>
								<?php echo $row['soa_note1'];?>
							</div>
						</div>
						<!-- modal body ends here -->
						<!-- modal footer starts here -->
						<div class="modal-footer">
							<a href="deletesoa.php?id=<?php echo $row['soa_id'];?>" class="btn btn-danger btn-sm">Delete</a>
							<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
						</div>
						<!-- modal footer ends here -->
					</div>
					<!-- modal content ends here -->
				</div>
				<!-- modal dialog ends here -->
			</div>
<!-- end of delete modal -->
								<!-- <td><a href="approvesoa.php?id=<?php echo $row['soa_id'];?>" class="btn btn-success btn-sm">Approve</a></td> -->
								
							</tr>
							<?php
							$count++;
						}
					?>
				</tbody>
			</table>
			<!-- end of client table -->
		</div>
	</div>
	<!-- end of client listing -->
	
</body>

<script type="text/javascript">
	$('#data-table').DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});
</script>
</html>