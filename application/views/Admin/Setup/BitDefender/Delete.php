<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/BitDefender";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
    <div class="row row-header">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Are you sure want to delete this?</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<div class="col-md-12">
							<div class="col-md-2">Product Name</div>
							<div class="col-md-10"><?php echo $bitdefRecord[0]->ProductName; ?></div>
							<span class="text-danger"><?php echo form_error('ProductName'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Product Image</div>
							<div class="col-md-10"><?php echo $bitdefRecord[0]->ProductImage; ?></div>
							<span class="text-danger"><?php echo form_error('ProductImage'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Description</div>
							<div class="col-md-10"><?php echo $bitdefRecord[0]->ProductDesc; ?></div>
							<span class="text-danger"><?php echo form_error('Description'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Normal Price</div>
							<div class="col-md-10"><?php echo $bitdefRecord[0]->NormalPrice; ?></div>
							<span class="text-danger"><?php echo form_error('NormalPrice'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Promo Date</div>
							<div class="col-md-10"><?php echo date("d-m-Y", strtotime($bitdefRecord[0]->PromoDate)); ?></div>
							<span class="text-danger"><?php echo form_error('PromoDate'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Promo Price</div>
							<div class="col-md-10"><?php echo $bitdefRecord[0]->PromoPrice; ?></div>
							<span class="text-danger"><?php echo form_error('PromoPrice'); ?></span>
						</div>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/BitDefender/delete_record/".$bitdefRecord[0]->UID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
        </div>
    </div>
</div>