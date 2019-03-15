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
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Are you sure want to delete this?</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<div class="col-md-2">News Type</div>
						<div class="col-md-10"><?php echo $newsRecord['newstype']; ?></div>
						<span class="text-danger"><?php echo form_error('NewsType'); ?></span>
						
						<div class="col-md-2">Title</div>
						<div class="col-md-10"><?php echo $newsRecord['title']; ?></div>
						<span class="text-danger"><?php echo form_error('Title'); ?></span>
						
						<div class="col-md-2">Summary</div>
						<div class="col-md-10"><?php echo $newsRecord['summary']; ?></div>
						<span class="text-danger"><?php echo form_error('Summary'); ?></span>
						
						<div class="col-md-2">Description</div>
						<div class="col-md-10"><?php echo $newsRecord['description']; ?></div>
						<span class="text-danger"><?php echo form_error('Description'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<div class="btn btn-sm btn-grey"><a href="<?php echo base_url() . "index.php/Common/News/delete_record/".$newsRecord['newsID']; ?>">Delete</a></div>
				</div>
			</div>
        </div>
    </div>
</div>