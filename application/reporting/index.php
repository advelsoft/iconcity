<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php require_once 'stimulsoft/helper.php'; ?>

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
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/Feedbacks";?>" target="_blank">Search Feedback</a><br></td></tr>
						</tbody>
					</table>
					<table class="table table-striped table-hover table-custom">
						<thead>
							<tr><th>Facilities Booking</th></tr>
						</thead>
						<tbody>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/FacilityBooking";?>" target="_blank">Facilities Booking Summary</a><br></td></tr>
							<!--<tr><td><a href="#" target="_self">Facilities Booking Details</a><br></td></tr>-->
						</tbody>
					</table>
					<!--<table class="table table-striped table-hover table-custom">
						<thead>
							<tr><th>KPI Report</th></tr>
						</thead>
						<tbody>
							<tr><td><a href="#" target="_self">KPI Report Closed</a><br></td></tr>
						</tbody>
					</table>-->
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>