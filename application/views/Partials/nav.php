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
				<a class="navbar-brand" href="<?php echo base_url()."index.php/Home/Index";?>">Welcome <?php echo $_SESSION['username']; ?></a>
			</div>
		</div>
	</nav>
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li>
					<a href="<?php echo base_url()."index.php/Home/Index";?>"><i class="glyphicon glyphicon-dashboard"></i>&nbsp;Dashboard&nbsp;</a>
				</li>
				<li>
					<a href="#"><i class="glyphicon glyphicon-comment"></i>&nbsp;Tickets&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/Tickets/AllTickets_Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;All&nbsp;&nbsp;</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Open&nbsp;&nbsp;</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-share-alt"></i>&nbsp;&nbsp;In Progress&nbsp;&nbsp;</a></li> 
						<li><a href="#"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Closed&nbsp;&nbsp;</a></li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Facility Booking&nbsp;<span class="glyphicon arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?php echo base_url()."index.php/FacilityBooking/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Facility Management&nbsp;&nbsp;</a></li>
						<li><a href="<?php echo base_url()."index.php/BookingType/Index";?>"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;Booking Type&nbsp;&nbsp;</a></li>
					</ul>
				</li>
				<li>
					<a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
				</li>
			</ul>
		</div>
	</div>