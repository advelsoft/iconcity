<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
	<title><?php echo $company[0]->CompanyName; ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'content/img/cloud-icon.png'; ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/landing-page.css"?>">
</head>
<body>
<!-- Header -->
<header id="top" class="header">
	<div class="text-vertical-center">
		<div class="container">
			<div class="row" align="left">
				<div class="headertext col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="panel-body">
						<?php $attributes = array("id" => "forgetpwform", "name" => "forgetpwform");
						echo form_open("index.php/Common/ForgetPassword/ForgetPassword", $attributes);?>
						<div class="form-horizontal">
							<div class="form-group">
								<label class="forgetPw col-md-12"><b>Terms and Conditions</b></label>
							</div>
							<div class="form-group">
								<label for="LoginID" class="create-label col-md-3">Login ID</label>
								<div class="col-md-9">
									<input id="LoginID" name="LoginID" placeholder="Login ID" type="text" class="form-control" value="" />
									<span class="text-danger"><?php echo form_error('LoginID'); ?></span>
								</div>
							</div>
							<div align="center">
								<input type="submit" value="Submit" class="submit btn-submit" />
								<div class="btn btn-submit">
									<a href="<?php echo base_url(); ?>" style="text-align:center">Back to Login</a>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="modal1" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" name="title" id="title">Terms and Conditions</h4>
							</div>
							<div class="modal-body">
								<div class="text-content">
									<input type="checkbox" name="terms" id="terms" onchange="activateButton(this)" />  
									<a href="#">I agree to the Terms and Conditions.</a>
								</div>
							</div>
							<div class="modal-footer">
								<input type="submit" id="Submit" name="Submit" value="Submit" class="submit" />
								<input type="reset" id="Cancel" name="Cancel" value="Cancel" class="submit" data-dismiss="modal" onclick="disableCheckbox()"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<?php echo $this->session->flashdata('msg'); ?>
<script src="<?php echo base_url()."scripts/plugins/jquery/jquery.min.js"?>"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>