<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Notice/Index";?>">
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
						<div class="col-md-2">Title</div>
						<div class="col-md-10"><?php echo $noticeRecord[0]->Title; ?></div>
						<span class="text-danger"><?php echo form_error('Title'); ?></span>
						
						<div class="col-md-2">Notice Date</div>
						<div class="col-md-10"><?php echo date("d/m/Y", strtotime($noticeRecord[0]->NoticeDate)); ?></div>
						<span class="text-danger"><?php echo form_error('NoticeDate'); ?></span>
						
						<div class="col-md-2">Date To</div>
						<div class="col-md-10"><?php echo date("d/m/Y", strtotime($noticeRecord[0]->DateTo)); ?></div>
						<span class="text-danger"><?php echo form_error('DateTo'); ?></span>
						
						<div class="col-md-2">Summary</div>
						<div class="col-md-10"><?php echo $noticeRecord[0]->Summary; ?></div>
						<span class="text-danger"><?php echo form_error('Summary'); ?></span>
						
						<div class="col-md-2">Description</div>
						<div class="col-md-10"><?php echo $noticeRecord[0]->Description; ?></div>
						<span class="text-danger"><?php echo form_error('Description'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<div class="btn btn-sm btn-grey"><a href="<?php echo base_url() . "index.php/Common/Notice/delete_record/".$noticeRecord[0]->NoticeID; ?>">Delete</a></div>
				</div>
			</div>
        </div>
    </div>
</div>