<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/SubCategories/Index";?>">
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
				<?php $attributes = array("id" => "subcategoriesform", "name" => "subcategoriesform");
				echo form_open("index.php/Common/SubCategories/Create", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="SubCategories" class="create-label col-md-3">Sub-Categories</label>
							<div class="col-md-9">
								<input id="SubCategories" name="SubCategories" placeholder="Sub-Categories" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('SubCategories'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Categories" class="create-label col-md-3">Categories</label>
							<div class="col-md-9">
								<?php $attributes = 'class = "form-control" id = "Categories" onchange="getSubCategoriesC(this.value)"';
								echo form_dropdown('Categories',$categories,set_value('Categories'),$attributes);?>
								<span class="text-danger"><?php echo form_error('Categories'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Email" class="create-label col-md-3">Email</label>
							<div class="col-md-9" id="EmailCat">
								<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="" />
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