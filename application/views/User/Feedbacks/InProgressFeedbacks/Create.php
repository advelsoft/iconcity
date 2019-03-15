<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/InProgressFeedbacks/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">Create Feedbacks/Requests</div>			
				<?php $attributes = array("id" => "feedbackform", "name" => "feedbackform");
				echo form_open("index.php/Common/InProgressFeedbacks/Create", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="Description" class="create-label col-md-2">Incident Type</label>
                            <div class="col-md-10">
                                <?php $attributes = 'class = "form-control" id = "IncidentType"';
								echo form_dropdown('IncidentType',$department,set_value('IncidentType'),$attributes);?>
								<span class="text-danger"><?php echo form_error('IncidentType'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Subject" class="create-label col-md-2">Subject</label>
                            <div class="col-md-10">
                                <input id="Subject" name="Subject" placeholder="Subject" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('Subject'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Description" class="create-label col-md-2">Description</label>
                            <div class="col-md-10">
								<textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
								<span class="text-danger"><?php echo form_error('Description'); ?></span>
							</div>
                        </div>									
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" value="Save" class="submit" />
					<!--<input type="reset" value="Cancel" class="btn btn-danger" />-->
				</div>
				<?php echo form_close(); ?>
				<?php echo $this->session->flashdata('msg'); ?>
			</div>
		</div>
	</div>
</div>