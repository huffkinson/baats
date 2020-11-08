<?php
	include('conn.php');
?>

<!-- delete modal -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="DeleteModal<?php echo $row['soa_id'];?>" tab-index="-1" aria-hidden="true">
	<!-- modal dialog starts here -->
	<div class="modal-dialog modal-md">
		<!-- modal content starts here -->
		<div class="modal-content">
			<!-- modal header starts here -->
			<div class="modal-header">
				<h4 class="modal-title">Delete Client</h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- modal header ends here -->
			<!-- modal body starts here -->
			<div class="modal-body">
				<div class="container">
					Are you sure to delete this client?<br>
					<?php echo $row['soa_note1'];?>
				</div>
			</div>
			<!-- modal body ends here -->
			<!-- modal footer starts here -->
			<div class="modal-footer">
				<a href="deletesoa.php?id=<?php echo $row['soa_id'];?>" class="btn btn-danger btn-sm">Delete</a>
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
			</div>
			<!-- modal footer ends here -->
		</div>
		<!-- modal content ends here -->
	</div>
	<!-- modal dialog ends here -->
</div>
<!-- end of delete modal -->