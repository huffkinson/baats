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
	include('reportfunctions.php');
	$date_today = date_create(date("y-m-d"));
	$SQL = "";

	function get_collected_amountfor($remarks,$clientid) {
		include('conn.php');

		$sql = "SELECT Sum(collection_amount) as total, tbl_collection.remarks, tbl_collection.client_id FROM tbl_collection WHERE (((tbl_collection.remarks)='$remarks') AND ((tbl_collection.client_id)='$clientid'))";

		$query = mysqli_query($connection, $sql);

		$result = mysqli_fetch_assoc($query);

		return $result['total'];
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Payment Summary | Reports</title>
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
			/*border-radius: 5px;*/
			/*box-shadow: 0px 0px 5px 1px grey;*/
			padding-top: 5px;
			padding-bottom: 5px;
		}
	</style>
</head>
<body>
	<!-- navigation bar starts here -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">Main Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="reports.php">Reports</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ar-reports.php">Account Receivable</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="paymentsummary.php">Payment Summary</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="cashdisbursement.php">Cash Disbursement</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- navigation ends here -->

	<!-- payment summary title starts here -->
	<div class="container">
		<div class="row justify-content-center my-frames">
			<div class="my-frames">
				<h3>Payment Summary Report</h3>
			</div>
		</div>
	</div>
	<!-- payment summary title ends here -->

	<!-- search bar starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<form class="form form-inline form-sm" method="POST" action="">
			<div>
				<div class="col"><label class="control-label">Filters:</label></div><div class="col">
				<select class="form-control-sm" name="main">
					<option selected>Choose...</option>
					<option value="All">All</option>
					<option value="RDO">by RDO</option>
				</select></div>
			</div>
			<div>
				<div class="my-spacer"></div>
				<div class="my-spacer"></div>
				<input type="text" class="form-control-sm" name="filter" placeholder="Enter filter keyword">
			</div>
			<div>
				<div class="col"><label class="control-label">Tax type:</label></div><div class="col">
				<input class="form-control-sm" list="chargelist" name="charges" placeholder="Choose charges">
				<datalist id="chargelist">
					<?php echo get_all_charges();?>						
				</datalist></div>
			</div>
			<div>
				<div class="col"><label class="control-label">Date 1</label></div><div class="col">
				<input class="form-control-sm" type="date" name="date1"></div>
			</div>
			<div>
				<div class="col"><label class="control-label">Date 2</label></div><div class="col">
				<input class="form-control-sm" type="date" name="date2"></div>
			</div>
			<div>
				<div class="my-spacer"></div>
				<div class="my-spacer"></div>
				<input class="btn btn-sm btn-primary" type="submit" name="GO" value="Submit">
			</div>
			</form>
		</div>
	</div>
	<!-- search bar title ends here -->

	<!-- payment summary report section starts here -->
	<div class="my-spacer"></div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-10">
			<?php
				if(isset($_POST['GO'])){
					$option = $_POST['main'];
					$charges = $_POST['charges'];

					switch ($option) {
						case 'All':

						$remarks_filter = $_POST['charges'];
						$datestart = $_POST['date1'];
						$dateend = $_POST['date2'];

						?>
						<table class="table table-sm">
							<thead class="thead-dark">
								<tr>
									<th>RDO</th>
									<th class="text-center">Details</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$rdo_array=array();
								$sql = "select distinct client_rdo from tbl_client order by client_rdo desc";
								$query = mysqli_query($connection,$sql);
								while($row=mysqli_fetch_assoc($query)){
									$rdo_array[]=$row['client_rdo'];
								}
								foreach($rdo_array as $rdo){

									$sql = "SELECT DISTINCT tbl_collection.client_id, tbl_client.client_rdo FROM tbl_collection INNER JOIN tbl_client ON tbl_collection.client_id = tbl_client.client_id WHERE (((tbl_client.client_rdo)='$rdo'))";

									$query = mysqli_query($connection, $sql);
									if($query){
										$rows = mysqli_num_rows($query);
										if($rows>0){
											
											$clientid_array = array();
											while($row=mysqli_fetch_assoc($query)){
												$clientid_array[]=$row['client_id'];
											}

											foreach($clientid_array as $client_id){
												// table in this td repeats per customer
												
												$sql = "SELECT * from tbl_soa where client_id='$client_id' and soa_status='approved'";
												if($datestart!="" && $dateend!=""){
													$sql .= " and soa_date between '$datestart' and '$dateend'";
												}

												if($datestart!="" && $dateend==""){
													$sql .= " and soa_date = '$datestart'";
												}

												$query2 = mysqli_query($connection, $sql);
												if($query2){
													$rows2 = mysqli_num_rows($query2);
													if($rows2>0){

														$soaid_array = array();
														while($row2=mysqli_fetch_assoc($query2)){
															$soaid_array[]=$row2['soa_id'];
														}
														foreach($soaid_array as $soa_id){
															
															$sql = "Select * From tbl_soa_details where soa_id='$soa_id'";
															if($remarks_filter!=""){
																$sql .=" and soa_description like '%$remarks_filter%'";
															}
															$query3 = mysqli_query($connection, $sql);
															if($query3){
																$rows3 = mysqli_num_rows($query3);
																if($rows3>0){
																	echo '<tr>';
																	echo '<td>'.$rdo.'</td>';
																	echo '<td>';
																	echo '<table class="table table-sm table-striped">';
																	echo '<tr>';
																	echo '<td colspan="3">Client : '.strtoupper($client_id).'-'.get_clientname($client_id).'</td>';
																	echo '</tr>';
																	echo '<tr>';
																	echo '<td colspan="3">SOA# : '.$soa_id.'</td>';
																	echo '</tr>';
																	echo '<tr>';
																	echo '<td>Description</td>';
																	echo '<td>Amount to Pay</td>';
																	echo '<td>Amount Collected</td>';
																	echo '</tr>';
																	while($row3=mysqli_fetch_assoc($query3)){
																		echo '<tr>';
																		echo '<td>'.$row3['soa_description'].'</td>';
																		echo '<td class="text-right">'.$row3['soa_description_amount'].'</td>';
																		echo '<td class="text-right">'.get_collected_amountfor($row3['soa_description'],$client_id).'</td>';
																		echo '</tr>';
																	}

																	echo '</table>';
																	echo '</td>';
																	echo '</tr>';

																}
															}
														}
															
													}
												}
												
												
											}

										}
									}
									
								}
							?>
							</tbody>
						</table>
						<?php

							break;

						case 'RDO':

							$rdo_filter = $_POST['filter'];
							$remarks_filter = $_POST['charges'];
							$datestart = $_POST['date1'];
							$dateend = $_POST['date2'];

							?>
							<table class="table table-sm">
								<thead class="thead-dark">
									<tr>
										<th>RDO</th>
										<th class="text-center">Details</th>
									</tr>
								</thead>
								<tbody>
								<?php
									

										$sql = "SELECT DISTINCT tbl_collection.client_id, tbl_client.client_rdo FROM tbl_collection INNER JOIN tbl_client ON tbl_collection.client_id = tbl_client.client_id WHERE (((tbl_client.client_rdo)='$rdo_filter'))";

										$query = mysqli_query($connection, $sql);
										if($query){
											$rows = mysqli_num_rows($query);
											if($rows>0){
												
												$clientid_array = array();
												while($row=mysqli_fetch_assoc($query)){
													$clientid_array[]=$row['client_id'];
												}

												foreach($clientid_array as $client_id){
													// table in this td repeats per customer
													
													$sql = "SELECT * from tbl_soa where client_id='$client_id' and soa_status='approved'";
													if($datestart!="" && $dateend!=""){
														$sql .= " and soa_date between '$datestart' and '$dateend'";
													}

													if($datestart!="" && $dateend==""){
														$sql .= " and soa_date = '$datestart'";
													}

													$query2 = mysqli_query($connection, $sql);
													if($query2){
														$rows2 = mysqli_num_rows($query2);
														if($rows2>0){

															$soaid_array = array();
															while($row2=mysqli_fetch_assoc($query2)){
																$soaid_array[]=$row2['soa_id'];
															}
															foreach($soaid_array as $soa_id){
																
																$sql = "Select * From tbl_soa_details where soa_id='$soa_id'";
																if($remarks_filter!=""){
																	$sql .=" and soa_description like '%$remarks_filter%'";
																}
																$query3 = mysqli_query($connection, $sql);
																if($query3){
																	$rows3 = mysqli_num_rows($query3);
																	if($rows3>0){
																		echo '<tr>';
																		echo '<td>'.$rdo_filter.'</td>';
																		echo '<td>';
																		echo '<table class="table table-sm table-striped">';
																		echo '<tr>';
																		echo '<td colspan="3">Client : '.strtoupper($client_id).'-'.get_clientname($client_id).'</td>';
																		echo '</tr>';
																		echo '<tr>';
																		echo '<td colspan="3">SOA# : '.$soa_id.'</td>';
																		echo '</tr>';
																		echo '<tr>';
																		echo '<td>Description</td>';
																		echo '<td>Amount to Pay</td>';
																		echo '<td>Amount Collected</td>';
																		echo '</tr>';
																		while($row3=mysqli_fetch_assoc($query3)){
																			echo '<tr>';
																			echo '<td>'.$row3['soa_description'].'</td>';
																			echo '<td class="text-right">'.$row3['soa_description_amount'].'</td>';
																			echo '<td class="text-right">'.get_collected_amountfor($row3['soa_description'],$client_id).'</td>';
																			echo '</tr>';
																		}

																		echo '</table>';
																		echo '</td>';
																		echo '</tr>';

																	}
																}
															}
																
														}
													}
													
													
												}

											}
										}
										
									
								?>
								</tbody>
							</table>
							<?php

							break;
						
						default:
						?>
						<table class="table table-sm">
							<thead class="thead-dark">
								<tr>
									<th>RDO</th>
									<th class="text-center">Details</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$rdo_array=array();
								$sql = "select distinct client_rdo from tbl_client order by client_rdo desc";
								$query = mysqli_query($connection,$sql);
								while($row=mysqli_fetch_assoc($query)){
									$rdo_array[]=$row['client_rdo'];
								}
								foreach($rdo_array as $rdo){
									echo '<tr>';

									$sql = "SELECT DISTINCT tbl_collection.client_id, tbl_client.client_rdo FROM tbl_collection INNER JOIN tbl_client ON tbl_collection.client_id = tbl_client.client_id WHERE (((tbl_client.client_rdo)='$rdo'))";

									$query = mysqli_query($connection, $sql);
									if($query){
										$rows = mysqli_num_rows($query);
										if($rows>0){
											echo '<td>'.$rdo.'</td>';
											$clientid_array = array();
											while($row=mysqli_fetch_assoc($query)){
												$clientid_array[]=$row['client_id'];
											}
											echo '<td>';
											foreach($clientid_array as $client_id){
												// table in this td repeats per customer
												
												echo '<table class="table table-sm table-striped">';
												echo '<tr>';
												echo '<td colspan="3">Client : '.strtoupper($client_id).'-'.get_clientname($client_id).'</td>';
												echo '</tr>';
												$sql = "SELECT * from tbl_soa where client_id='$client_id' and soa_status='approved'";
												$query2 = mysqli_query($connection, $sql);
												if($query2){
													$rows2 = mysqli_num_rows($query2);
													if($rows2>0){
														$soaid_array = array();
														while($row2=mysqli_fetch_assoc($query2)){
															$soaid_array[]=$row2['soa_id'];
														}
														foreach($soaid_array as $soa_id){
															echo '<tr>';
															echo '<td colspan="3">SOA# : '.$soa_id.'</td>';
															echo '</tr>';
															echo '<tr>';
															echo '<td>Description</td>';
															echo '<td>Amount to Pay</td>';
															echo '<td>Amount Collected</td>';
															echo '</tr>';
															$sql = "Select * From tbl_soa_details where soa_id='$soa_id'";
															$query3 = mysqli_query($connection, $sql);
															if($query3){
																$rows3 = mysqli_num_rows($query3);
																if($rows3>0){
																	while($row3=mysqli_fetch_assoc($query3)){
																		echo '<tr>';
																		echo '<td>'.$row3['soa_description'].'</td>';
																		echo '<td class="text-right">'.$row3['soa_description_amount'].'</td>';
																		echo '<td class="text-right">'.get_collected_amountfor($row3['soa_description'],$client_id).'</td>';
																		echo '</tr>';
																	}
																}
															}
														}
															
													}
												}
												echo '</table>';
												
											}
											echo '</td>';
										}
									}
									echo '</tr>';
								}
							?>
							</tbody>
						</table>
						<?php
							break;
					}
				}
			?>
			</div>
		</div>
	</div>
	
	<!-- payment summary report section ends here -->

</body>
</html>