<?php
	include('conn.php');

	$collection_id = $_GET['id'];

	$SQL = "DELETE FROM tbl_collection_details WHERE collection_id=$collection_id AND editmode=1";
	mysqli_query($connection, $SQL);

	header('location: collection.php');
?>