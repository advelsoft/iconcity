<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="page-wrapper">
	<div class="row"></div>	
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Company</h4>
				</div>
				<div class="panel-body">
					<?php $attributes = array("id" => "companyform", "name" => "companyform");
					echo form_open_multipart("index.php/Common/Company/Index", $attributes);?>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="CompanyName" class="create-label col-md-2">Company Name</label>
											<div class="col-md-10">
												<input id="Name" name="Name" placeholder="Name" type="text" class="form-control" value="<?php if (count($company) != 0) { echo $company[0]->CompanyName; } ?>" />
												<span class="text-danger"><?php echo form_error('Name'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="Contact" class="create-label col-md-2">Contact</label>
											<div class="col-md-10">
												<textarea class="form-control" id="Contact" name="Contact" placeholder="Contact" rows="4"><?php if (count($company) != 0) { echo $company[0]->Contact; } ?></textarea>
												<span class="text-danger"><?php echo form_error('Contact'); ?></span>
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
		$('#Contact').summernote({
			height: 350,
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