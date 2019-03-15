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
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
				</div>	
					<?php $attributes = array("id" => "bookingtypeform", "name" => "bookingtypeform");
					echo form_open("index.php/Common/BookingType/update/" . $bookingTypeID, $attributes);?>
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
								<label for="ViewOnly" class="create-label col-md-4">Owner View Only</label>
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
								<label for="OtherFacility" class="create-label col-md-4">Other Facility</label>
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
						</div>
					</div>
					<div class="panel-footer">
						<input type="submit" value="Save" class="submit" />
						<!--<input type="reset" value="Cancel" class="btn btn-danger" />-->
					</div>
				<?php echo form_close(); ?>
				<?php echo $this->session->flashdata('msg'); ?>
			</div>
		</div>
	</div>
</div>
