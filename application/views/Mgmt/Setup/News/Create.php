<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/News/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>News/Events</h4>
				</div>			
				<?php $attributes = array("id" => "newsform", "name" => "newsform");
				echo form_open_multipart("index.php/Common/News/Create", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="NewsType" class="create-label col-md-2">News Type</label>
                            <div class="col-md-10">
                                <?php $attributes = 'class = "form-control" id = "NewsType"';
								echo form_dropdown('NewsType',$newsType,set_value('NewsType'),$attributes);?>
								<span class="text-danger"><?php echo form_error('NewsType'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Title" class="create-label col-md-2">Title</label>
                            <div class="col-md-10">
                                <input id="Title" name="Title" placeholder="Title" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('Title'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="NewsType" class="create-label col-md-2">Summary *(Maxlength:300)</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Summary" name="Summary" placeholder="Summary (Maxlength:300)" rows="4" maxlength="300"></textarea>
								<span class="text-danger"><?php echo form_error('Summary'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="NewsType" class="create-label col-md-2">Description</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
								<span class="text-danger"><?php echo form_error('Description'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" value="Save" class="submit" />
				</div>
				<?php echo form_close(); ?>
				<?php echo $this->session->flashdata('msg'); ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		$('#Description').summernote({
			height: 250,   //set editable area's height
			codemirror: { // codemirror options
				theme: 'monokai'
			}
		});
    });
</script>