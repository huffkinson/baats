<?php
	include('conn.php');

	$soa_id = $_GET['id'];
	$suffix = $_GET['suffix'];
	$soa_description = $_POST['soa_description']."-".$suffix;
	$soa_description_amount = $_POST['soa_description_amount'];

	$SQL = "INSERT INTO tbl_soa_details (soa_id,soa_description,soa_description_amount) VALUES('$soa_id','$soa_description','$soa_description_amount')";

	mysqli_query($connection, $SQL);

	header('location: soadetails.php?id='.$soa_id);
?>