<?php
	include('conn.php');

	$collection_id = $_GET['id'];
	$collection_amount = $_GET['amount'];

	$SQL = "UPDATE tbl_collection_details set editmode='0' where collection_id='$collection_id' and editmode='1'";
	mysqli_query($connection, $SQL);

	$SQL = "UPDATE tbl_collection SET collection_amount='$collection_amount' WHERE collection_id='$collection_id'";
	mysqli_query($connection, $SQL);

	header('location: collection.php');
?>