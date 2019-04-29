<?php require_once 'stimulsoft/helper.php';?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Facility Booking</title>
	<link href="<?php echo base_url()."application/reporting2/css/stimulsoft.viewer.office2013.whiteblue.css";?>" rel="stylesheet">
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
			Stimulsoft.Base.StiLicense.loadFromFile("license.key");
			var report = new Stimulsoft.Report.StiReport();
			report.loadFile("<?php echo base_url()."application/reporting2/reports/feedback.mrt";?>");
			report.dictionary.variables.getByName("condoseq").valueObject = "<?php echo $_SESSION['condoseq']; ?>";
			report.dictionary.variables.getByName("datefrom").valueObject = "<?php echo $_SESSION['datefrom']; ?>";
			report.dictionary.variables.getByName("dateto").valueObject = "<?php echo $_SESSION['dateto']; ?>";
			report.dictionary.variables.getByName("status").valueObject = "<?php echo $_SESSION['status']; ?>";

			var options = new Stimulsoft.Viewer.StiViewerOptions();
			options.appearance.fullScreenMode = true;
			options.toolbar.showSendEmailButton = true;
			var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);

			viewer.onBeginProcessData = function (args, callback) {
				<?php StiHelper::createHandler(); ?>
			}

			viewer.onEmailReport = function (event) {
				<?php StiHelper::createHandler(); ?>
			}

			viewer.report = report;
			viewer.renderHtml("viewerContent");
			<?php
				$this->session->unset_userdata('datefrom');
				$this->session->unset_userdata('dateto');
				$this->session->unset_userdata('status');
			?>
		}	
	</script>
	</head>
<body onload="Start()">
	<div id="viewerContent"></div>
</body>
</html>

