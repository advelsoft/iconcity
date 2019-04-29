<?php
require_once "stimulsoft2/helper.php";
?>
<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" charset="text/html; charset=UTF-8">
	<title>Report.mrt - Viewer</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/reporting/css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>application/reporting/scripts/stimulsoft.reports.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>application/reporting/scripts/stimulsoft.viewer.js"></script>

	<?php 
		$options = StiHelper::createOptions();
		$options->handler = "handler.php";
		$options->timeout = 30;
		StiHelper::initialize($options);
	?>
	<script type="text/javascript">
		function Start(){
			var report = new Stimulsoft.Report.StiReport();
			report.loadFile("<?php echo base_url(); ?>application/reporting/reports/testing.mrt");

			var options = new Stimulsoft.Viewer.StiViewerOptions();
			var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);

			viewer.onBeginProcessData = function (args, callback){
				<?php StiHelpert::createHandler(); ?>
			}

			viewer.report = report;
			viewer.renderHtml('viewerContent');
		}
	</script>
</head>
<body onload="Start()">
	<div id="viewerContent"></div>
</body>
</html>