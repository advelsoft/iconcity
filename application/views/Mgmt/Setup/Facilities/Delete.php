<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/BookingType/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
    <div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Are you sure want to delete this?</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Description</dt>
						<dd><?php echo $btRecord[0]->Description; ?></dd>
						<span class="text-danger"><?php echo form_error('Description'); ?></span>
						
						<dt>Group ID</dt>
						<dd><?php echo $btRecord[0]->GROUPCODE; ?></dd>
						<span class="text-danger"><?php echo form_error('Group ID'); ?></span>
						
						<dt>Status</dt>
						<dd><?php echo $btRecord[0]->Status; ?></dd>
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
					<a href="<?php echo base_url() . "index.php/Common/BookingType/delete_record/" . $btRecord[0]->BookingTypeID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
        </div>
    </div>
</div>