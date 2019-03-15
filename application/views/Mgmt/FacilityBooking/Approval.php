<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Waiting Approval Facilities Booking</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Facility</th>
									<th data-hide="phone,tablet">Unit No</th>
									<th data-hide="phone,tablet">Date</th>
									<th data-hide="phone,tablet">Time From</th>
									<th data-hide="phone,tablet">Time To</th>
									<th data-hide="phone,tablet">Status</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($fbRecord as $item) { ?>
								<tr>
									<td><?php echo $item['description']; ?></td>
									<td><?php echo $item['propertyNo']; ?></td>
									<td><?php echo date("d-m-Y", strtotime($item['dateFrom'])) ?></td>              
									<td><?php 
										$timeFrom = new DateTime($item['timeFrom']);
										echo $timeFrom->format('h:i A') 
									?></td>              
									<td><?php
										$timeTo = new DateTime($item['timeTo']);
										echo $timeTo->format('h:i A')
									?></td>              
									<td><?php echo $item['status']; ?></td>
									<td>
										<a href="<?php echo base_url()."index.php/Common/FacilityBooking/Update/".$item['bookingID'].'?Date='.date("Y-m-d", strtotime($item['dateFrom'])); ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">View</div>
										</a>
									</td>
								</tr>
								<?php } ?>
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
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>