<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/Deals/".$promoRecord[0]->CondoSeq;?>">
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
							<div class="col-md-2">Category</div>
							<div class="col-md-10"><?php echo $promoRecord[0]->Desc; ?></div>
							<span class="text-danger"><?php echo form_error('Desc'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Title</div>
							<div class="col-md-10"><?php echo $promoRecord[0]->Title; ?></div>
							<span class="text-danger"><?php echo form_error('Title'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Summary</div>
							<div class="col-md-10"><?php echo $promoRecord[0]->Summary; ?></div>
							<span class="text-danger"><?php echo form_error('Summary'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Description</div>
							<div class="col-md-10"><?php echo $promoRecord[0]->Description; ?></div>
							<span class="text-danger"><?php echo form_error('Description'); ?></span>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">Promo Code</div>
							<div class="col-md-10"><?php echo $promoRecord[0]->PromoCode; ?></div>
							<span class="text-danger"><?php echo form_error('PromoCode'); ?></span>
						</div>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/Deals/delete_record/".$promoRecord[0]->PromoID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
        </div>
    </div>
</div>