<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/InProgressFeedbacks/Index";?>">
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
						<dd><?php echo $inProgressFeedbacks[0]->Priority; ?></dd>
						
						<dt>Property No</dt>
						<dd><?php echo $inProgressFeedbacks[0]->PropertyNo; ?></dd>
						
						<dt>Incident Type</dt>
						<dd><?php echo $inProgressFeedbacks[0]->IncidentType; ?></dd>
						
						<dt>Subject</dt>
						<dd><?php echo $inProgressFeedbacks[0]->Subject; ?></dd>
						
						<dt>Status</dt>
						<dd><?php echo $inProgressFeedbacks[0]->Status; ?></dd>
						
						<dt>Date Incident</dt>
						<dd><?php echo date("jS F Y", strtotime($inProgressFeedbacks[0]->CreatedDate)); ?></dd>
						
						<dt>Time Incident</dt>
						<dd><?php echo date("h:i A", strtotime($inProgressFeedbacks[0]->CreatedDate)); ?></dd>
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
							<h4><?php echo $inProgressFeedbacks[0]->Subject; ?></h4>
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
										<div class="frwd"><?php { echo $item['frwd'].': '.$item['tech']; } ?> </div>
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
										<?php else: ?>
										<div class="message"> 
											<?php { echo $item['desc']; } ?>
											<?php if (isset($item['attach1'])): ?>
												<div class="files-holder clearfix">
													<a href="<?php echo $item['attach1']; ?>" class="file clearfix" target="_blank">
														<img src="<?php echo $item['attach1']; ?>" width="auto" height="auto">
													</a>
												</div>
											<?php endif;?>
											<?php if (isset($item['attach2'])): ?>
												<div class="files-holder clearfix">
													<a href="<?php echo $item['attach2']; ?>" class="file clearfix" target="_blank">
														<img src="<?php echo $item['attach2']; ?>" width="auto" height="auto">
													</a>
												</div>
											<?php endif;?>
											<?php if (isset($item['attach3'])): ?>
												<div class="files-holder clearfix">
													<a href="<?php echo $item['attach3']; ?>" class="file clearfix" target="_blank">
														<img src="<?php echo $item['attach3']; ?>" width="auto" height="auto">
													</a>
												</div>
											<?php endif;?>
											<?php if (isset($item['attach4'])): ?>
												<div class="files-holder clearfix">
													<a href="<?php echo $item['attach4']; ?>" class="file clearfix" target="_blank">
														<img src="<?php echo $item['attach4']; ?>" width="auto" height="auto">
													</a>
												</div>
											<?php endif;?>
										</div>
										<?php endif;?>
										<div class="date"><?php echo date("d/m/Y, h:i A", strtotime($item['createdDate'])); ?></div>
									</div>
							<?php echo '</div><br><br>'; } ?>
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
						echo form_open_multipart("index.php/Common/InProgressFeedbacks/Detail/".$UID, $attributes);?>
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
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<input type="submit" class="submit" value="SUBMIT REPLY" />
							</div>
						<?php echo form_close(); ?>
						<?php echo $this->session->flashdata('reply'); ?>
					</div>
					<!-- Modal -->
					<div class="modal fade" id="forward" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<?php $attributes = array("id" => "forwardform", "name" => "forwardform");
								echo form_open("index.php/Common/InProgressFeedbacks/SendMail/".$UID, $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Forward To</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="PropertyNo" class="create-label col-md-3">Property No</label>
											<div class="col-md-9">
												<input id="PropertyNo" name="PropertyNo" placeholder="Property No" type="text" class="form-control" value="<?php echo $inProgressFeedbacks[0]->PropertyNo; ?>" readonly />
												<span class="text-danger"><?php echo form_error('PropertyNo'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="AssignTo" class="create-label col-md-3">Technician Name</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "AssignTo"';
												echo form_dropdown('AssignTo',$assignTo,set_value('AssignTo'),$attributes);?>
												<span class="text-danger"><?php echo form_error('AssignTo'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Email" class="create-label col-md-3">Email</label>
											<div class="col-md-9">
												<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="" readonly />
												<span class="text-danger"><?php echo form_error('Email'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Description" class="create-label col-md-3">Description</label>
											<div class="col-md-9">
												<textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
												<span class="text-danger"><?php echo form_error('Description'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Priority" class="create-label col-md-3">Priority</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "Priority"';
												echo form_dropdown('Priority',$priority,set_value('Priority'),$attributes);?>
												<span class="text-danger"><?php echo form_error('Priority'); ?></span>
											</div>
										</div>
									</div>
								</div>
								<!-- Modal Footer -->
								<div class="modal-footer">
									<input type="submit" value="Send Email" class="submit" />
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div><?php echo $this->session->flashdata('email'); ?></div>
	</div>
</div>