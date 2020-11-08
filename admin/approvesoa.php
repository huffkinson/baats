<?php
	include('conn.php');

	$soa_id=$_GET['id'];

	$SQL = "SELECT * FROM tbl_soa where soa_id='$soa_id'";
	$result = mysqli_query($connection, $SQL);

	$row = mysqli_fetch_assoc($result);
	$getAmount = $row['soa_total_amount'];
	if ($getAmount<=0 || $getAmount='') {
		?>
		<script type="text/javascript">
			alert("No amount to approve.");
			location="soapending.php";
		</script>
		<?php
	} else {
		$SQL = "UPDATE tbl_soa set soa_status='approved' where soa_id='$soa_id'";

		mysqli_query($connection, $SQL);
		header('location: soapending.php');
	}

?>