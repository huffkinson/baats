<?php
	session_start();
	include('conn.php');
	$date_today = date_create(date("y-m-d"));

	$collection_date = $_POST['collection_date'];
	$posting_date = $_POST['posting_date'];
	$client_id = $_POST['client_id'];
	$collected_by = $_POST['collected_by'];
	$remitted_to = $_POST['remitted_to'];
	$collection_amount = 0;

	$SQL = "INSERT INTO tbl_collection(collection_date,posting_date,client_id,collected_by,remitted_to,collection_amount) VALUES('$collection_date','$posting_date','$client_id','$collected_by','$remitted_to','$collection_amount')";

	mysqli_query($connection, $SQL);

	$row = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * from tbl_collection order by collection_id desc limit 1"));

	$id = $row['collection_id'];


	$_SESSION['id'] = $id;

	$format = date_format($date_today,"y-m").sprintf("%04d",$id); 

	mysqli_query($connection,"UPDATE tbl_collection set or_no='$format' where collection_id='$id'");

	header('location: collectiondetails.php');
?>
	
	
	

	
	
	