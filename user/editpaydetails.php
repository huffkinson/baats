<?php
	include('conn.php');
	
	$soa_id = $_GET['soaid'];
	$temp_pay = $_GET['id'];

	$payamount = $_POST['payamount'];
	$pay_status="";

	/*echo '<br>soa-id:'.$soa_id;
	echo '<br>temp_pay:'.$temp_pay;
	echo '<br>payamount:'.$payamount;
	echo '<br>pay_status:'.$pay_status;*/

	// check for previous payment history
	if(checkPreviousPayments($soa_id)==false){
		//if compare pay amount to original amount is equal
		if(compareAmounttoOriginal($payamount,$temp_pay)==true){
			//proceed to update temporary pay details with original amount and status fully-paid
			?>
				<script>
					alert("<?php echo $soa_id;?>");
				</script>
			<?php
			$pay_status = "fully-paid";
			$SQL = "UPDATE temp_pay_details set pay_amount='$payamount', pay_status='$pay_status' where temp_pay='$temp_pay'";

			mysqli_query($connection, $SQL);
			//echo 'record updated';
			header('location: collectiondetails.php?id='.$soa_id);
		}
		//if compare pay amount to original amount is not equal
		if (compareAmounttoOriginal($payamount,$temp_pay)==false) {
			if (isAmountGreatertoOriginal($payamount,$temp_pay)==true) {
				?>
				<script>
					alert("Amount paid greater than original amount");
					location="collectiondetails.php?id=<?php echo $soa_id;?>";
				</script>
				<?php
			}
			else {
				
				$pay_status = "partial";
				$SQL = "UPDATE temp_pay_details set pay_amount='$payamount', pay_status='$pay_status' where temp_pay='$temp_pay'";

				mysqli_query($connection, $SQL);
				//echo 'record updated';
				header('location: collectiondetails.php?id='.$soa_id);	
			}
		}

	}
	//if there is a previous payment record
	else {
		//echo 'sample output';
		header('location: collectiondetails.php?id=.$soa_id.');
	}



	function checkPreviousPayments($soaid){
		include('conn.php');
		$SQL = "SELECT * FROM tbl_pay where soa_id=$soaid";
		$query = mysqli_query($connection, $SQL);

		if(mysqli_num_rows($query)>0){
			return true;
		}
		else{
			return false;
		}
	}


	function compareAmounttoOriginal($amount, $soadetailid){
		include('conn.php');
		$SQL = "SELECT soa_description_amount from tbl_soa_details where soa_details_id=$soadetailid";
		$query = mysqli_query($connection, $SQL);
		$row = mysqli_fetch_assoc($query);
		$getOriginalAmt = $row['soa_description_amount'];

		if($getOriginalAmt==$amount){
			return true;
		} else {
			return false;
		}
	}

	function isAmountGreatertoOriginal($amount,$soadetailid){
		include('conn.php');
		$SQL = "SELECT soa_description_amount from tbl_soa_details where soa_details_id=$soadetailid";
		$query = mysqli_query($connection, $SQL);
		$row = mysqli_fetch_assoc($query);
		$getOriginalAmt = $row['soa_description_amount'];

		if($amount > $getOriginalAmt){
			return true;
		} else {
			return false;
		}
	}
?>