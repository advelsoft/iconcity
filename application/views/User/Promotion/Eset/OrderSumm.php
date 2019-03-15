<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Eset</h4>
				</div>
				<div class="panel-body">
					<h4 class="page-top"><a href="<?php echo base_url()."index.php/Common/Promotion/Eset";?>"><b>Continue Shopping</b></a></h4>
					<table id="tbl" class="table table-striped table-hover table-custom footable">
					<?php if ($cart = $this->cart->contents()): ?>
						<thead>
							<tr>
								<th data-class="expand">Product Image</th>
								<th data-hide="phone">Product Name</th>
								<th data-hide="phone">Product Price</th>
								<th data-hide="phone">Quantity</th>
								<th data-hide="phone">Total Price</th>
								<th data-hide="phone"></th>
							</tr>
						</thead>
						<?php
							$attributes = array("id" => "esetform", "name" => "esetform");
							echo form_open("index.php/Common/Eset/OrderUpdate", $attributes);
							$grand_total = 0; $i = 1;
							foreach ($cart as $item):
								echo form_hidden('cart['. $item['id'] .'][rowid]', $item['rowid']);
								echo form_hidden('cart['. $item['id'] .'][id]', $item['image']);
								echo form_hidden('cart['. $item['id'] .'][name]', $item['name']);
								echo form_hidden('cart['. $item['id'] .'][price]', $item['price']);
								echo form_hidden('cart['. $item['id'] .'][qty]', $item['qty']);
						?>
						<tbody>
							<tr>
								<td class="orderImg"><?php echo $item['image']; ?></td>
								<td><?php echo $item['name']; ?></td>
								<td>RM <?php echo number_format($item['price'],2); ?></td>
								<td><?php echo form_input('cart['. $item['id'] .'][qty]', $item['qty'], 'maxlength="3" size="1" style="text-align: right"'); ?></td>
								<?php $grand_total = $grand_total + $item['subtotal']; ?>
								<td>RM <?php echo number_format($item['subtotal'],2) ?></td>
								<td style="text-decoration: underline;"><?php echo anchor('index.php/Common/Eset/OrderRemove/'.$item['rowid'],'Delete'); ?></td>
								<?php endforeach; ?>
							</tr>
						</tbody>
						<tfoot>
							<td colspan='3'></td>
							<td style='text-align:center;'><input type="submit" value="Update Cart"></td>
							<td style='text-align:center;'>
								<b>Total Amount: </b><span><?php echo number_format((float)$grand_total, 2, '.', ''); ?></span>
							</td>
							<td style='text-align:center;'>
								<input type="button" class="submit" value="Clear Cart" onclick="clear_cart()">
							<?php echo form_close(); ?>
								<input type="button" class="submit" value="Place Order" onclick="place_order()">
							</td>
						</tfoot>
					<?php endif; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function clear_cart() {
	var result = confirm('Are you sure want to clear all bookings?');

	if(result) {
		window.location = "<?php echo base_url(); ?>index.php/Common/Eset/OrderRemove/All";
	}else{
		return false; // cancel button
	}
}

function place_order(){
	window.location = "<?php echo base_url(); ?>index.php/Common/Eset/CheckOut";
}
</script>