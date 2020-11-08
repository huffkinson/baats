<?php
	include('conn.php');

	$soa_id = $_GET['id'];

	$SQL = "DELETE FROM tbl_soa where soa_id='$soa_id'";
	if(!mysqli_query($connection, $SQL)){
		echo mysqli_error($connection);
	}

	$SQL = "DELETE FROM tbl_soa_details where soa_id='$soa_id'";
	if(!mysqli_query($connection, $SQL)){
		echo mysqli_error($connection);
	}
	
	header('location: soapending.php')
?>