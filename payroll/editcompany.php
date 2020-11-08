<?php
	include('conn.php');

	$company_id = $_GET['id'];
	$company_name = $_POST['company_name'];
	$company_address = $_POST['company_address'];
	$company_contactno = $_POST['company_contactno'];

	$sql = "UPDATE payroll_company SET company_name='$company_name', company_address='$company_address', company_contactno='$company_contactno' WHERE company_id='$company_id'";

	if(mysqli_query($connection, $sql)){
		?>
		<script>
			alert("Company edited successfully.");
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