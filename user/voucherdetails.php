<?php
	include('conn.php');

	if(!isset($_GET['id'])){
		?>
			<script type="text/javascript">
				alert("No Voucher selected!");
				location = "voucher.php";
			</script>
		<?php
	} else {
		$id = $_GET['id'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Voucher Details</title>

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
		.small-text-form{
			font-size: 12px;
			/*height: 16px;*/
			line-height: 1px;
			padding: 2px !important;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row my-spacer"></div>
		<div class="row justify-content-center">
			<h4><b>Voucher Details</b></h4>
		</div>
		<div class="row my-spacer"></div>
		<!-- voucher detail -->
		<div class="row">
			<div class="col" style="border: 1px solid gray; padding: 10px 15px 10px 15px; border-radius: 10px;">
				<table class="col-12 table-sm" align="center">
					<?php
						$SQL = "SELECT * FROM tbl_voucher where voucher_id=$id";

						$result = mysqli_query($connection, $SQL);
						$row = mysqli_fetch_assoc($result);
						$getVoucherDate = $row['voucher_date'];
						$getVoucherID = $row['voucher_id'];
						$getVoucherFrom = $row['voucher_from'];
						$getVoucherTo = $row['voucher_to'];
					?>
					<tr>
						<td>Ref#</td>
						<td>:</td>
						<td><?php echo $getVoucherID ?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td>:</td>
						<td><?php echo $getVoucherDate ?></td>
					</tr>
					<tr>
						<td>FROM</td>
						<td>:</td>
						<td><?php echo $getVoucherFrom ?></td>
					</tr>
					<tr>
						<td>TO</td>
						<td>:</td>
						<td><?php echo $getVoucherTo ?></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- voucher detail -->
		<div class="row my-spacer"></div>
		<!-- Detail input here -->
		<div class="row justify-content-center" align="center" style="border: 1px solid gray; padding: 10px 15px 10px 15px; border-radius: 10px;">
			<form class="form form-inline" method="POST" action="addvoucherdetails.php?id=<?php echo $id; ?>">
						<div class="form-group">
							<label class="control-label">Description</label>&nbsp;&nbsp;
							<input type="text" name="voucher_description" class="form-control">
						</div>&nbsp;&nbsp;&nbsp;&nbsp;

						<div class="form-group">
							<label class="control-label">Amount</label>&nbsp;&nbsp;
							<input type="text" name="voucher_amount" class="form-control">
						</div>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="submit" class="btn btn-sm btn-success" style="width: 75px;">Add</button>
					</div>
			</form>
		</div>
		<!-- detail view here -->
		<div class="row">
			<div class="col">
				<table class="detail-table table table-bordered table-striped table-hover table-sm" align="center" style="width: 100%;" cellspacing="0">
					<thead class="thead-dark">
							<th>#</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Edit</th>
							<th>Delete</th>
					</thead>
					<tbody>
						<?php
							//$con = new mysqli('localhost','root','','samplecrud') or die();
							$SQL = "SELECT * FROM tbl_voucher_details WHERE voucher_id=$id";
							$result = mysqli_query($connection, $SQL);
							$count = 1;
							$total_amount = 0;
							while($row=mysqli_fetch_assoc($result)){
								?>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo $row['voucher_description']; ?></td>
									<td align="right"><?php echo number_format($row['voucher_amount'],'2','.',','); ?></td>
									<td align="center"><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editvoucherdetail<?php echo $row['voucher_detail_id'];?>">Edit</button></td>
									<td align="center"><a href="deletevoucherdetail.php?id=<?php echo $id; ?>&voucher=<?php echo $row['voucher_detail_id']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
								</tr>
								<div class="modal fade" id="editvoucherdetail<?php echo $row['voucher_detail_id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Edit Detail</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<div class="container">
													<form class="form" method="POST" action="editvoucherdetail.php?id=<?php echo $id;?>&detail=<?php echo $row['voucher_detail_id'];?>">
														<div class="row form-group">
															<label class="control-label">Description</label>
															<input class="form-control" type="text" name="voucher_description" value="<?php echo $row['voucher_description'];?>">
														</div>
														<div class="row form-group">
															<label class="control-label">Amount</label>
															<input class="form-control" type="text" name="voucher_amount" value="<?php echo $row['voucher_amount'];?>">
														</div>
												</div>
											</div>
											<div class="modal-footer">
														<button type="submit" class="btn btn-sm btn-primary">Save</button>
														<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
													</form>
											</div>
										</div>
									</div>
								</div>
								<?php
								$total_amount += $row['voucher_amount'];
								$count++;
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row my-spacer"></div>
		<!-- voucher remarks -->
		<div class="row">
			<div class="container">
				<form class="form" method="POST" action="updatevoucher.php?id=<?php echo $id; ?>&amount=<?php echo $total_amount; ?>">
					<div class="row justify-content-end">
						<h4>Amount: <?php echo number_format($total_amount,'2','.',','); ?></h4>
					</div>
					<div class="row">
						<div class="col-6">
							<div class="form-group small-text-form">
								<label class="control-label">Remarks</label>
								<textarea class="form-control" type="textarea" name="voucher_remarks1" rows="1" style="min-width: 100%"></textarea>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group small-text-form">
								<label class="control-label">Remarks</label>
								<textarea class="form-control" type="textarea" name="voucher_remarks2" rows="1" style="min-width: 100%"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group small-text-form">
								<label class="control-label">Note</label>
								<textarea class="form-control" type="textarea" name="voucher_note" rows="1"></textarea>
							</div>
						</div>
					</div>
					<div class="row justify-content-end">
						<button type="submit" class="btn btn-sm btn-primary">Update</button>&nbsp;&nbsp;&nbsp;
						<a href="cancelvoucher.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger">Cancel Voucher</a>
					</div>
				</form>
			</div>
		</div>
		
	</div>
</body>
<script type="text/javascript">
	$('.detail-table').DataTable({
		searching: false,
		ordering: false,
		paging: false
	});
</script>
</html>