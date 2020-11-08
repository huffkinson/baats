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

	$soa_id = $_GET['id'];
	$date_today = date_create(date("y-m-d"));

	//$tempcon = new mysqli('localhost','id12256582_bote','bote2020','id12256582_bote') or die();
	//$tempcon = new mysqli('localhost','root','','samplecrud') or die();
	
	//$connection = new mysqli('localhost','id12256582_bote','bote2020','id12256582_bote') or die();
	//$connection = new mysqli('localhost','root','','samplecrud') or die();

	// enable when session starts
	/*$getID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM login WHERE user = '".$_SESSION['user']."'"));
    $userfullname = $getID['fullname'];*/

	
	//$connection = new mysqli('localhost','id12256582_bote','bote2020','id12256582_bote') or die();
	//$connection = new mysqli('localhost','root','','samplecrud') or die();

	$getID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbl_soa WHERE soa_id = '$soa_id'"));
    $client_id = $getID['client_id'];
    $total_soa_amount = $getID['soa_total_amount'];

    $getID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbl_client WHERE client_id = '$client_id'"));
	$clientname = $getID['client_name'];
	$clientaddress = $getID['client_address'];

	

	$tempsql = "Select tbl_soa.soa_id, tbl_soa.client_id, tbl_soa.soa_total_amount, tbl_soa.soa_note1, tbl_soa.soa_note2, tbl_soa_details.soa_details_id, tbl_soa_details.soa_description, tbl_soa_details.soa_description_amount from tbl_soa inner join tbl_soa_details on tbl_soa_details.soa_id=tbl_soa.soa_id where tbl_soa_details.soa_id='$soa_id'";

	$tempqry = mysqli_query($connection, $tempsql);


?>
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
	.smaller-height{
		line-height: 10px;
		min-height: 10px;
		height: 10px;
	}
	.smaller-height-details{
		line-height: 12px;
		min-height: 12px;
		height: 12px;
	}
	.signature-area {
		line-height: 75px;
		min-height: 75px;
		height: 75px;
	}
</style>
<body>
<div>
	<!-- -->
	<div class="row">
	    <div class="col">
			<center style="font-size: 28px; font-weight: 700;">BOTE ACCOUNTING AND TAXATION SERVICES</center>
			<CENTER><P style="font-weight: 700;">1052 Quirino Highway, Dela Cruz Street Interior<br>
			Sta. Monica, Novaliches, Quezon City<br>
			Tel#:794-5332 Mobile#:0922-8438045 Email:boteacctgandtaxationservices@gmail.com</P></CENTER>
		</div>
	</div>
	<div class="row">
	    <div class="col">
	    <table class="table table-borderless table-lg" align="center">
	        <thead>
	            <th rowspan="3" class="align-middle" style="font-size: 24px;">SOA Control# <?php printf("%04d",$soa_id);?></th>
				<th rowspan="3" class="align-middle text-center" colspan="5" style="font-size: 24px;">Statement of Account</th>
				<th rowspan="3" class="align-middle text-right" style="font-size: 24px;">Charge Slip# <?php $format = date_format($date_today,"y-m").sprintf("%04d",$soa_id); echo $format; ?></th>
	        </thead>
	        <tbody>
	            <tr>
	                <td class="smaller-height" colspan="5"><b>Client Name: <?php echo $clientname;?></b></td>
				    <td rowspan="2" colspan="2" class="align-middle text-right" style="font-size:26px;"><b>TOTAL AMOUNT : <?php echo number_format($total_soa_amount,'2','.',',');?></b></td>
				</tr>
				<tr>
				    <td class="smaller-height" colspan="5"><b>Address: <?php echo $clientaddress;?></b></td>
			    </tr>
			    <tr>
			        <td colspan="4" style="text-indent: 25px;"><b>Charge Description</b></td>
			        <td></td>
				    <td class="text-center"><b>Amount</b></td>
				    <td rowspan="3" style="background-image: url('../img/bote_logo.jpg');background-size: 25%;
  background-repeat: no-repeat; background-position: center;opacity:0.2;"></td>
			    </tr>
			    
				<?php
					
					while($temprec = mysqli_fetch_assoc($tempqry)){
					extract($temprec);?>
				    <tr>
				        <td class="smaller-height" colspan="2" style="text-indent: 100px;"><?php echo $temprec['soa_description'];?></td>
				        <td></td>
				        <td class="smaller-height" colspan="3" align="right"><?php echo number_format($temprec['soa_description_amount'],2,'.',',');?></td>
				    </tr>
				    <?php } ?>
				<tr>
					<td class="smaller-height" align="center" colspan="7"><i><small>* * * * * * * * * * Nothing Follows * * * * * * * * * *</small></i></td>
				</tr>
			</tbody>
	    </table>
	    </div>
	    
	</div>
	<div class="row justify-content-center">
	        <table class="table table-borderless table-lg">
	            <tr>
					<td style="text-indent: 15px;" class="smaller-height" colspan="3" align="left"><B>Prepared by:</B></td>
					<td class="smaller-height" colspan="2" align="left"><B>Checked by:</B></td>
					<td class="smaller-height" colspan="2" align="left"><B>Approved by:</B></td>
				</tr>
				<tr class="signature-area" align="center">
					<td colspan="3" class="smaller-height"><br><br><br>_____________________________________<br><br><b><!-- <?php echo $userfullname;?> --></td>
					<td colspan="2" class="smaller-height"><br><br><br>_____________________________________<br><br><B>DIVINE LOVE S. BOTE</B></td>
					<td colspan="2" class="smaller-height"><br><br><br>_____________________________________<br><br><B>DIVINE LOVE S. BOTE</B></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><B>Received payments by:</B></td>
					<td colspan="4" align="center"><B>Copy received by:</B></td>
				</tr>
				<tr class="signature-area" align="center">
					<td colspan="3" class="smaller-height"><br><br><br>_____________________________________<br><br>Signature over Printed Name</td>
					<td colspan="4" class="smaller-height"><br><br><br>_____________________________________<br><br>Signature over Printed Name</td>
				</tr>
				<tr>
				    <td class="smaller-height" colspan="6"></td>
					<td class="smaller-height" align="right"><small>Charge Slip #:
					<?php $format = date_format($date_today,"y-m").sprintf("%04d",$soa_id); echo $format; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small></td>
				</tr>
				<tr class="smaller-height" style="border: 1px solid black"><td colspan="7"><center><B>Note: All Check Payments should be payable to DIVINE LOVE S. BOTE or BOTE ACCOUNTING AND TAXATION SERVICES</B></center></td></tr>
	        </table>
	    </div>
</div>
</body>