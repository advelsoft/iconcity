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
                        <?php if(isset($_SESSION['ResidentProfile']) && $_SESSION['ResidentProfile']){ ?>
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
				<li><a href="<?php echo base_url()."index.php/User/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;&nbsp;Dashboard&nbsp;</a></li>
				<?php if(isset($_SESSION['ResidentAccountSummary']) && $_SESSION['ResidentAccountSummary']){ ?>
					<li>
						<a href="#"><i class="glyphicon glyphicon-inbox"></i>&nbsp;&nbsp;Account Summary&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/Outstanding/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;E-Payment (JomPAY)&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/Outstanding/Statement";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;E-Statement&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/Outstanding/History";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Payment History&nbsp;&nbsp;</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if(isset($_SESSION['ResidentFeedbackRequest']) && $_SESSION['ResidentFeedbackRequest']){ ?>
					<li>
						<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;Feedbacks/Requests&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/OpenFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;New Feedbacks/Requests&nbsp;&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/ClosedFeedbacks/Index";?>"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if(isset($_SESSION['ResidentFacilityBooking']) && $_SESSION['ResidentFacilityBooking']){ ?>
					<li>
						<a href="#"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Facility Booking&nbsp;<span class="glyphicon arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>"><i class="glyphicon glyphicon-tasks"></i>&nbsp;New Facility Booking&nbsp;</a></li>
							<li><a href="<?php echo base_url()."index.php/Common/FacilityBooking/Lists";?>"><i class="glyphicon glyphicon-tasks"></i>&nbsp;On Going Facilities Booking&nbsp;</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if(isset($_SESSION['ResidentSponsor']) && $_SESSION['ResidentSponsor']){ ?>
					<li><a href="<?php echo base_url()."index.php/Common/Promotion/Index/".GLOBAL_CONDOSEQ;?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Sponsor&nbsp;</a></li>
				<?php } ?>
				<li><a href="<?php echo base_url()."index.php/Login/Logout";?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout</a></li>
			</ul>
		</div>
	</div>