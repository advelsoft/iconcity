<?php require_once 'stimulsoft/helper.php';?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Facility Booking</title>
	<link rel="stylesheet" href="<?php echo base_url()."application/reporting/css/stimulsoft.viewer.office2013.whiteblue.css";?>" >
	<script type="text/javascript" src="<?php echo base_url()."application/reporting/scripts/stimulsoft.reports.js";?>" ></script>
	<script type="text/javascript" src="<?php echo base_url()."application/reporting/scripts/stimulsoft.viewer.js";?>" ></script>
	
	<?php
		$options = StiHelper::createOptions();
		$options->handler = base_url()."application/reporting/handler.php";
		$options->timeout = 30;
		StiHelper::initialize($options);
	?>
	<script type="text/javascript">
		function Start() {
		Stimulsoft.Base.StiLicense.key =
				"6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHnYQaPJ9mcBek1Ns9gSlgZkunP1HB4YHL4RhClH" +
				"TA627faspxkQlur5AqLfeovSxR+Wq9jFRCz68cgetivfWviQCW6wqm808woyAltnHpEbvHHPUzNQRGdR" +
				"o6+uNf9IKTkARXByHcmv0vt4y5l1Qz0FKW9KyXUkX5F6KHOCCs+EOmSZgEAf47OsMIbjrWfn3Up/+n1v" +
				"7nd9FMf2d0mvDAy8mgGYYU30U29XSKX30R8O4vL6t5vSKKN6WXQ11KZW7R+vb8J2vPkgI3HihoXyJALU" +
				"lWWFy6yae4DT6tse9J6rw94//cxZDuMzyU5PFZczmQ07oKfEx2AWwV73N3t9LHFEEX9ifzrc2tDA7Y42" +
				"cG1Ok8ZuXRL3JboUClGvOLgpJ2UgkFMVn8RU6/7G9enyNe+7Idgk2TK9fC7Lnx7x55r+aNNc0u65MH37" +
				"p/fhBhLfOowd5sGgw3JiexOwSsN7kIPKFJk4d083qysL2bNCpTWYPfVaOJD49JVAnjm97n8Tz05EidCz" +
				"+3CYUk2UHtlN6jZ3";
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
