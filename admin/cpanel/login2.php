<?php
	session_start();
	include('cpanelconn.php');
	$user = $_POST['user'];
	$password = $_POST['password'];

	$op = $_GET['op'];

	if ($op=="in") {
		$SQL = "SELECT * FROM login WHERE user = '$user' and password = '$password'";
		$result = mysqli_query($connection, $SQL);
		$row = mysqli_num_rows($result);

		if ($row==1) {
			$row = mysqli_fetch_array($result);
			$_SESSION['user'] = $row['user'];
			$_SESSION['fullname'] = $row['fullname'];
			$_SESSION['level'] = $row['level'];
			 
			if ($row['level']=="admin") {
				header("Location:cpanel.php");
			} else{
				?>
					<script language="JavaScript" type="text/javascript">
						alert('Username and Password not allowed');
						document.location='../../index.php';
					</script>
				<?php
			}
		} else {
			?>

			<script language="JavaScript" type="text/javascript">
				alert('Username and Password not register or is invalid');
				document.location='../../index.php';
			</script>

			<?php
		} 
	} elseif ($op=="out") {
		unset($_SESSION['user']);
		unset($_SESSION['level']);
		header("location:index.php");
	}
?>