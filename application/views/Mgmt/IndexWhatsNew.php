<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="whatsnew">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($whatsnew); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
									<div class="timeline-panel panel-yellow">
										<?php if($whatsnew[$i]->BookingID != ''): {?>
											<div class="timeline-heading">
												<h4 class="timeline-title"><?php echo $whatsnew[$i]->Description; ?></h4>
												<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
													<?php echo date("d-m-Y h:i A", strtotime($whatsnew[$i]->CreatedDate)); ?>
												</small></p>
											</div>
											<div class="timeline-body">
												<p>Booking Date: <?php echo date("d-m-Y", strtotime($whatsnew[$i]->DateFrom)); ?></p>
												<p>Unit No.: <?php echo $whatsnew[$i]->PropertyNo; ?></p>
												<p>Status: <?php echo $whatsnew[$i]->Status; ?></p>
												<p><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Detail/".$whatsnew[$i]->BookingID;?>">View Details</a></p>
											</div>
										<?php } ?>
										<?php else: {?>
											<div class="timeline-heading">
												<h4 class="timeline-title"><?php echo $whatsnew[$i]->IncidentType; ?></h4>
												<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
													<?php echo date("d-m-Y h:i A", strtotime($whatsnew[$i]->CreatedDate)); ?>
												</small></p>
											</div>
											<div class="timeline-body">
												<p>Subject: <?php echo $whatsnew[$i]->Subject; ?></p>
												<p>Unit No.: <?php echo $whatsnew[$i]->PropNo; ?></p>
												<p>Status: <?php echo $whatsnew[$i]->Progress; ?></p>
												<p>Priority: <?php echo $whatsnew[$i]->Priority; ?></p>
												<p><a href="<?php echo base_url()."index.php/Common/AllFeedbacks/Detail/".$whatsnew[$i]->FeedbackID;?>">View Details</a></p>
											</div>
										<?php } ?>
										<?php endif;?>
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