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
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Facilities Booking Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Facility</dt>
						<dd><?php echo $fbRecord['description']; ?></dd>
						<span class="text-danger"><?php echo form_error('Description'); ?></span>
						
						<dt>Unit No</dt>
						<dd><?php echo $fbRecord['propertyNo']; ?></dd>
						<span class="text-danger"><?php echo form_error('PropertyNo'); ?></span>
						
						<dt>Date</dt>
						<dd><?php echo date("d-m-Y", strtotime($fbRecord['dateFrom'])); ?>
						</dd>
						<span class="text-danger"><?php echo form_error('DateFrom'); ?></span>
						
						<dt>Time From</dt>
						<dd><?php 
							$timeFrom = new DateTime( $fbRecord['timeFrom'] );
							echo $timeFrom->format('h:i A');
						?></dd>
						<span class="text-danger"><?php echo form_error('TimeFrom'); ?></span>
						
						<dt>Time To</dt>
						<dd><?php 
							$timeTo = new DateTime( $fbRecord['timeTo'] );
							echo $timeTo->format('h:i A');
						?></dd>
						<span class="text-danger"><?php echo form_error('TimeTo'); ?></span>
						
						<dt>Status</dt>
						<dd><?php echo $fbRecord['status']; ?></dd>
						<span class="text-danger"><?php echo form_error('Status'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/FacilityBooking/Delete/".$fbRecord['bookingID'];?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
		</div>
	</div>
</div>