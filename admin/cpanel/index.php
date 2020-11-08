<!DOCTYPE html>
<html>
<head>
	<title>CPanel Login Page</title>
	<meta charset="utf-8">
    
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/landing-page.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../css/datatables.min.css">
	<script src="../../jquery/jquery.min.js"></script>
	<script src="../../js/popper.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/datatables.min.js"></script>

	<style type="text/css">
		
		body{
			background-color: white;
		}

		.login-form{
			margin-top: 50px;
			box-shadow: 0px 0px 10px 1px grey;
			border-radius: 20px;
			padding-bottom: 20px;
			background: #eef5f5;
		}

		.login-title{
			background: #007bbf;
			padding: 10px;
			text-align: center;
			color: #fff;
			border-radius: 0px 0px 15px 15px;
		}

	</style>

</head>
<body>
	<div class="container">
				<div class="login-form offset-md-4 col-sm-6 col-md-6 col-lg-4">
					
						<h2 class="login-title">CPanel Login</h2>
					
					<form action="login2.php?op=in" method="POST">
						<!-- username field -->
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="user" class="form-control">
						</div>
						<!-- password field -->
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control">
						</div>
						<!-- submit button -->
						<div class="form-group">
							<input type="submit" class="form-control btn btn-primary" value="LOGIN">
						</div>
					</form>
				</div>
	</div>
		
</body>
</html>