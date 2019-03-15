<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/WorkOrder/Closed";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Work Order Info</h4>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="FeedbackID" class="create-label col-md-4">Work Order ID</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->WorkOrderID; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-4">Category</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->CatDesc; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-4">Incident Type</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->IncidentType; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-4">Item Location</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->LocName; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-4">Item Group</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->GroupName; ?>
							</div>
							<label for="PropertyNo" class="create-label col-md-4">Unit No</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->PropertyNo; ?>
							</div>
							<label for="Subject" class="create-label col-md-4">Subject</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->Subject; ?>
							</div>
							<label for="Description" class="create-label col-md-4">Description</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->Description; ?>
							</div>
							<label for="Date Incident" class="create-label col-md-4">Date Incident</label>
							<div class="col-md-8">
								<?php echo date("jS F Y", strtotime($closedWO[0]->CreatedDate)); ?>
							</div>
							<label for="AssignBy" class="create-label col-md-4">Assign By</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->AssignBy; ?>
							</div>
							<label for="TechnicianName" class="create-label col-md-4">Technician Name</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->AssignTo; ?>
							</div>
							<label for="Priority" class="create-label col-md-4">Priority</label>
							<div class="col-md-8">
								<?php echo $closedWO[0]->Priority; ?>
							</div>
							<label for="ActionTaken" class="create-label col-md-4">Action Taken</label>
							<div class="col-md-8">
								<?php if($closedWO[0]->ActionTaken != '') { ?>
									<?php echo $closedWO[0]->ActionTaken; ?>
								<?php } else { ?>
									<?php echo 'N/A'; ?>
								<?php } ?>
							</div>
							<label for="ActionTaken" class="create-label col-md-4">Completed Date</label>
							<div class="col-md-8">
								<?php if($closedWO[0]->ClosedDate != '') { ?>
									<?php echo date("jS F Y", strtotime($closedWO[0]->ClosedDate)); ?>
								<?php } else { ?>
									<?php echo 'N/A'; ?>
								<?php } ?>
							</div>
							<label for="Remarks" class="create-label col-md-4">Remarks</label>
							<div class="col-md-8">
								<?php if($closedWO[0]->ManagementRemarks != '') { ?>
									<?php echo $closedWO[0]->ManagementRemarks; ?>
								<?php } else { ?>
									<?php echo 'N/A'; ?>
								<?php } ?>
							</div>
							<?php if(count($woItem) > 0) { ?>
								<div class="col-md-12">
								<div id="table" class="table-editable">
									<table class="table table-bordered table-hover" id="tab_logic">
										<thead>
											<tr>
												<th class="text-center">No.</th>
												<th class="text-center">Item</th>
												<th class="text-center">Quantity</th>
												<th class="text-center">Unit Price</th>
												<th class="text-center">Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php for($i = 0; $i < count($woItem); $i++) { ?>
												<tr id='addr<?php echo $i; ?>'>
													<td><?php echo $i+1; ?></td>
													<td><?php echo $woItem[$i]->Item; ?></td>
													<td><?php echo $woItem[$i]->Quantity; ?></td>
													<td><?php echo $woItem[$i]->UnitPrice; ?></td>
													<td><?php echo $woItem[$i]->Amount; ?></td>
												</tr>
											<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<td>
													<b>Chargeable: </b>
													<input type="checkbox" id="chargeable" name="chargeable" 
													<?php if(count($woItem) > 0) { ?>
														value="<?php echo $woItem[0]->Chargeable; ?>" <?php echo set_checkbox('chargeable','1'); ?> <?php if ($woItem[0]->Chargeable == "1") {echo "checked = checked";} ?>
													<?php } else { ?>
														value=""
													<?php } ?>
													disabled />
												</td>
												<td colspan='3'></td>
												<td>
													<b>Total: </b>
													<span id="totalPrice"><?php if(count($woItem) > 0) { echo $woItem[0]->TotalAmount; } ?></span>
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	$(document).ready(function(){
		$('#CompletedDate').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
	});
	
	function getEmail(){
		var email = $("#AssignTo").val();
		var arr = email.split(',');
		document.getElementById("Email").value = arr[1];
	};
	$("#AssignTo").change(getEmail);
</script>