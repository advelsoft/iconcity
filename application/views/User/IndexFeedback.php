<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="feedback">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($feedbackList); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
									<div class="timeline-panel panel-green">
										<div class="timeline-heading">
											<h4 class="timeline-title"><?php echo $feedbackList[$i]->IncidentType; ?></h4>
											<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
												<?php echo date("d-m-Y h:i A", strtotime($feedbackList[$i]->CreatedDate)); ?>
											</small></p>
										</div>
										<div class="timeline-body">
											<p>Subject: <?php echo $feedbackList[$i]->Subject; ?></p>
											<p>Unit No.: <?php echo $feedbackList[$i]->PropertyNo; ?></p>
											<p style="text-transform: capitalize;">Status: <?php echo $feedbackList[$i]->Status; ?></p>
											<p>Priority: <?php echo $feedbackList[$i]->Priority; ?></p>
											<p><a href="<?php echo base_url()."index.php/Common/".$feedbackList[$i]->Status."Feedbacks/Detail/".$feedbackList[$i]->FeedbackID;?>">View Details</a></p>
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