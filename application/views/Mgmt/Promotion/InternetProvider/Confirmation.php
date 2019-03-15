<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/InternetProvider/".GLOBAL_CONDOSEQ;?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Internet Provider</h4>
				</div>
				<?php $attributes = array("id" => "internetform", "name" => "internetform");
				echo form_open_multipart("index.php/Common/InternetProvider/Store/".$condoSeq, $attributes);?>
				<div class="panel-body">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal">
								<h4>You have choose <b><?php echo $package; ?></b> package.</h4>
								<h4>Please provide us with your details.</h4>
							</dl>
							<div class="form-horizontal">
								<div class="form-group">
									<label for="Phone" class="create-label col-md-2">Phone No.</label>
									<div class="col-md-10">
										<input id="Phone" name="Phone" placeholder="Phone No." type="text" class="form-control" value="" />
										<span class="text-danger"><?php echo form_error('Phone'); ?></span>
									</div>
								</div>
								<div class="form-group">
									<label for="Email" class="create-label col-md-2">Email</label>
									<div class="col-md-10">
										<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="" />
										<span class="text-danger"><?php echo form_error('Email'); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer" style="text-align: right;" >
					<input id="provider" name="provider" type="hidden" value="<?php echo $provider; ?>"/>
					<input id="package" name="package" type="hidden" value="<?php echo $package; ?>"/>
					<input type="submit" id="Submit" name="Submit" value="Submit" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<script language="Javascript">

</script>