<?php
	include('conn.php');

	$id  = $_GET['id'];
	$voucher_detail_id = $_GET['voucher'];

	$SQL = "DELETE FROM tbl_voucher_details where voucher_detail_id=$voucher_detail_id";

	mysqli_query($connection, $SQL);

	header('location: voucherdetails.php?id='.$id);

?>