<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/FacilityBooking/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div id="calendar"></div>
		</div>
	</div>
</div>
<script>
	var url = window.location.href;
	//get bokingtypeid from url
	var param = url.substring(url.lastIndexOf('/') + 1);
	var id = param.split("?")[0];
	//get date from url
	var value = param.split("?")[1];
	var date = value.split("=")[1];
	//get path from url
	var vars = url.split("/");
	var path = '';
	for (var i=0; i<vars.length-2; i++) {
		path += vars[i] + "/";
	}

	$("#calendar").datepicker({
		firstDay: 1,
		showOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dateFormat: "yy-mm-dd",
		minDate: 0,
		defaultDate: date,
		onSelect: function(dateText) {
			$(this).change();
		}
	})
	.change(function() {
		var href = path+'Create/'+id+'?Date='+this.value;
		window.location.href = href;
	});
</script>