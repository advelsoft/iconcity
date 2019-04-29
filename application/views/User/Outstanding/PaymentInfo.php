<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
	.selected{
	   	border: 3px solid green;
  		margin: 0;
  		border-radius: 12px;
	}
</style>
<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Payment Summary</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom">
							<!--Reset-->
							<!-- <tr>
								<th>Reference No.</th>
								<td>
									<?php echo $bundleRef; ?>
								</td>
							</tr> -->
							<tr>
								<th>Total Amount (RM)</th>
								<td><?php echo $amount; ?></td>
							</tr>
							<tr>
								<th>Selected Bills</th>
								<td><?php echo $totalBills; ?></td>
							</tr>
						</table>
						<div class="table-responsive">
							<h4 class="modal-title" name="title" id="title">Please choose your payment method</h4>
							<table class="table table-striped table-hover table-custom">
								<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
								echo form_open("index.php/Common/Outstanding/PayInfo", $attributes);?>
									<tr>
										<td>
												<?php $jompay = $_SESSION['ResidentJompay']; if(isset($jompay) && $_SESSION['ResidentJompay']){ ?>
												<div class="col-lg-4">
													<a href="#"><img width="80%" id="jompayimg" onclick="choosepayment('1')" src="<?php echo base_url()."content/img/payment/jompay.png";?>"></a>
												</div>
												<?php } ?>
												<?php $revpay = $_SESSION['ResidentRevpay']; if(isset($revpay) && $_SESSION['ResidentRevpay']){ ?>
													<div class="col-lg-4">
														<a href="#"><img width="80%" id="visaimg" onclick="choosepayment('2')" src="<?php echo base_url()."content/img/payment/creditdebit.png";?>"></a>
													</div>
													<div class="col-lg-4">
														<a href="#"><img width="80%" id="fpximg" onclick="choosepayment('3')" src="<?php echo base_url()."content/img/payment/fpx.png";?>"></a>
													</div>
												<?php } ?>
										</td>
									</tr>
									<tr>
										<td><br><input type="submit" value="Submit" style="background-color: green;" class="submit pull-right" /></td>
									</tr>
									<input id="UserTokenNo" name="UserTokenNo" type="hidden" value="2YC9OMDXE0"/>
									<input id="BundleReference" name="BundleReference" type="hidden" value="<?php echo $bundleRef; ?>"/>
									<input id="amount" name="amount" type="hidden" value="<?php echo $amount; ?>"/>
									<input id="CondoSeqNo" name="CondoSeqNo" type="hidden" value="<?php echo $_SESSION['condoseq']; ?>"/>
									<input id="UnitSeqNo" name="UnitSeqNo" type="hidden" value="<?php echo $userDetail['UnitSeqNo']; ?>"/>
									<input id="UserIdNo" name="UserIdNo" type="hidden" value="<?php echo $_SESSION['userid']; ?>"/>
									<input id="CustType" name="CustType" type="hidden" value="<?php echo $userDetail['CustType']; ?>"/>
									<input id="customer_name" name="customer_name" type="hidden" value="<?php echo $userDetail['customer_name']; ?>"/>
									<input id="customer_email" name="customer_email" type="hidden" value="<?php echo $userDetail['customer_email']; ?>"/>
									<input id="name" name="name" type="hidden" value="Utility"/>
									<input id="description" name="description" type="hidden" value="Utility Description"/>
									<input id="Payment_ID" name="Payment_ID" type="hidden" value=""/>
									<input id="merchant_pointer" name="merchant_pointer" type="hidden" value="CondoDefault"/>
									<input id="return_url" name="return_url" type="hidden" value="<?php echo base_url('/index.php/Common/Outstanding/PayStatus'); ?>"/>
								<?php echo form_close(); ?>
							</table>
						</div>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#jompayimg").click(function() {
	    $('#visaimg').removeClass('selected'); // removes the previous selected class
	    $('#fpximg').removeClass('selected'); // removes the previous selected class
   		$(this).addClass('selected'); // adds the class to the clicked image
	});
	$("#visaimg").click(function() {
	    $('#jompayimg').removeClass('selected'); // removes the previous selected class
	    $('#fpximg').removeClass('selected'); // removes the previous selected class
   		$(this).addClass('selected'); // adds the class to the clicked image
	});
	$("#fpximg").click(function() {
	    $('#jompayimg').removeClass('selected'); // removes the previous selected class
	    $('#visaimg').removeClass('selected'); // removes the previous selected class
   		$(this).addClass('selected'); // adds the class to the clicked image
	});
	function choosepayment(element) {
		var base = '<?php echo base_url(); ?>';
		if(element == '1'){
			document.forms['outstandingform'].action = base+"index.php/Common/Outstanding/Create";
		}
		else if(element == '2'){
			document.forms['outstandingform'].action = "http://manage.wyapp.my/revpay/bill/pay/web";
			document.getElementById('Payment_ID').value = '2';
		}
		else if(element == '3'){
			document.forms['outstandingform'].action = "http://manage.wyapp.my/revpay/bill/pay/web";
			document.getElementById('Payment_ID').value = '3';
		}
	}
	
	function getConfirmation(){	
		var msg = confirm("Do you want to continue?");
		if(msg == true){
		  return true;
		}
		else{
		  return false;
		}
	}
</script>