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
				<!--Level 1-->
				<?php foreach ($menuList as $item) { ?>
					<?php if($item['cnt'] != ''): { ?>
						<?php echo '<li><a href="'.$item['link'].'"><i class="glyphicon glyphicon-'.$item['icon'].'"></i>&nbsp;&nbsp;'.$item['label'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
						<!--Level 2-->
						<?php echo '<ul class="nav nav-second-level">'?>
							<?php foreach ($submenuList as $subitem) { ?>
								<?php if($subitem['parentID'] == $item['uid']) { ?>
									<?php if($subitem['cnt'] != ''): { ?>
										<?php echo '<li><a href="'.$subitem['link'].'"><i class="glyphicon glyphicon-'.$subitem['icon'].'"></i>&nbsp;&nbsp;'.$subitem['label'].'&nbsp;<span class="glyphicon arrow"></span></a>'; ?>
										<!--Level 3-->
										<?php echo '<ul class="nav nav-third-level">'?>
											<?php foreach ($subsubmenuList as $subsubitem) { ?>
												<?php if($subsubitem['parentID'] == $subitem['uid']) { ?>
													<?php echo '<li><a href="'.base_url().$subsubitem['link'].'"><i class="glyphicon glyphicon-'.$subsubitem['icon'].'"></i>&nbsp;&nbsp;'.$subsubitem['label'].'</a></li>'; ?>
												<?php } ?>
											<?php } ?>
										<?php echo '</ul>' ?>
										<!----------->
									<?php } else: {?>
										<?php echo '<li><a href="'.base_url().$subitem['link'].'"><i class="glyphicon glyphicon-'.$subitem['icon'].'"></i>&nbsp;&nbsp;'.$subitem['label'].'</a>'; ?>
									<?php } endif;?>
								<?php } ?>
							<?php } ?>
						<?php echo '</li></ul>' ?>
						<!----------->
					<?php } else: {?>
						<?php echo '<li><a href="'.base_url().$item['link'].'"><i class="glyphicon glyphicon-'.$item['icon'].'"></i>&nbsp;&nbsp;'.$item['label'].'</a>'; ?>
					<?php } endif;?>
					<?php echo '</li>' ?>
				<?php } ?>
			</ul>
		</div>
	</div>
