<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
	<title><?php echo $company[0]->CompanyName; ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'content/img/cloud-icon.png'; ?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/bootstrap/bootstrap.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/metisMenu/metisMenu.min.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/forms.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/custom-css.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/timeline.css";?>">
    <link rel="stylesheet" href="<?php echo base_url()."content/css/morris.css";?>">
</head>
<body>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="navbar-brand" style="text-transform: uppercase;"><?php echo $company[0]->CompanyName; ?></div>
			</div>
			<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user gi-1x"></i> <i class="glyphicon glyphicon-triangle-bottom"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url()."index.php/Common/ProfileSet/Index";?>"><i class="glyphicon glyphicon-lock"></i>&nbsp;&nbsp;Profile Setting</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Logout&nbsp;</a></li>
                    </ul>
                </li>
            </ul>
		</div>
	</nav>
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<div class="menu-badge"><i class="glyphicon glyphicon-user"></i></div>
			<div class="menu-brand"><p align="center"><?php echo $_SESSION['fullname']; ?></p></div>
			<ul class="nav" id="side-menu">
				<li><a href="<?php echo base_url()."index.php/Tech/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;Dashboard&nbsp;</a></li>
				<li>
					<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;Feedbacks/Requests&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;Feedbacks/Requests&nbsp;</a></li>
						<li><a href="<?php echo base_url()."index.php/Common/ClosedFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
					</ul>
				</li>
				<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Logout&nbsp;</a></li>
			</ul>
		</div>
	</div>
	<div id="page-wrapper">
		<div class="row"></div>
		<div class="row row-header">
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-comment gi-5x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge"><?php echo count($feedback); ?></div>
									<div>Feedbacks/Requests</div></br>
									<span class="view-detail">View Details</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#feedback" data-toggle="tab">Feedbacks/Requests</a></li>
						</ul>
						<div class="tab-content">
							<?php echo $tab1; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script src="<?php echo base_url()."scripts/plugins/jquery/jquery.min.js";?>"></script>
<script src="<?php echo base_url()."scripts/plugins/bootstrap/bootstrap.js";?>"></script>
<script src="<?php echo base_url()."scripts/plugins/metisMenu/metisMenu.min.js";?>"></script>
<script src="<?php echo base_url()."scripts/custom-js.js";?>"></script>
</body>
</html>