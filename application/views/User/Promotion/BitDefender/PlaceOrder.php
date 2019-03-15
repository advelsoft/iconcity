<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/BitDefender/OrderSumm";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to Order List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>CheckOut</h4>
				</div>
				<div class="panel-body">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<!--<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">Payment Method</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									Please bank-in cheque, cash or Internet Banking to the following account:<br><br>
									<b>Bank : Public Bank.  | A/C: 3184460105 | Payee: Advelsoft Technologies (M) Sdn. Bhd.</b><br><br>
									-------------------------------------------------------------------------------------------------------------------------<br><br>
									Please send us the payment details of:<br><br>
									<b>1. Bank Name<br>
									2. Banking Date/Time<br>
									3. Banking Reference No<br>
									4. Total amount you have paid<br>
									5. Your Order No<br>
									6. End User / Company Name</b><br><br><br>
									You may send the above info to: <a href="mailto:hariana@advelsoft.com.my"><b>hariana@advelsoft.com.my</b></a> or WhatApps to Mobile no: <b>+60123456789</b>. 
									Your purchases will not be delivered until the above information are received.
								</div>
								<div class="panel-footer" style="text-align: right;">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
										<input type="button" class="submit" value="Continue">
									</a>
								</div>
							</div>
						</div>-->
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">Order Details</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									<table class="table table-striped table-hover table-custom footable">
										<thead>
											<tr style="text-align: center;">
												<td><b>Product Name</b></td>
												<td><b>Quantity</b></td>
												<td><b>Price</b></td>
												<td><b>Total</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$grand_total = 0;
											if ($cart = $this->cart->contents()):
												foreach ($cart as $item):
													$grand_total = $grand_total + $item['subtotal'];
													echo '<tr>';
													echo '<td class="name">'.$item['name'].'</td>';
													echo '<td class="quantity">'.$item['qty'].'</td>';
													echo '<td class="price">RM'.number_format($item['price'],2).'</td>';
													echo '<td class="total">RM'.number_format($item['subtotal'],2).'</td>';
													echo '</tr>';
												endforeach;
											endif;
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="3"></td>
												<td style="text-align: center;"><b>Total: <?php echo number_format($grand_total,2); ?></b></td>
											</tr>      
										</tfoot>
									</table>
								</div>
								<div class="panel-footer" style="text-align: right;">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<input type="button" class="submit" value="Continue">
									</a>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title">Your Personal Details</h4>
							</div>
							<?php $attributes = array("id" => "orderform", "name" => "orderform");
							echo form_open("index.php/Common/BitDefender/PlaceOrder", $attributes); ?>
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Phone" class="create-label col-md-2">Phone No.</label>
											<div class="col-md-10">
												<input id="Phone" name="Phone" placeholder="Phone No." type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Phone'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Email" class="create-label col-md-2">Email</label>
											<div class="col-md-10">
												<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Email'); ?></span>
											</div>
										</div>
									</div>
									<div>
										<b>Please transfer the total amount to the following bank account. Your order will not ship until we receive payment.</b>
									</div>
								</div>
								<div class="panel-footer" style="text-align: right;">
									<input type="submit" id="Submit" name="Submit" value="Confirm Order" class="submit" />
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>