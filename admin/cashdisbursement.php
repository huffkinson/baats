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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cash Disbursement | Reports</title>
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
</head>
<body>
	<!-- navigation bar starts here -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">Main Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mx-auto">
				<li class="nav-item">
					<a class="nav-link" href="reports.php">Reports</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ar-reports.php">Account Receivable</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="paymentsummary.php">Payment Summary</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="#">Cash Disbursement</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- navigation ends here -->

	<!-- section title starts here -->
	<div class="container">
		<div class="row text-center">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Cash Disbursement Summary Report</h3>
			</div>
		</div>
	</div>
	<!-- section title ends here -->

	<!-- filter section starts here -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-12 col-xl-12" style="border: 1px solid grey; border-radius: 10px;">
				<form class="form form-inline" method="POST" action="">
					<div class="form-group">
						<label class="control-label">Filter by:</label>
						<div class="col">
						<input class="form-control" list="accountname" name="account_name" placeholder="Choose...">
						<datalist id="accountname">
							<?php
							$sql = "select * from tbl_chart_of_accounts order by account_name asc";
							$query = mysqli_query($connection, $sql);
							$output = '';
							while($row=mysqli_fetch_assoc($query)){
								$output .= '<option value="'.$row['account_name'].'">'.$row['account_name'].'</option>';
							}
							echo $output;
							?>
							<option value="All">All</option>								
						</datalist>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Start Date:</label>
						<div class="col">
						<input class="form-control" type="date" name="start_date">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">End Date:</label>
						<div class="col">
						<input class="form-control" type="date" name="end_date">
						</div>
					</div>
					<div class="form-group">
						<input class="btn btn-sm btn-primary" type="submit" name="filter" value="SUBMIT">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- filter section ends here -->

	<div class="my-spacer"></div>
	<!-- detail section starts here -->
	<div class="container">
		<?php
			if(isset($_POST['printreport'])){
				?>
				<script>
					window.open("cashdisbursementreport.php","_blank");
				</script>
				<?php
			}
			if(isset($_POST['filter'])){
				?>
				<form class="form" method="POST" action="">
				<?php
				$_SESSION['account_name'] = $_POST['account_name'];
				$_SESSION['start_date'] = $_POST['start_date'];
				$_SESSION['end_date'] = $_POST['end_date'];
				$sql = "SELECT tbl_voucher_details.*, tbl_voucher.* from tbl_voucher_details join tbl_voucher on tbl_voucher.voucher_id=tbl_voucher_details.voucher_id";

				switch ($_SESSION['account_name']) {
					case 'All':
					$_SESSION['account_name'] = $_POST['account_name'];
					$_SESSION['start_date'] = $_POST['start_date'];
					$_SESSION['end_date'] = $_POST['end_date'];

					if(!$_SESSION['start_date']==""){
						if(!$_SESSION['end_date']==""){
							$sql .= ' where tbl_voucher.voucher_date between "'.$_SESSION['start_date'].'" and "'.$_SESSION['end_date'].'"';
						} else {
							$sql .= ' where tbl_voucher.voucher_date="'.$_SESSION['start_date'].'"';
						}
					}
					$sql .= ' order by tbl_voucher_details.voucher_id desc';
					?>
					
					<div class="row justify-content-center">
						<div class="col-2" align="center">
							<button type="submit" name="printreport" class="btn btn-sm btn-success">Print Report</button>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-10" style="border: 1px solid black;">
						<table class="table">
							<thead>
								<tr>
									<th>Voucher #</th>
									<th>Description</th>
									<th>Amount</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = mysqli_query($connection,$sql);
								while($row=mysqli_fetch_assoc($query)){
									echo '<tr>';
									echo '<td>'.$row['voucher_id'].'</td>';
									echo '<td>'.$row['voucher_description'].'</td>';
									echo '<td>'.$row['voucher_amount'].'</td>';
									echo '<td>'.$row['voucher_date'].'</td>';
									echo '</tr>';
								}
								?>
							</tbody>
							<tfoot>
								
							</tfoot>
						</table>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-2" align="center">
							<button type="submit" name="printreport" class="btn btn-sm btn-success">Print Report</button>
						</div>
					</div>
					<?php
						break;

					case $_SESSION['account_name']:
					$_SESSION['account_name'] = $_POST['account_name'];
					$_SESSION['start_date'] = $_POST['start_date'];
					$_SESSION['end_date'] = $_POST['end_date'];

						if(!$_SESSION['account_name']==""){
							$sql .= ' where voucher_description like "%'.$_SESSION['account_name'].'%"';
						} else {
							echo 'Please select an option from the filters.';
							break;
						}
						if(!$_SESSION['start_date']==""){
							if(!$_SESSION['end_date']==""){
								$sql .= ' and tbl_voucher.voucher_date between "'.$_SESSION['start_date'].'" and "'.$_SESSION['end_date'].'"';
							} else {
								$sql .= ' and tbl_voucher.voucher_date="'.$_SESSION['start_date'].'"';
							}
						}
					$sql .= ' order by tbl_voucher_details.voucher_id desc';
						?>
					
						<div class="row justify-content-center">
							<div class="col-2" align="center">
								<button type="submit" name="printreport" class="btn btn-sm btn-success">Print Report</button>
							</div>
						</div>

						<div class="row justify-content-center">
						<div class="col-10" style="border: 1px solid black;">
						<table class="table">
							<thead>
								<tr>
									<th>Voucher #</th>
									<th>Description</th>
									<th>Amount</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = mysqli_query($connection,$sql);
								while($row=mysqli_fetch_assoc($query)){
									echo '<tr>';
									echo '<td>'.$row['voucher_id'].'</td>';
									echo '<td>'.$row['voucher_description'].'</td>';
									echo '<td>'.$row['voucher_amount'].'</td>';
									echo '<td>'.$row['voucher_date'].'</td>';
									echo '</tr>';
								}
								?>
							</tbody>
							<tfoot>
								
							</tfoot>
						</table>
						</div>
					</div>

						<div class="row justify-content-center">
							<div class="col-2" align="center">
								<button type="submit" name="printreport" class="btn btn-sm btn-success">Print Report</button>
							</div>
						</div>
						<?php
						break;
					
					default:
						break;
				}
				?>
			</form>
			<?php
			}
		?>
	</div>
	<!-- detail section ends here -->
</body>
</html>