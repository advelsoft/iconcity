<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Item Group List</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th>Item Group</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($groupList as $item) { ?>
								<tr>
									<td><?php echo $item['groupName']; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $item['groupID']; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $item['groupID']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/ItemList/GroupUpdate/".$item['groupID'], $attributes);?>
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="GroupName" class="create-label col-md-3">Group Name</label>
															<div class="col-md-9">
																<input id="GroupName" name="GroupName" placeholder="Group Name" type="text" class="form-control" value="<?php echo $item['groupName']; ?>" />
																<span class="text-danger"><?php echo form_error('GroupName'); ?></span>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="submit" value="Submit" class="submit" />
												</div>
												<?php echo form_close(); ?>
											</div>
										</div>
									</div>
									<td><a href="#" data-toggle="modal" data-target="#delete<?php echo $item['groupID']; ?>"><div class="btn btn-sm btn-grey">Delete</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="delete<?php echo $item['groupID']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "deleteform", "name" => "deleteform");
												echo form_open("index.php/Common/ItemList/GroupDelete/".$item['groupID'], $attributes);?>
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="GroupName" class="create-label col-md-3">Group Name</label>
															<div class="col-md-9">
																<input id="GroupName" name="GroupName" placeholder="Group Name" type="text" class="form-control" value="<?php echo $item['groupName']; ?>" />
																<span class="text-danger"><?php echo form_error('GroupName'); ?></span>
															</div>
														</div>
													</div>
												</div>
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
									<td colspan="3">
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
								echo form_open("index.php/Common/ItemList/GroupCreate", $attributes);?>
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="GroupName" class="create-label col-md-3">Group Name</label>
											<div class="col-md-9">
												<input id="GroupName" name="GroupName" placeholder="Group Name" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('GroupName'); ?></span>
											</div>
										</div>
									</div>
								</div>
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