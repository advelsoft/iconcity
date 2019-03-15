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
		<div class="col-lg-12">
			<div id="calendar"></div>
		</div>
	</div>
	</br>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo $bookingTypeDesc[0]->Description;?></div>			
				<?php $attributes = array("id" => "FacilitiesBookingform", "name" => "FacilitiesBookingform");
				echo form_open("index.php/Common/FacilityBooking/Create/".$bookingTypeID."?Date=".$_GET['Date'], $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="Description" class="create-label col-md-2">Facility</label>
                            <div class="col-md-10 descimg">
                                <img src="<?php echo base_url()."application/uploads/facility/".$bookingTypeDesc[0]->ImgToShown;?>" alt="Facilities">
                            </div>
                        </div>
						<!--<div class="form-group">
							<label for="Outstanding" class="create-label col-md-2">Outstanding</label>
                            <div class="col-md-10">
								<div id="OverdueAmount"><b><?php echo 'RM '.$blackList[0]->OverdueAmount; ?></b></div>
								<span class="text-danger"><?php echo form_error('Outstanding'); ?></span>
								<input type="hidden" id="StatusB" name="StatusB" value="<?php echo $blackList[0]->Status; ?>">
								<input type="hidden" id="Outstanding" name="Outstanding" value="<?php echo $blackList[0]->OverdueAmount; ?>">
							</div>
                        </div>-->
						<div class="form-group">
							<label for="DateFrom" class="create-label col-md-2">Date</label>
                            <div class="col-md-10">
								<input id="DateFrom" name="DateFrom" placeholder="Date" type="text" class="form-control" value="<?php echo $_GET['Date']; ?>" readonly />
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
							<a href="#" data-toggle="modal" data-target="#facdetail" class="create-label col-md-6">Facility Rules & Regulation</a>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="facdetail" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<!-- Modal Header -->
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title">Facility Rules & Regulation</h4>
									</div>
									<!-- Modal Body -->
									<div class="modal-body">
									</div>
									<!-- Modal Footer -->
									<div class="modal-footer">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group col-md-6">
							<input type="checkbox" name="accept_terms_checkbox" id="terms" onchange="activateButton(this)"> I agree to the Terms and Conditions.<br>
							<span class="text-danger"><?php echo form_error('accept_terms_checkbox') ?></span>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" id="Submit" name="Submit" value="Submit" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Schedule Facilities Booking</div>	
				<div class="panel-body">
					<table class="table table-striped table-hover" id='tbl'>
						<thead>
							<tr>
								<th>Time</th>
								<th>Availability</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($schedule as $file) { ?>
								<tr class="Row">
									<td><?php echo $file['timeRange']; ?></td>
									<td>
										<?php if ($file['booked'] == '0'): ?>
											<?php { echo 'Available'; } ?>
										<?php else: {?>
												<?php if ($file['status'] == 'Approved'): ?>
												<?php { echo 'Booked ('.$file['propNo'].')'; } ?>
												<?php elseif ($file['status'] == 'New' || $file['status'] == 'Pre-book'): ?>
												<?php { echo 'Pending Approval ('.$file['propNo'].')'; } ?>
												<?php endif;?>
											<?php } ?>
										<?php endif;?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	var url = window.location.href;
	//get bokingtypeid from url
	var param = url.substring(url.lastIndexOf('/') + 1);
	var id = param.split("?")[0];
	//get date from url
	var value = param.split("?")[1];
	var date = value.split("=")[1];
	//get path from url
	var vars = url.split("/");
	var path = '';
	for (var i=0; i<vars.length-2; i++) {
		path += vars[i] + "/";
	}
		
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

	$("#calendar").datepicker({
		firstDay: 1,
		showOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dateFormat: "yy-mm-dd",
		minDate: 0,
		defaultDate: date,
		onSelect: function(dateText) {
			$(this).change();
		}
	})
	.change(function() {
		var href = path+'Create/'+id+'?Date='+this.value;
		window.location.href = href;
	});
	
	function fromChange() {
		var timeFrom = document.getElementById("TimeFrom");
		var timeTo = document.getElementById("TimeTo");
		var fromTime = $(this).val();
		var maxHour = parseInt(document.getElementById("MaxHour").value);   
		var cnt = 0;

		for (var i=1; i<=timeFrom.options.length; i++)
		{
			if (i >= timeFrom.selectedIndex+1 && cnt < maxHour)
			{
				cnt = cnt + 1;
				document.getElementById("TimeTo").options[i-1].disabled = false;
				document.getElementById("TimeTo").options[0].disabled = false;	
				document.getElementById("TimeTo").value = document.getElementById("TimeTo").options[0].value;		
			}
			else{
				document.getElementById("TimeTo").options[i-1].disabled = true;
				document.getElementById("TimeTo").options[0].disabled = false;
				document.getElementById("TimeTo").value = document.getElementById("TimeTo").options[0].value;
			}
		}
	}
	$('#TimeFrom').change(fromChange);
	
	var tbl = document.getElementById('tbl');
	var classes = tbl.getElementsByClassName('Row');
	
	for (var r = 1; r < tbl.rows.length; r++) {	
		var text = tbl.rows[r].cells[1].innerHTML;
		var b = text.includes("Booked");
		var p = text.includes("Pending Approval");
		
		if(b == true){
			tbl.rows[r].cells[0].style.color =  "red";
			tbl.rows[r].cells[1].style.color =  "red";
		}
		else if(p == true){
			tbl.rows[r].cells[0].style.color =  "blue";
			tbl.rows[r].cells[1].style.color =  "blue";
		}
		else{
			tbl.rows[r].cells[1].style.color =  "green";
		}
	}
	
	var outstanding = parseFloat(document.getElementById("Outstanding").value);
	var blackListAmt = '1800.00';

	if(outstanding > blackListAmt){
		document.getElementById("OverdueAmount").setAttribute("style", "color: #ff0000;");
	}
</script>