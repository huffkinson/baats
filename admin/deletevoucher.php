<?php
	include('conn.php');

	$id = $_GET['id'];

	$SQL = "DELETE FROM tbl_voucher where voucher_id='$id'";

	mysqli_query($connection, $SQL);

	header('location: voucher.php');

?>