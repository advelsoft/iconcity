<?php require_once 'stimulsoft/helper.php';?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Feedback Report Summary</title>

	<!-- Report Office2013 style -->
	<link href="<?php echo base_url()."application/reporting2/css/stimulsoft.viewer.office2013.whiteblue.css";?>" rel="stylesheet">

	<!-- Stimusloft Reports.JS -->
	<script src="<?php echo base_url()."application/reporting2/scripts/stimulsoft.reports.js";?>" type="text/javascript"></script>
	<script src="<?php echo base_url()."application/reporting2/scripts/stimulsoft.viewer.js";?>" type="text/javascript"></script>
	
	<?php
		$options = StiHelper::createOptions();
		$options->handler = base_url()."application/reporting2/handler.php";
		$options->timeout = 30;
		StiHelper::initialize($options);
	?>
	<script type="text/javascript">
		function Start() {
			var report = new Stimulsoft.Report.StiReport();
			report.loadFile("<?php echo base_url()."application/reporting2/reports/FeedbackS.mrt";?>");

			var options = new Stimulsoft.Viewer.StiViewerOptions();
			options.appearance.fullScreenMode = true;
			options.toolbar.showSendEmailButton = true;
			var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
			
			// Process SQL data source
			viewer.onBeginProcessData = function (event, callback) {
				<?php StiHelper::createHandler(); ?>
			}
			
			// Load and show report
			
			viewer.report = report;
			viewer.renderHtml("viewerContent");
		}
	</script>
	</head>
<body onload="Start()">
	<div id="viewerContent"></div>
</body>
</html>
