<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="outstanding">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="padding: 15px;">
						<h4><b>* Select Doc No for payment</b></h4>
						<div class="table-responsive">
							<table id="tbl" class="table table-striped table-hover footable">
								<thead>
									<tr>
										<th data-class="expand">No.</th>
										<th data-class="expand">Doc No.</th>
										<th data-hide="phone">Transaction Date</th>
										<th data-hide="phone">Description</th>
										<th data-hide="phone">Due Date</th>
										<th data-hide="phone">Outstanding Amount</th>
										<th><input type="checkbox" class="selectAll" id="selectall">&nbsp;Select/Unselect All</th>
									</tr>
								</thead>
								<?php if(count($osList) > 0) { ?>
									<tbody>
										<?php $num = 1; foreach($osList as $item) { ?>
											<tr>
												<td><?php echo $num; ?></td>
												<td id="docNo"><?php echo $item['docNo']; ?></td>
												<td><?php echo $item['trxnDate']; ?></td>
												<td style="text-align:left;"><?php echo $item['desc']; ?></td>
												<td><?php echo $item['dueDate']; ?></td>
												<td id="amt"><?php echo number_format(floatval($item['amt']), 2, '.', ''); ?></td>
												<td name="selectBox"><input type="checkbox" class="selectAll" name="selectData"><label name="selectLbl" /></td>
											</tr>
										<?php $num++; } ?>
									</tbody>
									<tfoot class="footable-pagination">
										<tr>
											<td colspan='5'></td>
											<td style='text-align:left'>
												<b>Total Gross Amount: </b><span id="totalGross"><?php echo number_format((float)$totalGross, 2, '.', ''); ?></span></br>
												<b>Total Unapplied Amount: </b><span id="totalOpen"><?php echo number_format((float)$totalOpen, 2, '.', ''); ?></span></br>
												<b>Net Outstanding: </b><span id="totalNet"></span>
											</td>
											<td colspan='2' style='text-align:left'><b>Total Selected Amount: </b><span id="ttlSelect">0.00</span></td>
										</tr>
										<tr>
											<td colspan="6"></td>
											<!--Submit-->
											<?php $jompay = $_SESSION['ResidentJompay']; $revpay = $_SESSION['ResidentRevpay']; if((isset($jompay) && $_SESSION['ResidentJompay']) || (isset($revpay) && $_SESSION['ResidentRevpay'])){
												$attributes = array("id" => "outstandingform", "name" => "outstandingform");
												echo form_open("index.php/Common/Outstanding/PayInfo", $attributes);
											} ?>
											<td>
												<input type="submit" value="Submit" style="background-color: green;" class="submit" onclick="return submitConfirm();" />
												<input id="tmpDocNo" name="tmpDocNo" type="hidden" value=""/>
												<input id="tmpTtlSelect" name="tmpTtlSelect" type="hidden" value=""/>
												<input id="tmpCustType" name="tmpCustType" type="hidden" value="<?php if(isset($item['custType'])){ echo $item['custType']; } ?>"/>
												<input id="jompay" name="jompay" type="hidden" value="<?php echo $company[0]->JomPay; ?>"/>
											<?php $jompay = $_SESSION['ResidentJompay']; $revpay = $_SESSION['ResidentRevpay']; if((isset($jompay) && $_SESSION['ResidentJompay']) || (isset($revpay) && $_SESSION['ResidentRevpay'])){ echo form_close(); } ?>
											</td>
										</tr>
									</tfoot>
								<?php } else {  ?>
									<tbody>
										<tr><td colspan="9">No Records</td></tr>
									</tbody>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
