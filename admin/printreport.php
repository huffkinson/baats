<!DOCTYPE html>
<html>
<head>
	<title>Reports</title>
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
		.my-header {
			border: 1px solid black; 
			padding-bottom: 5px; 
			padding-top: 5px; 
			padding-right: 30px;
		}
	</style>
</head>
<body>

</body>
</html>
<?php
	include('conn.php');

	function getClientName($clientid){
		include('conn.php');
		$SQL = "SELECT * FROM tbl_client WHERE client_id='$clientid'";
		$row = mysqli_fetch_assoc(mysqli_query($connection, $SQL));
		$clientName = $row['client_name'];
		return $clientName;
	}

	if(isset($_GET['op'])){ 
		switch ($_GET['op']) {
			case 'all':

				$total_soa_amount = 0;
				$number = 1;
				$SQL = "SELECT * FROM tbl_soa WHERE soa_status='approved' ORDER BY client_id, soa_date ASC";
				?>
				<div class="container my-header">
					<h2><b>Report: All</b></h2>
				</div>
				<div class="my-spacer"></div>
				<div class="container">
					<div class="row">
						<table class="table text-nowrap table-bordered">
							<tr>
								<td align="center"><b>#</b></td>
								<td align="center"><b>Client Name</b></td>
								<td align="center"><b>SOA ID</b></td>
								<td align="center"><b>SOA Date</b></td>
								<td align="center"><b>SOA Amount</b></td>
							</tr>
							<?php
							$result = mysqli_query($connection, $SQL);
							while($row = mysqli_fetch_assoc($result)){
								?>
								<tr>
									<td align="center"><?php echo $number; ?></td>
									<td><?php echo getClientName($row['client_id']); ?></td>
									<td align="center"><?php echo $row['soa_id']; ?></td>
									<td align="center"><?php echo $row['soa_date']; ?></td>
									<td align="right"><?php echo number_format($row['soa_total_amount'],'2','.',','); ?></td>
								</tr>
								<?php
								$number++;
								$total_soa_amount += $row['soa_total_amount'];
							}
							?>
						</table>
					</div>
				</div>
				<div class="my-spacer"></div>
				<div class="container my-header">
					<div class="row  justify-content-end">
						<b>Total SOA Amount: <?php echo number_format($total_soa_amount,'2','.',','); ?></b>
					</div>
				</div>
				<?php
				break;
			
			case 'cust':

				$total_soa_amount = 0;
				$number = 1;
				$client_id = $_GET['id'];
				$SQL = "SELECT * FROM tbl_soa INNER JOIN tbl_soa_details ON tbl_soa.soa_id=tbl_soa_details.soa_id WHERE tbl_soa.client_id='$client_id'";
				?>

				<div class="container my-header">
					<h2><b>Report: <?php echo getClientName($client_id); ?></b></h2>
				</div>
				<div class="my-spacer"></div>
				<div class="container">
					<div class="row">
						<table class="table text-nowrap table-bordered">
							<tr>
								<td align="center"><b>#</b></td>
								<td align="center"><b>SOA ID</b></td>
								<td align="center"><b>SOA Date</b></td>
								<td align="center"><b>Description</b></td>
								<td align="center"><b>SOA Amount</b></td>
							</tr>
							<?php
							$result = mysqli_query($connection, $SQL);
							while($row = mysqli_fetch_assoc($result)){
								?>
								<tr>
									<td align="center"><?php echo $number; ?></td>
									<td align="center"><?php echo $row['soa_id']; ?></td>
									<td align="center"><?php echo $row['soa_date']; ?></td>
									<td><?php echo $row['soa_description']; ?></td>
									<td align="right"><?php echo number_format($row['soa_description_amount'],'2','.',','); ?></td>
								</tr>
								<?php
								$number++;
								$total_soa_amount += $row['soa_description_amount'];
							}
							?>
						</table>
					</div>
				</div>
				<div class="my-spacer"></div>
				<div class="container my-header">
					<div class="row  justify-content-end">
						<b>Total SOA Amount: <?php echo number_format($total_soa_amount,'2','.',','); ?></b>
					</div>
				</div>

				<?php
				break;

			case 'desc':
				
				$total_soa_amount = 0;
				$number = 1;
				$client_id = $_GET['id'];
				$soa_description = $_GET['code'];
				$SQL = "SELECT * FROM tbl_soa INNER JOIN tbl_soa_details ON tbl_soa.soa_id=tbl_soa_details.soa_id WHERE tbl_soa.client_id='$client_id' AND tbl_soa_details.soa_description LIKE '%$soa_description%'";
				?>

				<div class="container my-header">
					<h2><b>Report: <?php echo getClientName($client_id); ?></b></h2>
					<h2><b><?php echo $soa_description; ?></b></h2>
				</div>
				<div class="my-spacer"></div>
				<div class="container">
					<div class="row">
						<table class="table text-nowrap table-bordered">
							<tr>
								<td align="center"><b>#</b></td>
								<td align="center"><b>SOA ID</b></td>
								<td align="center"><b>SOA Date</b></td>
								<td align="center"><b>Description</b></td>
								<td align="center"><b>Status</b></td>
								<td align="center"><b>SOA Amount</b></td>
							</tr>
							<?php
							$result = mysqli_query($connection, $SQL);
							while($row = mysqli_fetch_assoc($result)){
								?>
								<tr>
									<td align="center"><?php echo $number; ?></td>
									<td align="center"><?php echo $row['soa_id']; ?></td>
									<td align="center"><?php echo $row['soa_date']; ?></td>
									<td><?php echo $row['soa_description']; ?></td>
									<td><?php echo $row['status']; ?></td>
									<td align="right"><?php echo number_format($row['soa_description_amount'],'2','.',','); ?></td>
								</tr>
								<?php
								$number++;
								$total_soa_amount += $row['soa_description_amount'];
							}
							?>
						</table>
					</div>
				</div>
				<div class="my-spacer"></div>
				<div class="container my-header">
					<div class="row  justify-content-end">
						<b>Total SOA Amount: <?php echo number_format($total_soa_amount,'2','.',','); ?></b>
					</div>
				</div>

				<?php
				break;


			default:
				 
				break;
			}
	} else{
		?>
			<script>
				alert("Nothing to process");
				document.location="reports.php";
			</script>
		<?php
	}