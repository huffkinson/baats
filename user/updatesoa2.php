<?php
	include('conn.php');

	$soa_id = $_GET['id'];
	$soa_total_amount = $_GET['amount'];

	$SQL = "UPDATE tbl_soa set soa_total_amount='$soa_total_amount' where soa_id='$soa_id'";

	mysqli_query($connection, $SQL);

	header('location: soaapproved.php');
?>