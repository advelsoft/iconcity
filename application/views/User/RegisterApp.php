<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url("index.php/User/Home/Index");?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Register for Apps</h4>
				</div>			
				<?php $attributes = array("id" => "changepwform", "name" => "changepwform");
				echo form_open("index.php/Common/RegisterApp/RegisterApp", $attributes);?>
				<div class="panel-body">
					Registration for Mobile Apps. Please click below button to confirm.
				</div>
				<div class="panel-footer" align="center">
					<input type="submit" value="Confirm" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>