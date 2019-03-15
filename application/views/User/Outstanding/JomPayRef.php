<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>JomPAY Reference</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom">
								<tr>
									<th>Biller Code</th>
									<td>
										<?php echo $jomPayRef['BillerCode']; ?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<b>(PLEASE STATE THIS BILLER CODE WHEN PAYMENT MAKE!)</b>
									</td>
								</tr>
								<tr>
									<th>Ref1</th>
									<td>
										<span id="Ref1"><?php echo $Ref1; ?></span>
										<a href="#" class="copytext" onclick="copyfieldvalue(event, 'Ref1');return false">Click to copy Ref-1</a>
									</td>
								</tr>
								<tr>
									<th>Amount (RM)</th>
									<td><?php echo $jomPayRef['TotalAmt']; ?></td>
								</tr>
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<div class="btn-bottom">
						<a href="<?php if (count($bankLog) != 0): { echo $bankLog[0]->BANKURL; } ?>
								 <?php else: { echo base_url()."index.php/Common/Outstanding/JomPayBank"; } ?>
								 <?php endif;?>"
						target="_blank" style="text-align:center"><div class="btn btn-sm btn-grey" style="text-align:center">Make Payment</div></a>
						<a href="<?php echo base_url()."index.php/User/Home/Index";?>" style="text-align:center">
							<div class="btn btn-sm btn-grey" style="text-align:center">Back To Dashboard</div>
						</a>
					</div>
					</br>
					<div class="btn-bottom">
						<a href="<?php echo base_url()."index.php/Common/Outstanding/JomPayBank";?>" target="_blank" style="text-align:center"><div class="btn btn-sm btn-grey" style="text-align:center">Change Bank</div></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url()."scripts/copytext.js";?>"></script>