<?php
	include('conn.php');
	$collection_id = $_GET['id'];
	$soa_id = $_GET['soaid'];
	$collection_details_id = $_GET['cdi'];

	$description = $_POST['description'];
	$amount = $_POST['amount'];

	$SQL = "UPDATE tbl_collection_details set description='$description', amount='$amount' WHERE collection_details_id='$collection_details_id'";

	mysqli_query($connection, $SQL);

	header('location: collectiondetails.php?id='.$collection_id.'&soaid='.$soa_id.'');
?>