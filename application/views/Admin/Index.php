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
	<link rel="stylesheet" href="<?php echo base_url()."content/css/metisMenu/metisMenu.min.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/forms.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/custom-css.css";?>">
	<link rel="stylesheet" href="<?php echo base_url()."content/css/timeline.css";?>">
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
						<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout</a></li>
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
				<li><a href="<?php echo base_url()."index.php/Admin/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;Dashboard&nbsp;</a></li>
				<li>
					<a href="#"><i class="glyphicon glyphicon-wrench"></i>&nbsp;Setup&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/Common/Setup/Lists";?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Server Setup&nbsp;&nbsp;</a></li>
						<li><a href="<?php echo base_url()."index.php/Common/Users/Index";?>"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Users&nbsp;&nbsp;</a></li>
						<li>
							<a href="#"><i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;Sponsor&nbsp;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="<?php echo base_url()."index.php/Common/PromoCategory/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Sponsor Category&nbsp;</a></li>
								<li><a href="<?php echo base_url()."index.php/Common/Promotion/Lists";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Sponsor List&nbsp;</a></li>
								<li><a href="<?php echo base_url()."index.php/Common/Promotion/Eset";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Eset&nbsp;</a></li>
								<li><a href="<?php echo base_url()."index.php/Common/Promotion/BitDefender";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;BitDefender&nbsp;</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="<?php echo base_url()."index.php/Common/Reporting/Jompay";?>"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Reporting&nbsp;</a></li>
				<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Logout&nbsp;</a></li>
			</ul>
		</div>
	</div>
	<div id="page-wrapper">
		<div class="row"></div>
		<div class="row row-header">
			<div class="col-lg-3 col-md-6">
				<a href="#">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="glyphicon glyphicon-tasks gi-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">0</div>
									<div>Facilites Booking</div></br>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="#">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="glyphicon glyphicon-comment gi-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">0</div>
									<div>Feedbacks/Requests</div></br>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="#">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="glyphicon glyphicon-envelope gi-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">0</div>
									<div>News/Events</div></br>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6">
				<a href="#">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="glyphicon glyphicon-list-alt gi-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">0</div>
									<div>Noticeboard</div></br>
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
							<li class="active"><a href="#promo" data-toggle="tab">Promotion</a></li>
							<li><a href="#booking" data-toggle="tab">Facilites Booking</a></li>
							<li><a href="#feedback" data-toggle="tab">Feedbacks/Requests</a></li>
							<li><a href="#news" data-toggle="tab">News/Events</a></li>
							<li><a href="#notice" data-toggle="tab">Notice board</a></li>
						</ul>
						<div class="tab-content">
							<?php echo $tab1; ?>
							<!--<?php echo $tab2; ?>
							<?php echo $tab3; ?>
							<?php echo $tab4; ?>
							<?php echo $tab5; ?>-->
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Forms</div>
					<div class="panel-body">
						<table class="table table-striped table-hover table-custom">
							<tbody>
								<tr><td>
								</td></tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;Archive Files</div>
					<div class="panel-body">
						<table class="table table-striped table-hover table-custom">
							<tbody>
								<tr><td>
								</td></tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Useful Info</div>
					<div class="panel-body">
						<table class="table table-striped table-hover table-custom">
							<tbody>
								<tr><td>
								</td></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url()."scripts/plugins/jquery/jquery.min.js";?>"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php echo base_url()."scripts/plugins/metisMenu/metisMenu.min.js";?>"></script>
<script src="<?php echo base_url()."scripts/custom-js.js";?>"></script>
</body>
</html>