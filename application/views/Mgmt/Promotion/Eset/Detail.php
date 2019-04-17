<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/BitDefender/".$_SESSION['condoseq'];?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<h2>Products
			<div style="float: right; cursor: pointer;">
				<span class="glyphicon glyphicon-shopping-cart my-cart-icon"><span class="badge badge-notify my-cart-badge"></span></span>
			</div>
		</h2>
		<div class="row">
			<div class="col-md-3 text-center">
				<?php echo $bitdefRecord[0]->ProductImage ;?>
				<br>
				<div class="price">
					Price: <span class="price-old">RM<?php echo $bitdefRecord[0]->NormalPrice ;?></span> <span class="price-new">RM<?php echo $bitdefRecord[0]->PromoPrice ;?></span>
                </div>
				<br>
				<button class="btn btn-danger my-cart-btn" data-id="1" data-name="product 1" data-summary="summary 1" data-price="10" data-quantity="1" data-image="images/img_1.png">Add to Cart</button>
				<a href="#" class="btn btn-info">Details</a>
			</div>
		</div>
	</div>
</div>