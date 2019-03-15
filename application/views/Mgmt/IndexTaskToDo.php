<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="tasktodo">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($tasktodo); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
										<!--Facilities Booking-->
										<?php if($tasktodo[$i]->BookingID != ''): {?>
											<div class="timeline-panel panel-blue">
												<div class="timeline-heading">
													<h4 class="timeline-title"><?php echo $tasktodo[$i]->Description; ?></h4>
													<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
														<?php echo date("d-m-Y h:i A", strtotime($tasktodo[$i]->CreatedDate)); ?>
													</small></p>
												</div>
												<div class="timeline-body">
													<p>Booking Date: <?php echo date("d-m-Y", strtotime($tasktodo[$i]->DateFrom)); ?></p>
													<p>Unit No.: <?php echo $tasktodo[$i]->PropertyNo; ?></p>
													<p>Status: <?php echo $tasktodo[$i]->Status; ?></p>
													<p><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Detail/".$tasktodo[$i]->BookingID;?>">View Details</a></p>
												</div>
										<?php } ?>
										<!--Feedback-->
										<?php else: {?>
											<div class="timeline-panel panel-green">
												<div class="timeline-heading">
													<h4 class="timeline-title"><?php echo $tasktodo[$i]->IncidentType; ?></h4>
													<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
														<?php echo date("d-m-Y h:i A", strtotime($tasktodo[$i]->CreatedDate)); ?>
													</small></p>
												</div>
												<div class="timeline-body">
													<p>Subject: <?php echo $tasktodo[$i]->FeedSubject; ?></p>
													<p>Unit No.: <?php echo $tasktodo[$i]->PropNo; ?></p>
													<p style="text-transform: capitalize;">Status: <?php echo $tasktodo[$i]->Progress; ?></p>
													<p>Priority: <?php echo $tasktodo[$i]->Priority; ?></p>
													<p><a href="<?php echo base_url()."index.php/Common/".$tasktodo[$i]->Progress."Feedbacks/Detail/".$tasktodo[$i]->FeedbackID;?>">View Details</a></p>
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