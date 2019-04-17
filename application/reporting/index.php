<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
require_once "stimulsoft/helper.php";
?>
<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Reporting</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-custom">
						<thead>
							<tr><th>Feedback</th></tr>
						</thead>
						<tbody>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/FeedbackSumm";?>" target="_blank">Feedback Summary</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/FeedbackDetails";?>" target="_blank">Feedback Details</a><br></td></tr>
						</tbody>
					</table>
					<table class="table table-striped table-hover table-custom">
						<thead>
							<tr><th>Facilities Booking</th></tr>
						</thead>
						<tbody>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/facilitybooking";?>" target="_blank">Facility Booking</a><br></td></tr>
							<tr>
								<td>
									<?php $attributes = array("id" => "searchform", "name" => "searchform", "target" => "_blank"); echo form_open_multipart("index.php/Common/FacilityBooking/BookingPdf/", $attributes);?>
										<div class="form-horizontal">
											<div class="form-group">
												<label for="status" class="create-label col-md-1">Date Booked From</label>
					                            <div class="col-md-2">
													<input id="datefrom" name="datefrom" autocomplete="off" placeholder="" type="text" class="form-control" value="" />
					                            </div>
											</div>
										</div>
										<div class="form-horizontal">
											<div class="form-group">
												<label for="status" class="create-label col-md-1">Date Booked To</label>
					                            <div class="col-md-2">
													<input id="dateto" name="dateto" autocomplete="off" placeholder="" type="text" class="form-control" value="" />
					                            </div>
											</div>
										</div>
										<div class="form-horizontal">
											<div class="form-group">
												<div class="col-md-3">
													<button class="btn pull-right" type="submit" value="Search">Search</button>
												</div>
											</div>
										</div>
									<?php echo form_close(); ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#datefrom').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			// minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
		$('#dateto').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			// minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
	});
</script>