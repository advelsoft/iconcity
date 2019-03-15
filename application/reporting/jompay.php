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
						<thead>
							<tr><th>Jompay</th></tr>
						</thead>
						<tbody>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomServiceErr";?>" target="_blank">Jompay Service Error</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomMessageErr";?>" target="_blank">Jompay Message Error</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomProcessErr";?>" target="_blank">Jompay Process Error</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomOutstanding";?>" target="_blank">Jompay Outstanding</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomDailyUsers";?>" target="_blank">Jompay Daily Users</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomServiceFTP";?>" target="_blank">Jompay Service FTP</a><br></td></tr>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/JomServiceData";?>" target="_blank">Jompay Service Data</a><br></td></tr>
						</tbody>
					</table>
					<table class="table table-striped table-hover table-custom">
						<thead>
							<tr><th>Promotion</th></tr>
						</thead>
						<tbody>
							<tr><td><a href="<?php echo base_url()."index.php/Common/Reporting/PromoLog";?>" target="_blank">Promotion Log</a><br></td></tr>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>