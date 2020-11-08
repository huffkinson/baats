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

	$voucher_id = $_GET['id'];
	$date_today = date_create(date("y-m-d"));

	$record = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbl_voucher WHERE voucher_id = '$voucher_id'"));
	extract($record);
    $voucher_amt = $record['voucher_amt'];
    $voucher_date = $record['voucher_date'];
    $voucher_from = $record['voucher_from'];
    $voucher_to = $record['voucher_to'];

    // if($voucher_amt <= 0 || $voucher_amt==''){

    // 	?>
     		<script>
    // 			alert("No amount to process.");
    // 			location = "voucher.php";
    // 		</script>
     	<?php
    // 	//header('location: voucher.php');
    // }
    // else{

    // }
	

	/*$tempsql = "Select tbl_soa.soa_id, tbl_soa.client_id, tbl_soa.soa_total_amount, tbl_soa.soa_note1, tbl_soa.soa_note2, tbl_soa_details.soa_details_id, tbl_soa_details.soa_description, tbl_soa_details.soa_description_amount from tbl_soa inner join tbl_soa_details on tbl_soa_details.soa_id=tbl_soa.soa_id where tbl_soa_details.soa_id='$soa_id'";

	$tempqry = mysqli_query($connection, $tempsql);*/

?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Voucher</title>
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
		.voucher-title{
			font-size: 26px;
			font-weight: 700px;
		}
		.voucher-subtitle{
			font-size: 10px;
		}
		.smaller-height{
			font-size: 10px;
			height: 10px;
			line-height: 5px;
		}
	</style>

</head>
<body>
	


<div>
	<div class="container" style="height: 25px;"></div>
	<div class="row">
	    <div class="col">
			<center class="voucher-title"><b>BOTE ACCOUNTING AND TAXATION SERVICES</b></center>
			<center class="voucher-subtitle"><p>1052 Quirino Highway, Dela Cruz Street Interior<br>
			Sta. Monica, Novaliches, Quezon City<br>
			Tel#:794-5332 Mobile#:0922-8438045 Email:boteacctgandtaxationservices@gmail.com</p></center>
		</div>
	</div>
	<div class="row justify-content-between">
	    <div class="col-3" align="center">
	    	<b style="font-size: 20px;">VOUCHER</b>
	    </div>
	    <div class="col-3" align="center">
	    	<table>
	    		<tr>
	    			<td><b>Voucher#</b></td>
	    			<td>:</td>
	    			<td><b><?php $format = date_format($date_today,"y-m").sprintf("%04d",$voucher_id); echo $format; ?></b></td>
	    		</tr>
	    		<tr>
	    			<td><b>Date#</b></td>
	    			<td>:</td>
	    			<td><b><?php echo $voucher_date; ?></b></td>
	    		</tr>
	    	</table>
	    </div>
	</div>
	<div class="container">
		<div class="row">
			<table style="width: 80%;">
				<tr style="">
					<td style="padding-bottom: 5px;padding-top: 5px;"><b>FROM</b>&nbsp;</td>
					<td>&nbsp;:&nbsp;</td>
					<td><b><?php echo $voucher_from; ?></b></td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px;padding-top: 5px;">TO&nbsp;</td>
					<td>&nbsp;:&nbsp;</td>
					<td style="border-bottom: 1px solid black;"><?php echo $voucher_to; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="container" style="height: 25px;"></div>
	<div class="container">
		<div class="row">
			<div class="col-8" style="border: 1px solid black; font-size: 12px; line-height: 0px;" align="center"><b>DESCRIPTION / PARTICULARS</b></div>
			<div class="col-4" style="border: 1px solid black; font-size: 12px; line-height: 0px;" align="center"><b>AMOUNT</b></div>
		</div>
	</div>
	<div class="container" style="height: 25px;"></div>
	<div class="container">
		<div class="row">
			<div class="col-8">
				<?php
					//$voucherCONN = new mysqli('localhost','root','','samplecrud') or die();
					$SQL = "SELECT * FROM tbl_voucher_details WHERE voucher_id='$voucher_id'";
					// $result = mysqli_query($voucherCONN, $SQL);
					$result = mysqli_query($connection, $SQL);
					while($row=mysqli_fetch_assoc($result)){
						echo $row['voucher_description'].'<br>';
					}
				?>
			</div>
			<div class="col-4" style="padding-right: 100px;" align="right">
				<?php
					//$voucherCONN = new mysqli('localhost','root','','samplecrud') or die();
					$SQL = "SELECT * FROM tbl_voucher_details WHERE voucher_id='$voucher_id'";
					// $result = mysqli_query($voucherCONN, $SQL);
					$result = mysqli_query($connection, $SQL);
					while($row=mysqli_fetch_assoc($result)){
						echo number_format($row['voucher_amount'],'2','.',',').'<br>';
					}
				?>
			</div>
		</div>
	</div>
	<div class="container" style="height: 25px;"></div>
	<div class="container">
		<div class="row">
			<table class="table table-bordered" style="border: 3px solid black;">
				<tr>
					<td style="border: 3px solid black;">CASH</td>
					<td style="border: 3px solid black;">CHECK</td>
					<td style="border: 3px solid black;" align="center">Prepared by:</td>
					<td style="border: 3px solid black;" align="center">Approved by:</td>
					<td style="border: 3px solid black;" align="center">Received by:</td>
				</tr>
				<tr style="height: 100px;">
					<!-- <td style="border: 3px solid black;" class="smaller-height align-middle" align="center"><?php echo number_format($voucher_amt,'2','.',','); ?></td> -->
					<td style="border: 3px solid black;"></td>
					<td style="border: 3px solid black;"></td>
					<td style="border: 3px solid black;"></td>
					<td style="border: 3px solid black;"></td>
					<td style="border: 3px solid black;"></td>
				</tr>
				<tr>
					<td style="border: 3px solid black; width: 85px;"></td>
					<td style="border: 3px solid black; width: 85px;"></td>
					<td style="border: 3px solid black; width: 200px;"></td>
					<td style="border: 3px solid black; width: 200px;" class="smaller-height" align="center"><B>DIVINE LOVE S. BOTE</B></td>
					<td style="border: 3px solid black;"></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="container">
		<div class="row" style="padding-right: 25px; font-size: 12px;">
			<div class="col" align="right">Voucher# :<b><?php $format = date_format($date_today,"y-m").sprintf("%04d",$voucher_id); echo $format; ?></b></div>
		</div>
	</div>
</div>
</body>
</html>