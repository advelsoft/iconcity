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
			<div class="row">
				<div class="headertext col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
					<div class="panel-body">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3><strong><?php echo $newsRecord[0]->Title; ?></strong></h3></br>
							<div class="news-desc"><?php echo $newsRecord[0]->Description; ?></div></br>
							<div>
								<a href="<?php echo base_url()."index.php/Common/Login/Login";?>" class="btn btn-submit">More Info</a>
								<a href="<?php echo base_url();?>" class="btn btn-submit">Back</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-vertical-center copyright">
				<span>&copy; Advelsoft (M) Sdn Bhd [855271-W]. All Rights Reserved</span>
			</div>
		</div>
	</div>
</footer>
<?php echo $this->session->flashdata('msg'); ?>
<script src="<?php echo base_url()."scripts/plugins/jquery/jquery.min.js"?>"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>