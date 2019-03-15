<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="feedback">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php if(isset($feedbackList) && $feedbackList != ''){ ?>
								<?php foreach($feedbackList as $item) { ?>
									<?php if ($item['cnt']%2 == 0): ?>
									<?php { echo '<li>'; } ?>
									<?php else: ?>
									<?php { echo '<li class="timeline-inverted">'; } ?>
									<?php endif;?>
										<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
										<div class="timeline-panel panel-green">
											<div class="timeline-heading">
												<h4 class="timeline-title"><?php echo $item['incidentType']; ?></h4>
												<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
													<?php echo date("d-m-Y h:i A", strtotime($item['createdDate'])); ?>
												</small></p>
											</div>
											<div class="timeline-body">
												<p>Subject: <?php echo $item['subject']; ?></p>
												<p>Unit No.: <?php echo $item['propertyNo']; ?></p>
												<p style="text-transform: capitalize;">Status: <?php echo $item['status']; ?></p>
												<p>Priority: <?php echo $item['priority']; ?></p>
												<p><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Detail/".$item['feedbackID'];?>">View Details</a></p>
											</div>
										</div>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
					</div>		
				</div>
			</div>
		</div>
	</div>
</div>