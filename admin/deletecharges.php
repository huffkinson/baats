<?php
	include('conn.php');
	//$con = mysqli_connect('localhost','id12256582_bote','bote2020','id12256582_bote') or die();
	//$con = new mysqli('localhost','root','','samplecrud');

	$id = $_GET['id'];

	mysqli_query($connection, "DELETE FROM charges WHERE chargeid='$id'");

	header('location: charges.php');

?>