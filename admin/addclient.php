<?php
	include('conn.php');

	$client_id = $_POST['client_id'];
	$client_name = $_POST['client_name'];
	$client_vat_type = $_POST['client_vat_type'];
	$client_rdo = $_POST['client_rdo'];
	$client_tin = $_POST['client_tin'];
	$client_trade_name = $_POST['client_trade_name'];
	$client_line_of_business = $_POST['client_line_of_business'];
	$client_address = $_POST['client_address'];
	$client_email = $_POST['client_email'];

	$SQL = "INSERT INTO tbl_client(client_id,client_name,client_vat_type,client_rdo,client_tin,client_trade_name,client_line_of_business,client_address,client_email) VALUES('$client_id','$client_name','$client_vat_type','$client_rdo','$client_tin','$client_trade_name','$client_line_of_business','$client_address','$client_email')";

	mysqli_query($connection, $SQL);
	
	header('location: clients.php');
?>