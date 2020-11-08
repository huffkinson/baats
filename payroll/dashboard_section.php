<?php

	$output = '';
	
	if (!isset($_SESSION['user']))
	{
		$output .= 'You are not a logged user.';
		if (!isset($_SESSION['level']))
		{
			$output .= '<br>Your access level is not allowed.<br>';
			$output .= '<a href="#" class="btn btn-sm btn-primary">Login here</a>';
		}
	}
	else
	{
		$output .= 'Welcome, '.$_SESSION['user'];
	}
	

?>
<div class="container">
	<div class="row justify-content-center text-center">
		<h3><?php echo $output; ?></h1>
	</div>
</div>