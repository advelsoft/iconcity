<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Setup/IndexCat";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
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
									<th>Email</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0; $i < count($catList); ++$i) { ?>
								<tr>
									<td><?php echo $catList[$i]->DESCRIPTION; ?></td>
									<td style='text-transform:none;'><?php echo $catList[$i]->EMAIL; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $catList[$i]->UID; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $catList[$i]->UID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/Setup/ComplaintCategories/".$CondoSeq, $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="DESCRIPTION" class="create-label col-md-3">Categories</label>
															<div class="col-md-9">
																<input id="DESCRIPTION" name="DESCRIPTION" placeholder="Categories" type="text" class="form-control" value="<?php echo $catList[$i]->DESCRIPTION; ?>" />
																<span class="text-danger"><?php echo form_error('DESCRIPTION'); ?></span>
																<input id="UID" name="UID" type="hidden" value="<?php echo $catList[$i]->UID; ?>" />
															</div>
														</div>
														<div class="form-group">
															<label for="EMAILID" class="create-label col-md-3">Email</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "EMAILID"';
																echo form_dropdown('EMAILID',$deptEmail,set_value('EMAILID', $catList[$i]->EMAILID),$attributes);?>
																<span class="text-danger"><?php echo form_error('EMAILID'); ?></span>
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
								echo form_open("index.php/Common/Setup/ComplaintCategories/".$CondoSeq, $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="DESCRIPTION" class="create-label col-md-3">Categories</label>
											<div class="col-md-9">
												<input id="DESCRIPTION" name="DESCRIPTION" placeholder="Categories" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('DESCRIPTION'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="EMAILID" class="create-label col-md-3">Email</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "EMAILID"';
												echo form_dropdown('EMAILID',$deptEmail,set_value('EMAILID'),$attributes);?>
												<span class="text-danger"><?php echo form_error('EMAILID'); ?></span>
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