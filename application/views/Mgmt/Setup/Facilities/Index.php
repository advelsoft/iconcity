<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Booking Type</h4>
				</div>
				<div class="panel-body">
					<div>
						<a href="<?php echo base_url()."index.php/Common/BookingType/Create";?>">
							<div class="btn btn-new btn-sm btn-light-blue" style="text-align:center">Create New</div>
						</a>
					</div>
					</br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Description</th>
									<th data-hide="phone,tablet">Group ID</th>
									<th data-hide="phone,tablet">Status</th>
									<th data-hide="phone,tablet">Max Book Hour</th>
									<th data-hide="phone,tablet">Created By</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet">Modified By</th>
									<th data-hide="phone,tablet">Modified Date</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($bookingTypeList as $item) { ?>
								<tr>
									<td><?php echo $item['description']; ?></td>
									<td><?php echo $item['groupCode']; ?></td>
									<td><?php echo $item['status']; ?></td>
									<td><?php echo $item['maxBookHour']; ?></td>
									<td><?php echo $item['createdBy']; ?></td>
									<td><?php echo date("d-m-Y", strtotime($item['createdDate'])) ?></td>
									<td><?php echo $item['modifiedBy']; ?></td>
									<td><?php if ($item['modifiedDate'] != '') { echo date("d-m-Y", strtotime($item['modifiedDate'])); } ?></td>
									<td>
										<a href="<?php echo base_url()."index.php/Common/BookingType/Detail/".$item['bookingTypeID']; ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">View</div>
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="9">
										<div><?php echo $this->pagination->create_links();?></div>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>