<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/NameEmail/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Name/Email Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Name</dt>
						<dd><?php echo $deptRecord[0]->Name; ?></dd>
						<span class="text-danger"><?php echo form_error('Name'); ?></span>
						
						<dt>Email</dt>
						<dd><?php echo $deptRecord[0]->Email; ?></dd>
						<span class="text-danger"><?php echo form_error('Email'); ?></span>
						
						<dt>Department</dt>
						<dd><?php echo $deptRecord[0]->Department; ?></dd>
						<span class="text-danger"><?php echo form_error('Department'); ?></span>
						
						<dt>Position</dt>
						<dd><?php echo $deptRecord[0]->Position; ?></dd>
						<span class="text-danger"><?php echo form_error('Position'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/NameEmail/Update/".$deptRecord[0]->UID;?>"><div class="btn btn-sm btn-grey">Edit</div></a>
					<a href="<?php echo base_url()."index.php/Common/NameEmail/Delete/".$deptRecord[0]->UID;?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
		</div>
	</div>
</div>