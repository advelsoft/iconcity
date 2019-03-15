<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Services On-Demand</h4>
				</div>
				<div class="panel-body">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 promosec">
							<div class="promoimg promo-black">
								<a href="<?php echo base_url().'index.php/Common/Promotion/DetailAircon'; ?>" style="text-align:center">
									<img src="http://103.17.211.197/Condo/application/uploads/img/aircon.jpg" style="width: 100%; height: 250px;">
								</a>
								<div class="promotype-black">Aircon On-Demand</div>
							</div>
						</div>
					<!-- <?php for ($i = 0; $i < count($promoCat); ++$i) { ?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 promosec">
							<div class="promoimg promo-black">
								<?php if($promoCat[$i]->CondoSeq == '1'): {?>
									<a href="<?php echo base_url().$promoCat[$i]->PageLink."/".$condoSeq; ?>" style="text-align:center">
										<img src="<?php echo base_url().'application/uploads/promotion/'.$promoCat[$i]->Img; ?>" style="width: 100%; height: 250px;">
									</a>
								<?php } else: {?>
									<a href="<?php echo base_url().$promoCat[$i]->PageLink; ?>" style="text-align:center">
										<img src="<?php echo base_url().'application/uploads/promotion/'.$promoCat[$i]->Img; ?>" style="width: 100%; height: 250px;">
										<?php $this->cart->destroy(); ?>
									</a>
								<?php } endif; ?>
								<div class="promotype-black"><?php echo $promoCat[$i]->Description;?></div>
							</div>
						</div>
					<?php } ?> -->
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>