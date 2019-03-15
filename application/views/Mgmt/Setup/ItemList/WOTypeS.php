<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/ItemList/TypeList";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Item Type List</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<!--<p>Item Location: </p>
						<p>Item Group: </p>-->
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th>Item Type</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($typeList as $item) { ?>
								<tr>
									<td><?php echo $item['typeName']; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $item['typeID']; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $item['typeID']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/ItemList/TypeUpdate/".$item['typeID'], $attributes);?>
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Location" class="create-label col-md-3">Item Location</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "Location"';
																echo form_dropdown('Location',$location,set_value('Location', $item['locID']),$attributes);?>
															</div>
														</div>
														<div class="form-group">
															<label for="Group" class="create-label col-md-3">Item Group</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "Group"';
																echo form_dropdown('Group',$group,set_value('Group', $item['groupID']),$attributes);?>
															</div>
														</div>
														<div class="form-group">
															<label for="Type" class="create-label col-md-3">Item Type</label>
															<div class="col-md-9">
																<input id="Type" name="Type" placeholder="Item Type" type="text" class="form-control" value="<?php echo $item['typeName']; ?>" />
																<span class="text-danger"><?php echo form_error('Type'); ?></span>
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
									<td><a href="#" data-toggle="modal" data-target="#delete<?php echo $item['typeID']; ?>"><div class="btn btn-sm btn-grey">Delete</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="delete<?php echo $item['typeID']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "deleteform", "name" => "deleteform");
												echo form_open("index.php/Common/ItemList/TypeDelete/".$item['typeID'], $attributes);?>
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Group" class="create-label col-md-3">Item Location</label>
															<div class="col-md-9">
																<input id="Location" name="Location" placeholder="Item Location" type="text" class="form-control" value="<?php echo $item['locName']; ?>" readonly />
															</div>
														</div>
														<div class="form-group">
															<label for="Group" class="create-label col-md-3">Item Group</label>
															<div class="col-md-9">
																<input id="Group" name="Group" placeholder="Item Group" type="text" class="form-control" value="<?php echo $item['groupName']; ?>" readonly />
															</div>
														</div>
														<div class="form-group">
															<label for="Type" class="create-label col-md-3">Item Type</label>
															<div class="col-md-9">
																<input id="Type" name="Type" placeholder="Item Type" type="text" class="form-control" value="<?php echo $item['typeName']; ?>" readonly />
																<span class="text-danger"><?php echo form_error('Type'); ?></span>
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