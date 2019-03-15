<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Promotion Category</h4>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-striped table-hover footable" data-page-size="10">
								<thead>
									<tr>
										<th>Category</th>
										<th>Page Link</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < count($promoCatList); ++$i) { ?>
									<tr>
										<td><?php echo $promoCatList[$i]->Description; ?></td>
										<td><?php echo $promoCatList[$i]->PageLink; ?></td>
										<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $promoCatList[$i]->PromoCatId; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
										<!-- Modal -->
										<div class="modal fade" id="edit<?php echo $promoCatList[$i]->PromoCatId; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<?php $attributes = array("id" => "editform", "name" => "editform");
													echo form_open_multipart("index.php/Common/PromoCategory/Update/".$promoCatList[$i]->PromoCatId, $attributes);?>
													<!-- Modal Header -->
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title">Record Will Be Changed</h4>
													</div>
													<!-- Modal Body -->
													<div class="modal-body">
														<div class="form-horizontal">
															<div class="form-group">
																<label for="Category" class="create-label col-md-3">Category</label>
																<div class="col-md-9">
																	<input id="Category" name="Category" placeholder="Category" type="text" class="form-control"  value="<?php echo $promoCatList[$i]->Description; ?>" />
																	<span class="text-danger"><?php echo form_error('Category'); ?></span>
																</div>
															</div>
															<div class="form-group">
																<label for="PageLink" class="create-label col-md-3">Page Link</label>
																<div class="col-md-9">
																	<input id="PageLink" name="PageLink" placeholder="PageLink" type="text" class="form-control"  value="<?php echo $promoCatList[$i]->PageLink; ?>" />
																	<span class="text-danger"><?php echo form_error('PageLink'); ?></span>
																</div>
															</div>
															<div class="form-group">
																<label for="Img" class="create-label col-md-3">Picture to Display</label>
																<div class="col-md-9">
																	<input type="file" name="Img" size="20" />
																	<span class="text-danger"><?php echo form_error('Img'); ?></span>
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
										<td><a href="#" data-toggle="modal" data-target="#delete<?php echo $promoCatList[$i]->PromoCatId; ?>"><div class="btn btn-sm btn-grey">Delete</div></a></td>
										<!-- Modal -->
										<div class="modal fade" id="delete<?php echo $promoCatList[$i]->PromoCatId; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<?php $attributes = array("id" => "deleteform", "name" => "deleteform");
													echo form_open_multipart("index.php/Common/PromoCategory/Delete/".$promoCatList[$i]->PromoCatId, $attributes);?>
													<!-- Modal Header -->
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title">Record Will Be Changed</h4>
													</div>
													<!-- Modal Body -->
													<div class="modal-body">
														<div class="form-horizontal">
															<div class="form-group">
																<label for="Category" class="create-label col-md-3">Category</label>
																<div class="col-md-9">
																	<input id="Category" name="Category" placeholder="Category" type="text" class="form-control" value="<?php echo $promoCatList[$i]->Description; ?>" />
																	<span class="text-danger"><?php echo form_error('Category'); ?></span>
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
							</table>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a href="#" data-toggle="modal" data-target="#insert"><div class="btn btn-sm btn-grey">Insert</div></a>
					<!-- Modal -->
					<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<?php $attributes = array("id" => "insertform", "name" => "insertform");
								echo form_open_multipart("index.php/Common/PromoCategory/Create", $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Category" class="create-label col-md-3">Category</label>
											<div class="col-md-9">
												<input id="Category" name="Category" placeholder="Category" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Category'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="PageLink" class="create-label col-md-3">Page Link</label>
											<div class="col-md-9">
												<input id="PageLink" name="PageLink" placeholder="PageLink" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('PageLink'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Img" class="create-label col-md-3">Picture to Display</label>
											<div class="col-md-9">
												<input type="file" name="Img" size="20" />
												<span class="text-danger"><?php echo form_error('Img'); ?></span>
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