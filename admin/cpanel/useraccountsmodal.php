

<!-- View User Account Modal Dialog starts here -->
<div class="modal fade" id="View<?php echo $row['id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">View Account Details</h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form" method="" action="">
					<div class="form-group">
						<label class="control-label">Username</label>
						<input type="text" name="user" class="form-control" disabled="" value="<?php echo $row['user']; ?>">
					</div>
					<div class="form-group">
						<label class="control-label">Full Name</label>
						<input type="text" name="fullname" class="form-control" disabled="" value="<?php echo $row['fullname']; ?>">
					</div>
					<div class="form-group">
						<label class="control-label">Password</label>
						<input type="text" name="password" class="form-control" disabled="" value="<?php echo $row['password']; ?>">
					</div>
					<div class="form-group">
						<label class="control-label">User Level</label>
						<input type="text" name="level" class="form-control" disabled="" value="<?php echo $row['level']; ?>">
					</div>
			</div>
			<div class="modal-footer">
					<button type="button" class="btn btn-md btn-outline-danger" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- View User Account Modal Dialog ends here -->

<div class="modal fade" id="Edit<?php echo $row['id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Account Details</h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form" method="POST" action="useraccountsaction.php?op=edit&id=<?php echo $row['id'];?>">
					<div class="form-group">
						<label class="control-label">Username</label>
						<input type="text" name="user" class="form-control" value="<?php echo $row['user']; ?>">
					</div>
					<div class="form-group">
						<label class="control-label">Full Name</label>
						<input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname']; ?>">
					</div>
					<div class="form-group">
						<label class="control-label">Password</label>
						<input type="password" name="password" class="form-control" value="<?php echo $row['password']; ?>">
					</div>
					<div class="form-group">
							<label class="control-label">Select User Level</label>
							<select class="form-control" name="level">
								<option value="admin">Admin</option>
								<option value="user">User</option>
							</select>
						</div>
			</div>
			<div class="modal-footer">
					<input type="submit" name="submit" class="btn btn-md btn-outline-primary" value="Save">
					<button type="button" class="btn btn-md btn-outline-danger" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Edit User Account Modal Dialog ends here -->