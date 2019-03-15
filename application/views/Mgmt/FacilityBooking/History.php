<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Previous Facilities Booking</h4>
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
								</tr>
							</thead>
							<tbody>
								<?php foreach($facilityBookingHistory as $item) { ?>
								<tr>
									<td><?php echo $item['description']; ?></td>
									<td><?php echo $item['propertyNo']; ?></td>
									<td><?php echo date("d-m-Y", strtotime($item['dateFrom'])); ?></td>              
									<td><?php 
										$timeFrom = new DateTime( $item['timeFrom'] );
										echo $timeFrom->format('h:i A') 
									?></td>              
									<td><?php
										$timeTo = new DateTime( $item['timeTo'] );
										echo $timeTo->format('h:i A')
									?></td>              						
								</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="5">
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