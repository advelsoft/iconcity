<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/WorkOrder/Open";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Work Order Info</h4>
				</div>
				<?php $attributes = array("id" => "workorderform", "name" => "workorderform", "target" => "_blank");
				echo form_open_multipart("index.php/Common/WorkOrder/OpenWO/".$WOID, $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="FeedbackID" class="create-label col-md-3">Work Order ID</label>
							<div class="col-md-9"><?php echo $openWO[0]->WorkOrderID; ?></div>
						</div>
						<div class="form-group">
							<label for="FeedbackID" class="create-label col-md-3">Feedback ID</label>
							<div class="col-md-9"><?php echo $openWO[0]->FeedbackID; ?></div>
						</div>
						<div class="form-group">
							<label for="Category" class="create-label col-md-3">Category *</label>
                            <div class="col-md-9">
                                <?php $attributes = 'class = "form-control" id = "Category"';
								echo form_dropdown('Category',$category,set_value('Category'),$attributes);?>
								<span class="text-danger"><?php echo form_error('Category'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="IncidentType" class="create-label col-md-3">Incident Type</label>
                            <div class="col-md-9"><?php echo $openWO[0]->IncidentType; ?></div>
                        </div>
						<div class="form-group">
							<label for="Location" class="create-label col-md-3">Item Location</label>
                            <div class="col-md-9">
                                <?php $attributes = 'class = "form-control" id = "Location"';
								echo form_dropdown('Location',$location,set_value('Location'),$attributes);?>
								<span class="text-danger"><?php echo form_error('Location'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Group" class="create-label col-md-3">Item Group</label>
                            <div class="col-md-9" id="Group">
								<select name="Group" id="Group">
									<option value="0">Select Value</option>
								</select>
								<span class="text-danger"><?php echo form_error('Group'); ?></span>
							</div>
                        </div>
						<div class="form-group">
							<label for="UnitNo" class="create-label col-md-3">Unit No</label>
                            <div class="col-md-9"><?php echo $openWO[0]->PropertyNo; ?></div>
                        </div>
						<div class="form-group">
							<label for="Subject" class="create-label col-md-3">Subject</label>
                            <div class="col-md-9"><?php echo $openWO[0]->Subject; ?></div>
                        </div>
						<div class="form-group">
							<label for="Description" class="create-label col-md-3">Description</label>
                            <div class="col-md-9"><?php echo $openWO[0]->Description; ?></div>
                        </div>
						<div class="form-group">
							<label for="DateIncident" class="create-label col-md-3">Date Incident </br>(YYYY-MM-DD)</label>
							<div class="col-md-3">
								<input id="DateIncident" name="DateIncident" placeholder="Date Incident (YYYY-MM-DD)" type="text" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
								<span class="text-danger"><?php echo form_error('DateIncident'); ?></span>
							</div>
							<label for="TimeIncident" class="create-label col-md-3">Time Incident </br>(HH:mm)</label>
							<div class="col-md-3">
								<input id="TimeIncident" name="TimeIncident" placeholder="Time Incident (HH:mm)" type="text" class="form-control" value="<?php echo date("H:i"); ?>" />
								<span class="text-danger"><?php echo form_error('TimeIncident'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="StartDate" class="create-label col-md-3">Start Date </br>(YYYY-MM-DD)</label>
							<div class="col-md-3">
								<input id="StartDate" name="StartDate" placeholder="Start Date" type="text" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
								<span class="text-danger"><?php echo form_error('CompletedDate'); ?></span>
							</div>
							<label for="EndDate" class="create-label col-md-3">End Date </br>(YYYY-MM-DD)</label>
							<div class="col-md-3">
								<input id="EndDate" name="EndDate" placeholder="End Date" type="text" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
								<span class="text-danger"><?php echo form_error('CompletedTime'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="AssignTo" class="create-label col-md-3">Technician Name *</label>
							<div class="col-md-9">
								<?php $attributes = 'class = "form-control" id = "AssignTo"';
								echo form_dropdown('AssignTo',$assignTo,set_value('AssignTo'),$attributes);?>
								<span class="text-danger"><?php echo form_error('AssignTo'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Priority" class="create-label col-md-3">Priority *</label>
							<div class="col-md-9">
								<?php $attributes = 'class = "form-control" id = "Priority"';
								echo form_dropdown('Priority',$priority,set_value('Priority', $openWO[0]->Priority),$attributes);?>
								<span class="text-danger"><?php echo form_error('Priority'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Instruction" class="create-label col-md-3">Instruction</label>
							<div class="col-md-9">
								<textarea class="form-control" id="Instruction" name="Instruction" rows="4"></textarea>
								<span class="text-danger"><?php echo form_error('Instruction'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" class="submit" value="SUBMIT & PRINT" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	function itemGroup(location) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('index.php/Common/WorkOrder/ItemGroup'); ?>",
			data: {
				loc: location
			},
			success: function(data) {
				$('#Group').html(data);
			},
			failure: function() {
				alert('fail');
			}
		});
	}
	
	$('#Location').change(function() {
		var location = $(this).val();
		if(location != '')
		{
			itemGroup(location);
		}
	});
</script>