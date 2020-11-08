<?php
	include('conn.php');
	$id = $_GET['id'];

	$chargename = $_POST['chargename'];
	$chargedescription = $_POST['chargedescription'];

	//$con = mysqli_connect('localhost','id12256582_bote','bote2020','id12256582_bote') or die();
	//$con = new mysqli('localhost','root','','samplecrud');
	$SQL = "UPDATE charges SET chargename='$chargename', chargedescription='$chargedescription' WHERE chargeid=$id";
	mysqli_query($connection, $SQL);

	header('location: charges.php');
?>