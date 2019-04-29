<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in" id="os">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<ul class="timeline">
							<?php for ($i = 0; $i < count($oshistory); ++$i) { ?>
								<?php if ($i%2 == 0): ?>
								<?php { echo '<li>'; } ?>
								<?php else: ?>
								<?php { echo '<li class="timeline-inverted">'; } ?>
								<?php endif;?>
									<div class="timeline-badge"><i class="glyphicon glyphicon-ok"></i></div>
									<div class="timeline-panel panel-orange">
										<div class="timeline-heading">
											<h4 class="timeline-title">New Payment Receipt</h4>
											<!-- <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;
												<?php echo date("d-m-Y", strtotime($oshistory[$i]->DATEUPDATED)); ?>
											</small></p> -->
										</div>
										<div class="timeline-body">
											<p>Receipt No.: <?php echo $oshistory[$i]['receiptno']; ?></p>
											<p>Description: <?php echo $oshistory[$i]['desc']; ?></p>
											<p>Amount Paid: <?php echo 'RM '.$oshistory[$i]['amt']; ?></p>
											<p>Date of Payment: <?php echo date("d/m/Y", strtotime($oshistory[$i]['datepaid'])); ?></p>
											<p><a href="<?php echo base_url()."index.php/Common/Outstanding/History";?>">View Details</a></p>
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