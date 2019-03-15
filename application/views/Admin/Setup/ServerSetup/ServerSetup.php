<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Setup/Lists";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Record Will Be Changed</h4>
				</div>
				<div class="panel-body">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#email" data-toggle="tab">Email</a></li>
						<li><a href="#sendpw" data-toggle="tab">Send Password Text</a></li>
						<li><a href="#jompay" data-toggle="tab">Jompay</a></li>
					</ul>
					<div class="tab-content">
						<?php echo $tab1; ?>
						<?php echo $tab2; ?>
						<?php echo $tab3; ?>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>