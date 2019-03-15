<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="tab-pane fade" id="block">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $attributes = array("id" => "emailform", "name" => "emailform");
					echo form_open("index.php/Common/Setup/BlockSetup/".$CondoSeq, $attributes);?>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="ENABLEBLOCKUSER" class="create-label col-md-5">Enabled Block User From Booking Facilities</label>
									<div class="col-md-1">
										<input type="checkbox" id="ENABLEBLOCKUSER" name="ENABLEBLOCKUSER" <?php if (count($setupList) != 0) { if ($setupList[0]->ENABLEBLOCKUSER == "1") {echo "checked = checked";} } ?> />
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
											<label for="BLOCKMETHOD" class="create-label col-md-2">Amount: </label>
											<div class="col-md-2">
												<input type="radio" name="BLOCKMETHOD" value="Amount" <?php if (count($setupList) != 0) { if ($setupList[0]->BLOCKMETHOD == "1") { echo "checked";} } ?>>&nbsp;&nbsp;Amount
											</div>
										</div>
										<div class="form-group">
											<label for="BLOCKMETHOD" class="create-label col-md-2">Days: </label>
											<div class="col-md-2">
												<input type="radio" name="BLOCKMETHOD" value="Day" <?php if (count($setupList) != 0) { if ($setupList[0]->BLOCKMETHOD == "2") { echo "checked";} } ?> >&nbsp;&nbsp;Days
											</div>
										</div>
										<div class="form-group">
											<label for="BLOCKMETHOD" class="create-label col-md-2">Amount and Days: </label>
											<div class="col-md-2">
												<input type="radio" name="BLOCKMETHOD" value="AmtnDay" <?php if (count($setupList) != 0) { if ($setupList[0]->BLOCKMETHOD == "3") { echo "checked"; } }?> >&nbsp;&nbsp;Amount and Days
											</div>
										</div>
										<div class="form-group">
											<label for="BLOCKMETHOD" class="create-label col-md-2">Amount or Days: </label>
											<div class="col-md-2">
												<input type="radio" name="BLOCKMETHOD" value="AmtoDay" <?php if (count($setupList) != 0) { if ($setupList[0]->BLOCKMETHOD == "4") { echo "checked"; } }?> >&nbsp;&nbsp;Amount or Days
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
											<label for="OVERDUEAMOUNT" class="create-label col-md-2">Overdue Amount</label>
											<div class="col-md-2">
												<input id="OVERDUEAMOUNT" name="OVERDUEAMOUNT" placeholder="Overdue Amount" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->OVERDUEAMOUNT; } ?>" />
												<span class="text-danger"><?php echo form_error('OVERDUEAMOUNT'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="OVERDUEDAYS" class="create-label col-md-2">Overdue Days</label>
											<div class="col-md-2">
												<input id="OVERDUEDAYS" name="OVERDUEDAYS" placeholder="Overdue Days" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->OVERDUEDAYS; } ?>" />
												<span class="text-danger"><?php echo form_error('OVERDUEDAYS'); ?></span>
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
											<label for="DEFAULTERMSG" class="create-label col-md-2">Defaulter Message</label>
											<div class="col-md-10">
												<input id="DEFAULTERMSG" name="DEFAULTERMSG" placeholder="Defaulter Message" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->DEFAULTERMSG; } ?>" />
												<span class="text-danger"><?php echo form_error('DEFAULTERMSG'); ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
<?php echo $this->session->flashdata('block'); ?>