<?php
	include('conn.php');

	$id = $_GET['id'];
	$to = $_POST['to'];

	$SQL = "UPDATE tbl_voucher SET voucher_to='$to' WHERE voucher_id='$id'";
	mysqli_query($connection, $SQL);

	header('location: voucher.php');

?>