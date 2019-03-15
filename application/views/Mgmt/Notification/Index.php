<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="page-wrapper">
	<div class="row"></div>	
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Email Notification</h4>
				</div>
				<div class="panel-body">
					<?php $attributes = array("id" => "notifyform", "name" => "notifyform");
					echo form_open_multipart("index.php/Common/Notification/Index", $attributes);?>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Title" class="create-label col-md-2">Title</label>
											<div class="col-md-10">
												<input id="Title" name="Title" placeholder="Title" type="text" class="form-control" value="" />
												<span class="text-danger"><?php echo form_error('Title'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Description" class="create-label col-md-2">Description</label>
											<div class="col-md-10">
												<textarea class="form-control" id="Description" name="Description" placeholder="Description" rows="4"></textarea>
												<span class="text-danger"><?php echo form_error('Description'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="PropertyNo" class="create-label col-md-2">Property No</label>
											<div class="col-md-10">
												<input type="button" id="select_all" name="select_all" value="Select All">
												<?php echo form_multiselect('PropertyNo[]', $userPropNo, array(), 'id="PropertyNo" size="10"'); ?>
												<span class="text-danger"><?php echo form_error('PropertyNo'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Attachment" class="create-label col-md-2">Attachment</label>
											<div class="col-md-10">
												<input type="file" name="Attachment" value=""/>
												<span class="text-danger"><?php echo form_error('Attachment'); ?></span>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer" align="center">
									<input type="submit" value="Submit" class="submit" />
								</div>
							</div>
						</div>
					</div>	
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>