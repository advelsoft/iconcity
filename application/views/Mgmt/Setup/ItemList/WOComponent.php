<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<!--<div class="col-lg-12">
			<a class="homeLink" href="<?php echo base_url()."index.php/Mgmt/Home/Index";?>">&nbsp;Home /</a>
			<a class="homeLink" href="<?php echo base_url()."index.php/Common/ItemList/GroupList";?>">Item Group /</a>
			<a class="homeLink" href="<?php echo base_url()."index.php/Common/ItemList/TypeList/".$type[0]->GroupID;?>">Item Type /</a>
			<a class="homeLink" href="<?php echo base_url()."index.php/Common/ItemList/ComponentList/".$typeID;?>">Item Component</a>
		</div>-->
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Item Component List</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th>Item Group</th>
									<th>Item Type</th>
									<th>Item Component</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php for($i=0; $i < count($componentList); $i++) { ?>
								<tr>
									<td><?php echo $componentList[$i]->GroupName; ?></td>
									<td><?php echo $componentList[$i]->TypeName; ?></td>
									<td><?php echo $componentList[$i]->ComponentName; ?></td>
									<td><a href="#" data-toggle="modal" data-target="#edit<?php echo $componentList[$i]->ComponentID; ?>"><div class="btn btn-sm btn-grey">Edit</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="edit<?php echo $componentList[$i]->ComponentID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "editform", "name" => "editform");
												echo form_open("index.php/Common/ItemList/ComponentUpdate/".$componentList[$i]->ComponentID, $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Group" class="create-label col-md-3">Item Group</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "Group"';
																echo form_dropdown('Group',$group,set_value('Group', $componentList[$i]->GroupID),$attributes);?>
															</div>
														</div>
														<div class="form-group">
															<label for="Level" class="create-label col-md-3">Item Type</label>
															<div class="col-md-9">
																<?php $attributes = 'class = "form-control" id = "Type"';
																echo form_dropdown('Type',$type,set_value('Type', $componentList[$i]->TypeID),$attributes);?>
															</div>
														</div>
														<div class="form-group">
															<label for="Component" class="create-label col-md-3">Item Component</label>
															<div class="col-md-9">
																<input id="Component" name="Component" placeholder="Component" type="text" class="form-control" value="<?php echo $componentList[$i]->ComponentName; ?>" />
																<span class="text-danger"><?php echo form_error('Component'); ?></span>
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
									<td><a href="#" data-toggle="modal" data-target="#delete<?php echo $componentList[$i]->ComponentID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a></td>
									<!-- Modal -->
									<div class="modal fade" id="delete<?php echo $componentList[$i]->ComponentID; ?>" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<?php $attributes = array("id" => "deleteform", "name" => "deleteform");
												echo form_open("index.php/Common/ItemList/ComponentDelete/".$componentList[$i]->ComponentID, $attributes);?>
												<!-- Modal Header -->
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title">Record Will Be Changed</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="Group" class="create-label col-md-3">Item Group</label>
															<div class="col-md-9">
																<input id="Group" name="Group" placeholder="Item Group" type="text" class="form-control" value="<?php echo $componentList[$i]->GroupName;?>" readonly />
															</div>
														</div>
														<div class="form-group">
															<label for="Level" class="create-label col-md-3">Item Type</label>
															<div class="col-md-9">
																<input id="Type" name="Type" placeholder="Item Type" type="text" class="form-control" value="<?php echo $componentList[$i]->TypeName;?>" readonly />
															</div>
														</div>
														<div class="form-group">
														<label for="Component" class="create-label col-md-3">Item Component</label>
														<div class="col-md-9">
															<input id="Component" name="Component" placeholder="Component" type="Component" class="form-control" value="<?php echo $componentList[$i]->ComponentName; ?>" readonly />
															<span class="text-danger"><?php echo form_error('Component'); ?></span>
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
									<td colspan="6">
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
								echo form_open("index.php/Common/ItemList/ComponentCreate", $attributes);?>
								<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<!-- Modal Body -->
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Group" class="create-label col-md-3">Item Group</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "Group"';
												echo form_dropdown('Group',$group,set_value('Group'),$attributes);?>
											</div>
										</div>
										<div class="form-group">
											<label for="Type" class="create-label col-md-3">Item Type</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "Type"';
												echo form_dropdown('Type',$type,set_value('Type'),$attributes);?>
											</div>
										</div>
										<div class="form-group">
											<label for="Component" class="create-label col-md-3">Item Component</label>
											<div class="col-md-9">
												<input id="Component" name="Component" placeholder="Component" type="Component" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Component'); ?></span>
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