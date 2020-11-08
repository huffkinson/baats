<?php

?>

<!DOCTYPE html>
<html>
<head>
	<title>Test File</title>
</head>
<body>
<form method="post">
	<input type="submit" name="edit" value="edit">
</form>

<form method="post">
	<input type="submit" name="delete" value="delete">
</form>

<form method="POST" action="">
	<input type="text" name="str1">
	<input type="text" name="str2">
	<input type="submit" name="compare">
</form>

<?php

	if(isset($_POST['edit'])){
		echo "edit was pressed";
	}

	if(isset($_POST['delete'])){
		echo "delete was pressed";
	}

	if(isset($_POST['compare'])){
		$first = strtok($_POST['str1'], "-");
		echo $first;
		if()
		echo $last;
	}
?>
</body>
</html>