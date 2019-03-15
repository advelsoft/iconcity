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
                    	<?php if($_SESSION['MgmtProfile']){ ?>
                        	<li><a href="<?php echo base_url()."index.php/Common/ProfileSet/Index";?>"><i class="glyphicon glyphicon-lock"></i>&nbsp;&nbsp;Profile Setting</a></li>
                        <?php } ?>
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
				<li><a href="<?php echo base_url()."index.php/Mgmt/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;Dashboard&nbsp;</a></li>
				<?php if($_SESSION['MgmtFeedbackRequest']){ ?>
					<li>
						<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;Feedbacks/Requests&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Open&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/InProgressFeedbacks/Index";?>"><i class="glyphicon glyphicon-share-alt"></i>&nbsp;&nbsp;In Progress&nbsp;&nbsp;</a></li> 
							<li><a href="<?php echo base_url()."index.php/Common/ClosedFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if($_SESSION['MgmtFacilityBooking']){ ?>
					<li><a href="#"><i class="glyphicon glyphicon-tasks"></i>&nbsp;Facility Booking&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;On Going Facility Booking&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Approval";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Waiting Approval Facility Booking&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/History";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Previous Facility Booking&nbsp;&nbsp;</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if($_SESSION['MgmtNewsfeed']){ ?>
					<li><a href="<?php echo base_url()."index.php/Common/News/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Newsfeed&nbsp;</a></li>
				<?php } ?>
				<?php if($_SESSION['MgmtSponsor']){ ?>
					<li><a href="<?php echo base_url()."index.php/Common/Promotion/Index/".GLOBAL_CONDOSEQ;?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Services On-Demand&nbsp;</a></li>
				<?php } ?>
				<li>
					<a href="#"><i class="glyphicon glyphicon-wrench"></i>&nbsp;Setup&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<?php if($_SESSION['MgmtFeedbackRequest']){ ?>
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
								</ul>
							</li>
						<?php } ?>
						<?php if($_SESSION['MgmtFacilityBooking']){ ?>
							<li>
								<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Facility Setup&nbsp;<span class="glyphicon arrow"></span></a>
								<ul class="nav nav-third-level">
									<li><a href="<?php echo base_url()."index.php/Common/BookingStatus/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Facilities Status&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/BookingGroup/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Facilities Group&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/BookingType/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Assign Facility&nbsp;&nbsp;</a></li>
									<li><a href="<?php echo base_url()."index.php/Common/BlockUsers/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Blacklist&nbsp;&nbsp;</a></li>
								</ul>
							</li>
						<?php } ?>
						<?php if($_SESSION['MgmtSetupForm']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Forms/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Form Setup&nbsp;&nbsp;</a></li>
						<?php } ?>
						<?php if($_SESSION['MgmtSetupCondoIntro']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Amenities/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Condo Intro&nbsp;&nbsp;</a></li>
						<?php } ?>
						<?php if($_SESSION['MgmtSetupContact']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Company/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Contact&nbsp;&nbsp;</a></li>
						<?php } ?>
						<?php if($_SESSION['MgmtNewsfeed']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Jmb/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;JMB Setup&nbsp;&nbsp;</a></li>
						<?php } ?>
					</ul>
				</li>
				<li>
					<a href="#"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Reporting&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/Common/Reporting/Index";?>"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Report&nbsp;</a></li>
					</ul>
				</li>
				<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Logout</a></li>
			</ul>
		</div>
	</div>
	<div id="page-wrapper">
		<div class="row"></div>
		<div class="row row-header">
			<?php if($_SESSION['MgmtFacilityBooking']){ ?>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<a href="<?php echo base_url()."index.php/Common/FacilityBooking/Approval";?>">
						<div class="panel panel-blue">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-2">
										<i class="glyphicon glyphicon-tasks gi-x"></i>
									</div>
									<div class="col-xs-10 text-right">
										<div class="huge"><?php echo count($booking); ?></div>
										<div class="panel-title">Facilites Booking</div></br>
										<span class="view-detail">View Details</span>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-tasks gi-x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge">0</div>
									<div class="panel-title">Facilites Booking</div></br>
									<span class="view-detail">Unsubscribed</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($_SESSION['MgmtFeedbackRequest']){ ?>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-2">
										<i class="glyphicon glyphicon-comment gi-x"></i>
									</div>
									<div class="col-xs-10 text-right">
										<div class="huge"><?php echo count($feedback); ?></div>
										<div class="panel-title">Feedbacks/Requests</div></br>
										<span class="view-detail">View Details</span>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-comment gi-x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge">0</div>
									<div class="panel-title">Feedbacks/Requests</div></br>
									<span class="view-detail">Unsubscribed</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($_SESSION['MgmtNewsfeed']){ ?>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<a href="<?php echo base_url()."index.php/Common/News/Index";?>">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-2">
										<i class="glyphicon glyphicon-envelope gi-x"></i>
									</div>
									<div class="col-xs-10 text-right">
										<div class="huge"><?php echo count($news); ?></div>
										<div class="panel-title">Newsfeed</div></br>
										<span class="view-detail">View Details</span>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			<?php }else{ ?>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-2">
									<i class="glyphicon glyphicon-envelope gi-x"></i>
								</div>
								<div class="col-xs-10 text-right">
									<div class="huge">0</div>
									<div class="panel-title">Newsfeed</div></br>
									<span class="view-detail">Unsubscribed</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tasktodo" data-toggle="tab">Tasks To Do</a></li>
							<?php if($_SESSION['MgmtFacilityBooking']){ ?>
								<li><a href="#booking" data-toggle="tab">Facilites Booking</a></li>
							<?php } ?>
							<?php if($_SESSION['MgmtFeedbackRequest']){ ?>
								<li><a href="#feedback" data-toggle="tab">Feedbacks/Requests</a></li>
							<?php } ?>
							<?php if($_SESSION['MgmtNewsfeed']){ ?>
								<li><a href="#news" data-toggle="tab">Newsfeed</a></li>
							<?php } ?>
							<?php if($_SESSION['MgmtSponsor']){ ?>
								<li><a href="#promo" data-toggle="tab">Promotion</a></li>
							<?php } ?>
						</ul>
						<div class="tab-content">
							<?php echo $tab1; ?>
							<?php if($_SESSION['MgmtFacilityBooking']){ ?>
							    <?php echo $tab2; ?>
							<?php } ?>
							<?php if($_SESSION['MgmtFeedbackRequest']){ ?>
								<?php echo $tab3; ?>
							<?php } ?>
							<?php if($_SESSION['MgmtNewsfeed']){ ?>
								<?php echo $tab4; ?>
							<?php } ?>
							<?php if($_SESSION['MgmtSponsor']){ ?>
								<?php echo $tab5; ?>
							<?php } ?>
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
										<!--Level 1-->
										<?php foreach ($formList as $item) { ?>
											<?php if($item['cnt'] != ''): { ?>
												<?php echo '<li><a href="'.$item['file'].'">'.$item['name'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
												<!--Level 2-->
												<?php echo '<ul class="nav nav-second-level">'?>
													<?php foreach ($subformList as $subitem) { ?>
														<?php if($subitem['parentID'] == $item['formID']) { ?>
															<?php if($subitem['cnt'] != ''): { ?>
																<?php echo '<li><a href="'.$subitem['file'].'">&nbsp;&nbsp;'.$subitem['name'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
																<!--Level 3-->
																<?php echo '<ul class="nav nav-third-level">'?>
																	<?php foreach ($subsubformList as $subsubitem) { ?>
																		<?php if($subsubitem['parentID'] == $subitem['formID']) { ?>
																			<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$subsubitem['file'].'" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;'.$subsubitem['name'].'</a></li>'; ?>
																		<?php } ?>
																	<?php } ?>
																<?php echo '</ul>' ?>
																<!----------->
															<?php } else: {?>
																<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$subitem['file'].'" target="_blank">&nbsp;&nbsp;'.$subitem['name'].'</a>'; ?>
															<?php } endif;?>
														<?php } ?>
													<?php } ?>
												<?php echo '</li></ul>' ?>
												<!----------->
											<?php } else: {?>
												<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$item['file'].'" target="_blank">'.$item['name'].'</a>'; ?>
											<?php } endif;?>
											<?php echo '</li>' ?>
										<?php } ?>
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
										<!--Level 1-->
										<?php foreach ($archiveList as $item) { ?>
											<?php if($item['cnt'] != ''): { ?>
												<?php echo '<li><a href="'.$item['file'].'">'.$item['name'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
												<!--Level 2-->
												<?php echo '<ul class="nav nav-second-level">'?>
													<?php foreach ($subarchiveList as $subitem) { ?>
														<?php if($subitem['parentID'] == $item['formID']) { ?>
															<?php if($subitem['cnt'] != ''): { ?>
																<?php echo '<li><a href="'.$subitem['file'].'">&nbsp;&nbsp;'.$subitem['name'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
																<!--Level 3-->
																<?php echo '<ul class="nav nav-third-level">'?>
																	<?php foreach ($subsubarchiveList as $subsubitem) { ?>
																		<?php if($subsubitem['parentID'] == $subitem['formID']) { ?>
																			<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$subsubitem['file'].'" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;'.$subsubitem['name'].'</a></li>'; ?>
																		<?php } ?>
																	<?php } ?>
																<?php echo '</ul>' ?>
																<!----------->
															<?php } else: {?>
																<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$subitem['file'].'" target="_blank">&nbsp;&nbsp;'.$subitem['name'].'</a>'; ?>
															<?php } endif;?>
														<?php } ?>
													<?php } ?>
												<?php echo '</li></ul>' ?>
												<!----------->
											<?php } else: {?>
												<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$item['file'].'" target="_blank">'.$item['name'].'</a>'; ?>
											<?php } endif;?>
											<?php echo '</li>' ?>
										<?php } ?>
									</ul>
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
										<!--Level 1-->
										<?php foreach ($infoList as $item) { ?>
											<?php if($item['cnt'] != ''): { ?>
												<?php echo '<li><a href="'.$item['file'].'">'.$item['name'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
												<!--Level 2-->
												<?php echo '<ul class="nav nav-second-level">'?>
													<?php foreach ($subinfoList as $subitem) { ?>
														<?php if($subitem['parentID'] == $item['formID']) { ?>
															<?php if($subitem['cnt'] != ''): { ?>
																<?php echo '<li><a href="'.$subitem['file'].'">&nbsp;&nbsp;'.$subitem['name'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
																<!--Level 3-->
																<?php echo '<ul class="nav nav-third-level">'?>
																	<?php foreach ($subsubinfoList as $subsubitem) { ?>
																		<?php if($subsubitem['parentID'] == $subitem['formID']) { ?>
																			<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$subsubitem['file'].'" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;'.$subsubitem['name'].'</a></li>'; ?>
																		<?php } ?>
																	<?php } ?>
																<?php echo '</ul>' ?>
																<!----------->
															<?php } else: {?>
																<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$subitem['file'].'" target="_blank">&nbsp;&nbsp;'.$subitem['name'].'</a>'; ?>
															<?php } endif;?>
														<?php } ?>
													<?php } ?>
												<?php echo '</li></ul>' ?>
												<!----------->
											<?php } else: {?>
												<?php echo '<li><a href="'.base_url().'application/uploads/forms/'.$item['file'].'" target="_blank">'.$item['name'].'</a>'; ?>
											<?php } endif;?>
											<?php echo '</li>' ?>
										<?php } ?>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php echo base_url()."scripts/plugins/metisMenu/metisMenu.min.js";?>"></script>
<script src="<?php echo base_url()."scripts/custom-js.js";?>"></script>
</body>
</html>