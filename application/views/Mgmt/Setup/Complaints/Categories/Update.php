<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
    <div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Categories/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
				</div>	
					<?php $attributes = array("id" => "categoriesform", "name" => "categoriesform");
					echo form_open("index.php/Common/Categories/Update/".$UID, $attributes);?>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="Categories" class="create-label col-md-3">Categories</label>
								<div class="col-md-9">
									<input id="Categories" name="Categories" placeholder="Categories" type="text" class="form-control" value="<?php echo $catRecord[0]->Categories; ?>" />
									<span class="text-danger"><?php echo form_error('Categories'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="Department" class="create-label col-md-3">Department</label>
								<div class="col-md-9">
									<?php $attributes = 'class = "form-control" id = "Department" onchange="getCategoriesU(this.value)"';
									echo form_dropdown('Department',$department,set_value('Department', $catRecord[0]->Department),$attributes);?>
									<span class="text-danger"><?php echo form_error('Department'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="EmailID" class="create-label col-md-3">Email</label>
								<div class="col-md-9">
									<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="<?php echo $catRecord[0]->Email; ?>" />
									<span class="text-danger"><?php echo form_error('Email'); ?></span>
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