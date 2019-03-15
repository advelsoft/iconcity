<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="promo">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($promoList); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
									<div class="timeline-panel panel-purple">
										<div class="timeline-heading">
											<h4 class="timeline-title"><?php echo $promoList[$i]->Description; ?></h4>
											<!--<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
												<?php echo date("d-m-Y h:i A", strtotime($promoList[$i]->CreatedDate)); ?>
											</small></p>--> 
										</div>
										<div class="timeline-body">
											<p><b><?php echo $promoList[$i]->Title; ?></b></p>
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