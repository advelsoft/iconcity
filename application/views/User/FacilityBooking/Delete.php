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
		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Are you sure want to delete this?</h4>
				</div>
				<?php $attributes = array("id" => "FacilitiesBookingform", "name" => "FacilitiesBookingform");
				echo form_open("index.php/Common/FacilityBooking/Delete/".$fbRecord['bookingID'], $attributes);?>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Facility</dt>
						<dd><?php echo $fbRecord['description']; ?></dd>
						
						<dt>Unit No</dt>
						<dd><?php echo $fbRecord['propertyNo']; ?></dd>
						
						<dt>Date</dt>
						<dd><?php echo date("d-m-Y", strtotime($fbRecord['dateFrom'])); ?></dd>
						
						<dt>Time From</dt>
						<dd><?php $timeFrom = new DateTime($fbRecord['timeFrom']); echo $timeFrom->format('h:i A');?></dd>
						
						<dt>Time To</dt>
						<dd><?php $timeTo = new DateTime($fbRecord['timeTo']);echo $timeTo->format('h:i A');?></dd>
						
						<dt>Status</dt>
						<dd><?php echo $fbRecord['status']; ?></dd>
						
						<dt>Reason to Delete</dt>
						<dd>
							<input id="Remarks" name="Remarks" placeholder="Reason to Delete" type="text" class="form-control" maxlength="50" value="" />*limit to 50 characters
							<span class="text-danger"><?php echo form_error('Remarks'); ?></span>
						</dd>
					</dl>
				</div>
				<div class="panel-footer">
					<input type="submit" value="Delete" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
        </div>
    </div>
</div>
<?php echo $this->session->flashdata('msg'); ?>