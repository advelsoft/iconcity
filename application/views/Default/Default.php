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
	<link rel="stylesheet" href="content/css/metisMenu/metisMenu.min.css">
	<link rel="stylesheet" href="content/css/forms.css">
	<link rel="stylesheet" href="content/css/landing-page.css">
	<style>
		.carousel {
			margin-bottom: 0;
			padding: 0 40px 30px 40px;
		}
		/* The controlsy */
		.carousel-control {
			left: -12px;
			height: 40px;
			width: 40px;
			background: none repeat scroll 0 0 #222222;
			border: 4px solid #FFFFFF;
			border-radius: 23px 23px 23px 23px;
			margin-top: 90px;
		}
		.carousel-control.right {
			right: -12px;
		}
		/* The indicators */
		.carousel-indicators {
			right: 50%;
			top: auto;
			bottom: -10px;
			margin-right: -19px;
		}
		/* The colour of the indicators */
		.carousel-indicators li {
			background: #cecece;
		}
		.carousel-indicators .active {
		background: #428bca;
		}
	</style>
</head>
<body>

<!-- Navigation -->
<a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
<nav id="sidebar-wrapper">
	<ul class="sidebar-nav">
		<a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="glyphicon glyphicon-remove"></i></a>
		<li class="sidebar-brand"><a href="#top" onclick=$("#menu-close").click();><?php echo $condo[0]->CondoName; ?></a></li>
		<li><a href="#top" onclick=$("#menu-close").click();>Home</a></li>
		<li><a href="#gallery" onclick=$("#menu-close").click();>Gallery</a></li>
		<li><a href="#news" onclick=$("#menu-close").click();>News</a></li>
		<li><a href="#contact" onclick=$("#menu-close").click();>Contact</a></li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Login
				<span class="caret">&nbsp;</span>
			</a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					<div class="panel-body">
						<?php $attributes = array("id" => "Loginform", "name" => "Loginform");
						echo form_open("", $attributes);?>
						<fieldset>
							<div class="form-custom">Username
								<input type="text" class="form-control" id="username" name="username" placeholder="Your username">
							</div>
							<div class="form-custom">Password
								<input type="password" class="form-control" id="password" name="password" placeholder="Your password">
							</div>
							<div class="loginForgetPw">
								<a href="<?php echo base_url()."index.php/Common/ForgetPassword/Index";?>">Forget Password</a>
							</div>
							<div>
								<input type="submit" class="btn btn-lg btn-success btn-block" value="Submit" />
							</div>
						</fieldset>
						<?php echo form_close(); ?>
						<?php echo $this->session->flashdata('msg'); ?>
					</div>
				</li>
			</ul>
		</li>
	</ul>
</nav>

<!-- Header -->
<header id="top" class="header">
	<div class="text-vertical-center">
		<div class="container">
			<div class="row text-center">
				<div class="headertext col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1><?php if (count($amenities) != 0) { echo $amenities[0]->Title; } ?></h1>
					<h3><?php if (count($amenities) != 0) { echo $amenities[0]->Summary; } ?></h3>
				</div>
				<a href="#" class="btn btn-dark btn-md" data-toggle="modal" data-target="#more"><b>Read More</b></a>
				<!-- Modal -->
				<div class="modal fade" id="more" tabindex="-1" role="dialog" aria-labelledby="taskform" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<!-- Modal Body -->
							<div class="modal-body">
								<div class="moreinfo"><?php if (count($amenities) != 0) { echo $amenities[0]->Description; } ?></div>
							</div>
							<!-- Modal Footer -->
							<div class="modal-footer">
								<button class="btn-dark" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<?php if($UACLanding->GalleryFacilities == TRUE || $UACLanding->GalleryCommonArea == TRUE || $UACLanding->GalleryFloorPlan == TRUE ){ ?>
<!-- Gallery -->
<section class="gallery" id="gallery" style="min-height: 400px; position: relative; padding: 100px 0; background: url(<?php echo base_url() ?>/content/img/gallery-bg.jpg); background-attachment: fixed; background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="dmask">
        <div class="our-clients">
            <div class="container">
				<div class="row text-center">
					<h2>Gallery</h2>
					<hr class="small">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div id="Carousel" class="carousel slide">
									<ol class="carousel-indicators">
										<li data-target="#Carousel" data-slide-to="0" class="active"></li>
										<li data-target="#Carousel" data-slide-to="1"></li>
										<li data-target="#Carousel" data-slide-to="2"></li>
									</ol>
									<div class="carousel-inner">
										<!-- Facilities -->
										<div class="item active">
											<div class="row">
											  <div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/facilities/fc01.jpg" alt="Image" style="max-width:100%;"></a></div>
											  <div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/facilities/fc02.jpg" alt="Image" style="max-width:100%;"></a></div>
											  <div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/facilities/fc03.jpg" alt="Image" style="max-width:100%;"></a></div>
											  <div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/facilities/fc04.jpg" alt="Image" style="max-width:100%;"></a></div>
											  <!--<div class="imgTitle">Facilities</div>-->
											</div>
										</div>
										<!-- Common Area -->
										<div class="item">
											<div class="row">
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/common-area/ca01.jpg" alt="Image" style="max-width:100%;"></a></div>
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/common-area/ca02.jpg" alt="Image" style="max-width:100%;"></a></div>
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/common-area/ca03.jpg" alt="Image" style="max-width:100%;"></a></div>
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/common-area/ca04.jpg" alt="Image" style="max-width:100%;"></a></div>
												<!--<div class="imgTitle">Common Area</div>-->
											</div>
										</div>
										<!-- Floor Plan -->
										<div class="item">
											<div class="row">
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/floor-plan/fp01.jpg" alt="Image" style="max-width:100%;"></a></div>
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/floor-plan/fp02.jpg" alt="Image" style="max-width:100%;"></a></div>
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/floor-plan/fp03.jpg" alt="Image" style="max-width:100%;"></a></div>
												<div class="col-md-3"><a href="#gallery" class="thumbnail"><img src="content/img/floor-plan/fp04.jpg" alt="Image" style="max-width:100%;"></a></div>
												<!--<div class="imgTitle">Floor Plan</div>-->
											</div>
										</div>
									</div>
									<a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
									<a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php if($UACLanding->News == TRUE ){ ?>
<!-- News -->
<section id="news" class="news bg-primary">
	<div class="container">
		<div class="row text-center">
			<div class="col-lg-10 col-lg-offset-1">
				<h2>News</h2>
				<hr class="small">
				<div class="row">
					<?php if (count($news) > 0): {?>
						<?php for ($i = 0; $i < count($news); ++$i) { ?>
							<div class="col-md-12 col-sm-6">
								<div class="news-item">
									<h4><strong><?php echo $news[$i]->Title; ?></strong></h4>
									<!--<p><?php echo $news[$i]->Summary; ?></p>-->
									<a href="<?php echo base_url()."index.php/Common/News/News/".$news[$i]->NewsID;?>" class="btn btn-light">Read More</a>
									</br>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php else: ?>
						<div class="col-md-12 col-sm-6">
							<div class="news-item">
								<h4><strong>No News Available</strong></h4>
							</div>
						</div>
					<?php endif;?>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.col-lg-10 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->
</section>
<?php } ?>
<?php if($UACLanding->Map == TRUE ){ ?>
<!-- Map -->
<section id="contact" class="map">
	<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php if($UACLanding->EmbedMap != '' ){ echo $UACLanding->EmbedMap; } ?>"></iframe>
</section>
<?php } ?>
<?php if($UACLanding->Contact == TRUE ){ ?>
<!-- Contact -->
<section class="bg-primary" style="background: url(<?php echo base_url() ?>/content/img/contact-bg.jpg); background-attachment: fixed; background-size: cover; background-position: center; background-repeat: no-repeat; padding: 100px 0;">
	<div class="container">
		<div class="row text-center">
			<div class="headertext col-lg-10 col-lg-offset-1">
				<div class="row">
					<div class="col-md-12 col-sm-6">
						<div class="contact-item">
							<h4><strong><?php echo $company[0]->CompanyName; ?></strong></h4>
							<?php echo $company[0]->Contact; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 copyright">
				<span>&copy; Advelsoft (M) Sdn Bhd [855271-W]. All Rights Reserved</span>
			</div>
		</div>
	</div>
	<a id="to-top" href="#top" class="btn btn-dark btn-md"><i class="glyphicon glyphicon-menu-up"></i></a>
</footer>

<script src="scripts/plugins/jquery/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="scripts/plugins/jquery/jquery.backstretch.js"></script>
<script>
    $.backstretch([
	  "content/img/bg.jpg",
	  "content/img/bg2.jpg",
	  "content/img/bg3.jpg",
	  "content/img/bg4.jpg",
	  "content/img/bg5.jpg"
	], {
		fade: 750,
		duration: 4000
	});
	
	// Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    //#to-top button appears after scrolling
    var fixed = false;
    $(document).scroll(function() {
        if ($(this).scrollTop() > 250) {
            if (!fixed) {
                fixed = true;
                // $('#to-top').css({position:'fixed', display:'block'});
                $('#to-top').show("slow", function() {
                    $('#to-top').css({
                        position: 'fixed',
                        display: 'block'
                    });
                });
            }
        } else {
            if (fixed) {
                fixed = false;
                $('#to-top').hide("slow", function() {
                    $('#to-top').css({
                        display: 'none'
                    });
                });
            }
        }
    });
    // Disable Google Maps scrolling
    // See http://stackoverflow.com/a/25904582/1607849
    // Disable scroll zooming and bind back the click event
    var onMapMouseleaveHandler = function(event) {
        var that = $(this);
        that.on('click', onMapClickHandler);
        that.off('mouseleave', onMapMouseleaveHandler);
        that.find('iframe').css("pointer-events", "none");
    }
    var onMapClickHandler = function(event) {
            var that = $(this);
            // Disable the click handler until the user leaves the map area
            that.off('click', onMapClickHandler);
            // Enable scrolling zoom
            that.find('iframe').css("pointer-events", "auto");
            // Handle the mouse leave event
            that.on('mouseleave', onMapMouseleaveHandler);
        }
        // Enable map zooming with mouse scroll when the user clicks the map
    $('.map').on('click', onMapClickHandler);
	
	$(document).ready(function () {
		$('#myCarousel').carousel({
			interval: 10000
		})
	});
</script>
</body>
</html>