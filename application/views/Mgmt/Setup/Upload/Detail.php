<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Upload/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Upload Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<div class="col-md-2">File</div>
						<div class="col-md-10">
							<input type="image" src="<?php echo base_url().'application/uploads/files/'.$uploadRecord['file'];?>" alt="File">
						</div>
						<span class="text-danger"><?php echo form_error('File'); ?></span>
						
						<div class="col-md-2">Type</div>
						<div class="col-md-10"><?php echo $uploadRecord['desc']; ?></div>
						<span class="text-danger"><?php echo form_error('Type'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/Upload/Update/".$uploadRecord['uploadID']; ?>" style="text-align:center">
						<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
					</a>
					<a href="<?php echo base_url()."index.php/Common/Upload/Delete/".$uploadRecord['uploadID']; ?>" style="text-align:center">
						<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>