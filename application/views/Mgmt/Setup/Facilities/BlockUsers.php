<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Block Users</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<?php $attributes = array("id" => "blockuserform", "name" => "blockuserform");
									echo form_open("index.php/Common/BlockUsers/Blockusers", $attributes);?>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-horizontal">
												<div class="form-group">
													<label for="EnableBlockUser" class="create-label col-md-5">Enabled Block User From Booking Facilities</label>
													<div class="col-md-1">
														<input type="checkbox" id="EnableBlockUser" name="EnableBlockUser" <?php if (count($blockList) != 0) { if ($blockList['enabled'] == "Y") {echo "checked = checked";} } ?> />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-heading">Block Method</div>
												<div class="panel-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="BlockMethod" class="create-label col-md-2">Amount: </label>
															<div class="col-md-2">
																<input type="radio" name="BlockMethod" value="Amount" <?php if (count($blockList) != 0) { if ($blockList['blockMethod'] == "1") { echo "checked";} } ?>>&nbsp;&nbsp;Amount
															</div>
														</div>
														<div class="form-group">
															<label for="BlockMethod" class="create-label col-md-2">Days: </label>
															<div class="col-md-2">
																<input type="radio" name="BlockMethod" value="Day" <?php if (count($blockList) != 0) { if ($blockList['blockMethod'] == "2") { echo "checked";} } ?> >&nbsp;&nbsp;Days
															</div>
														</div>
														<div class="form-group">
															<label for="BlockMethod" class="create-label col-md-2">Amount and Days: </label>
															<div class="col-md-2">
																<input type="radio" name="BlockMethod" value="AmtnDay" <?php if (count($blockList) != 0) { if ($blockList['blockMethod'] == "3") { echo "checked"; } }?> >&nbsp;&nbsp;Amount and Days
															</div>
														</div>
														<div class="form-group">
															<label for="BlockMethod" class="create-label col-md-2">Amount or Days: </label>
															<div class="col-md-2">
																<input type="radio" name="BlockMethod" value="AmtoDay" <?php if (count($blockList) != 0) { if ($blockList['blockMethod'] == "4") { echo "checked"; } }?> >&nbsp;&nbsp;Amount or Days
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="OverDueAmount" class="create-label col-md-2">Overdue Amount</label>
															<div class="col-md-2">
																<input id="OverDueAmount" name="OverDueAmount" placeholder="Overdue Amount" type="text" class="form-control" value="<?php if (count($blockList) != 0) { echo $blockList['overdueAmount']; } ?>" />
																<span class="text-danger"><?php echo form_error('OverDueAmount'); ?></span>
															</div>
														</div>
														<div class="form-group">
															<label for="OverDueDays" class="create-label col-md-2">Overdue Days</label>
															<div class="col-md-2">
																<input id="OverDueDays" name="OverDueDays" placeholder="Overdue Days" type="text" class="form-control" value="<?php if (count($blockList) != 0) { echo $blockList['overdueDays']; } ?>" />
																<span class="text-danger"><?php echo form_error('OverDueDays'); ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- <div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="DefaulterMsg" class="create-label col-md-2">Defaulter Message</label>
															<div class="col-md-10">
																<input id="DefaulterMsg" name="DefaulterMsg" placeholder="Defaulter Message" type="text" class="form-control" value="<?php if (count($blockList) != 0) { echo $blockList[0]->DefaulterMsg; } ?>" />
																<span class="text-danger"><?php echo form_error('DefaulterMsg'); ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div> -->
									<div class="row">
										<div align="center">
											<input type="submit" value="Submit" class="submit" />
										</div>
									</div>		
									<?php echo form_close(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<div><?php echo $this->session->flashdata('msg'); ?></div>