<?php
	include('conn.php');
	$chargename = $_POST['chargename'];
	$chargedescription = $_POST['chargedescription'];

	//$con = mysqli_connect('localhost','id12256582_bote','bote2020','id12256582_bote') or die();
	//$con = new mysqli('localhost','root','','samplecrud');

	mysqli_query($connection, "INSERT INTO charges (chargename, chargedescription) VALUES ('$chargename','$chargedescription')");

	header('location: charges.php');

?>