<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
                        <?php if(isset($_SESSION['MgmtProfile']) && $_SESSION['MgmtProfile']){ ?>
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
				<li><a href="<?php echo base_url()."index.php/Mgmt/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;&nbsp;Dashboard&nbsp;</a></li>
				<?php if(isset($_SESSION['MgmtFeedbackRequest']) && $_SESSION['MgmtFeedbackRequest']){ ?>
				<li>
					<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;Feedbacks/Requests&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Open&nbsp;&nbsp;</a></li>
						<li><a href="<?php echo base_url()."index.php/Common/InProgressFeedbacks/Index";?>"><i class="glyphicon glyphicon-share-alt"></i>&nbsp;&nbsp;In Progress&nbsp;&nbsp;</a></li> 
						<li><a href="<?php echo base_url()."index.php/Common/ClosedFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
					</ul>
				</li>
				<?php } ?>
				<?php if(isset($_SESSION['MgmtFacilityBooking']) && $_SESSION['MgmtFacilityBooking']){ ?>
				<li><a href="#"><i class="glyphicon glyphicon-tasks"></i>&nbsp;&nbsp;Facility Booking&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;On Going Facility Booking&nbsp;&nbsp;</a></li>
						<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Approval";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Waiting Approval Facility Booking&nbsp;&nbsp;</a></li>
						<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/History";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Previous Facility Booking&nbsp;&nbsp;</a></li>
					</ul>
				</li>
				<?php } ?>
				<?php if(isset($_SESSION['MgmtNewsfeed']) && $_SESSION['MgmtNewsfeed']){ ?>
				<li><a href="<?php echo base_url()."index.php/Common/News/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Newsfeed&nbsp;</a></li>
				<?php } ?>
				<?php if(isset($_SESSION['MgmtSponsor']) && $_SESSION['MgmtSponsor']){ ?>
				<li><a href="<?php echo base_url()."index.php/Common/Promotion/Index/".GLOBAL_CONDOSEQ;?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Services On-Demand&nbsp;</a></li>
				<?php } ?>
				<li>
					<a href="#"><i class="glyphicon glyphicon-wrench"></i>&nbsp;&nbsp;Setup&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<?php if(isset($_SESSION['MgmtFeedbackRequest']) && $_SESSION['MgmtFeedbackRequest']){ ?>
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
						<?php if(isset($_SESSION['MgmtFacilityBooking']) && $_SESSION['MgmtFacilityBooking']){ ?>
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
						<?php if(isset($_SESSION['MgmtSetupForm']) && $_SESSION['MgmtSetupForm']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Forms/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Form Setup&nbsp;&nbsp;</a></li>
						<?php } ?>
						<?php if(isset($_SESSION['MgmtSetupCondoIntro']) && $_SESSION['MgmtSetupCondoIntro']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Amenities/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Condo Intro&nbsp;&nbsp;</a></li>
						<?php } ?>
						<?php if(isset($_SESSION['MgmtSetupContact']) && $_SESSION['MgmtSetupContact']){ ?>
							<li><a href="<?php echo base_url()."index.php/Common/Company/Index";?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Contact&nbsp;&nbsp;</a></li>
						<?php } ?>
						<?php if(isset($_SESSION['MgmtNewsfeed']) && $_SESSION['MgmtNewsfeed']){ ?>
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