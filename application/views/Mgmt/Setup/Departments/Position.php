<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Position List</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th>Position</th>
									<th>Department</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($posList as $item) { ?>
								<tr>
									<td><?php echo $item['position']; ?></td>
									<td><?php echo $item['department']; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $item['UID']; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $item['UID']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/Positions/Update/".$item['UID'], $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Department" class="create-label col-md-3">Department</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "Department"';
																echo form_dropdown('Department',$dept,set_value('Department', trim($item['department'])),$attributes);?>
																<span class="text-danger"><?php echo form_error('Department'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="Position" class="create-label col-md-3">Position</label>
															<div class="col-md-9">
																<input id="Position" name="Position" placeholder="Position" type="text" class="form-control" value="<?php echo $item['position']; ?>" />
																<span class="text-danger"><?php echo form_error('Position'); ?></span>
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
									<td><a href="#" data-toggle="modal" data-target="#delete<?php echo $item['UID']; ?>"><div class="btn btn-sm btn-grey">Delete</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="delete<?php echo $item['UID']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "deleteform", "name" => "deleteform");
												echo form_open("index.php/Common/Positions/Delete/".$item['UID'], $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Department" class="create-label col-md-3">Department</label>
															<div class="col-md-9">
																<input id="Department" name="Department" placeholder="Department" type="text" class="form-control" value="<?php echo $item['department']; ?>" />
																<span class="text-danger"><?php echo form_error('Department'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="Position" class="create-label col-md-3">Position</label>
															<div class="col-md-9">
																<input id="Position" name="Position" placeholder="Position" type="text" class="form-control" value="<?php echo $item['position']; ?>" />
																<span class="text-danger"><?php echo form_error('Position'); ?></span>
															</div>
														</div>
													</div>
												</div>
												<!-- Modal Footer -->
												<div class="modal-footer">
													<input type="submit" value="Delete" class="submit" />
												</div>
												<?php echo form_close(); ?>
											</div>
										</div>
									</div>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="4">
										<div><?php echo $this->pagination->create_links();?></div>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<a href="#" data-toggle="modal" data-target="#insert"><div class="btn btn-sm btn-grey">Insert</div></a>
					<!-- Modal -->
					<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<?php $attributes = array("id" => "insertform", "name" => "insertform");
								echo form_open("index.php/Common/Positions/Create", $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Department" class="create-label col-md-3">Department</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "Department"';
												echo form_dropdown('Department',$dept,set_value('Department'),$attributes);?>
												<span class="text-danger"><?php echo form_error('Department'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Position" class="create-label col-md-3">Position</label>
											<div class="col-md-9">
												<input id="Position" name="Position" placeholder="Position" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Position'); ?></span>
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
<div><?php echo $this->session->flashdata('msg'); ?></div>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>