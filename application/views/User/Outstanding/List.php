<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Bill/Outstanding</h4>
				</div>
				<div class="panel-body">
					<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
					echo form_open("index.php/Common/Outstanding/Lists", $attributes);?>
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Doc No</th>
									<th data-hide="phone,tablet">Transaction Date</th>
									<th data-hide="phone,tablet">Description</th>
									<th data-hide="phone,tablet">Due Date</th>
									<th data-hide="phone,tablet">Outstanding Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($osList as $item) { ?>
									<tr>
										<td><?php echo $item['docNo']; ?></td>
										<td><?php echo $item['trxnDate']; ?></td>
										<td style="text-align:left;"><?php echo $item['desc']; ?></td>
										<td><?php echo $item['dueDate']; ?></td>
										<td id="amt"><?php echo number_format(floatval($item['amt']), 2); ?></td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan='4'></td>
									<td style='text-align:center'>
										<b>Total Gross Amount: </b><span id="totalGross"><?php echo number_format((float)$totalGross, 2, '.', ''); ?></span></br>
										<b>Total Unapplied Amount: </b><span id="totalOpen"><?php echo number_format((float)$totalOpen, 2, '.', ''); ?></span></br>
										<b>Net Outstanding: </b><span id="totalNet"></span>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<div><?php echo $this->pagination->create_links();?></div>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<?php echo form_close(); ?>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script language="Javascript">
	var totalGross = document.getElementById("totalGross").innerHTML;
	var totalOpen = document.getElementById("totalOpen").innerHTML;
	var totalNet = parseFloat(totalGross)+parseFloat(totalOpen);
	document.getElementById("totalNet").innerHTML = totalNet.toFixed(2);
	
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>