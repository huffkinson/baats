<?php
	include('conn.php');

	$id = $_GET['id'];

	$SQL = "DELETE FROM tbl_voucher_details WHERE voucher_id=$id";
	mysqli_query($connection, $SQL);

	$SQL = "DELETE FROM tbl_voucher WHERE voucher_id=$id";
	mysqli_query($connection, $SQL);

	header('location: voucher.php');

?>