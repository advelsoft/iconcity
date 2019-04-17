<?php require_once 'stimulsoft/helper.php';?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Facility Booking</title>

	<!-- Report Office2013 style -->
	<link href="<?php echo base_url()."application/reporting/css/stimulsoft.viewer.office2013.whiteteal.css";?>" rel="stylesheet">

	<!-- Stimusloft Reports.JS -->
	<script src="<?php echo base_url()."application/reporting/scripts/stimulsoft.reports.js";?>" type="text/javascript"></script>
	<script src="<?php echo base_url()."application/reporting/scripts/stimulsoft.viewer.js";?>" type="text/javascript"></script>
	
	
	<?php
		$options = StiHelper::createOptions();
		$options->handler = "handler.php";
		$options->timeout = 30;
		StiHelper::initialize($options);
	?>
	<script type="text/javascript">
		function Start() {
			var report = new Stimulsoft.Report.StiReport();
			report.loadFile("<?php echo base_url()."application/reporting/reports/fbooking.mrt";?>");
			report.dictionary.variables.getByName("condoseq").valueObject = "<?php echo $_SESSION['condoseq']; ?>";
			report.dictionary.variables.getByName("datefrom").valueObject = "<?php echo $_SESSION['datefrom']; ?>";
			report.dictionary.variables.getByName("dateto").valueObject = "<?php echo $_SESSION['dateto']; ?>";

			var options = new Stimulsoft.Viewer.StiViewerOptions();
			options.appearance.fullScreenMode = true;
			options.toolbar.showSendEmailButton = true;
			var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);

			viewer.onBeginProcessData = function (args, callback) {
				<?php StiHelper::createHandler(); ?>
			}
			
			// Send exported report to server side
			/*viewer.onEndExportReport = function (event) {
				event.preventDefault = true; // Prevent client default event handler (save the exported report as a file)
			<?php StiHelper::createHandler(); ?>
			}*/
			
			viewer.onEmailReport = function (event) {
				<?php StiHelper::createHandler(); ?>
			}

			viewer.report = report;
			viewer.renderHtml("viewerContent");
			<?php
				$this->session->unset_userdata('datefrom');
				$this->session->unset_userdata('dateto');
			?>
		}	
	</script>
	</head>
<body>
	<div id="viewerContent"></div>
</body>
</html>
