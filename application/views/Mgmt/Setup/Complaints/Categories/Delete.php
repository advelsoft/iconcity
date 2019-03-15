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
					<h4>Are you sure want to delete this?</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Categories</dt>
						<dd><?php echo $catRecord[0]->Categories; ?></dd>
						<span class="text-danger"><?php echo form_error('Categories'); ?></span>
						
						<dt>Department</dt>
						<dd><?php echo $catRecord[0]->Department; ?></dd>
						<span class="text-danger"><?php echo form_error('Department'); ?></span>
						
						<dt>Email</dt>
						<dd style='text-transform:none;'><?php echo $catRecord[0]->Email; ?></dd>
						<span class="text-danger"><?php echo form_error('Email'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url() . "index.php/Common/Categories/Delete_record/".$catRecord[0]->UID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
        </div>
    </div>
</div>