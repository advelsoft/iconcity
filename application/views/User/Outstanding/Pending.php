<!-- <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Pending Payments</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover footable">
							<thead>
								<tr>
									<th data-class="expand">Payment Reference No.</th>
									<th data-hide="phone,tablet">Biller Code (JomPAY)</th>
									<th data-hide="phone,tablet">JomPAY Ref-1</th>
									<th data-hide="phone,tablet">Amount Selected</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet">Total Bills Selected</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<?php if(count($pending) > 0): { ?>
								<tbody>
									<?php $i = 0?>
									<?php foreach($pending as $item) { ?>
									<?php $i++?>
									<tr>
										<td><?php echo substr($item['bundleRef'], -7); ?></td>
										<td><?php echo $item['billerCode']; ?></td>
										<td><?php echo $item['ref1']; ?></td>
										<td><?php echo number_format(floatval($item['amount']), 2, '.', ''); ?></td>                          
										<td><?php echo date("d-m-Y", strtotime($item['date'])); ?></td>
										<td><?php echo $item['totalBills']; ?></td>
										<td>
											<?php if($item['ref1'] != '') { ?>
												<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
												echo form_open("index.php/Common/Outstanding/ResetRef1/1", $attributes);?>
													<input id="bundleRef" name="bundleRef" type="hidden" value="<?php echo $item['bundleRef']; ?>"/>
													<input type="submit" value="Cancel Payment" class="submit" onclick="return getConfirmation();" />
												<?php echo form_close(); ?>
											<?php } else { ?>
												<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
												echo form_open("index.php/Common/Outstanding/PayInfo", $attributes);?>
													<input id="bundleRef" name="bundleRef" type="hidden" value="<?php echo $item['bundleRef']; ?>"/>
													<input id="amount" name="amount" type="hidden" value="<?php echo $item['amount']; ?>"/>
													<input id="totalBills" name="totalBills" type="hidden" value="<?php echo $item['totalBills']; ?>"/>
													<input type="submit" value="Pay" class="submit" />
												<?php echo form_close(); ?>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot class="footable-pagination">
									<tr>
										<td colspan="7">
											<div><?php echo $this->pagination->create_links();?></div>
										</td>
									</tr>
								</tfoot>
							<?php } ?>
							<?php else: {  ?>
								<tbody>
									<tr><td colspan="7">No Records</td></tr>
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
<?php echo $this->session->flashdata('pending'); ?>
<script>
	function getConfirmation(){	
		var message = "Note: Cancellation of *confirmed JomPAY payments will affect the receipt generation and in turn cause unwanted miscalculations in your account statement.\n\n"+ 
					   "This is due to the GIRO window utilized by JomPAY, which normally takes up to 2 days to be fully processed.\n\n"+
					   "*Confirmed payments are defined as payments authorized via your personal bank account.\n\n";
		var msg = confirm(message);
		if(msg == true){
		  return true;
		}
		else{
		  return false;
		}
	}
</script>
 -->


<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="pending">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover footable">
							<thead>
								<tr>
									<th data-class="expand">No.</th>
									<th data-class="expand">Reference No.</th>
									<th data-hide="phone,tablet">Biller Code (JomPAY)</th>
									<th data-hide="phone,tablet">JomPAY Ref-1</th>
									<th data-hide="phone,tablet">Total Amount</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet">Total Selected Bills</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<?php if(count($pending) > 0): { ?>
								<tbody>
									<?php $i = 0?>
									<?php $num = 1; foreach($pending as $item) { ?>
									<?php $i++?>
									<tr>
										<td><?php echo $num; ?></td>
										<td>#<?php echo substr($item['bundleRef'], -7); ?></td>
										<td><?php if(isset($item['ref1']) && $item['ref1'] != '') { echo $item['billerCode']; } else { echo '-'; } ?></td>
										<td><?php if(isset($item['ref1']) && $item['ref1'] != '') { echo $item['ref1']; } else { echo '-'; } ?></td>
										<td><?php echo number_format(floatval($item['amount']), 2, '.', ''); ?></td>                          
										<td><?php echo date("d-m-Y", strtotime($item['date'])); ?></td>
										<td><?php echo $item['totalBills']; ?></td>
										<td>
											<?php if($item['ref1'] != '') { ?>
												<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
												echo form_open("index.php/Common/Outstanding/ResetRef1/1", $attributes);?>
													<input id="bundleRef" name="bundleRef" type="hidden" value="<?php echo $item['bundleRef']; ?>"/>
													<input type="submit" value="Cancel Payment" class="submit" style="background-color: red;" onclick="return getConfirmation();" /><br>
												<?php echo form_close(); ?>
											<?php } else { ?>
												<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
												echo form_open("index.php/Common/Outstanding/PayInfo", $attributes);?>
													<input id="bundleRef" name="bundleRef" type="hidden" value="<?php echo $item['bundleRef']; ?>"/>
													<input id="amount" name="amount" type="hidden" value="<?php echo $item['amount']; ?>"/>
													<input id="totalBills" name="totalBills" type="hidden" value="<?php echo $item['totalBills']; ?>"/>
													<input type="submit" value="Pay" style="background-color: green;" class="submit" />
												<?php echo form_close(); ?><br>
												<?php $attributes = array("id" => "resetform", "name" => "resetform");
													echo form_open("index.php/Common/Outstanding/ResetRef1/2", $attributes);?>
													<button id="btnReset" class="submit" style="background-color: red;" onclick="return getConfirmation();">Cancel Payment</button>
													<input id="bundleRef" name="bundleRef" type="hidden" value="<?php echo $item['bundleRef']; ?>"/><br>
												<?php echo form_close(); ?>
											<?php } ?>
											
										</td>
									</tr>
									<?php $num++; } ?>
								</tbody>
								<tfoot class="footable-pagination">
									<tr>
										<td colspan="8">
											<div><?php echo $this->pagination->create_links();?></div>
										</td>
									</tr>
								</tfoot>
							<?php } ?>
							<?php else: {  ?>
								<tbody>
									<tr><td colspan="8">No Records</td></tr>
								</tbody>
							<?php } ?>
							<?php endif;?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('pending'); ?>
<script>
	function getConfirmation(){	
		var message = "Note: Cancellation of *confirmed JomPAY payments will affect the receipt generation and in turn cause unwanted miscalculations in your account statement.\n\n"+ 
					   "This is due to the GIRO window utilized by JomPAY, which normally takes up to 2 days to be fully processed.\n\n"+
					   "*Confirmed payments are defined as payments authorized via your personal bank account.\n\n";
		var msg = confirm(message);
		if(msg == true){
		  return true;
		}
		else{
		  return false;
		}
	}
</script>