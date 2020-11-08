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

	$soa_id = $_GET['id'];
	$totalamount = 0;

	$sql = "SELECT * FROM tbl_soa where soa_id='$soa_id'";

	//$sql = "SELECT client_name, client_address FROM tbl_client where client_id='$client_id'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_fetch_assoc($query);
	$client_name = $result['soa_note1'];
	$client_address = $result['soa_note2'];
	//$billingdate = date_create($result['soa_date']);
	$billingdate = $result['soa_date'];
	$soadate = date_create($result['soa_date']);
	date_sub($soadate,date_interval_create_from_date_string("1 months"));
	$soadate = date_format($soadate,"My");

?>
<!DOCTYPE html>
<html>
<head>
	<title>SOA Details | Pending</title>
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
	
	<!-- title starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<h2><b>SOA Detailed List</b></h2>
		</div>
	</div>
	<!-- title ends here -->
	<!-- detail section starts here -->
	<div class="container">
		<div class="row">
			<table>
				<tr>
					<td>SOS Reference#</td>
					<td>:</td>
					<td><?php echo $soa_id;?></td>
				</tr>
				<tr>
					<td>Client Name</td>
					<td>:</td>
					<td><?php echo $client_name;?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>:</td>
					<td><?php echo $client_address;?></td>
				</tr>
				<tr>
					<td>Date</td>
					<td>:</td>
					<td><?php echo $billingdate;?></td>
				</tr>
			</table>
		</div>
		<div class="row my-spacer"></div>
		<div class="row">
			<div class="col">
				<table class="table" id="data-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$SQL = "SELECT * from tbl_soa_details where soa_id='$soa_id'";
							$result = mysqli_query($connection, $SQL);
							while($rec=mysqli_fetch_assoc($result)){ 
								$totalamount+=$rec['soa_description_amount'];
								?>
								<tr>
									<td><?php echo $rec['soa_details_id'];?></td>
									<td><?php echo $rec['soa_description']; ?></td>
									<td><?php echo $rec['soa_description_amount']; ?></td>
									<td><a href="deletesoadetail.php?id=<?php echo $rec['soa_details_id'];?>&soaid=<?php echo $soa_id;?>" class="btn btn-danger btn-sm">Delete</a></td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row my-spacer"></div>
		<div class="row justify-content-end">
			<h4><b>Total Amount: <?php echo number_format($totalamount,'2','.',',');?></b></h4>
		</div>
		<div class="row justify-content-center">
			<a href="#AddNew" class="btn btn-success btn-sm" data-toggle="modal">Add New</a>&nbsp;
			<a href="updatesoa.php?id=<?php echo $soa_id;?>&amount=<?php echo $totalamount;?>" class="btn btn-primary btn-sm">Update</a>
			<div class="modal fade" id="AddNew" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Add Item</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<form method="POST" action="addsoadetails.php?id=<?php echo $soa_id;?>&suffix=<?php echo $soadate;?>">
									<div class="form-group row">
										<label class="control-label">Description</label>
										
										<input list="chargename" class="form-control" name="soa_description">
											<datalist id="chargename">
												<?php
													$SQL = "SELECT chargename FROM charges";
													$result = mysqli_query($connection, $SQL);
													while($rowid = mysqli_fetch_array($result)){
														extract($rowid);
														echo '<option value="'.$rowid['chargename'].'">';
													}
												?>									
											</datalist>
									</div>
									<div class="form-group row">
										<label class="control-label">Amount</label>
										<input type="text" class="form-control" name="soa_description_amount">
									</div>
							</div>
						</div>
						<div class="modal-footer">
								<button type="submit" class="btn btn-primary btn-sm">Add</button>
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- detail section ends here -->
</body>
<script type="text/javascript">
	$('#data-table').DataTable({
		searching: false,
		ordering: false,
		paging: false
	});
</script>
</html>