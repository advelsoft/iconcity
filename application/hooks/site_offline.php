<?php
 
if (!defined('BASEPATH'))
exit('No direct script access allowed');
 
/**
* Description of site_offline
*
* @author admin
*/
class Site_Offline {
 
function __construct() {
 
}
 
public function is_offline() {
if (file_exists(APPPATH . 'config/config.php')) {
include(APPPATH . 'config/config.php');
 
if (isset($config['is_offline']) && $config['is_offline'] === TRUE) {
$this->show_site_offline();
exit;
}
}
}
 
private function show_site_offline() {
echo '<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
	<link rel="stylesheet" href="content/css/bootstrap/bootstrap.css">
	<link rel="stylesheet" href="content/css/metisMenu/metisMenu.min.css">
	<link rel="stylesheet" href="content/css/forms.css">
	<link rel="stylesheet" href="content/css/landing-page.css">
</head>
<body>
<!-- Header -->
<header id="top" class="header2">
	<div class="text-vertical-center">
		<div class="container">
			<div class="row text-center">
				<div class="headertext col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1>Sorry, we are down for maintenance.</h1>
					<h3>We will be back shortly.</h3>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-vertical-center copyright">
				<span>&copy; Advelsoft (M) Sdn Bhd [855271-W-M]. All Rights Reserved</span>
			</div>
		</div>
	</div>
	<a id="to-top" href="#top" class="btn btn-dark btn-md"><i class="glyphicon glyphicon-menu-up"></i></a>
</footer>

<script src="scripts/plugins/jquery/jquery.min.js"></script>
<script src="scripts/plugins/bootstrap/bootstrap.min.js"></script>
<script src="scripts/plugins/metisMenu/metisMenu.min.js"></script>
';
}
 
}
 
/* End of file site_offline.php */
/* Location: ./application/hooks/site_offline.php */