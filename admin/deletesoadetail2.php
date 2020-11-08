<?php
	include('conn.php');

	$soa_details_id = $_GET['id'];
	$soa_id = $_GET['soaid'];

	$SQL = "DELETE FROM tbl_soa_details where soa_details_id='$soa_details_id'";

	mysqli_query($connection, $SQL);

	header('location: soadetails2.php?id='.$soa_id);
?>