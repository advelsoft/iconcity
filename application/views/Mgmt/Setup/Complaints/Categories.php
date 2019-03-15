<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Categories</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th>Categories</th>
									<th>Department</th>
									<th>Email</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0; $i < count($catList); ++$i) { ?>
								<tr>
									<td><?php echo $catList[$i]->Categories; ?></td>
									<td><?php echo $catList[$i]->Department; ?></td>
									<td style='text-transform:none;'><?php echo $catList[$i]->Email; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $catList[$i]->UID; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $catList[$i]->UID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/Categories/Update/".$catList[$i]->UID, $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Categories" class="create-label col-md-3">Categories</label>
															<div class="col-md-9">
																<input id="Categories" name="Categories" placeholder="Categories" type="text" class="form-control" value="<?php echo $catList[$i]->Categories; ?>" />
																<span class="text-danger"><?php echo form_error('Categories'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="Department" class="create-label col-md-3">Department</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "DepartmentEU"';
																echo form_dropdown('Department',$department,set_value('Department'),$attributes);?>
																<span class="text-danger"><?php echo form_error('Department'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="EmailID" class="create-label col-md-3">Email</label>
															<div class="col-md-9">
																<select id="EmailU" name="Email"></select>
																<span class="text-danger"><?php echo form_error('Email'); ?></span>
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
									<td><a href="#" data-toggle="modal" data-target="#delete<?php echo $catList[$i]->UID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="delete<?php echo $catList[$i]->UID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "deleteform", "name" => "deleteform");
												echo form_open("index.php/Common/Categories/Delete".$catList[$i]->UID, $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Categories" class="create-label col-md-3">Categories</label>
															<div class="col-md-9">
																<input id="Categories" name="Categories" placeholder="Categories" type="text" class="form-control" value="<?php echo $catList[$i]->Categories; ?>" />
																<span class="text-danger"><?php echo form_error('Categories'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="Department" class="create-label col-md-3">Department</label>
															<div class="col-md-9">
																<input id="Department" name="Department" placeholder="Department" type="text" class="form-control" value="<?php echo $catList[$i]->Department; ?>" />
																<span class="text-danger"><?php echo form_error('Department'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="Email" class="create-label col-md-3">Email</label>
															<div class="col-md-9">
																<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="<?php echo $catList[$i]->Email; ?>" />
																<span class="text-danger"><?php echo form_error('Email'); ?></span>
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
					<a href="#" data-toggle="modal" data-target="#insert"><div class="btn btn-sm btn-grey">Insert</div></a>
					<!-- Modal -->
					<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<?php $attributes = array("id" => "insertform", "name" => "insertform");
								echo form_open("index.php/Common/Categories/Create", $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Categories" class="create-label col-md-3">Categories</label>
											<div class="col-md-9">
												<input id="Categories" name="Categories" placeholder="Categories" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Categories'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Department" class="create-label col-md-3">Department</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "DepartmentEI"';
												echo form_dropdown('Department',$department,set_value('Department'),$attributes);?>
												<span class="text-danger"><?php echo form_error('Department'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Email" class="create-label col-md-3">Email</label>
											<div class="col-md-9">
												<select id="EmailI" name="Email"></select>
												<span class="text-danger"><?php echo form_error('Email'); ?></span>
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