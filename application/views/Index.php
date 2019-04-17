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
				<?php if($_SESSION['role'] == 'Mgmt') :?>
					<li><a href="<?php echo base_url()."index.php/Mgmt/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;Dashboard&nbsp;</a></li>
					<li>
						<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;Feedbacks/Requests&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<!--<li><a href="<?php echo base_url()."index.php/Common/AllFeedbacks/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;All&nbsp;&nbsp;</a></li>-->
							<li><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Open&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/InProgressFeedbacks/Index";?>"><i class="glyphicon glyphicon-share-alt"></i>&nbsp;&nbsp;In Progress&nbsp;&nbsp;</a></li> 
							<li><a href="<?php echo base_url()."index.php/Common/ClosedFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="glyphicon glyphicon-tasks"></i>&nbsp;Facility Booking&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;On Going Facility Booking&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Approval";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Waiting Approval Facility Booking&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/History";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Previous Facility Booking&nbsp;&nbsp;</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url()."index.php/Common/News/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;News/Events&nbsp;</a></li>
					<li><a href="<?php echo base_url()."index.php/Common/Notice/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Notice Board&nbsp;</a></li>
					<!--<li><a href="<?php echo base_url()."index.php/Common/Notification/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Email Notification&nbsp;</a></li>-->
					<li><a href="<?php echo base_url()."index.php/Common/Promotion/Index/".$_SESSION['condoseq'];?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Sponsor&nbsp;</a></li>
					<li>
						<a href="#"><i class="glyphicon glyphicon-wrench"></i>&nbsp;Setup&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Department Setup&nbsp;<span class="glyphicon arrow"></span></a>
								<ul class="nav nav-third-level">
									<li><a href="<?php echo base_url()."index.php/Common/Departments/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Department&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/Positions/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Position&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/NameEmail/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Name/Email&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/Technician/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Assign Technician&nbsp;&nbsp;</a></li>
								</ul>
							</li>
							<li>
								<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Complaint Setup&nbsp;<span class="glyphicon arrow"></span></a>
								<ul class="nav nav-third-level">
									<li><a href="<?php echo base_url()."index.php/Common/Categories/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Main Categories&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/SubCategories/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Sub-Categories&nbsp;&nbsp;</a></li>
									<!--<li><a href="<?php echo base_url()."index.php/Common/Elevation/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Elevation&nbsp;&nbsp;</a></li>-->
								</ul>
							</li>
							<li>
								<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Facility Setup&nbsp;<span class="glyphicon arrow"></span></a>
								<ul class="nav nav-third-level">
									<li><a href="<?php echo base_url()."index.php/Common/BookingStatus/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Facilities Status&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/BookingGroup/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Facilities Group&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/BookingType/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Assign Facility&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/BlockUsers/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Blacklist&nbsp;&nbsp;</a></li>
								</ul>
							</li>
							<li>
								<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Upload Setup&nbsp;<span class="glyphicon arrow"></span></a>
								<ul class="nav nav-third-level">
									<li><a href="<?php echo base_url()."index.php/Common/UploadType/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Upload Type&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/Upload/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Upload&nbsp;&nbsp;</a></li>
								</ul>
							</li>
							<li><a href="<?php echo base_url()."index.php/Common/Amenities/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Condo Intro&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/Company/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Contact&nbsp;&nbsp;</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url()."index.php/Common/Reporting/Index";?>"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Reporting&nbsp;</a></li>
					<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout</a></li>
				<?php else: ?>
					<li><a href="<?php echo base_url()."index.php/User/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;Dashboard&nbsp;</a></li>
					<li>
						<a href="#"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Account Summary&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/Outstanding/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;E-Payment (JomPAY)&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/Outstanding/Statement";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;E-Statement&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/Outstanding/History";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Payment History&nbsp;&nbsp;</a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;Feedbacks/Requests&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;New Feedbacks/Requests&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/ClosedFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Facility Booking&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>"><i class="glyphicon glyphicon-tasks"></i>&nbsp;New Facility Booking&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Lists";?>"><i class="glyphicon glyphicon-tasks"></i>&nbsp;On Going Facilities Booking&nbsp;</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url()."index.php/Common/Promotion/Index/".$_SESSION['condoseq'];?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Sponsor&nbsp;</a></li>
					<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<div id="page-wrapper">
		<div class="row"></div>
		<div class="row row-header">
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<a href="<?php echo base_url()."index.php/Common/FacilityBooking/Approval";?>">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-tasks gi-5x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge"><?php echo count($booking); ?></div>
									<div>Facilites Booking</div></br>
									<span class="view-detail">View Details</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
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
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<a href="<?php echo base_url()."index.php/Common/News/Index";?>">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-envelope gi-5x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge"><?php echo count($news); ?></div>
									<div>News/Events</div></br>
									<span class="view-detail">View Details</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<a href="<?php echo base_url()."index.php/Common/Notice/Index";?>">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-list-alt gi-5x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge"><?php echo count($notice); ?></div>
									<div>Noticeboard</div></br>
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
							<li class="active"><a href="#promo" data-toggle="tab">Promotion</a></li>
							<?php if($_SESSION['role'] == 'Mgmt'): ?>
								<li><a href="#tasktodo" data-toggle="tab">Tasks To Do</a></li>
							<?php else: ?>
								<li><a href="#whatsnew" data-toggle="tab">What's New</a></li>
							<?php endif ?>
							<li><a href="#booking" data-toggle="tab">Facilites Booking</a></li>
							<li><a href="#feedback" data-toggle="tab">Feedbacks/Requests</a></li>
							<li><a href="#news" data-toggle="tab">News/Events</a></li>
							<li><a href="#notice" data-toggle="tab">Notice board</a></li>
						</ul>
						<div class="tab-content">
							<?php echo $tab1; ?>
							<?php echo $tab2; ?>
							<?php echo $tab3; ?>
							<?php echo $tab4; ?>
							<?php echo $tab5; ?>
							<?php echo $tab6; ?>
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
									<ul class="nav formbar" id="form-menu">
										<li>
											<a href="#">Complaint Form<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><a href="<?php echo base_url()."application/uploads/files/20170112025910_dummy.jpg";?>" target="_blank">&nbsp;&nbsp;Complaint Form1</a></li>
												<li><a href="<?php echo base_url()."application/uploads/files/20170116042154_9BU_E-PORTAL_LAUNCH.jpg";?>" target="_blank">&nbsp;&nbsp;Complaint Form2</a></li>
											</ul>
										</li>
										<li>
											<a href="#">Change of Address Form<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Change of Address Form1</a></li>
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Change of Address Form2</a></li>
											</ul>
										</li>
										<li>
											<a href="#">Deposit Refund Form<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Deposit Refund Form1</a></li>
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Deposit Refund Form2</a></li>
											</ul>
										</li>
										<li><a href="<?php echo base_url()."";?>" target="_blank">Form1</a></li>
										<li><a href="<?php echo base_url()."";?>" target="_blank">Form2</a></li>
										<li><a href="<?php echo base_url()."";?>" target="_blank">Form3</a></li>
									</ul>
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
									<ul class="nav formbar" id="jmb-menu">
										<li>
											<a href="#">JMB MOM<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li>
													<a href="#">&nbsp;&nbsp;1st JMB Minutes of Meeting<span class="glyphicon arrow"></span></a>
													<ul class="nav nav-third-level">
														<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;1st JMB Meeting No 1</a></li>
														<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;1st JMB Meeting No 2</a></li>
													</ul>
												</li>
												<li>
													<a href="#">&nbsp;&nbsp;2nd JMB Minutes of Meeting<span class="glyphicon arrow"></span></a>
													<ul class="nav nav-third-level">
														<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;2nd JMB Meeting No 1</a></li>
														<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;2nd JMB Meeting No 2</a></li>
													</ul>
												</li>
											</ul>
										</li>
										<li>
											<a href="#">AGM and EGM<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;2015 1st AGM</a></li>
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;2015 2nd AGM</a></li>
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;2016 1st EGM</a></li>
											</ul>
										</li>
										<li>
											<a href="#">Audited Account<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Audited Acc 1 </a></li>
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Audited Acc 2</a></li>
											</ul>
										</li>
										<li>
											<a href="#">Newsletter<span class="glyphicon arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Newsletter 1</a></li>
												<li><a href="<?php echo base_url()."";?>" target="_blank">&nbsp;&nbsp;Newsletter 2</a></li>
											</ul>
										</li>
										<li><a href="<?php echo base_url()."";?>" target="_blank">JMB SOP</a></li>
									</ul>
								</td></tr>
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
									<ul class="nav formbar" id="use-menu">
										<li><a href="<?php echo base_url()."";?>" target="_blank">House Rules</a></li>
										<li><a href="<?php echo base_url()."";?>" target="_blank">Strata Management Act 2013 </a></li>
										<li><a href="<?php echo base_url()."";?>" target="_blank">Emergency Contact</a></li>
									</ul>
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
<script src="<?php echo base_url()."scripts/plugins/bootstrap/bootstrap.js";?>"></script>
<script src="<?php echo base_url()."scripts/plugins/metisMenu/metisMenu.min.js";?>"></script>
<script src="<?php echo base_url()."scripts/custom-js.js";?>"></script>
</body>
</html>