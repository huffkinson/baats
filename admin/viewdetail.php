<?php
	$id = $_GET['id'];

	include('conn.php');

	$sql = "select * from tbl_soa_details where soa_id='$id'";
	$total_amount = 0;

	$query = mysqli_query($connection, $sql);

	$output = '<table border="1">';
	$output .= '<tr>';
	$output .= '<td>Description</td>';
	$output .= '<td>Amount</td>';
	$output .= '</tr>';
	

	while($row=mysqli_fetch_assoc($query)){
		$output .= '<tr>';
		$output .= '<td>'.$row['soa_description'].'</td>';
		$output .= '<td align="right">'.number_format($row['soa_description_amount'],'2','.',',').'</td>';
		$output .= '</tr>';
		$total_amount += $row['soa_description_amount'];
	}

	$output .= '<tr>';
	$output .= '<td>Total Amount:</td>';
	$output .= '<td align="right">'.number_format($total_amount,'2','.',',').'</td>';
	$output .= '</tr>';
	$output .= '</table>';

	echo $output;


?>
<a href="#" onclick="closewindow()">close window</a>
<script>
	function closewindow(){
		window.top.close();
	}
</script>