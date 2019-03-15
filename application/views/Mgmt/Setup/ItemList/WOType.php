<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Search Location/Group</h4>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="status" class="create-label col-md-2">Item Location</label>
                            <div class="col-md-4">
								<select name="lockey" id="lockey">
									<option value="0">Select Value</option>
									<?php for ($i = 0; $i < count($locSort); ++$i) { ?>
										<?php if($locSort == trim($locSort[$i]->LocID)) { ?>
											<?php echo '<option value="'.trim($locSort[$i]->LocID).'" selected="selected">'.$locSort[$i]->LocName.'</option>'; ?>
										<?php } else { ?>
											<?php echo '<option value="'.trim($locSort[$i]->LocID).'">'.$locSort[$i]->LocName.'</option>'; ?>
										<?php } ?>
									<?php } ?>
								</select>
								<input type="hidden" id="hdnLoc" value="">
                            </div>
							<label for="Name" class="create-label col-md-2">Item Group</label>
                            <div class="col-md-4">
                                <select name="grpkey" id="grpkey">
									<option value="0">Select Value</option>
									<?php for ($i = 0; $i < count($groupSort); ++$i) { ?>
										<?php if($groupSort == trim($groupSort[$i]->GroupID)) { ?>
											<?php echo '<option value="'.trim($groupSort[$i]->GroupID).'" selected="selected">'.$groupSort[$i]->GroupName.'</option>'; ?>
										<?php } else { ?>
											<?php echo '<option value="'.trim($groupSort[$i]->GroupID).'">'.$groupSort[$i]->GroupName.'</option>'; ?>
										<?php } ?>
									<?php } ?>
								</select>
								<input type="hidden" id="hdnGrp" value="">
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Item Type List</h4>
				</div>
				<div class="panel-body">
					<div><a href="#" data-toggle="modal" data-target="#insert"><div class="btn btn-sm btn-grey">Insert</div></a></div>
					<!-- Modal -->
					<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<?php $attributes = array("id" => "insertform", "name" => "insertform");
								echo form_open("index.php/Common/ItemList/TypeCreate", $attributes);?>
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Record Will Be Added</h4>
								</div>
								<div class="modal-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Location" class="create-label col-md-3">Item Location</label>
											<div class="col-md-9">
												<?php $attributes = 'class = "form-control" id = "Location"';
												echo form_dropdown('Location',$location,set_value('Location'),$attributes);?>
											</div>
										</div>
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
												<input id="Type" name="Type" placeholder="Item Type" type="text" class="form-control" value="" />
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
					</br>
					<div class="table-responsive" id="result">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th>Item Type</th>
									<th>Item Location</th>
									<th>Item Group</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($typeList as $item) { ?>
									<tr>
										<td style="text-align:left"><?php echo $item['typeName']; ?></td>
										<td style="text-align:left"><?php echo $item['locName']; ?></td>
										<td style="text-align:left"><?php echo $item['groupName']; ?></td>
										<td>
											<a href="#" data-toggle="modal" data-target="#edit<?php echo $item['typeID']; ?>"><div class="btn btn-sm btn-grey">Edit</div></a>
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
											<a href="#" data-toggle="modal" data-target="#delete<?php echo $item['typeID']; ?>"><div class="btn btn-sm btn-grey">Delete</div></a>
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
										</td>
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
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	$(document).ready(function(){
		function load_location(loc, grp)
		{
			$.ajax({
				url:"<?php echo site_url('index.php/Common/Itemlist/SearchLocation') ?>",
				method:"POST",
				data:{loc:loc, grp:grp},
				success:function(data){
					$('#result').html(data);
				}
			})
		}

		$('#lockey').change(function(){
			var lockey = $(this).val();
			document.getElementById('hdnLoc').value = lockey;
			var hdnGrp = document.getElementById('hdnGrp').value;
			if(lockey != '0')
			{
				load_location(lockey, hdnGrp);
			}
			else
			{
				load_location();
			}
		});
		
		function load_group(grp, loc)
		{
			$.ajax({
				url:"<?php echo site_url('index.php/Common/Itemlist/SearchGroup') ?>",
				method:"POST",
				data:{grp:grp, loc:loc},
				success:function(data){
					$('#result').html(data);
				}
			})
		}

		$('#grpkey').change(function(){
			var grpkey = $(this).val();
			document.getElementById('hdnGrp').value = grpkey;
			var hdnLoc = document.getElementById('hdnLoc').value;
			if(grpkey != '0')
			{
				load_group(grpkey, hdnLoc);
			}
			else
			{
				load_group();
			}
		});
	});
</script>