<?php
	include('conn.php');

	$collection_id = $_GET['id'];
	
	$posting_date = $_POST['posting_date'];
	$collection_date = $_POST['collection_date'];
	$collection_by = $_POST['collection_by'];
	$remitted_to = $_POST['remitted_to'];
	$or_id = $_POST['or_id'];

	$SQL = "UPDATE tbl_collection SET collection_date='$collection_date', posting_date='$posting_date', collection_by='$collection_by', remitted_to='$remitted_to', or_id='$or_id'  WHERE collection_id='$collection_id'";

	mysqli_query($connection, $SQL);
	header('location: collection.php');
	
?>