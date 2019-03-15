<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="booking">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($bookingList); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
									<div class="timeline-panel panel-blue">
										<div class="timeline-heading">
											<h4 class="timeline-title"><?php echo $bookingList[$i]->Description; ?></h4>
											<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
												<?php echo date("d-m-Y h:i A", strtotime($bookingList[$i]->CreatedDate)); ?>
											</small></p>
										</div>
										<div class="timeline-body">
											<p>Booking Date: <?php echo date("d-m-Y", strtotime($bookingList[$i]->DateFrom)); ?></p>
											<p>Unit No.: <?php echo $bookingList[$i]->PropertyNo; ?></p>
											<p>Status: <?php echo $bookingList[$i]->Status; ?></p>
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