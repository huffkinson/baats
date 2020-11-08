<?php
	include('conn.php');

	$company_name = $_POST['company_name'];
	$company_address = $_POST['company_address'];
	$company_contactno = $_POST['company_contactno'];
	$archived = "no";

	$sql = "insert into payroll_company (company_name,company_address,company_contactno,archived) values('$company_name','$company_address','$company_contactno','$archived')";

	if(mysqli_query($connection, $sql)){
		?>
		<script>
			alert("New company added successfully.");
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