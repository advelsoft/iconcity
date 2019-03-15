<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="promo">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="promotion">
							<?php for ($i = 0; $i < count($promoList); ++$i) { ?>
								<li>
									<div class="promotion-panel panel-purple">
										<div class="promotion-heading">
											<h4 class="promotion-title"><?php echo $promoList[$i]->Description; ?></h4>
											<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
												<?php echo date("d-m-Y h:i A", strtotime($promoList[$i]->CreatedDate)); ?>
											</small></p>
										</div>
										<div class="promotion-body">
											<p><?php echo $promoList[$i]->Title; ?></p>
											<div class="promoimg">
												<?php if ($promoList[$i]->PromoUrl != ''): ?>
												<?php { echo '<a href="'.$promoList[$i]->PromoUrl.'='.$promoList[$i]->PromoCode.'" target="_blank">'.$promoList[$i]->Summary.'</a>'; } ?>
												<?php else: ?>
												<?php { echo $promoList[$i]->Summary; } ?>
												<?php endif;?>
											</div>
											<p style="text-align: right;">
												<?php if ($promoList[$i]->PromoUrl != ''): ?>
												<?php { echo '<a href="'.$promoList[$i]->PromoUrl.'='.$promoList[$i]->PromoCode.'" target="_blank">View Details</a>'; } ?>
												<?php else: ?>
												<?php { echo '<a href="'.base_url().'index.php/Common/Promotion/Detail/'.$promoList[$i]->PromoID.'">View Details</a>'; } ?>
												<?php endif;?>
											</p>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>