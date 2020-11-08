<?php
	include('conn.php');

	$SQL = "DELETE FROM temp_pay";
	mysqli_query($connection, $SQL);

	$SQL = "DELETE FROM temp_pay_details";
	mysqli_query($connection, $SQL);

	header('location: index.php');

?>