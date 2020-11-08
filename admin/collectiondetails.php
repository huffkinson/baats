<?php
	session_start();
	$date_today = date_create(date("y-m-d"));
	$payment=0;
	$soa_id='';

	include('conn.php');
	include('functions.php');

	$collection_id = $_SESSION['id'];
	$client_id = getSOAforClient($collection_id);

	$sql = "select * from tbl_collection where collection_id=$collection_id";
	$result = mysqli_query($connection, $sql);
	$row = mysqli_fetch_assoc($result);

	$or_no = $row['or_no'];
	$collection_date = $row['collection_date'];
	$posting_date = $row['posting_date'];
	$collected_by = $row['collected_by'];
	$remitted_to = $row['remitted_to'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Collection Details</title>
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/brands.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/solid.min.css">

	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>
	<style>
		.my-frames{
			margin-top: 10px; 
			border-radius: 5px;
			box-shadow: 0px 0px 5px 1px grey;
			padding: 15px;
		}
		.amount {
			font-size: 20px;
			font-weight: bold;
		}
	</style>

</head>
<body>
	<!-- collection title starts here -->
	<div class="container my-frames">
		<div class="row justify-content-center">
			<h2>Collection Report</h2>
		</div>
	</div>
	<!-- collection title ends here -->

	<!-- collection header starts here -->
	<div class="container my-frames">
		<div class="row">
			<!-- header section 2 -->
			<div class="col-xs-12 col-sm-12 col-md-3">
				<div class="col">
					<label class="control-label">Reference #:</label>
					<input class="form-control" type="text" name="client_name" disabled value="<?php echo $collection_id;?>">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3">
				<div class="col">
					<label class="control-label">OR #:</label>
					<input class="form-control" type="text" name="client_name" disabled value="<?php echo $or_no;?>">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3">
				<div class="col">
					<label class="control-label">Collection Date:</label>
					<input class="form-control" type="text" name="client_name" disabled value="<?php echo $collection_date;?>">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3">
				<div class="col">
					<label class="control-label">Posting Date:</label>
					<input class="form-control" type="text" name="client_name" disabled value="<?php echo $posting_date;?>">
				</div>
			</div>
		</div>
	</div>
	<!-- collection header ends here -->

	<!-- client information starts here -->
	<div class="container my-frames">
		<div class="row">
			<!-- header section 2 -->
			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="col">
					<label class="control-label">Client</label>
					<input class="form-control" type="text" name="client_name" value="<?php echo $client_id.':'.getClientName($client_id);?>">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="col">
					<form method="POST" action="">
					<label class="control-label">Enter amount collected</label>
					<input class="form-control" type="text" name="payment">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="row">
					<div class="col" style="width: 50%;">
						<div class="my-spacer"></div>
						<div class="my-spacer"></div>
						<div class="my-spacer"></div>
						<input class="btn btn-sm btn-primary" type="submit" name="go" value="GO" style="width: 30%;">
						<input class="btn btn-sm btn-danger" type="submit" name="cancel" value="Cancel" style="width: 40%;">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- client information ends here -->

	<!-- details section starts here -->
	<?php 

		

		if(isset($_POST['accept']))
		{
			$change = 0;
			$remarks = $_POST['remarks'];
			$amount = $_SESSION['payment'];
			$soa_array=$_POST['checkbox'];

			if(strtoupper($remarks)=='ALL')
			{
				$array_charges = array();
				$array_amount = array();
				$first_record=true;
				foreach ($soa_array as $soa_id) {
					//get all charges for this soa
					$sql = "SELECT * from tbl_soa_details where soa_id='$soa_id' order by soa_description_amount desc";
					$query = mysqli_query($connection, $sql);
					while($row=mysqli_fetch_assoc($query)){
						$array_charges[]=$row['soa_description'];
						$array_amount[]=$row['soa_description_amount'];
					}
					
					//check and unset array if payment is already made
					foreach($array_charges as $k => $val)
					{ 
					    $sql = "SELECT * FROM tbl_collection where client_id='$client_id' and remarks='$val'";
					    $query = mysqli_query($connection, $sql);
					    $row_count = mysqli_num_rows($query);

					    if($row_count>0)
					    {
							unset($array_charges[$k]);
							unset($array_amount[$k]);
					    }
					    
					} 
					//reindex the arrays
					$array_charges = array_values($array_charges);
					$array_amount = array_values($array_amount);
					
					// print_r($array_charges);
					// print_r($array_amount);
					// echo count($array_charges);
					if($first_record==true)
					{
						$sql = "update tbl_collection set collection_amount='$array_amount[0]', remarks='$array_charges[0]' where collection_id='$collection_id'";
						$first_record=false;
						mysqli_query($connection, $sql);
						//add remaining charges to the collection
						for($icount=1;$icount<count($array_charges);$icount++){
							$sql = "INSERT INTO tbl_collection(or_no,collection_date,posting_date,client_id,collected_by,remitted_to,collection_amount,remarks) VALUES('$or_no','$collection_date','$posting_date','$client_id','$collected_by','$remitted_to','$array_amount[$icount]','$array_charges[$icount]')";

							mysqli_query($connection,$sql);
						}
					}
					else
					{
						for($icount=0;$icount<count($array_charges);$icount++){
							$sql = "INSERT INTO tbl_collection(or_no,collection_date,posting_date,client_id,collected_by,remitted_to,collection_amount,remarks) VALUES('$or_no','$collection_date','$posting_date','$client_id','$collected_by','$remitted_to','$array_amount[$icount]','$array_charges[$icount]')";

							mysqli_query($connection,$sql);
						}
					}
					//update soa balance
					$sql = "update tbl_soa set soa_balance=0 where soa_id='$soa_id'";
					mysqli_query($connection, $sql);
				}

				//display accepted payment message
				?>
				<div class="container my-frames">
					<div class="row justify-content-center">
						<h2>All was selected. Payment accepted.</h2>
					</div>
				</div>
				<script>location="collection.php";</script>
				<?php

			}
			else
			{
				do{
					foreach ($soa_array as $soa_id) {
						$_SESSION['soaid'] = $soa_id;
						$sql = "select soa_balance from tbl_soa where soa_id='$soa_id'";
						$query = mysqli_query($connection, $sql);
						// echo mysqli_error($connection);

						$row = mysqli_fetch_assoc($query);
						$soa_balance = $row['soa_balance'];

						if($amount > $soa_balance && $soa_balance > 0){
							$change = $amount - $soa_balance;
							$deduct = $amount - $soa_balance - $change;
							mysqli_query($connection, "update tbl_soa set soa_balance='$deduct' where soa_id='$soa_id'");
							// echo 'error1:'.mysqli_error($connection);
							$sql = "insert into tbl_collection_details (collection_id,description,amount,soa_id,remarks) values('$collection_id','Payment for balance in Soa# $soa_id','$soa_balance','$soa_id','$remarks')";
							mysqli_query($connection, $sql);
							// echo 'error1:'.mysqli_error($connection);
						}

						if($amount < $soa_balance && $soa_balance > 0){
							$deduct = $soa_balance - $amount;
							mysqli_query($connection, "update tbl_soa set soa_balance='$deduct' where soa_id='$soa_id'");
							// echo 'error2:'.mysqli_error($connection);
							$sql = "insert into tbl_collection_details (collection_id,description,amount,soa_id,remarks) values('$collection_id','Payment for balance in Soa# $soa_id','$amount','$soa_id','$remarks')";
							mysqli_query($connection, $sql);
							// echo 'error2:'.mysqli_error($connection);
							$change = 0;
						}

						if($amount == $soa_balance && $soa_balance > 0){
							$deduct = 0;
							mysqli_query($connection, "update tbl_soa set soa_balance='$deduct' where soa_id='$soa_id'");
							// echo 'error3:'.mysqli_error($connection);
							$sql = "insert into tbl_collection_details (collection_id,description,amount,soa_id,remarks) values('$collection_id','Payment for balance in Soa# $soa_id','$amount','$soa_id','$remarks')";
							mysqli_query($connection, $sql);
							// echo 'error3:'.mysqli_error($connection);
							$change = 0;
						}
					}

				} while($change>0);
				?>
				<div class="container my-frames">
					<div class="row justify-content-center">
						<h2>Payment accepted.</h2>
					</div>
				</div>
				<?php
				$sql = "SELECT * from tbl_soa_details where soa_id=".$_SESSION['soaid']." and soa_description like '%".$remarks."%'";

				$query = mysqli_query($connection, $sql);
				$row = mysqli_fetch_assoc($query);
				$remarks = $row['soa_description'];

				updateCollection($collection_id, $_SESSION['payment'], $remarks);
				
				?><script>location="collection.php";</script><?php
			}
			
			if(get_clientemail($client_id)!="")
			{
				$message = 'This is to acknowledge your payment to BOTE ACCOUNTING and TAXATION SERVICES amounting to '.number_format($amount,'2','.',',');
				$from = "Bote Accounting and Taxation Services";
				$to = get_clientemail($client_id);
				$headers = "From:Bote Accounting and Taxation Services \r\n"."Reply-To:baats2010@gmail.com \r\n";
			
				$subject = 'New message from Bote Accounting and Taxation Services:';
				$body = 'Message:'.$message;

				if(mail($to, $subject, $body, $headers)){
				    ?>
				        alert("Message sent");
				    <?php
				} else {
				    ?>
				        alert("Message not sent");
				    <?php
				}
			}
			
		}

		if(isset($_POST['cancel'])){

			mysqli_query($connection, "DELETE FROM tbl_collection where collection_id=$collection_id");
			?>
			<script>
				alert("Payment was cancelled.");
				location="collection.php";
			</script>
			<?php
		}

		if(isset($_POST['go'])){

			$_SESSION['payment'] = $_POST['payment'];

			if($_POST['payment']<=0){
				?>
				<div class="container my-frames">
					<div class="my-spacer"></div>
					<div class="row justify-content-center">
						<h2>No Amount entered.</h2>
					</div>
					<div class="my-spacer"></div>
					<div class="row justify-content-center">
						<h4>Enter amount then press GO</h4>
					</div>
				</div>
				<?php
			} else {
			
				//show all soa for this client
				$sql = "select * from tbl_soa where client_id='$client_id' and soa_balance > 0 and soa_status='approved'";
				$result = mysqli_query($connection, $sql);
				?>
				<div class="container my-frames">
					<div class="row justify-content-center">
						<div class="col-xs-12 col-sm-12 col-md-6">
							<h3>Payment Received: <?php echo number_format($_SESSION['payment'],'2','.',',');?></h3>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6">
						<form method="POST" action="">
						<table class="table table-bordered table-lg">
							<thead>
								<tr>
									<td colspan="3">Select SOA to apply payments to</td>
								</tr>
							</thead>
							<tr>
								<td></td>
								<td class="text-center">SOA #</td>
								<td class="text-center">Balance</td>
								<td class="text-center">View</td>
							</tr>
						
						<?php
						while($row=mysqli_fetch_assoc($result)){
						?>
							<tr>
								<td><input type="checkbox" name="checkbox[]" value="<?php echo $row['soa_id'];?>" checked></td>
								<td class="text-center"><?php echo $row['soa_id'];?></td>
								<td class="text-right"><?php echo number_format($row['soa_balance'],'2','.',',');?></td>
								<td class="text-center"><a target="_blank" href="viewdetail.php?id=<?php echo $row['soa_id']; ?>" style="height: 25px; text-decoration: none;">View</a>
							</tr>
						<?php
						}
						?>
						</table>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="col">
							<label class="control-label">Payment for:</label>
							</div>
							<!-- <div class="col">
							<textarea class="form-control" type="textarea" row="2" name="remarks"></textarea>
							</div> -->
							<div class="col">
							<input class="form-control-sm" list="chargelist" name="remarks" placeholder="Choose charges">
							<datalist id="chargelist">
								<?php echo get_all_charges();?>						
							</datalist></div>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-xs-12 col-sm-12 col-md-2">
						<input class="btn btn-sm btn-primary form-control" type="submit" name="accept" value="Accept Payment"></div>
						<div class="col-xs-12 col-sm-12 col-md-2">
						<input class="btn btn-sm btn-danger form-control" type="submit" name="cancel" value="Cancel Payment"></div>
						</form>
					</div>
				</div>
				<?php
			
			}
		}

	?>
	<!-- details section ends here -->

</body>
</html>