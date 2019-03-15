<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Open Work Order</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Work Order ID</th>
									<th data-hide="phone,tablet">Feedback ID</th>
									<th data-hide="phone,tablet">Property No</th>
									<th data-hide="phone,tablet">Priority</th>
									<th data-hide="phone,tablet">Status</th>
									<th data-hide="phone,tablet">Category</th>
									<th data-hide="phone,tablet">Incident Type</th>
									<th data-hide="phone,tablet">Subject</th>
									<th data-hide="phone,tablet">Date Incident</th>
									<th data-hide="phone,tablet">Time Incident</th>
									<th data-hide="phone,tablet">Last Activity</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($workOrder as $item) { ?>
								<tr>
									<td><?php echo $item['workOrderID']; ?></td>
									<td><?php echo $item['feedbackID']; ?></td>
									<td><?php echo $item['propertyNo']; ?></td>
									<td><?php echo $item['priority']; ?></td>
									<td><?php echo $item['status']; ?></td>
									<td><?php echo $item['category']; ?></td>
									<td><?php echo $item['incidentType']; ?></td>
									<td><?php echo $item['subject']; ?></td>
									<td><?php echo date("d-m-Y", strtotime($item['dateIncident'])); ?></td>
									<td><?php echo date("h:i A", strtotime($item['dateIncident'])); ?></td>
									<td><?php echo date("d-m-Y h:i A", strtotime($item['maxDate'])); ?>
									<td>
										<a href="<?php echo base_url()."index.php/Common/WorkOrder/OpenWO/".$item['workOrderID']; ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">Assign</div>
										</a>
									</td>	
								</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="12">
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
<?php echo $this->session->flashdata('msg'); ?>