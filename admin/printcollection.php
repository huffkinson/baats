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

	$collection_id = $_GET['id'];
	$date_today = date_create(date("y-m-d"));

	$getID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM login WHERE user = '".$_SESSION['user']."'"));
    $userfullname = $getID['fullname'];

	$record = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbl_collection WHERE collection_id = '$collection_id'"));
	extract($record);
    $collection_amount = $record['collection_amount'];
    $collection_date = $record['collection_date'];
    $posting_date = $record['posting_date'];
    $soa_id = $record['soa_id'];
    $collection_by = $record['collection_by'];
    $remitted_to = $record['remitted_to'];
    $or_id = $record['or_id'];

   	$record = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbl_soa WHERE soa_id='$soa_id'"));
   	extract($record);
   	$clientFrom = $record['soa_note1'];
   	$clientAddress = $record['soa_note2'];

    if($collection_amount <= 0 || $collection_amount==''){
		?>
     		<script>
     			alert("No amount to process.");
     			location = "collection.php";
    		</script>
     	<?php
     }
	

	/*$tempsql = "Select tbl_soa.soa_id, tbl_soa.client_id, tbl_soa.soa_total_amount, tbl_soa.soa_note1, tbl_soa.soa_note2, tbl_soa_details.soa_details_id, tbl_soa_details.soa_description, tbl_soa_details.soa_description_amount from tbl_soa inner join tbl_soa_details on tbl_soa_details.soa_id=tbl_soa.soa_id where tbl_soa_details.soa_id='$soa_id'";

	$tempqry = mysqli_query($connection, $tempsql);*/

?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Collection Report</title>
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
		.collection-title{
			font-size: 26px;
			font-weight: 700px;
		}
		.collection-subtitle{
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
	<div class="container" style="height: 25px;"></div>
		<div class="row">
		    <div class="col">
				<center class="collection-title"><b>BOTE ACCOUNTING AND TAXATION SERVICES</b></center>
				<center class="collection-subtitle"><p>1052 Quirino Highway, Dela Cruz Street Interior<br>
				Sta. Monica, Novaliches, Quezon City<br>
				Tel#:794-5332 Mobile#:0922-8438045 Email:boteacctgandtaxationservices@gmail.com</p></center>
			</div>
		</div>
		<div class="container">
			<div class="row">
			    <div class="col-8">
			    	<b style="font-size: 20px;">COLLECTION REPORT</b>
			    </div>
			    <div class="col-4">
			    	<table>
			    		<tr>
			    			<td><b>CR#</b></td>
			    			<td>:</td>
			    			<td><b><?php $format = date_format($date_today,"y-m").sprintf("%04d",$collection_id); echo $format; ?></b></td>
			    		</tr>
			    		<tr>
			    			<td><b>Collection Date#</b></td>
			    			<td>:</td>
			    			<td><b><?php echo $collection_date; ?></b></td>
			    		</tr>
			    		<tr>
			    			<td><b>Posting Date#</b></td>
			    			<td>:</td>
			    			<td><b><?php echo $posting_date; ?></b></td>
			    		</tr>
			    	</table>
			    </div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<table style="width: 80%;">
					<tr style="">
						<td style="padding-bottom: 5px;padding-top: 5px;"><b>FROM</b>&nbsp;</td>
						<td>&nbsp;:&nbsp;</td>
						<td><b><?php echo $clientFrom; ?></b></td>
					</tr>
					<tr>
						<td style="padding-bottom: 5px;padding-top: 5px;">Address&nbsp;</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo $clientAddress; ?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="container my-spacer"></div>
		<div class="container">
			<div class="row">
				<div class="col-8" style="border: 1px solid black; font-size: 12px; line-height: 0px;" align="center"><b>DESCRIPTION / PARTICULARS</b></div>
				<div class="col-4" style="border: 1px solid black; font-size: 12px; line-height: 0px;" align="center"><b>AMOUNT</b></div>
			</div>
		</div>
		<div class="container my-spacer"></div>
		<div class="container">
			<div class="row">
				<div class="col-8">
					<?php
						$SQL = "SELECT * FROM tbl_collection_details WHERE collection_id='$collection_id'";
						$result = mysqli_query($connection, $SQL);

						while($row=mysqli_fetch_assoc($result)){
							echo $row['description'].'<br>';
						}
					?>
				</div>
				<div class="col-4" style="padding-right: 100px;" align="right">
					<?php
						$SQL = "SELECT * FROM tbl_collection_details WHERE collection_id='$collection_id'";
						$result = mysqli_query($connection, $SQL);
						while($row=mysqli_fetch_assoc($result)){
							echo number_format($row['amount'],'2','.',',').'<br>';
						}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
				<?php
					echo "<br><b>Collected by:</b>"."<br>".$collection_by;
				?>
				</div>
				<div class="col-4">
				<?php
					echo "<br><b>Remitted to:</b>"."<br>".$remitted_to;
				?>
				</div><div class="col-4">
				<?php
					echo "<br><b>OR #:</b>"."<br>".$or_id;
				?>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row" style="padding-right: 25px; font-size: 12px;">
			<div class="col" align="right">
				CR# :<?php $format = date_format($date_today,"y-m").sprintf("%04d",$collection_id); echo $format;?>
			</div>
		</div>
	</div>
</body>
</html>