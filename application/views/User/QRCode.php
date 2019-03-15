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
		<div class="col-md-12 text-center">
			<div class="panel-heading">
				<h4>Your QRCode Image here.</h4>
			</div>
			<div class="panel-body">
				<?php if($img_url){ ?>
					<img src="<?php echo base_url('application/uploads/qrimage/'.$img_url); ?>" alt="QRCode Image">
				<?php } ?>
				<h4>Activation Code: <span style="font-family: Verdana;"><?php echo $activateCode; ?></span></h4>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>