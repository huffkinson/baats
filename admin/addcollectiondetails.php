<?php
	include('conn.php');

	$collection_id=$_GET['id'];
	$soa_id=$_GET['soaid'];

	$description = $_POST['description'];
	$amount = $_POST['amount'];

	$SQL = "INSERT INTO tbl_collection_details(collection_id,description,amount,editmode) VALUES('$collection_id','$description','$amount','1')";

	mysqli_query($connection, $SQL);

	header('location: collectiondetails.php?id='.$collection_id.'&soaid='.$soa_id.'');
?>