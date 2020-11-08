<?php
	include('conn.php');

	$id = $_GET['id'];

	$voucher_description = $_POST['voucher_description'];
	$voucher_amount = $_POST['voucher_amount'];

	$SQL = "INSERT INTO tbl_voucher_details(voucher_id, voucher_description, voucher_amount) VALUES('$id','$voucher_description','$voucher_amount')";

	mysqli_query($connection, $SQL);

	header('location: voucherdetails.php?id='.$id);

?>