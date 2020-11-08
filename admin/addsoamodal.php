<?php
	include('conn.php');
	$clientid = '';

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

	$SQL = "Select * from tbl_client";
	$result = mysqli_query($connection, $SQL);

	while($row=mysqli_fetch_assoc($result)){
		$clientid .= '<option value="'.$row['client_id'].'">'.$row['client_name'].'</option>';
	}
?>
<!-- add new modal -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="AddNewSoa" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Add New SOA</h3>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form class="form" method="POST" action="addnewsoa.php">
						<div class="row form-group">
							<label class="control-label">Select Client ID</label>
							<!-- <input list="client_id" class="form-control" name="client_id">
							<datalist id="client_id">
								<?php
									// echo $clientid;
								?>									
							</datalist> -->
							<input class="form-control" list="clientlist" name="client_id">
							<datalist id="clientlist">
							<?php echo getClients(); ?>								
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
			<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>