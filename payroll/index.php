<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/brands.min.css">
	<link rel="stylesheet" type="text/css" href="../Fontawesome/css/solid.min.css">
	<style>
		.login-frame {
			border: 2px solid grey;
			border-radius: 5px;
			box-shadow: 0px 0px 10px 1px blue;
			background-color: white;
		}
		body {
			background-color: black;
		}
	</style>

</head>
<body>
	<div class="container my-spacer"></div>
	<div class="container my-spacer"></div>
	<div class="container my-spacer"></div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xs-10 col-sm-10 col-md-10 col-lg-4 col-xl-4 login-frame">
				<h3 class="text-center">Payroll Login</h3>
				<form class="form-sm" method="POST" action="">
					<div class="form-group">
						<label class="control-label">Username</label>
						<input class="form-control" type="text" name="username" required>
					</div>
					<div class="form-group">
						<label class="control-label">Password</label>
						<input class="form-control" type="password" name="password" required>
					</div>
					<div class="form-group text-center">
						<input class="btn btn-sm btn-primary" type="submit" name="login" value="Login">
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
		session_start();
		if(isset($_POST['login']))
		{
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			include('conn.php');

			$sql = "select * from payroll_login where username='$username' and password='$password'";
			$result = mysqli_query($connection, $sql);
			$row = mysqli_num_rows($result);

			if($row==1){
				$_SESSION['username'] = $row['username'];
				$_SESSION['fullname'] = $row['fullname'];
				$_SESSION['level'] = $row['level'];
				$_SESSION['logged'] = true;
				header("location: dashboard.php");
			}
			else
			{
				echo '<div class="my-spacer"></div>';
				echo '<h3 class="text-center">Username and/or Password did not match the records!</h3>';
			}
		}
	?>

	<!-- script section starts here -->
	<script src="../jquery/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/datatables.min.js"></script>
</body>
</html>