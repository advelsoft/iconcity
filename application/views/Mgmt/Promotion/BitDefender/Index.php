<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/Deals/".$_SESSION['condoseq'];?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row" align="center" style="background-color: #000;">
		<img src="<?php echo base_url().'application/uploads/promotion/bitdefender.png'; ?>" alt="Bitdefender" style="margin-bottom: 20px; border: none;">
	</div>
	<div class="cart">
		<div class="heading">
			<?php if ($cart = $this->cart->contents()): ?>
				<?php $grand_total = 0; ?>
				<?php foreach ($cart as $item): ?>
					<?php $grand_total = $grand_total + $item['subtotal']; ?>
				<?php endforeach; ?>
				<h4><span class="glyphicon glyphicon-shopping-cart"></span>
					<a href="<?php echo base_url()."index.php/Common/BitDefender/OrderSumm";?>">
						<span id="cart-total"><?php echo $this->cart->total_items(); ?> item(s) - Total Amount: </b><span>
						<?php echo number_format((float)$grand_total, 2, '.', ''); ?></span>
					</a>
				</h4>
			<?php else: ?>
				<h4><span class="glyphicon glyphicon-shopping-cart"></span> 0 item(s) - Total Amount: RM0.00</h4>
			<?php endif; ?>
		</div>
	</div>
	<div class="row row-header">
		<div class="row">
			<?php for ($i = 0; $i < count($bitdefList); ++$i) { ?>
				<div class="col-md-3 text-center">
					<a href="#" class="btn btn-dark btn-md" data-toggle="modal" data-target="#more">
						<?php echo $bitdefList[$i]->ProductImage ;?>
						<?php echo $bitdefList[$i]->ProductName ;?>
						<div class="price">
							Price: <span class="price-old">RM<?php echo $bitdefList[$i]->NormalPrice ;?></span><span class="price-new"> RM<?php echo $bitdefList[$i]->PromoPrice ;?></span>
						</div>
						<br>
					</a>
					<?php
						$attributes = array("id" => "bitdefenderform", "name" => "bitdefenderform");
						echo form_open("index.php/Common/BitDefender/OrderSumm", $attributes);
							echo form_hidden('id', $bitdefList[$i]->UID);
							echo form_hidden('name', $bitdefList[$i]->ProductName);
							echo form_hidden('image', $bitdefList[$i]->ProductImage);
							echo form_hidden('price', $bitdefList[$i]->PromoPrice);
							echo form_submit('action', 'Add to Cart', 'class="cd-add-to-cart"');
						echo form_close();
					?>
					<div class="modal fade" id="more" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<div class="moreinfo">
										<div class="col-md-4">
											<?php echo $bitdefList[$i]->ProductImage ;?>
										</div>
										<div class="col-md-8">
											<h3><?php echo $bitdefList[$i]->ProductDesc ;?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>