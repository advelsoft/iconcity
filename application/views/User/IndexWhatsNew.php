<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="whatsnew">
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
										<!--Facilities Booking-->
										<?php if($whatsnew[$i]->BookingID != ''): {?>
										<div class="timeline-panel panel-blue">
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
										<!--Feedback-->
										<?php elseif($whatsnew[$i]->FeedbackID != ''): {?>
										<div class="timeline-panel panel-green">
											<div class="timeline-heading">
												<h4 class="timeline-title"><?php echo $whatsnew[$i]->IncidentType; ?></h4>
												<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
													<?php echo date("d-m-Y h:i A", strtotime($whatsnew[$i]->CreatedDate)); ?>
												</small></p>
											</div>
											<div class="timeline-body">
												<p>Subject: <?php echo $whatsnew[$i]->FeedSubject; ?></p>
												<p>Unit No.: <?php echo $whatsnew[$i]->PropNo; ?></p>
												<p>Status: <?php echo $whatsnew[$i]->Progress; ?></p>
												<p>Priority: <?php echo $whatsnew[$i]->Priority; ?></p>
												<p><a href="<?php echo base_url()."index.php/Common/".$whatsnew[$i]->Progress."Feedbacks/Detail/".$whatsnew[$i]->FeedbackID;?>">View Details</a></p>
											</div>
										<?php } ?>
										<!--News-->
										<?php elseif($whatsnew[$i]->NewsID != ''): {?>
										<div class="timeline-panel panel-red">
											<div class="timeline-heading">
												<h4 class="timeline-title"><?php echo $whatsnew[$i]->NewsType; ?></h4>
												<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
													<?php echo date("d-m-Y h:i A", strtotime($whatsnew[$i]->CreatedDate)); ?>
												</small></p>
											</div>
											<div class="timeline-body">
												<p><?php echo $whatsnew[$i]->NewsTitle; ?></p>
												<p><?php echo $whatsnew[$i]->NewsSummary; ?></p>
												<p><a href="<?php echo base_url()."index.php/Common/News/Detail/".$whatsnew[$i]->NewsID;?>">View Details</a></p>
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