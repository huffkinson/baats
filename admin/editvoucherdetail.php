<?php
	include('conn.php');

	$id = $_GET['id'];
	$detail_id = $_GET['detail'];

	$voucher_description = $_POST['voucher_description'];
	$voucher_amount = $_POST['voucher_amount'];

	$SQL = "UPDATE tbl_voucher_details set voucher_description='$voucher_description', voucher_amount='$voucher_amount' WHERE voucher_detail_id='$detail_id'";

	mysqli_query($connection, $SQL);

	header('location: voucherdetails.php?id='.$id);

?>