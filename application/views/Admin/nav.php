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