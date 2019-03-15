<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/BookingType/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Booking Type Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Description</dt>
						<dd><?php echo $btRecord[0]->Description; ?></dd>
						<span class="text-danger"><?php echo form_error('Description'); ?></span>
						
						<dt>Status</dt>
						<dd><?php echo $btRecord[0]->BTStatusID; ?></dd>
						<span class="text-danger"><?php echo form_error('Status'); ?></span>
						
						<dt>Max Book Hour</dt>
						<dd><?php echo $btRecord[0]->MaxBookHour; ?></dd>
						<span class="text-danger"><?php echo form_error('MaxBookHour'); ?></span>
						
						<dt>Owner View Only</dt>
						<dd><input type="checkbox" id="ViewOnly" disabled="disabled" name="ViewOnly" class="check-box" value="1" <?php echo ($btRecord[0]->ViewOnly == '1' ? 'checked' : null); ?>></dd>
						
						<dt>Auto Approve Booking</dt>
						<dd><input type="checkbox" id="AutoApproveBooking" disabled="disabled" name="AutoApproveBooking" class="check-box" value="1" <?php echo ($btRecord[0]->AutoApproveBooking == '1' ? 'checked' : null); ?>></dd>
						
						<dt>Other Facility (Calendar)</dt>
						<dd><input type="checkbox" id="OtherFacility" disabled="disabled" name="OtherFacility" class="check-box" value="1" <?php echo ($btRecord[0]->OtherFacility == '1' ? 'checked' : null); ?>></dd>
						
						<dt>Manage Booking (Admin)</dt>
						<dd><input type="checkbox" id="ManageBookAdmin" disabled="disabled" name="ManageBookAdmin" class="check-box" value="1" <?php echo ($btRecord[0]->ManageBookAdmin == '1' ? 'checked' : null); ?>></dd>
					</dl>
				</div>
				<div class="panel-footer">
					<div class="btn btn-sm btn-grey"><a href="<?php echo base_url()."index.php/Common/BookingType/Update/".$btRecord[0]->BookingTypeID;?>">Edit</a></div>
					<div class="btn btn-sm btn-grey"><a href="<?php echo base_url()."index.php/Common/BookingType/Delete/".$btRecord[0]->BookingTypeID;?>">Delete</a></div>
				</div>
			</div>
		</div>
	</div>
</div>