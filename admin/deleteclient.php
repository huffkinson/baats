<?php
	include('conn.php');

	$client_id = $_GET['id'];

	$SQL = "DELETE FROM tbl_client where client_id='$client_id'";

	mysqli_query($connection, $SQL);

	header('location: clients.php');
?>