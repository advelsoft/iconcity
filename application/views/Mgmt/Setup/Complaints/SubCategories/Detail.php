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
					<h4>Sub-Categories Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">					
						<dt>Sub-Categories</dt>
						<dd><?php echo $subcatRecord[0]->SubCategories; ?></dd>
						<span class="text-danger"><?php echo form_error('SubCategories'); ?></span>
						
						<dt>Categories</dt>
						<dd><?php echo $subcatRecord[0]->Categories; ?></dd>
						<span class="text-danger"><?php echo form_error('Categories'); ?></span>

						<dt>Email</dt>
						<dd style='text-transform:none;'><?php echo $subcatRecord[0]->Email; ?></dd>
						<span class="text-danger"><?php echo form_error('Email'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/SubCategories/Update/".$subcatRecord[0]->UID;?>"><div class="btn btn-sm btn-grey">Edit</div></a>
					<a href="<?php echo base_url()."index.php/Common/SubCategories/Delete/".$subcatRecord[0]->UID;?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
		</div>
	</div>
</div>