<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/WorkOrder/InProgress";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Work Order Info
						<a href="#" data-toggle="modal" data-target="#closed">
							<div style="float: right;" class="btn btn-sm btn-grey">Close Case</div>
						</a>
					</h4>
					<!-- Modal -->
					<div class="modal fade" id="closed" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<?php $attributes = array("id" => "closeform", "name" => "closeform");
								echo form_open("index.php/Common/WorkOrder/ClosedWO/".$WOID, $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header"></div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<h4 class="modal-title">Do you want to close this case?</h4></br>
										<div class="form-group">
											<label for="CloseDate" class="create-label col-md-3">Close Date (YYYY-MM-DD)</label>
											<div class="col-md-9">
												<input id="CloseDate" name="CloseDate" placeholder="Close Date" type="text" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
												<span class="text-danger"><?php echo form_error('CloseDate'); ?></span>
												<input id="propNo" name="propNo" type="hidden" value="<?php echo $inProgressWO[0]->PropertyNo; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="CloseTime" class="create-label col-md-3">Close Time</label>
											<div class="col-md-9">
												<div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
													<input id="CloseTime" name="CloseTime" placeholder="Close Time" type="text" class="form-control" value="<?php echo date("H:i"); ?>" readonly />
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-time"></span>
													</span>
													<span class="text-danger"><?php echo form_error('CloseTime'); ?></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="Comment" class="create-label col-md-3">Comment</label>
											<div class="col-md-9">
												<input id="Comment" name="Comment" placeholder="Comment" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Comment'); ?></span>
											</div>
										</div>
									</div>
								</div>
								<!-- Modal Footer -->
								<div class="modal-footer">
									<input type="submit" value="YES" class="submit" />
									<button type="button" class="btn btn-sm btn-grey" data-dismiss="modal" aria-hidden="true">No</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
				<?php $attributes = array("id" => "feedbackform", "name" => "feedbackform", "target" => "_blank");
				echo form_open_multipart("index.php/Common/WorkOrder/InProgressWO/".$WOID, $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="FeedbackID" class="create-label col-md-3">Work Order ID</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->WorkOrderID; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-3">Category</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->Category; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-3">Incident Type</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->IncidentType; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-3">Item Location</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->LocName; ?>
							</div>
							<label for="IncidentType" class="create-label col-md-3">Item Group</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->GroupName; ?>
							</div>
							<label for="PropertyNo" class="create-label col-md-3">Unit No</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->PropertyNo; ?>
							</div>
							<label for="Subject" class="create-label col-md-3">Subject</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->Subject; ?>
							</div>
							<label for="Description" class="create-label col-md-3">Description</label>
							<div class="col-md-9">
								<?php echo $inProgressWO[0]->Description; ?>
							</div>
							<label for="DateIncident" class="create-label col-md-3">Date Incident</label>
							<div class="col-md-9">
								<?php echo date("jS F Y", strtotime($inProgressWO[0]->CreatedDate)); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="AssignBy" class="create-label col-md-3">Assign By *</label>
							<div class="col-md-9">
								<input id="AssignBy" name="AssignBy" placeholder="Assign By" type="text" class="form-control" value="<?php echo $inProgressWO[0]->AssignBy; ?>" />
								<span class="text-danger"><?php echo form_error('AssignBy'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="AssignTo" class="create-label col-md-3">Technician Name *</label>
							<div class="col-md-9">
								<input id="AssignTo" name="AssignTo" placeholder="Assign To" type="text" class="form-control" value="<?php echo $inProgressWO[0]->AssignTo; ?>" readonly />
								<span class="text-danger"><?php echo form_error('AssignTo'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Priority" class="create-label col-md-3">Priority *</label>
							<div class="col-md-9">
								<?php $attributes = 'class = "form-control" id = "Priority"';
								echo form_dropdown('Priority',$priority,set_value('Priority', $inProgressWO[0]->Priority),$attributes);?>
								<span class="text-danger"><?php echo form_error('Priority'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="ActionTaken" class="create-label col-md-3">Action Taken</label>
							<div class="col-md-9">
								<textarea class="form-control" id="ActionTaken" name="ActionTaken" rows="4"><?php echo $inProgressWO[0]->ActionTaken; ?></textarea>
								<span class="text-danger"><?php echo form_error('ActionTaken'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="CompletedBy" class="create-label col-md-3">Completed By</label>
							<div class="col-md-9">
								<input id="CompletedBy" name="CompletedBy" placeholder="Completed By" type="text" class="form-control" value="<?php if(isset($inProgressWO[0]->CompletedBy)) { echo $inProgressWO[0]->CompletedBy; } ?>" />
								<span class="text-danger"><?php echo form_error('CompletedBy'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="CompletedDate" class="create-label col-md-3">Completed Date (YYYY-MM-DD)</label>
							<div class="col-md-3">
								<input id="CompletedDate" name="CompletedDate" placeholder="Completed Date (YYYY-MM-DD)" type="text" class="form-control" value="<?php if(isset($inProgressWO[0]->CompletedDate)) { echo date("d-m-Y", strtotime($inProgressWO[0]->CompletedDate)); } ?>" />
								<span class="text-danger"><?php echo form_error('CompletedDate'); ?></span>
							</div>
							<label for="CompletedTime" class="create-label col-md-3">Completed Time (HH:mm)</label>
							<div class="col-md-3">
								<div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
									<input id="CompletedTime" name="CompletedTime" placeholder="Completed Time (HH:mm)" type="text" class="form-control" value="<?php if(isset($inProgressWO[0]->CompletedDate)) { echo date("h:i A", strtotime($inProgressWO[0]->CompletedDate)); } ?>" />
									<span class="text-danger"><?php echo form_error('CompletedTime'); ?></span>
								</div>
							</div>
						</div>
						<div class="form-group"><label class="create-label col-md-3">Item Replaced</label></div>
						<div class="form-group">
							<div class="col-md-12">
								<div id="table" class="table-editable">
									<table class="table table-bordered table-hover" id="tab_logic">
										<a id="add_row" class="btn btn-primary pull-left">Add Row</a>
										<a id='delete_row' class="pull-right btn btn-primary">Delete Row</a>
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
											<?php if(count($woItem) > 0) { ?>
												<?php for($i = 0; $i < count($woItem); $i++) { ?>
													<tr id='addr<?php echo $i; ?>'>
														<td><?php echo $i+1; ?><input name="UID<?php echo $i; ?>" type="hidden" class="form-control" value="<?php echo $woItem[$i]->UID; ?>"></td>
														<td><input type="text" id="item<?php echo $i; ?>" name="item<?php echo $i; ?>" class="form-control" value="<?php echo $woItem[$i]->Item; ?>" /></td>
														<td><input type="text" id="qty<?php echo $i; ?>" name="qty<?php echo $i; ?>" class="form-control" value="<?php echo $woItem[$i]->Quantity; ?>" onkeyup="ttlAmt(<?php echo $i; ?>);" /></td>
														<td><input type="text" id="up<?php echo $i; ?>" name="up<?php echo $i; ?>" class="form-control" value="<?php echo $woItem[$i]->UnitPrice; ?>" onkeyup="ttlAmt(<?php echo $i; ?>);" /></td>
														<td><input type="text" id="amt<?php echo $i; ?>" name="amt<?php echo $i; ?>" class="form-control amt" value="<?php echo $woItem[$i]->Amount; ?>" /></td>
													</tr>
												<?php } ?>
												<tr id='addr<?php echo count($woItem); ?>'></tr>
											<?php } else { ?>
												<tr id='addr0'>
													<td>1</td>
													<td><input type="text" id='item0' name='item0' placeholder='Item' class="form-control" /></td>
													<td><input type="text" id='qty0' name='qty0' placeholder='Quantity' class="form-control" onkeyup="ttlAmt(0);" /></td>
													<td><input type="text" id='up0' name='up0' placeholder='Unit Price' class="form-control" onkeyup="ttlAmt(0);" /></td>
													<td><input type="text" id='amt0' name='amt0' placeholder='Amount' class="form-control amt" /></td>
												</tr>
												<tr id='addr1'></tr>
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
												</td>
												<td colspan='3'></td>
												<td>
													<b>Total: </b>
													<span id="totalPrice"><?php if(count($woItem) > 0) { echo $woItem[0]->TotalAmount; } ?></span>
													<input type="hidden" name="hdnttlPrice" id="hdnttlPrice" value="<?php if(count($woItem) > 0) { echo $woItem[0]->TotalAmount; } ?>" />
												</td>
											</tr>
										</tfoot>
									</table>
									<?php if(count($woItem) > 0) { ?>
										<input type="hidden" name="rowCnt" id="rowCnt" value="<?php echo count($woItem); ?>" />
									<?php } else { ?>
										<input type="hidden" name="rowCnt" id="rowCnt" value="1" />
									<?php } ?>
								</div>
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
	$(document).ready(function(){
		var tbl = document.getElementById('tab_logic');
		var i = tbl.rows.length-3;
		
		$("#add_row").click(function(){
			$('#addr'+i).html("<td>"+(i+1)+"<input name='UID"+i+"' type='hidden' value=''></td>"+
							  "<td><input type='text' id='item"+i+"' name='item"+i+"' placeholder='Item' class='form-control' value='' /></td>"+
							  "<td><input type='text' id='qty"+i+"' name='qty"+i+"' placeholder='Quantity' class='form-control' value='' onkeyup='ttlAmt("+i+");' /></td>"+
							  "<td><input type='text' id='up"+i+"' name='up"+i+"' placeholder='Unit Price' class='form-control' value='' onkeyup='ttlAmt("+i+");' /></td>"+
							  "<td><input type='text' id='amt"+i+"' name='amt"+i+"' placeholder='Amount' class='form-control amt' value='' /></td>");
			$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
			i++;
			document.getElementById('rowCnt').value = i;
		});

		$("#delete_row").click(function(){
			if(i>1){
				$("#addr"+(i-1)).html('');
				i--;
			}
			document.getElementById('rowCnt').value = i;
		});
	});
	
	function ttlAmt(i){
		document.getElementById("amt"+i).value = document.getElementById("qty"+i).value*document.getElementById("up"+i).value;
		calculateSum();
	}
	
	function calculateSum() {
		var sum = 0;
		//iterate through each textboxes and add the values
		$(".amt").each(function () {
			if (!isNaN(this.value) && this.value.length != 0) {
				sum += parseFloat(this.value);
			}
		});
		$("#totalPrice").html(sum.toFixed(2));
		$("#hdnttlPrice").val(sum.toFixed(2));
	}
	
	$("#chargeable").click(function() {
		var chargeable = document.getElementById("chargeable").value;
		if(chargeable == '1'){
			document.getElementById("chargeable").value = '0';
		}
		else{
			document.getElementById("chargeable").value = '1';
		}
	});
	
	function checkTime(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
	
	$('#CompletedDate').keyup(function(){
		var now = new Date();
		document.getElementById("CompletedTime").value = [now.getHours(),':',checkTime(now.getMinutes())].join('');
	});
</script>