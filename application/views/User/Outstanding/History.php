<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Payment History</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Receipt No</th>
									<th data-hide="phone,tablet">Description (Ref1)</th>
									<th data-hide="phone,tablet">Amount Paid</th>
									<th data-hide="phone,tablet">Date of Payment</th>
									<th data-hide="phone,tablet">Receipt</th>
								</tr>
							</thead>
							<?php if(count($osHistory) > 0): { ?>
								<tbody>
									<?php $i = 0?>
									<?php foreach($osHistory as $item) { ?>
									<?php $i++?>
									<tr>
										<td id="receiptno"><?php echo $item['receiptno']; ?></td>
										<td><?php echo 'Ref1 #'.$item['desc']; ?></td>
										<td><?php echo number_format(floatval($item['amt']), 2, '.', ''); ?></td>                          
										<td><?php echo date("d-m-Y", strtotime($item['datepaid'])); ?></td>
										<td>
											<?php $attributes = array("id" => "receiptform", "name" => "receiptform", "target" => "_blank");
											echo form_open("index.php/Common/Outstanding/GenerateHistory/".$item['receiptno'], $attributes);?>
												<button id="<?php echo 'buttonRow'.$i?>" name="<?php echo $item['receiptno']; ?>" class="btn btn-sm btn-grey" style="color: white; text-transform: uppercase;">Print Receipt</button>
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
<?php echo $this->session->flashdata('history'); ?>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
	
	for (var r = 1; r < tbl.rows.length-1; r++) {
		var receiptNo = tbl.rows[r].cells[0].innerHTML;
		if(receiptNo == "" || /^\s*$/.test(receiptNo)){
			//remove row when no data to display
			$('#buttonRow'+r).hide();
		}
	}
	
	function generateReceipt(text) {
		try{
			var index = text.name.indexOf("_");
			var name = text.name.substring(index+1);
			document.getElementById("ReceiptNo").value = name.trim();
			document.historyform.action = document.getElementById("hdnPrintReceipt").value;
			document.historyform.target = "_blank";
			document.historyform.submit();
		}catch(e){alert(e)}
	}
</script>