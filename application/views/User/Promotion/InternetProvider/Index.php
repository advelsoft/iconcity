<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/Index/".$_SESSION['condoseq'];?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Internet Provider</h4>
				</div>
				<?php $attributes = array("id" => "internetform", "name" => "internetform");
				echo form_open_multipart("index.php/Common/InternetProvider/PackageSumm/".$condoSeq, $attributes);?>
				<div class="panel-body">
					<ul class="nav nav-tabs navIP">
						<li class="maxisIP"><a href="#maxis" data-toggle="tab" onclick='return getProvider(this)'>Maxis</a></li>
						<li class="unifiIP"><a href="#unifi" data-toggle="tab" onclick='return getProvider(this)'>Unifi</a></li>
						<li class="timeIP"><a href="#time" data-toggle="tab" onclick='return getProvider(this)'>Time</a></li>
					</ul>
					<div class="tab-content">
						<?php echo $tab1; ?>
						<?php echo $tab2; ?>
						<?php echo $tab3; ?>
					</div>
				</div>
				<div class="panel-footer" style="text-align: right;" >
					<input id="provider" name="provider" type="hidden" value=""/>
					<input id="package" name="package" type="hidden" value=""/>
					<input type="submit" id="Submit" name="Submit" value="Submit" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script language="Javascript">
	function getPackage(ele){
		document.getElementById("package").value = ele.id;
	}
	
	function getProvider(ele){
		document.getElementById("provider").value = ele.innerHTML;
	}
	
	$( ".maxis-row" ).on( "click", function() {
		$( ".maxis-row" ).css({
			"background-color": "#fff"
		});
		$( ".unifi-row" ).css({
			"background-color": "#fff"
		});
		$( ".time-row" ).css({
			"background-color": "#fff"
		});
		$( this ).css({
			"background-color": "#e7e7e7",
			"color": "#000"
		});
	});
	
	$( ".unifi-row" ).on( "click", function() {
		$( ".unifi-row" ).css({
			"background-color": "#fff"
		});
		$( ".maxis-row" ).css({
			"background-color": "#fff"
		});
		$( ".time-row" ).css({
			"background-color": "#fff"
		});
		$( this ).css({
			"background-color": "#e7e7e7",
			"color": "#000"
		});
	});
	
	$( ".time-row" ).on( "click", function() {
		$( ".time-row" ).css({
			"background-color": "#fff"
		});
		$( ".unifi-row" ).css({
			"background-color": "#fff"
		});
		$( ".time-row" ).css({
			"background-color": "#fff"
		});
		$( this ).css({
			"background-color": "#e7e7e7",
			"color": "#000"
		});
	});
</script>