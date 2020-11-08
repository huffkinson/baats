<?php
	
	function get_all_charges(){
		include('conn.php');

		$sql = "SELECT * From charges order by chargename asc";
		$query = mysqli_query($connection, $sql);

		$output = '';

		while($row=mysqli_fetch_assoc($query)){
			$output .= '<option value="'.$row['chargename'].'">'.$row['chargename'].'</option>';
		}

		$output .= '<option value="All">All</option>';
		return $output;

	}

	function get_clientemail($id){
		include('conn.php');
		$sql = "select client_email from tbl_client where client_id='$id'";
		$query = mysqli_query($connection, $sql);
		$rows = mysqli_num_rows($query);
		$email = '';
		if($rows==1)
		{
			$row = mysqli_fetch_assoc($query);
			$email = $row['client_email'];
		}
		else
		{
			$email = $email;
		}

		return $email;
	}

	function getClientName($id){
		include('conn.php');
		$name = '';
		$sql = "select * from tbl_client where client_id='$id'";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_assoc($result);
		$name = $row['client_name'];
		
		return $name;
	}

	function getSOAforClient($collectionid){
		include('conn.php');
		$client_id = '';
		$SQL = "SELECT * from tbl_collection where collection_id=$collectionid";
		$query = mysqli_query($connection, $SQL);
		$row = mysqli_fetch_assoc($query);
		$client_id = $row['client_id'];
		return $client_id;
	}

	function updateCollection($collectionid, $collectionamount, $remarks){
		include('conn.php');
		mysqli_query($connection, "UPDATE tbl_collection set collection_amount='$collectionamount', remarks='$remarks' where collection_id='$collectionid'");
	}

?>