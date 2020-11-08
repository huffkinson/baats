<?php
	include('conn.php');

	$from = $_POST['from'];
	$to = $_POST['to'];
	$date = $_POST['vdate'];

	if(isset($_POST['proceed'])){
		$SQL = "INSERT INTO tbl_voucher(voucher_to,voucher_from,voucher_date) VALUES ('$to', '$from', '$date')";
		mysqli_query($connection, $SQL);
	
		$SQL = "Select voucher_id from tbl_voucher order by voucher_id desc limit 1";

		$query = mysqli_query($connection,$SQL);
		$row = mysqli_fetch_assoc($query);
		$id = $row['voucher_id'];

		header('location: voucherdetails.php?id='.$id);
	}

	if(isset($_POST['cancel'])){
		header('location: voucher.php');
	}

	

?>
