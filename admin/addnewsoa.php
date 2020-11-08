<?php
	include('conn.php');
	
	$client_id = $_POST['client_id'];
	$soa_date = $_POST['soa_date'];
	$soa_status = $_POST['soa_status'];
	$tempBAL = 0;

	
	$SQL = "SELECT client_name, client_address FROM tbl_client where client_id='$client_id'";
	$query = mysqli_query($connection, $SQL);
	$result = mysqli_fetch_assoc($query);
	$client_name = $result['client_name'];
	$client_address = $result['client_address'];

	$SQL = "INSERT INTO tbl_soa (client_id,soa_date,soa_total_amount,soa_status,soa_note1,soa_note2,soa_balance,archived) values('$client_id','$soa_date','0','$soa_status','$client_name','$client_address','0','no')";

	if(mysqli_query($connection, $SQL)){
		echo "insert successful \n";
	} else {
		echo "insert error \n";
	}

	// select last record entered
	$SQL = "SELECT * FROM tbl_soa ORDER BY soa_id DESC LIMIT 1";
	$result = mysqli_query($connection, $SQL);
	$row = mysqli_fetch_assoc($result);
	$client_id = $row['client_id'];
	$newsoa_id = $row['soa_id'];

	// select all records where client id is equal to last record client id
	$SQL = "SELECT * FROM tbl_soa WHERE client_id='$client_id' AND soa_balance > 0 ORDER BY soa_id DESC LIMIT 1";
	$result = mysqli_query($connection, $SQL);
	
	if(mysqli_num_rows($result) > 0){
		//add to soa details of previous balances to new soa
		$row=mysqli_fetch_assoc($result);
		$previous_soa_id = $row['soa_id'];
		$previous_balance = $row['soa_balance'];
		$tempBAL += $previous_balance;
		$tempSQL = "INSERT INTO tbl_soa_details(soa_id,soa_description,soa_description_amount)";
		$tempSQL .= " VALUES('$newsoa_id','Previous Balance from SOA#: $previous_soa_id','$previous_balance')";
		mysqli_query($connection, $tempSQL);
		
		// update soa table
		mysqli_query($connection, "UPDATE tbl_soa SET soa_total_amount='$tempBAL', soa_balance='$tempBAL' where soa_id='$newsoa_id'");
	}
	
	header('location: soapending.php');
?>