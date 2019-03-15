<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="tab-pane fade" id="elev">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<?php $attributes = array("id" => "emailform", "name" => "emailform");
				echo form_open("index.php/Common/Setup/ElevSetup/".$CondoSeq, $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="NORESPONSEINHOURS" class="create-label col-md-2">No Response For New Incidents</label>
							<div class="col-md-2">
								<input id="NORESPONSEINHOURS" name="NORESPONSEINHOURS" placeholder="No Response In Hours" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->NORESPONSEINHOURS; } ?>" />
								<span class="text-danger"><?php echo form_error('NORESPONSEINHOURS'); ?></span>	
							</div>
							<div class="col-md-1">
								<label for="Hours">Hours</label>
							</div>
							<label for="NORESPONSELVL2" class="create-label col-md-1">2nd Level</label>
							<div class="col-md-2">
								<input id="NORESPONSELVL2" name="NORESPONSELVL2" placeholder="2nd Level" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->NORESPONSELVL2; } ?>" />
								<span class="text-danger"><?php echo form_error('NORESPONSELVL2'); ?></span>	
							</div>
							<label for="NORESPONSELVL3" class="create-label col-md-1">3rd Level</label>
							<div class="col-md-2">
								<input id="NORESPONSELVL3" name="NORESPONSELVL3" placeholder="3rd Level" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->NORESPONSELVL3; } ?>" />
								<span class="text-danger"><?php echo form_error('NORESPONSELVL3'); ?></span>	
							</div>
						</div>					
						<div class="form-group">
							<label for="RESPONSECYCLEINHOURS" class="create-label col-md-2">Check Response Cycle</label>
							<div class="col-md-2">
								<input id="RESPONSECYCLEINHOURS" name="RESPONSECYCLEINHOURS" placeholder="Check Response" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->RESPONSECYCLEINHOURS; } ?>" />
								<span class="text-danger"><?php echo form_error('RESPONSECYCLEINHOURS'); ?></span>	
							</div>
							<div class="col-md-2">
								<label for="Hours">Hours</label>
							</div>
						</div>
						<div class="form-group">
							<label for="NEWELEVATEEMAIL" class="create-label col-md-2">Elevate To (Email)</label>
							<div class="col-md-6">
								<input id="NEWELEVATEEMAIL" name="NEWELEVATEEMAIL" placeholder="Elevate To" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->NEWELEVATEEMAIL; } ?>" />
								<span class="text-danger"><?php echo form_error('NEWELEVATEEMAIL'); ?></span>	
							</div>
						</div>
						<div class="form-group">
							<label for="ELEVATELVL2EMAIL" class="create-label col-md-2">2nd Level Email</label>
							<div class="col-md-6">
								<input id="ELEVATELVL2EMAIL" name="ELEVATELVL2EMAIL" placeholder="2nd Level Email" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->ELEVATELVL2EMAIL; } ?>" />
								<span class="text-danger"><?php echo form_error('ELEVATELVL2EMAIL'); ?></span>	
							</div>
						</div>
						<div class="form-group">
							<label for="ELEVATELVL3EMAIL" class="create-label col-md-2">3rd Level Email</label>
							<div class="col-md-6">
								<input id="ELEVATELVL3EMAIL" name="ELEVATELVL3EMAIL" placeholder="3rd Level Email" type="text" class="form-control" value="<?php if (count($evelList) != 0) { echo $evelList[0]->ELEVATELVL3EMAIL; } ?>" />
								<span class="text-danger"><?php echo form_error('ELEVATELVL3EMAIL'); ?></span>	
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
<?php echo $this->session->flashdata('elev'); ?>