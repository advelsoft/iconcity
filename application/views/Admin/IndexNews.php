<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="news">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($newsList); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
									<div class="timeline-panel panel-yellow">
										<div class="timeline-heading">
											<h4 class="timeline-title"><?php echo $newsList[$i]->Description; ?></h4>
											<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
												<?php echo date("d-m-Y h:i A", strtotime($newsList[$i]->CreatedDate)); ?>
											</small></p>
										</div>
										<div class="timeline-body">
											<p><?php echo $newsList[$i]->Title; ?></p>
											<p><?php echo $newsList[$i]->Summary; ?></p>
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