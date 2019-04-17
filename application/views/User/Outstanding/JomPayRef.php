<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<a href="#"><img width="5%" style="margin-left: 10px;" src="<?php echo base_url()."content/img/payment/jompay-logo.png";?>"></a>
						<span style="font-size: 16px;">JomPAY Payment Reference</span>
						<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
							echo form_open("index.php/Common/Outstanding/ResetRef1/1", $attributes);?>
								<input id="bundleRef" name="bundleRef" type="hidden" value="<?php echo $bundleRef; ?>"/>
								<input type="submit" value="Cancel Jompay" class="btn btn-sm btn-red pull-right" style="margin-right: 10px; background-color: red;" onclick="return getConfirmation();" />
							<?php echo form_close(); ?>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom">
							<tr>
								<th class="col-lg-4">
									Biller Code
								</th>
								<td class="col-lg-8">
									<?php echo $billerCode; ?> 
									<b> (STATE BILLER CODE WHEN MAKE PAYMENT)</b>
								</td>
							</tr>
							<tr>
								<th class="col-lg-4">Ref-1</th>
								<td class="col-lg-8">
									<span id="Ref1"><?php echo $ref1; ?></span>
									<a href="#" class="copytext" onclick="copyfieldvalue(event, 'Ref1');return false">Click to copy Ref-1</a>
								</td>
							</tr>
							<tr>
								<th class="col-lg-4">Total Amount (RM)</th>
								<td class="col-lg-8"><?php echo $amount; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<p class="col-lg-6"><b>JomPAY online at Internet and Mobile Banking with your Current, Savings or Credit Card account.</b></p>
					<div class="btn-bottom">
						<a href="<?php if (count($bankLog) != 0): { echo $bankLog[0]->BANKURL; } ?>
								 <?php else: { echo base_url()."index.php/Common/Outstanding/JomPayBank"; } ?>
								 <?php endif;?>"
						target="_blank" style="text-align:center"><div class="btn btn-sm btn-grey" style="text-align:center; background-color: green;">Make Payment</div></a>
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
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>JomPAY Payment Guides</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-custom">
						<tr><td><a href="https://www.youtube.com/watch?v=IVCxankxp2k" target="_blank">JomPAY Introduction</a></td></tr>
						<tr><td><a href="https://www.youtube.com/watch?v=IAahTJq16l8k" target="_blank">AmBank</a></td></tr>
						<tr><td><a href="https://www.youtube.com/watch?v=keQu52UZa80" target="_blank">Maybank</a></td></tr>
						<tr><td><a href="https://www.youtube.com/watch?v=S8nHnK0IwFs" target="_blank">CIMB</a></td></tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default" style="background-color: #ffe34d;">
				<div class="panel-body">
					<h4>It takes up to 3 working days to process Jompay.</h4>
					<h4>Wait patiently for the payment status to be updated if you have made the payment.</h4>
					<h4>Otherwise, cancel Jompay if you wished to pay via other payment method.</h4>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url()."scripts/copytext.js";?>"></script>
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