<?php

	function myformat($value){
		$result = number_format($value, '2','.',',');
		return $result;
	}

	function get_clientRDO($clientid){
		include('conn.php');
		$sql = "SELECT client_rdo from tbl_client where client_id='$clientid'";
		$row = mysqli_fetch_assoc(mysqli_query($connection,$sql));
		$RDO = $row['client_rdo'];
		return $RDO;
	}

	function get_clientname($clientid){
		include('conn.php');
		$sql = "SELECT client_name from tbl_client where client_id='$clientid'";
		$row = mysqli_fetch_assoc(mysqli_query($connection,$sql));
		$name = $row['client_name'];
		return $name;
	}

	function get_all_charges(){
		include('conn.php');

		$sql = "SELECT * From charges order by chargename asc";
		$query = mysqli_query($connection, $sql);

		$output = '';

		while($row=mysqli_fetch_assoc($query)){
			$output .= '<option value="'.$row['chargename'].'">'.$row['chargename'].'</option>';
		}

		return $output;

	}

	function get_total_ar(){
		include('conn.php');

		$SQL = "select * from tbl_soa where soa_status='approved' order by soa_id asc";

		$result = mysqli_query($connection, $SQL);
		
		$total = 0;
		/**/

		while($row=mysqli_fetch_assoc($result)){
			$total += $row['soa_balance'];
		}

		return myformat($total);
	}

	function get_total_collection(){
		include('conn.php');

		$SQL = "SELECT sum(collection_amount) as Total from tbl_collection";

		$result = mysqli_query($connection, $SQL);

		$row = mysqli_fetch_assoc($result);

		$total = myformat($row['Total']);//, '2','.',',');

		return $total;

	}

	function get_total_voucher(){
		include('conn.php');

		$SQL = "SELECT sum(voucher_amt) as Total from tbl_voucher";

		$result = mysqli_query($connection, $SQL);

		$row = mysqli_fetch_assoc($result);

		$total = myformat($row['Total']);//, '2','.',',');

		return $total;

	}

	function get_soaid_from_collection($collectionid){
		include('conn.php');
		$sql = "select soa_id from tbl_collection_details where collection_id='$collectionid'";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_assoc($result);
		$getsoaid = $row['soa_id'];
		return $getsoaid;
	}

	function get_soadetails_fortable($soaid){
		
	}

?>