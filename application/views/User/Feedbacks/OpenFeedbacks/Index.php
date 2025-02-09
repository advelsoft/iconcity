<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Open Feedbacks/Requests</h4>
				</div>
				<div class="panel-body">
					<div>
						<a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Create";?>">
							<div class="btn btn-new btn-sm btn-light-blue" style="text-align:center">New Feedbacks/Requests</div>
						</a>
					</div>
					</br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Status</th>
									<th data-hide="phone,tablet">Incident Type</th>
									<th data-hide="phone,tablet">Subject</th>
									<th data-hide="phone,tablet">Date</th>
									<th data-hide="phone,tablet">Time</th>
									<th data-hide="phone,tablet">Last Activity</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php if (count($feedbacksList) > 0): ?>
									<?php foreach($feedbacksList as $item) { ?>
									<tr>
										<td><?php echo $item['status']; ?></td>
										<td><?php echo $item['incidentType']; ?></td>
										<td><?php echo $item['subject']; ?></td>
										<td><?php echo date("d-m-Y", strtotime($item['createdDate'])); ?></td>
										<td><?php echo date("h:i A", strtotime($item['createdDate'])); ?></td>
										<td><?php echo date("d-m-Y h:i A", strtotime($item['maxDate'])); ?>
										</td>
										<td>   
											<a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Detail/".$item['feedbackID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">View</div>
											</a>
										</td>	
									</tr>
									<?php } ?>
								<?php endif;?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="7">
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