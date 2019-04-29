<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>E-Reminder</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Title</th>
									<th data-hide="phone,tablet">Date of Reminder</th>
									<th data-hide="phone,tablet">Overdue Amount</th>
									<th data-hide="phone,tablet">Receipt</th>
								</tr>
							</thead>
							<?php if(count($osReminder) > 0): { ?>
								<tbody>
									<?php $i = 0?>
									<?php foreach($osReminder as $item) { ?>
									<?php $i++?>
									<tr>
										<td><?php echo $item['reminderNo']; ?></td>
										<td><?php echo date("d-m-Y", strtotime($item['reminderDate'])); ?></td>
										<td><?php echo $item['outstanding']; ?></td>
										<td>
											<?php $attributes = array("id" => "reminderform", "name" => "reminderform", "target" => "_blank");
											echo form_open("index.php/Common/Outstanding/GenerateReminder/".$item['reminderNo'], $attributes);?>
												<button id="<?php echo 'buttonRow'.$i?>" name="<?php echo $item['reminderNo']; ?>" class="btn btn-sm btn-grey" style="color: white; text-transform: uppercase;">Print Reminder</button>
											<?php echo form_close(); ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot class="footable-pagination">
									<tr>
										<td colspan="5">
											<div><?php echo $this->pagination->create_links();?></div>
										</td>
									</tr>
								</tfoot>
							<?php } ?>
							<?php else: {  ?>
								<tbody>
									<tr><td colspan="5">No Records</td></tr>
								</tbody>
							<?php } ?>
							<?php endif;?>
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('history'); $this->session->unset_userdata('history'); ?>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
	
	for (var r = 1; r < tbl.rows.length-1; r++) {
		var reminderNo = tbl.rows[r].cells[0].innerHTML;
		if(reminderNo == "" || /^\s*$/.test(reminderNo)){
			//remove row when no data to display
			$('#buttonRow'+r).hide();
		}
		
		var cnvrtNo = ordinal_suffix_of(reminderNo);
		tbl.rows[r].cells[0].innerHTML = cnvrtNo + " reminder";
	}
	
	function ordinal_suffix_of(i) {
		var j = i % 10,
			k = i % 100;
		if (j == 1 && k != 11) {
			return i + "st";
		}
		if (j == 2 && k != 12) {
			return i + "nd";
		}
		if (j == 3 && k != 13) {
			return i + "rd";
		}
		return i + "th";
	}
</script>