<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Setup/IndexDept";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Department Email List</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Position</th>
									<th>Department</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0; $i < count($deptList); ++$i) { ?>
								<tr>
									<td><?php echo $deptList[$i]->NAME; ?></td>
									<td style='text-transform:none;'><?php echo $deptList[$i]->EMAIL; ?></td>
									<td><?php echo $deptList[$i]->POSITION; ?></td>
									<td><?php echo $deptList[$i]->DEPARTMENT; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $deptList[$i]->UID; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $deptList[$i]->UID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/Setup/DepartmentEmail/".$CondoSeq, $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="NAME" class="create-label col-md-3">Name</label>
															<div class="col-md-9">
																<input id="NAME" name="NAME" placeholder="Name" type="text" class="form-control" value="<?php echo $deptList[$i]->NAME; ?>" />
																<span class="text-danger"><?php echo form_error('NAME'); ?></span>
																<input id="UID" name="UID" type="hidden" value="<?php echo $deptList[$i]->UID; ?>">
															</div>
														</div>
														<div class="form-group">
															<label for="EMAIL" class="create-label col-md-3">Email</label>
															<div class="col-md-9">
																<input id="EMAIL" name="EMAIL" placeholder="No." type="text" class="form-control" value="<?php echo $deptList[$i]->EMAIL; ?>" />
																<span class="text-danger"><?php echo form_error('EMAIL'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="POSITION" class="create-label col-md-3">Position</label>
															<div class="col-md-9">
																<input id="POSITION" name="POSITION" placeholder="Position" type="text" class="form-control" value="<?php echo $deptList[$i]->POSITION; ?>" />
																<span class="text-danger"><?php echo form_error('POSITION'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="DEPARTMENT" class="create-label col-md-3">Department</label>
															<div class="col-md-9">
																<input id="DEPARTMENT" name="DEPARTMENT" placeholder="Department" type="text" class="form-control" value="<?php echo $deptList[$i]->DEPARTMENT; ?>" />
																<span class="text-danger"><?php echo form_error('DEPARTMENT'); ?></span>
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
								echo form_open("index.php/Common/Setup/DepartmentEmail/".$CondoSeq, $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
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
										<div class="form-group">
											<label for="POSITION" class="create-label col-md-3">Position</label>
											<div class="col-md-9">
												<input id="POSITION" name="POSITION" placeholder="Position" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('POSITION'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="DEPARTMENT" class="create-label col-md-3">Department</label>
											<div class="col-md-9">
												<input id="DEPARTMENT" name="DEPARTMENT" placeholder="Department" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('DEPARTMENT'); ?></span>
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