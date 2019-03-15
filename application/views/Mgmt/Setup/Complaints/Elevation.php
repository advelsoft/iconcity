<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Elevation</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<?php $attributes = array("id" => "elevform", "name" => "elevform");
								echo form_open("index.php/Common/Elevation/Elevation", $attributes);?>
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="NoResponseInHours" class="create-label col-md-2">No Response For New Incidents</label>
											<div class="col-md-2">
												<input id="NoResponseInHours" name="NoResponseInHours" placeholder="No Response In Hours" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->NoResponseInHours; } ?>" />
												<span class="text-danger"><?php echo form_error('NoResponseInHours'); ?></span>	
											</div>
											<div class="col-md-1">
												<label for="Hours">Hours</label>
											</div>
											<label for="NoResponseLvl2" class="create-label col-md-1">2nd Level</label>
											<div class="col-md-2">
												<input id="NoResponseLvl2" name="NoResponseLvl2" placeholder="2nd Level" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->NoResponseLvl2; } ?>" />
												<span class="text-danger"><?php echo form_error('NoResponseLvl2'); ?></span>	
											</div>
											<label for="NoResponseLvl3" class="create-label col-md-1">3rd Level</label>
											<div class="col-md-2">
												<input id="NoResponseLvl3" name="NoResponseLvl3" placeholder="3rd Level" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->NoResponseLvl3; } ?>" />
												<span class="text-danger"><?php echo form_error('NoResponseLvl3'); ?></span>	
											</div>
										</div>					
										<div class="form-group">
											<label for="ResponseCycleInHours" class="create-label col-md-2">Check Response Cycle</label>
											<div class="col-md-2">
												<input id="ResponseCycleInHours" name="ResponseCycleInHours" placeholder="Check Response" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->ResponseCycleInHours; } ?>" />
												<span class="text-danger"><?php echo form_error('ResponseCycleInHours'); ?></span>	
											</div>
											<div class="col-md-2">
												<label for="Hours">Hours</label>
											</div>
										</div>
										<div class="form-group">
											<label for="NewElevateEmail" class="create-label col-md-2">Elevate To (Email)</label>
											<div class="col-md-6">
												<input id="NewElevateEmail" name="NewElevateEmail" placeholder="Elevate To" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->NewElevateEmail; } ?>" />
												<span class="text-danger"><?php echo form_error('NewElevateEmail'); ?></span>	
											</div>
										</div>
										<div class="form-group">
											<label for="ElevateLvl2Email" class="create-label col-md-2">2nd Level Email</label>
											<div class="col-md-6">
												<input id="ElevateLvl2Email" name="ElevateLvl2Email" placeholder="2nd Level Email" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->ElevateLvl2Email; } ?>" />
												<span class="text-danger"><?php echo form_error('ElevateLvl2Email'); ?></span>	
											</div>
										</div>
										<div class="form-group">
											<label for="ElevateLvl3Email" class="create-label col-md-2">3rd Level Email</label>
											<div class="col-md-6">
												<input id="ElevateLvl3Email" name="ElevateLvl3Email" placeholder="3rd Level Email" type="text" class="form-control" value="<?php if (count($elevList) != 0) { echo $elevList[0]->ElevateLvl3Email; } ?>" />
												<span class="text-danger"><?php echo form_error('ElevateLvl3Email'); ?></span>	
											</div>
										</div>
									</div>
									<div align="center">
										<input type="submit" value="Submit" class="submit" />
									</div>
								</div>
								<?php echo form_close(); ?>
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