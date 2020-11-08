<?php
	include('conn.php');

	$id = $_GET['id'];
	$voucher_amt = $_GET['amount'];
	$voucher_remarks1 = $_POST['voucher_remarks1'];
	$voucher_remarks2 = $_POST['voucher_remarks2'];
	$voucher_note = $_POST['voucher_note'];

	$SQL = "UPDATE tbl_voucher SET voucher_amt='$voucher_amt', voucher_remarks1='$voucher_remarks1', voucher_remarks2='$voucher_remarks2', voucher_note='$voucher_note' WHERE voucher_id='$id'";

	mysqli_query($connection, $SQL);

	header('location: voucher.php');

?>