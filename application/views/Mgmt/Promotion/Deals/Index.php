<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/Index/".$_SESSION['condoseq'];?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Services On-Demand</h4>
				</div>
				<div class="panel-body">
					<?php for ($i = 0; $i < count($promoList); ++$i) { ?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 promosec">
							<!--Featured-->
							<?php if ($promoList[$i]->Display == '1'): ?>
								<!--URL-->
								<?php if ($promoList[$i]->PromoUrl != ''): ?>
									<div class="promoimg promo-red">
										<?php { echo '<a href="'.$promoList[$i]->PromoUrl.'='.$promoList[$i]->PromoCode.'" target="_blank">'.$promoList[$i]->Summary.'</a>'; } ?>
									</div>
								<!--None-->
								<?php else: ?>
									<div class="promoimg2 promo-red">
										<?php { echo $promoList[$i]->Summary;  ?>
										<?php echo '<div style="text-align:center;"> '; ?>
											<a href="<?php echo base_url()."index.php/Common/Deals/Detail/".$promoList[$i]->PromoID; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="margin-top:10px">Read More</div>
											</a>
										<?php echo '</div>'; } ?>
										<div class="promotype-red"><?php echo $promoList[$i]->Description;?></div>
										<div class="promofeatured"><?php echo 'Featured'?></div>
									</div>
								<?php endif;?>
							<!--Others-->
							<?php else: ?>
							<div class="promoimg promo-black">
								<!--URL-->
								<?php if ($promoList[$i]->PromoUrl != ''): ?>
								<?php { echo '<a href="'.$promoList[$i]->PromoUrl.'='.$promoList[$i]->PromoCode.'" target="_blank">'.$promoList[$i]->Summary.'</a>'; } ?>
								<!--None-->
								<?php else: ?>
								<?php { echo $promoList[$i]->Summary; } ?>
								<?php endif;?>
								<div class="promotype-black"><?php echo $promoList[$i]->Description;?></div>
							</div>
							<div style="text-align:center;">
								<a href="<?php echo base_url()."index.php/Common/Deals/Detail/".$promoList[$i]->PromoID; ?>" style="text-align:center">
									<div class="btn btn-sm btn-grey" style="text-align:center;margin-top:10px">Read More</div>
								</a>
							</div>
							<?php endif;?>
						</div>
					<?php } ?>
					<!--Anti Virus-->
					<?php for ($i = 0; $i < count($antiVirus); ++$i) { ?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 promosec">
							<div class="promoimg promo-black">
								<a href="<?php echo base_url().$antiVirus[$i]->PageLink; ?>" style="text-align:center">
									<img src="<?php echo base_url().'application/uploads/promotion/'.$antiVirus[$i]->Img; ?>" style="width: 100%; height: 300px;">
									<?php $this->cart->destroy(); ?>
								</a>
								<div class="promotype-black"><?php echo $antiVirus[$i]->Description;?></div>
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