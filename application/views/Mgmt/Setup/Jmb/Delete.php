<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Jmb/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
    <div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>JMB Info</h4>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Property No</dt>
						<dd><?php echo $userRecord[0]->PropertyNo; ?></dd>
						<span class="text-danger"><?php echo form_error('PropertyNo'); ?></span>
						
						<dt>Owner Name</dt>
						<dd style='text-transform:none;'><?php echo $userRecord[0]->OwnerName; ?></dd>
						<span class="text-danger"><?php echo form_error('OwnerName'); ?></span>
					</dl>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/Jmb/delete_record/".$userRecord[0]->UserID; ?>"><div class="btn btn-sm btn-grey">Delete</div></a>
				</div>
			</div>
        </div>
    </div>
</div>