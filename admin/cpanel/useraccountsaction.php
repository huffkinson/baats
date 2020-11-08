<?php
	include('cpanelconn.php');
	

	if(isset($_POST['submit'])){
		// if user added new account
		if($_GET['op']=='add'){

			$user = $_POST['user'];
			$fullname = $_POST['fullname'];
			$password = $_POST['password'];
			$level = $_POST['level'];
			
			$SQL = "INSERT INTO login(user,fullname,password,level) VALUES('$user','$fullname','$password','$level')";
			if(mysqli_query($connection, $SQL)){
				?>
				<script>
					alert("User account successfully added!");
					document.location="useraccounts.php"
				</script>
				<?php
			} else {
				?>
				<script>
					alert("User account not added!");
					document.location="useraccounts.php"
				</script>
				<?php
			}
		}

		// if user edit an account
		if($_GET['op']=='edit'){

			$id = $_GET['id'];
			$user = $_POST['user'];
			$fullname = $_POST['fullname'];
			$password = $_POST['password'];
			$level = $_POST['level'];

			$SQL = "UPDATE login SET user='$user', fullname='$fullname', password='$password', level='$level' WHERE id='$id'";
			if(mysqli_query($connection, $SQL)){
				?>
				<script>
					alert("User account successfully updated!");
					document.location="useraccounts.php"
				</script>
				<?php
			} else {
				?>
				<script>
					alert("User account not updated!");
					document.location="useraccounts.php"
				</script>
				<?php
			}
		}

	}
?>