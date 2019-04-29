<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/User/Home/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to Dashboard
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>E-Statement</h4>
				</div>			
				<?php $attributes = array("id" => "statementform", "name" => "statementform", "target" => "_blank");
				echo form_open("index.php/Common/Outstanding/GenerateStatement", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="CustType" class="create-label col-md-2">Type</label>
                            <div class="col-md-4">
                                <?php $attributes = 'class = "form-control" id = "CustType"';
								echo form_dropdown('CustType',$userType,set_value('CustType'),$attributes);?>
								<span class="text-danger"><?php echo form_error('CustType'); ?></span>
								<input id="hdnCustType" name="hdnCustType" type="hidden" value="" />
                            </div>
                        </div>
                        <div class="form-group">
							<label for="year" class="create-label col-md-2">Year</label>
                            <div class="col-md-4">
                                <select id="year" name="year" class="form-control">
                                	<?php $a=date("Y"); $b=$a-7;
                                	for($c=$a; $c>$b; $c--){ ?>
                            			<option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                            		<?php } ?>
                            	</select>
								<span class="text-danger"><?php echo form_error('DateTo'); ?></span>
							</div>
                        </div>
						<div class="form-group">
							<label for="month" class="create-label col-md-2">Month</label>
							<div class="col-md-4">
                            	<select id="month" name="month" class="form-control">
                            		<option value="1">January</option>
                            		<option value="2">February</option>
                            		<option value="3">March</option>
                            		<option value="4">April</option>
                            		<option value="5">May</option>
                            		<option value="6">June</option>
                            		<option value="7">July</option>
                            		<option value="8">August</option>
                            		<option value="9">September</option>
                            		<option value="10">October</option>
                            		<option value="11">November</option>
                            		<option value="12">December</option>
                            	</select>
								<span class="text-danger"><?php echo form_error('month'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div id="btns" style='margin: 0 auto;text-align:center'>
						<button id="generate" class="btn btn-sm btn-grey" style="color: white; text-transform: uppercase;">Generate Statement</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	function getCustType(){
		var custType = document.getElementById("CustType").value;
		document.getElementById("hdnCustType").value = custType;
	};
	$("#CustType").change(getCustType);
	
	function generateStatement(){
		try{
			document.statementform.action = document.statementform.hdnStatement.value;
			document.statementform.target = "_blank";
			document.statementform.submit();
		}catch(e){alert(e)}
	}
	
	$(document).ready(function(){
		$('#DateFrom').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "yy-mm-dd",
			onSelect: function(dateText) {
				$(this).change();
			}
		});
		
		$('#DateTo').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "yy-mm-dd",
			onSelect: function(dateText) {
				$(this).change();
			}
		});

		var d = new Date();
		var n = d.getMonth();
		a = n + 1;
		$("#month option[value="+a+"]").attr('selected', 'selected');
	});
</script>