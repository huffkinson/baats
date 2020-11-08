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

	$getID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM login WHERE user = '".$_SESSION['user']."'"));
    $userfullname = $getID['fullname'];

	$date_today = time();
	$idStamp = date("mdhisY", $date_today);

	$client = $_GET['client'];
	$date1 = $_GET['date1'];
	$date2 = $_GET['date2'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print AR Report | Reports</title>
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
<div class="container my-frames"></div>
<div class="container my-frames"></div>
<div class="container my-frames">
	<div class="row">
		<h1>ACCOUNTS RECEIVABLE</h1>
	</div>
	<div class="row">
		as of <?php echo date("M d, Y",time());?>
	</div>
	<div class="row">
		Generated by: <?php echo $userfullname;?>
	</div>
	<div class="row">
		Document #: <?php echo $idStamp;?>
	</div>
</div>
<div class="container">
<div class="row">

<?php
	$SQL = "SELECT * FROM tbl_soa INNER JOIN tbl_client on tbl_soa.client_id=tbl_client.client_id where tbl_soa.soa_status='approved'";
	if($client==""){
		
	} else {
		$SQL .= " and tbl_client.client_id like '%".$client."%' or tbl_client.client_name like '%".$client."%'";
	}
	if($date1=="" && $date2==""){

	} else {
		
		if($date1!="" && $date2==""){
			$SQL .= " and tbl_soa.soa_date='$date1'";
		}
		if($date1!="" && $date2!=""){
			$SQL .= " and tbl_soa.soa_date between '$date1' and '$date2'";
		}
	}
	$SQL .= " order by tbl_client.client_id, tbl_soa.soa_date asc";
	$temp_subtotal = 0;
	$temp_balance = 0;
	$grand_total = 0;
	$grand_balance = 0;
	$islastrecord = false;
	$result = mysqli_query($connection, $SQL);
	
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		?>
		<table width="100%" border="1">
			<thead>
				<tr>
					<th class="text-center"><b>Client Name</b></th>
					<th class="text-center"><b>SOA #</b></th>
					<th class="text-center"><b>SOA Date</b></th>
					<th class="text-center"><b>Amount</b></th>
					<th class="text-center"><b>Balance</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><b><?php echo $row['client_id'].'-'.$row['client_name'];?></b></td>
					<td align="center"><?php echo $row['soa_id'];?></td>
					<td align="center"><?php echo $row['soa_date'];?></td>
					<td align="right"><?php echo myformat($row['soa_total_amount']);?></td>
					<td align="right"><?php echo myformat($row['soa_balance']);?></td>
				</tr>
			<?php
			$tempID = $row['client_id'];
			$temp_subtotal += $row['soa_total_amount'];
			$temp_balance += $row['soa_balance'];
			
			$islastrecord = true;
			while($row=mysqli_fetch_assoc($result)){
			if ($row['client_id']==$tempID) {
			$islastrecord=false;
			?>
				<tr>
					<td></td>
					<td align="center"><?php echo $row['soa_id'];?></td>
					<td align="center"><?php echo $row['soa_date'];?></td>
					<td align="right"><?php echo myformat($row['soa_total_amount']);?></td>
					<td align="right"><?php echo myformat($row['soa_balance']);?></td>
				</tr>
			<?php
			$temp_subtotal += $row['soa_total_amount'];
			$temp_balance += $row['soa_balance'];
			$islastrecord = true;
			} else {
			?>
				<!-- <tr>
					<td></td>
					<td align="center"></td>
					<td align="right" style="font-weight: bold;">Sub-total:</td>
					<td align="right" style="font-weight: bold;"><?php echo myformat($temp_subtotal);?></td>
					<td align="right" style="font-weight: bold;"><?php echo myformat($temp_balance);?></td>
				</tr> -->
			<?php
			$tempID = $row['client_id'];
			$grand_total += $temp_subtotal;
			$grand_balance += $temp_balance;
			$temp_subtotal = 0;
			$temp_balance = 0;
			$islastrecord = false;
			?>
				<tr>
					<td><b><?php echo $row['client_id'].'-'.$row['client_name'];?></b></td>
					<td align="center"><?php echo $row['soa_id'];?></td>
					<td align="center"><?php echo $row['soa_date'];?></td>
					<td align="right"><?php echo myformat($row['soa_total_amount']);?></td>
					<td align="right"><?php echo myformat($row['soa_balance']);?></td>
				</tr>
			<?php
			$temp_subtotal += $row['soa_total_amount'];
			$temp_balance += $row['soa_balance'];
			$islastrecord = true;
			}
			
			}
			if($islastrecord==true){
			?>
				<!-- <tr>
					<td></td>
					<td align="center"></td>
					<td align="right" style="font-weight: bold;">Sub-total:</td>
					<td align="right" style="font-weight: bold;"><?php echo myformat($temp_subtotal);?></td>
					<td align="right" style="font-weight: bold;"><?php echo myformat($temp_balance);?></td>
				</tr> -->
			<?php
			$grand_total += $temp_subtotal;
			$grand_balance += $temp_balance;
			}
			?>
				<!-- <tr>
					<td></td>
					<td align="center"></td>
					<td align="right" style="font-weight: bold;">Grand Total:</td>
					<td align="right" style="font-weight: bold;"><?php echo myformat($grand_total);?></td>
					<td align="right" style="font-weight: bold;"><?php echo myformat($grand_balance);?></td>
				</tr> -->
			</tbody>
		</table>
		<?php
		
	}
?>
</div>
</div>
</body>
</html>