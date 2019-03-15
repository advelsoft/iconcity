<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Create Feedbacks/Requests</div>			
				<?php $attributes = array("id" => "feedbackform", "name" => "feedbackform");
				echo form_open_multipart("index.php/Common/OpenFeedbacks/Create", $attributes);?>
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
                                <input id="Subject" name="Subject" placeholder="Subject" type="text" class="form-control" value="" maxlength="60" />
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
						<div class="form-group">
							<label for="Attachment1" class="create-label col-md-2">Attachment</label>
                            <div class="col-md-10 field_wrapper">
								<input class="col-md-5" type="file" name="Attachment1" value=""/>
								<a href="javascript:void(0);" class="add_button col-md-5" title="Add field"><img src="<?php echo base_url()."content/img/add-icon.png";?>" /></a>
								<span class="text-danger"><?php echo form_error('Attachment1'); ?></span>
							</div>
                        </div>						
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" value="Submit" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>