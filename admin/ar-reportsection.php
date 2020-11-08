<?php
	$client = $_POST['client'];
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
?>

<div class="container">
	<div class="row justify-content-center">
		<div class="my-frames">
			<a target="_blank" class="btn btn-md btn-outline-success" href="ar-printreport.php?client=<?php echo $client;?>&date1=<?php echo $date1;?>&date2=<?php echo $date2;?>">Print Report</a>
		</div>
	</div>
</div>
<div class="container my-frames"></div>
<?php
	$SQL = "SELECT * FROM tbl_soa INNER JOIN tbl_client on tbl_soa.client_id=tbl_client.client_id where tbl_soa.soa_status='approved' AND tbl_soa.soa_balance>0";
	if($client==""){
		
	} else {
		$SQL .= " and tbl_client.client_id like '%".$client."%' or tbl_client.client_name like '%".$client."%'";
	}
	if($date1=="" && $date2==""){

	} else {
		
		if($date1!="" && $date2==""){
			$SQL .= " and tbl_soa.soa_date='$date1'";
		}
		if($date1!="" && $date2!=""){
			$SQL .= " and tbl_soa.soa_date between '$date1' and '$date2'";
		}
	}
	$SQL .= " order by tbl_client.client_id, tbl_soa.soa_date asc";
	$temp_subtotal = 0;
	$temp_balance = 0;
	$grand_total = 0;
	$grand_balance = 0;
	$islastrecord = false;
	$result = mysqli_query($connection, $SQL);
	
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		?>
		<table width="100%" border="1">
			<thead>
				<tr>
					<th class="text-center"><b>Client Name</b></th>
					<th class="text-center"><b>SOA #</b></th>
					<th class="text-center"><b>SOA Date</b></th>
					<th class="text-center"><b>Amount</b></th>
					<th class="text-center"><b>Balance</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><b><?php echo $row['client_id'].'-'.$row['client_name'];?></b></td>
					<td align="center"><?php echo $row['soa_id'];?></td>
					<td align="center"><?php echo $row['soa_date'];?></td>
					<td align="right"><?php echo myformat($row['soa_total_amount']);?></td>
					<td align="right"><?php echo myformat($row['soa_balance']);?></td>
				</tr>
			<?php
			$tempID = $row['client_id'];
			$temp_subtotal += $row['soa_total_amount'];
			$temp_balance += $row['soa_balance'];
			
			$islastrecord = true;
			while($row=mysqli_fetch_assoc($result)){
			if ($row['client_id']==$tempID) {
			$islastrecord=false;
			?>
				<tr>
					<td></td>
					<td align="center"><?php echo $row['soa_id'];?></td>
					<td align="center"><?php echo $row['soa_date'];?></td>
					<td align="right"><?php echo myformat($row['soa_total_amount']);?></td>
					<td align="right"><?php echo myformat($row['soa_balance']);?></td>
				</tr>
			<?php
			$temp_subtotal += $row['soa_total_amount'];
			$temp_balance += $row['soa_balance'];
			$islastrecord = true;
			} else {
			?>
				<!-- <tr>
					<td></td>
					<td align="center"></td>
					<td align="right" style="font-size: 14px; font-weight: bold;">Sub-total:</td>
					<td align="right" style="font-size: 14px; font-weight: bold;"><?php echo myformat($temp_subtotal);?></td>
					<td align="right" style="font-size: 14px; font-weight: bold;"><?php echo myformat($temp_balance);?></td>
				</tr> -->
			<?php
			$tempID = $row['client_id'];
			$grand_total += $temp_subtotal;
			$grand_balance += $temp_balance;
			$temp_subtotal = 0;
			$temp_balance = 0;
			$islastrecord = false;
			?>
				<tr>
					<td><b><?php echo $row['client_id'].'-'.$row['client_name'];?></b></td>
					<td align="center"><?php echo $row['soa_id'];?></td>
					<td align="center"><?php echo $row['soa_date'];?></td>
					<td align="right"><?php echo myformat($row['soa_total_amount']);?></td>
					<td align="right"><?php echo myformat($row['soa_balance']);?></td>
				</tr>
			<?php
			$temp_subtotal += $row['soa_total_amount'];
			$temp_balance += $row['soa_balance'];
			$islastrecord = true;
			}
			
			}
			if($islastrecord==true){
			?>
				<!-- <tr>
					<td></td>
					<td align="center"></td>
					<td align="right" style="font-size: 14px; font-weight: bold;">Sub-total:</td>
					<td align="right" style="font-size: 14px; font-weight: bold;"><?php echo myformat($temp_subtotal);?></td>
					<td align="right" style="font-size: 14px; font-weight: bold;"><?php echo myformat($temp_balance);?></td>
				</tr> -->
			<?php
			$grand_total += $temp_subtotal;
			$grand_balance += $temp_balance;
			}
			?>
				<tr>
					<td></td>
					<td align="center"></td>
					<td align="right" style="font-size: 14px; font-weight: bold;">Grand Total:</td>
					<td align="right" style="font-size: 14px; font-weight: bold;"><?php echo myformat($grand_total);?></td>
					<td align="right" style="font-size: 14px; font-weight: bold;"><?php echo myformat($grand_balance);?></td>
				</tr>
			</tbody>
		</table>
		<?php
		
	}
?>

							
<div class="container">
	<div class="row justify-content-center">
		<div class="my-frames">
			<a target="_blank" class="btn btn-md btn-outline-success" href="ar-printreport.php?client=<?php echo $client;?>&date1=<?php echo $date1;?>&date2=<?php echo $date2;?>">Print Report</a>
		</div>
	</div>
</div>