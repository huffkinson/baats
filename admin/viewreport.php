
<div class="modal fade" id="viewreport<?php echo $row['soa_id'];?>" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">SOA Details - SOA # <?php echo $row['soa_id'];?></h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col">
							<table>
								<tr>
									<td>Description</td>
									<td>Amount</td>
									<td>Status</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>