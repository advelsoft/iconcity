<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php require_once 'stimulsoft/helper.php'; ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Reporting</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-custom">
						<tbody>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/AllAgent";?>" target="_blank">Report for all agents</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/CertainAgent";?>" target="_blank">Report for certain agent</a><br></td></tr>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>