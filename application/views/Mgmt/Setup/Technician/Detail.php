<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Technician/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Technician Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>LoginID</dt>
						<dd><?php echo $techRecord[0]->LoginID; ?></dd>
						<span class="text-danger"><?php echo form_error('LoginID'); ?></span>
						
						<dt>Name</dt>
						<dd><?php echo $techRecord[0]->Name; ?></dd>
						<span class="text-danger"><?php echo form_error('Name'); ?></span>
						
						<dt>Email</dt>
						<dd style='text-transform:none;'><?php echo $techRecord[0]->Email; ?></dd>
						<span class="text-danger"><?php echo form_error('Email'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>