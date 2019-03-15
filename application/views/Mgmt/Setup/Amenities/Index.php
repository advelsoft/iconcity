<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="page-wrapper">
	<div class="row"></div>	
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Amenities</h4>
				</div>
				<div class="panel-body">
					<?php $attributes = array("id" => "amenitiesform", "name" => "amenitiesform");
					echo form_open_multipart("index.php/Common/Amenities/Index", $attributes);?>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="Title" class="create-label col-md-2">Title</label>
											<div class="col-md-10">
												<input id="Title" name="Title" placeholder="Title" type="text" class="form-control" value="<?php if (count($amenities) != 0) { echo $amenities[0]->Title; } ?>" />
												<span class="text-danger"><?php echo form_error('Title'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Summary" class="create-label col-md-2">Summary</label>
											<div class="col-md-10">
												<textarea class="form-control" id="Summary" name="Summary" placeholder="Summary" rows="4"><?php if (count($amenities) != 0) { echo $amenities[0]->Summary; } ?></textarea>
												<span class="text-danger"><?php echo form_error('Summary'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Description" class="create-label col-md-2">Description (Read More)</label>
											<div class="col-md-10">
												<textarea class="form-control" id="Description" name="Description" placeholder="Description" rows="4"><?php if (count($amenities) != 0) { echo $amenities[0]->Description; } ?></textarea>
												<span class="text-danger"><?php echo form_error('Description'); ?></span>
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
<script>
	$(function() {
		$('#Summary').summernote({
			height: 200,
			popover: ['air', ['']],
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['fontsize', ['fontname', 'fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'picture']],
				['insert', ['table', 'hr']],
				['misc', ['fullscreen', 'codeview', 'help']]
			]
		});
		
		$('#Description').summernote({
			height: 200,
			popover: ['air', ['']],
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['fontsize', ['fontname', 'fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'picture']],
				['insert', ['table', 'hr']],
				['misc', ['fullscreen', 'codeview', 'help']]
			]
		});
    });
</script>