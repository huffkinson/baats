<?php
	include('conn.php');
	$collection_id = $_GET['id'];
	$soa_id = $_GET['soaid'];
	$collection_details_id = $_GET['cdi'];

	$SQL = "DELETE FROM tbl_collection_details WHERE collection_details_id=$collection_details_id";

	mysqli_query($connection, $SQL);

	header('location: collectiondetails.php?id='.$collection_id.'&soaid='.$soa_id.'');
?>