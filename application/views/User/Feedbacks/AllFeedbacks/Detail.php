<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/AllFeedbacks/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Feedbacks/Requests Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Priority</dt>
						<dd><?php echo $allFeedbacks[0]->Priority; ?></dd>
						
						<dt>Property No</dt>
						<dd><?php echo $allFeedbacks[0]->PropertyNo; ?></dd>
						
						<dt>Incident Type</dt>
						<dd><?php echo $allFeedbacks[0]->IncidentType; ?></dd>
						
						<dt>Subject</dt>
						<dd><?php echo $allFeedbacks[0]->Subject; ?></dd>
						
						<dt>Status</dt>
						<dd><?php echo $allFeedbacks[0]->Status; ?></dd>
						
						<dt>Date Incident</dt>
						<dd><?php echo date("jS F Y", strtotime($allFeedbacks[0]->CreatedDate)); ?></dd>
						
						<dt>Time Incident</dt>
						<dd><?php echo date("h:i A", strtotime($allFeedbacks[0]->CreatedDate)); ?></dd>
					</dl>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4><?php echo $allFeedbacks[0]->Subject; ?></h4>
						</div>
						<div class="panel-body">
							<?php foreach($replyFeedbacks as $item) { ?>
								<?php if ($item['createdBy'] == $_SESSION['username']): ?>
								<?php { echo '<div class="ticket-message message-right first clearfix">'; } ?>
								<?php else: ?>
								<?php { echo '<div class="ticket-message message-left first clearfix">'; } ?>
								<?php endif;?>
									<div class="text">
										<?php if ($item['frwd'] != ''): ?>
											<!--<div class="frwd"><?php { echo $item['frwd'].': '.$item['tech']; } ?> </div>-->
											<div class="message">
												<div align="left">
													<b><?php { echo $item['frwd'].': '.$item['tech']; } ?></b>
												</div>
												<?php { echo $item['desc']; } ?>
												<?php if (isset($item['attach1'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach1'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
												<?php if (isset($item['attach2'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach2'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
												<?php if (isset($item['attach3'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach3'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
												<?php if (isset($item['attach4'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach4'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
											</div>
										<?php else: ?>
											<div class="message">
												<?php { echo $item['desc']; } ?>
												<?php if (isset($item['attach1'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach1'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
												<?php if (isset($item['attach2'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach2'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
												<?php if (isset($item['attach3'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach3'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
												<?php if (isset($item['attach4'])): ?>
													<div class="files-holder clearfix">
														<a href="<?php echo base_url().'application/uploads/feedback/'.$item['attach4'];?>" class="file clearfix" target="_blank">
															<i class="glyphicon glyphicon-file"></i>
														</a>
													</div>
												<?php endif;?>
											</div>
										<?php endif;?>
										<div class="date"><?php echo date("d/m/Y, h:i A", strtotime($item['createdDate'])); ?></div>
									</div>
							<?php echo '</div>'; } ?>
						</div>
						<div class="panel-footer">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>New Reply</h4>
						</div>
						<?php $attributes = array("id" => "feedbackform", "name" => "feedbackform");
						echo form_open_multipart("index.php/Common/AllFeedbacks/Detail/".$UID, $attributes);?>
							<div class="panel-body">
								<div class="form-horizontal">
									<div class="col-md-12">
										<div class="form-group">
											<div class="col-md-12">
												<textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
												<span class="text-danger"><?php echo form_error('Description'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Attachment1" class="create-label col-md-2">Attachment</label>
											<div class="col-md-10 field_wrapper">
												<input class="col-md-5" type="file" name="Attachment1" value=""/>
												<a href="javascript:void(0);" class="add_button col-md-5" title="Add field"><img src="<?php echo base_url()."content/img/add-icon.png";?>" /></a>
												<span class="text-danger"><?php echo form_error('Attachment1'); ?></span>
												<input id="propNo" name="propNo" type="hidden" value="<?php echo $allFeedbacks[0]->PropertyNo; ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<input type="submit" class="submit" value="SUBMIT REPLY" />
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('reply'); ?>
<?php echo $this->session->flashdata('email'); ?>