<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/UploadType/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Upload Type</div>			
				<?php $attributes = array("id" => "uploadtypeform", "name" => "uploadtypeform");
				echo form_open("index.php/Common/UploadType/Create", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="Description" class="create-label col-md-4">Description</label>
                            <div class="col-md-8">
                                <input id="Description" name="Description" placeholder="Description" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('Description'); ?></span>
                            </div>
                        </div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" value="Submit" class="submit" />
				</div>
				<?php echo form_close(); ?>
				<?php echo $this->session->flashdata('msg'); ?>
			</div>
		</div>
	</div>
</div>