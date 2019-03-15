<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="promo">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<?php for ($i = 0; $i < count($promoList); ++$i) { ?>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 proimg">
								<?php if ($promoList[$i]->PromoCode != ''): ?>
								<?php { echo '<a class="prothumbnail wrapper" href="'.$promoList[$i]->PromoUrl.'='.$promoList[$i]->PromoCode.'" target="_blank">
											 <div class="image">'.$promoList[$i]->Summary.'</div></a>'; } ?>
								<?php elseif($promoList[$i]->PromoUrl != ''): ?>
								<?php { echo '<a class="prothumbnail wrapper" href="'.$promoList[$i]->PromoUrl.'" target="_blank">
											 <div class="image">'.$promoList[$i]->Summary.'</div></a>'; } ?>
								<?php else: ?>
								<?php { echo '<a class="prothumbnail wrapper"><div class="image">'.$promoList[$i]->Summary.'</div></a>'; } ?>
								<?php endif;?>
								<div class="promoText">
									<b><?php echo $promoList[$i]->Title; ?></b></br>
									<?php echo $promoList[$i]->Introduction; ?></br>
									<b>Promo Ends:</b> <?php echo date("j F Y", strtotime($promoList[$i]->PromoDateTo)); ?>
									<?php if ($promoList[$i]->PromoCode != ''): ?>
									<?php { echo '<p class="promoLink"><a href="'.$promoList[$i]->PromoUrl.'='.$promoList[$i]->PromoCode.'" target="_blank">View Details</a></p>'; } ?>
									<?php elseif($promoList[$i]->PromoUrl != ''): ?>
									<?php { echo '<p class="promoLink"><a href="'.$promoList[$i]->PromoUrl.'" target="_blank">View Details</a></p>'; } ?>
									<?php else: ?>
									<?php { echo '<p class="promoLink"><a href="'.base_url().'index.php/Common/Promotion/Detail/'.$promoList[$i]->PromoID.'">View Details</a></p>'; } ?>
									<?php endif;?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>