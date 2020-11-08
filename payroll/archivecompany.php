<?php
	include('conn.php');

	$company_id = $_GET['id'];
	

	$sql = "UPDATE payroll_company SET archived='yes' WHERE company_id='$company_id'";

	if(mysqli_query($connection, $sql)){
		?>
		<script>
			alert("Company archived successfully.");
			location="company.php";
		</script>
		<?php
	} else {
		?>
		<script>
			alert(mysqli_error($connection));
			location="company.php";
		</script>
		<?php
	}
?>