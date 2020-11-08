<?php
	include('conn.php');

	$soa_id = $_GET['id'];
	$client_id = $_POST['client_id'];
	$soa_date = $_POST['soa_date'];

	$sql = "SELECT client_name, client_address FROM tbl_client where client_id='$client_id'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_fetch_assoc($query);
	$client_name = $result['client_name'];
	$client_address = $result['client_address'];

	$sql = "UPDATE tbl_soa set client_id='$client_id', soa_date='$soa_date', soa_note1='$client_name', soa_note2='$client_address' where soa_id='$soa_id'";

	mysqli_query($connection, $sql);

	header('location: soapending.php');
?>