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
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Update Facilities Booking</div>	
					<?php $attributes = array("id" => "facilitybookingform", "name" => "facilitybookingform");
					echo form_open("index.php/Common/FacilityBooking/Update/".$bookingID, $attributes);?>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="Description" class="create-label col-md-2">Facility</label>
								<div class="col-md-10">
									<input id="Description" name="Description" placeholder="Description" type="text" class="form-control" value="<?php echo $fbRecord[0]->Description; ?>" disabled />
									<span class="text-danger"><?php echo form_error('Description'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="PropertyNo" class="create-label col-md-2">Unit No</label>
								<div class="col-md-10">
									<?php $attributes = 'class = "form-control" id = "PropertyNo"';
									echo form_dropdown('PropertyNo',$usersPropNo,set_value('PropertyNo', $fbRecord[0]->PropertyNo),$attributes);?>
									<span class="text-danger"><?php echo form_error('PropertyNo'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="DateFrom" class="create-label col-md-2">Date</label>
								<div class="col-md-10">
									<input id="DateFrom" name="DateFrom" placeholder="DateFrom" type="text" class="form-control"  value="<?php echo date("Y-m-d", strtotime($fbRecord[0]->DateFrom)); ?>" />
									<span class="text-danger"><?php echo form_error('DateFrom'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="TimeFrom" class="create-label col-md-2">Time From</label>
								<div class="col-md-4">
									<?php $attributes = 'class = "form-control" id = "TimeFrom"';
									echo form_dropdown('TimeFrom',$timeFrom,set_value('TimeFrom'),$attributes);?>
									<span class="text-danger"><?php echo form_error('TimeFrom'); ?></span>
									<input type="hidden" id="MaxHour" value="<?php echo $bookingTypeDesc[0]->MaxBookHour; ?>">
								</div>
								<label for="TimeTo" class="create-label col-md-2">Time To</label>
								<div class="col-md-4">
									<?php $attributes = 'class = "form-control" id = "TimeTo"';
									echo form_dropdown('TimeTo',$timeTo,set_value('TimeTo'),$attributes);?>
									<span class="text-danger"><?php echo form_error('TimeTo'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="Status" class="create-label col-md-2">Status</label>
								<div class="col-md-10">
									<?php $attributes = 'class = "form-control" id = "Status"';
									echo form_dropdown('Status',$bookingStatus,set_value('Status', $fbRecord[0]->BStatusID),$attributes);?>
									<span class="text-danger"><?php echo form_error('Status'); ?></span>
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
<script>
	$(document).ready(function(){	
		$('#DateFrom').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "yy/mm/dd",
			minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
	});
</script>