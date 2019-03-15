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
				</div>	
					<?php $attributes = array("id" => "bookingtypeform", "name" => "bookingtypeform");
					echo form_open_multipart("index.php/Common/BookingType/update/" . $bookingTypeID, $attributes);?>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="Description" class="create-label col-md-4">Description</label>
								<div class="col-md-8">
									<input id="Description" name="Description" placeholder="Description" type="text" class="form-control"  value="<?php echo $btRecord[0]->Description; ?>" />
									<span class="text-danger"><?php echo form_error('Description'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="Group" class="create-label col-md-4">Group</label>
								<div class="col-md-8">
									<?php $attributes = 'class = "form-control" id = "GroupCode"';
									echo form_dropdown('GroupCode',$btGroup,set_value('GroupCode', $btRecord[0]->GROUPCODE),$attributes);?>
									<span class="text-danger"><?php echo form_error('GroupCode'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="Status" class="create-label col-md-4">Status</label>
								<div class="col-md-8">
									<?php $attributes = 'class = "form-control" id = "Status"';
									echo form_dropdown('Status',$btStatus,set_value('Status', $btRecord[0]->BTStatusID),$attributes);?>
									<span class="text-danger"><?php echo form_error('Status'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="MaxBookHour" class="create-label col-md-4">Max Book Hour</label>
								<div class="col-md-8">
									<?php $attributes = 'class = "form-control" id = "MaxBookHour"';
									echo form_dropdown('MaxBookHour',$maxBookHour, set_value('MaxBookHour', $btRecord[0]->MaxBookHour), $attributes);?>								
									<span class="text-danger"><?php echo form_error('MaxBookHour'); ?></span>
								</div>
							</div>		
							<div class="form-group">
								<label for="ViewOnly" class="create-label col-md-4" data-toggle="tooltip" title="Only show schedule table">Owner View Only</label>
								<div class="col-md-8">
									<input type="checkbox" id="ViewOnly" name="ViewOnly" class="form-control" value="1" <?php echo ($btRecord[0]->ViewOnly == '1' ? 'checked' : null); ?>>
									<span class="text-danger"><?php echo form_error('ViewOnly'); ?></span>			
								</div>
							</div>
							<div class="form-group">
								<label for="AutoApproveBooking" class="create-label col-md-4">Auto Approve Booking</label>
								<div class="col-md-8">
									<input type="checkbox" id="AutoApproveBooking" name="AutoApproveBooking" class="form-control" value="1" <?php echo ($btRecord[0]->AutoApproveBooking == '1' ? 'checked' : null); ?>>
									<span class="text-danger"><?php echo form_error('AutoApproveBooking'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="OtherFacility" class="create-label col-md-4" data-toggle="tooltip" title="Pending approval function">Other Facility</label>
								<div class="col-md-8">
									<input type="checkbox" id="OtherFacility" name="OtherFacility" class="form-control" value="1" <?php echo ($btRecord[0]->OtherFacility == '1' ? 'checked' : null); ?>>
									<span class="text-danger"><?php echo form_error('OtherFacility'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="ManageBookAdmin" class="create-label col-md-4">Manage Book (Admin)</label>
								<div class="col-md-8">
									<input type="checkbox" id="ManageBookAdmin" name="ManageBookAdmin" class="form-control" value="1" <?php echo ($btRecord[0]->ManageBookAdmin == '1' ? 'checked' : null); ?>>
									<span class="text-danger"><?php echo form_error('ManageBookAdmin'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="ImgToShown" class="create-label col-md-4">Picture of Facility</label>
								<div class="col-md-8">
									<input type="file" name="ImgToShown" size="20" value="<?php echo base_url()."application/uploads/facility/".$btRecord[0]->ImgToShown; ?>" />
									<span class="text-danger"><?php echo form_error('ImgToShown'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="ResetBooking" class="create-label col-md-4">Reset Booking</label>
								<div class="col-md-4">
									<input type="checkbox" id="ResetBooking" name="ResetBooking" class="form-control" value="1" <?php echo ($btRecord[0]->Schedule == '1' ? 'checked' : null); ?>>
									<span class="text-danger"><?php echo form_error('ResetBooking'); ?></span>
								</div>
								<div class="col-md-4">
									<input id="ResetHour" name="ResetHour" placeholder="ResetHour" type="text" class="form-control"  value="<?php echo $btRecord[0]->SDuration; ?>" />
									<span class="text-danger"><?php echo form_error('ResetHour'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="DailyBooking" class="create-label col-md-4">Daily Booking</label>
								<div class="col-md-8">
									<input type="checkbox" id="DailyBooking" name="DailyBooking" class="form-control" value="1" <?php echo ($btRecord[0]->DailyBooking == '1' ? 'checked' : null); ?>>
									<span class="text-danger"><?php echo form_error('DailyBooking'); ?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<input type="submit" value="Submit" class="submit" />
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>