<?php
	include('conn.php');

	$soa_id = $_GET['id'];
	$soa_total_amount = $_GET['amount'];
	$soa_status = 'pending';


	// $SQL = "UPDATE tbl_soa set soa_total_amount='$soa_total_amount', soa_status='$soa_status', soa_balance='$soa_total_amount' where soa_id='$soa_id'";

	$SQL = "UPDATE tbl_soa set soa_total_amount='$soa_total_amount', soa_balance='$soa_total_amount', soa_status='$soa_status' where soa_id='$soa_id'";

	mysqli_query($connection, $SQL);

	header('location: soaapproved.php');
?>