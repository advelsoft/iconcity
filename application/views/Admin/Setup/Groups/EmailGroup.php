<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Setup/IndexEmail";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Email Group</h4>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover footable" data-page-size="10">
									<thead>
										<tr>
											<th>Group Name</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i = 0; $i < count($emailGroupList); ++$i) { ?>
										<tr>
											<td><?php echo $emailGroupList[$i]->GROUPNAME; ?></td>
											<td><a href="#" data-toggle="modal" data-target="#editemail<?php echo $emailGroupList[$i]->UID; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
											<!-- Modal -->
											<div class="modal fade" id="editemail<?php echo $emailGroupList[$i]->UID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<?php $attributes = array("id" => "editemailform", "name" => "editemailform");
														echo form_open("index.php/Common/Setup/EmailGroup/".$CondoSeq, $attributes);?>
														<!-- Modal Header -->
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title">Record Will Be Changed</h4>
														</div>
														<!-- Modal Body -->
														<div class="modal-body">
															<div class="form-horizontal">
																<div class="form-group">
																	<label for="GROUPNAME" class="create-label col-md-3">Group Name</label>
																	<div class="col-md-9">
																		<input id="GROUPNAME" name="GROUPNAME" placeholder="Group Name" type="text" class="form-control" value="<?php echo $emailGroupList[$i]->GROUPNAME; ?>" />
																		<span class="text-danger"><?php echo form_error('GROUPNAME'); ?></span>
																		<input id="UID" name="UID" type="hidden" value="<?php echo $emailGroupList[$i]->UID; ?>"/>
																	</div>
																</div>
															</div>
														</div>
														<!-- Modal Footer -->
														<div class="modal-footer">
															<input type="submit" value="Submit" class="submit" />
														</div>
														<?php echo form_close(); ?>
													</div>
												</div>
											</div>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer">
							<a href="#" data-toggle="modal" data-target="#insertemail"><div class="btn btn-sm btn-grey">Insert</div></a>
							<!-- Modal -->
							<div class="modal fade" id="insertemail" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<?php $attributes = array("id" => "insertemailform", "name" => "insertemailform");
										echo form_open("index.php/Common/Setup/EmailGroup/".$CondoSeq, $attributes);?>
										<!-- Modal Header -->
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">Record Will Be Added</h4>
										</div>
										<!-- Modal Body -->
										<div class="modal-body">
											<div class="form-horizontal">
												<div class="form-group">
													<label for="GROUPNAME" class="create-label col-md-3">Group Name</label>
													<div class="col-md-9">
														<input id="GROUPNAME" name="GROUPNAME" placeholder="Group Name" type="text" class="form-control" value="" />
														<span class="text-danger"><?php echo form_error('GROUPNAME'); ?></span>
													</div>
												</div>
											</div>
										</div>
										<!-- Modal Footer -->
										<div class="modal-footer">
											<input type="submit" value="Submit" class="submit" />
										</div>
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Members</h4>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover footable" data-page-size="10">
									<thead>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i = 0; $i < count($membersList); ++$i) { ?>
										<tr>
											<td><?php echo $membersList[$i]->NAME; ?></td>
											<td><?php echo $membersList[$i]->EMAIL; ?></td>
											<td><a href="#" data-toggle="modal" data-target="#editmmbr<?php echo $membersList[$i]->UID; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
											<!-- Modal -->
											<div class="modal fade" id="editmmbr<?php echo $membersList[$i]->UID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<?php $attributes = array("id" => "editmmbrform", "name" => "editmmbrform");
														echo form_open("index.php/Common/Setup/EmailMember/".$CondoSeq, $attributes);?>
														<!-- Modal Header -->
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title">Record Will Be Changed</h4>
														</div>
														<!-- Modal Body -->
														<div class="modal-body">
															<div class="form-horizontal">
																<div class="form-group">
																	<label for="PID" class="create-label col-md-3">PID</label>
																	<div class="col-md-9">
																		<?php $attributes = 'class = "form-control" id = "PID"';
																		echo form_dropdown('PID',$emailGroup,set_value('PID', $membersList[$i]->PID),$attributes);?>
																		<span class="text-danger"><?php echo form_error('PID'); ?></span>
																	</div>
																	<input id="UID" name="UID" type="hidden" value="<?php echo $membersList[$i]->UID; ?>"/>
																</div>
																<div class="form-group">
																	<label for="NAME" class="create-label col-md-3">Name</label>
																	<div class="col-md-9">
																		<input id="NAME" name="NAME" placeholder="Name" type="text" class="form-control" value="<?php echo $membersList[$i]->NAME; ?>" />
																		<span class="text-danger"><?php echo form_error('NAME'); ?></span>
																	</div>
																</div>
																<div class="form-group">
																	<label for="EMAIL" class="create-label col-md-3">Email</label>
																	<div class="col-md-9">
																		<input id="EMAIL" name="EMAIL" placeholder="Email" type="text" class="form-control" value="<?php echo $membersList[$i]->EMAIL; ?>" />
																		<span class="text-danger"><?php echo form_error('EMAIL'); ?></span>
																	</div>
																</div>
															</div>
														</div>
														<!-- Modal Footer -->
														<div class="modal-footer">
															<input type="submit" value="Submit" class="submit" />
														</div>
														<?php echo form_close(); ?>
													</div>
												</div>
											</div>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer">
							<a href="#" data-toggle="modal" data-target="#insertmmbr"><div class="btn btn-sm btn-grey">Insert</div></a>
							<!-- Modal -->
							<div class="modal fade" id="insertmmbr" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<?php $attributes = array("id" => "insertmmbrform", "name" => "insertmmbrform");
										echo form_open("index.php/Common/Setup/EmailMember/".$CondoSeq, $attributes);?>
										<!-- Modal Header -->
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">Record Will Be Added</h4>
										</div>
										<!-- Modal Body -->
										<div class="modal-body">
											<div class="form-horizontal">
												<div class="form-group">
													<label for="PID" class="create-label col-md-3">PID</label>
													<div class="col-md-9">
														<?php $attributes = 'class = "form-control" id = "PID"';
														echo form_dropdown('PID',$emailGroup,set_value('PID'),$attributes);?>
														<span class="text-danger"><?php echo form_error('PID'); ?></span>
													</div>
												</div>
												<div class="form-group">
													<label for="NAME" class="create-label col-md-3">Name</label>
													<div class="col-md-9">
														<input id="NAME" name="NAME" placeholder="Name" type="text" class="form-control" value="" />
														<span class="text-danger"><?php echo form_error('NAME'); ?></span>
													</div>
												</div>
												<div class="form-group">
													<label for="EMAIL" class="create-label col-md-3">Email</label>
													<div class="col-md-9">
														<input id="EMAIL" name="EMAIL" placeholder="Email" type="text" class="form-control" value="" />
														<span class="text-danger"><?php echo form_error('EMAIL'); ?></span>
													</div>
												</div>
											</div>
										</div>
										<!-- Modal Footer -->
										<div class="modal-footer">
											<input type="submit" value="Submit" class="submit" />
										</div>
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div><?php echo $this->session->flashdata('msg'); ?></div>