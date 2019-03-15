<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Promotion</h4>
				</div>
				<div class="panel-body">
					<?php for ($i = 0; $i < count($promoCat); ++$i) { ?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 promosec">
							<div class="promoimg promo-black">
								<a href="<?php echo base_url().$promoCat[$i]->PageLink."/".$condoSeq; ?>" style="text-align:center">
									<img src="<?php echo base_url().'application/uploads/promotion/'.$promoCat[$i]->Img; ?>" style="width: 100%; height: 250px;">
								</a>
								<div class="promotype-black"><?php echo $promoCat[$i]->Description;?></div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>