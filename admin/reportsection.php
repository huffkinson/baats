<!DOCTYPE html>
<html>
<head>
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
		.view-border{
			border: 1px solid black;
		}
		.view-font{
			font-size: 12px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-10 offset-1">
<?php
	include('conn.php');

	$SQL = '';
	$client_id = '';
	$soa_id = '';
	$soa_description = '';
	$total_soa_amount = 0;
	$counter = 0;

	function getClientName($clientid){
		include('conn.php');
		$SQL = "SELECT * FROM tbl_client WHERE client_id='$clientid'";
		$row = mysqli_fetch_assoc(mysqli_query($connection, $SQL));
		$clientName = $row['client_name'];
		return $clientName;
	}
	
	function getChargeName($description){
		include('conn.php');
		$SQL = "SELECT * FROM charges WHERE chargename LIKE '%$description%'";
		$row = mysqli_fetch_assoc(mysqli_query($connection, $SQL));
		$chargename = $row['chargename'];
		return $chargename;
	}

	function getSOADETAILS($soaid){
		$output = '';
		include('conn.php');
		$SQL = "SELECT * FROM tbl_soa_details WHERE soa_id='$soaid'";
		$result = mysqli_query($connection, $SQL);
		$output .='<div class="container">';
		// first row
		$output .='<div class="row view-border">';
		$output .='<div class="col">Description</div>';
		$output .='<div class="col text-right">Amount</div>';
		$output .='<div class="col">Status</div>';
		$output .='</div>';

		while($row=mysqli_fetch_assoc($result)){
			// following rows
			$output .='<div class="row">';
			$output .='<div class="col">'.$row['soa_description'].'</div>';
			$output .='<div class="col text-right">'.number_format($row['soa_description_amount'],'2','.',',').'</div>';
			$output .='<div class="col">'.$row['status'].'</div>';
			$output .='</div>';
		}

		$output .='</div>';
		return $output;
	}

	if(isset($_POST['submit'])){
		// this section relates to submit button being pressed
		switch ($_POST['options']) {
			case 'All':
				?>
				<table class="table table-bordered report-table table-lg">
					<thead>
						<tr>
							<th>#</th>
							<th>Client Name</th>
							<th>SOA ID</th>
							<th>SOA Date</th>
							<th>SOA Amount</th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$SQL = "SELECT * FROM tbl_soa WHERE soa_status='approved' ORDER BY client_id, soa_date ASC";
						$result = mysqli_query($connection, $SQL);
						while($row = mysqli_fetch_assoc($result)){
							$counter++;
							?>
						<tr>
							<td><?php echo $counter; ?></td>
							<td><?php echo getClientName($row['client_id']); ?></td>
							<td><?php echo $row['soa_id']; ?></td>
							<td><?php echo $row['soa_date']; ?></td>
							<td align="right"><?php echo number_format($row['soa_total_amount'],'2','.',','); ?></td>
							<td><a href="#viewreport<?php echo $row['soa_id'];?>" data-toggle="modal" class="btn btn-sm btn-outline-success">View</a></td>
<!-- view report modal dialog starts here -->

<div class="modal fade" id="viewreport<?php echo $row['soa_id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">SOA Details - SOA Reference# : <?php echo $row['soa_id']; ?></h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col view-font">
							<?php echo getSOADETAILS($row['soa_id']);?>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- view report modal dialog ends here -->
						</tr>
							<?php
							$total_soa_amount += $row['soa_total_amount'];
						}
						?>
					</tbody>
				</table>
				<div class="text-right"><h3><b>Total Amount:</b> <?php echo '<b>'.number_format($total_soa_amount,'2','.',',').'</b>';?></h3> </div>
				<div class=" row justify-content-center"><a href="printreport.php?op=all" target="_blank" class="btn btn-sm btn-outline-success">Print Report</a></div>				
				<?php
				break;

			case 'Customer':
				if(trim($_POST['clientid'])==''){
					?>
					<script>
						alert("No client to view.");
					</script>
					<?php
				} else {
				$client_id = $_POST['clientid'];
				//$SQL = "SELECT * FROM tbl_soa WHERE client_id='$client_id' ORDER BY soa_date ASC";

				$SQL = "SELECT * FROM tbl_soa INNER JOIN tbl_soa_details ON tbl_soa.soa_id=tbl_soa_details.soa_id WHERE tbl_soa.client_id='$client_id'";
				$result = mysqli_query($connection, $SQL);
				?>
				<div><h3><b><?php echo getClientName($client_id); ?></b></h3></div>
				<table class="table table-bordered table-hover report-table table-lg">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">SOA ID</th>
							<th class="text-center">SOA Date</th>
							<th class="text-center">Amount</th>
							<th class="text-center">View</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysqli_fetch_assoc($result)){
							$counter++;
							?>
						<tr>
							<td align="center"><?php echo $counter; ?></td>
							<td align="center"><?php echo $row['soa_id']; ?></td>
							<td align="center"><?php echo $row['soa_date']; ?></td>
							<td align="right"><?php echo number_format($row['soa_description_amount'],'2','.',','); ?></td>
							<td align="center"><a href="#viewreport<?php echo $row['soa_id'];?>" data-toggle="modal" class="btn btn-sm btn-outline-success">View</a></td>
<!-- view report modal dialog starts here -->

<div class="modal fade" id="viewreport<?php echo $row['soa_id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">SOA Details - SOA Reference# : <?php echo $row['soa_id']; ?></h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col view-font">
							<?php echo getSOADETAILS($row['soa_id']);?>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- view report modal dialog ends here -->
						</tr>
							<?php
							$total_soa_amount += $row['soa_description_amount'];
						}
						?>
					</tbody>
				</table>
				<div class="text-right"><h3><b>Total Amount:</b> <?php echo '<b>'.number_format($total_soa_amount,'2','.',',').'</b>';?></h3> </div>
				<div class=" row justify-content-center"><a href="printreport.php?op=cust&id=<?php echo $client_id; ?>" class="btn btn-sm btn-outline-success" target="_blank">Print Report</a></div>				
				<?php
				}
				break;

			case 'Description':
				if($_POST['clientid']!=''){
					$client_id = $_POST['clientid'];
					if($_POST['description']!=''){
						$soa_description = $_POST['description'];

						$SQL = "SELECT * FROM tbl_soa INNER JOIN tbl_soa_details ON tbl_soa.soa_id=tbl_soa_details.soa_id WHERE tbl_soa.client_id='$client_id' AND tbl_soa_details.soa_description LIKE '%$soa_description%'";

						$result = mysqli_query($connection, $SQL);

						?>
						<div><h3><b><?php echo getClientName($client_id); ?></b></h3></div>
						<div><h3><b><?php echo getChargeName($soa_description); ?></b></h3></div>
						<table class="table table-bordered report-table table-lg">
							<thead>
								<tr>
									<th>#</th>
									<th>SOA ID</th>
									<th>SOA Date</th>
									<th>Amount</th>
									<th>View</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while($row = mysqli_fetch_assoc($result)){
									$counter++;
									?>
								<tr>
									<td><?php echo $counter; ?></td>
									<td><?php echo $row['soa_id']; ?></td>
									<td><?php echo $row['soa_date']; ?></td>
									<td align="right"><?php echo number_format($row['soa_description_amount'],'2','.',','); ?></td>
									<td><a href="#viewreport<?php echo $row['soa_id'];?>" data-toggle="modal" class="btn btn-sm btn-outline-success">View</a></td>
<!-- view report modal dialog starts here -->

<div class="modal fade" id="viewreport<?php echo $row['soa_id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">SOA Details - SOA Reference# : <?php echo $row['soa_id']; ?></h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col view-font">
							<?php echo getSOADETAILS($row['soa_id']);?>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- view report modal dialog ends here -->
								</tr>
									<?php
									$total_soa_amount += $row['soa_description_amount'];
								}
								?>
							</tbody>
						</table>
						<div class="text-right"><h3><b>Total Amount:</b> <?php echo '<b>'.number_format($total_soa_amount,'2','.',',').'</b>';?></h3> </div>
						<div class=" row justify-content-center"><a href="printreport.php?op=desc&id=<?php echo $client_id; ?>&code=<?php echo $soa_description; ?>" class="btn btn-sm btn-outline-success" target="_blank">Print Report</a></div>				
						<?php

					} else {
						?>
						<script>
							alert("No description to view.");
						</script>
						<?php
					}
				} else {
					?>
					<script>
						alert("No client to view.");
					</script>
					<?php
				}
				
				break;

			default:
				# code...
				break;
		}
	}
	else {
		// this section relates to submit button not being pressed	
	}
?>
			</div>
		</div>
	</div>
</body>
<script>
	$('.report-table').DataTable({
		lengthMenu: [[5,10,25,-1],[5,10,25,"All"]]
	});
</script>
</html>