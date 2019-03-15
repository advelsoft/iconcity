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
					<h4>Statement</h4>
				</div>			
				<?php $attributes = array("id" => "statementform", "name" => "statementform", "target" => "_blank");
				echo form_open("index.php/Common/Outstanding/GenerateStatement", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="CustType" class="create-label col-md-3">Type</label>
                            <div class="col-md-9">
                                <label for="CustType"><?php echo 'Tenant'; ?></label>
								<span class="text-danger"><?php echo form_error('CustType'); ?></span>
								<input id="hdnCustType" name="hdnCustType" type="hidden" value="T" />
                            </div>
                        </div>
						<div class="form-group">
							<label for="DateFrom" class="create-label col-md-3">As at (yyyy/mm/dd)</label>
                            <div class="col-md-9">
                                <input id="DateFrom" name="DateFrom" placeholder="Date" type="text" class="form-control" value="<?php echo date("Y-m-d") ?>" />
								<span class="text-danger"><?php echo form_error('DateFrom'); ?></span>
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
			dateFormat: "yy/mm/dd",
			onSelect: function(dateText) {
				$(this).change();
			}
		});
	});
</script>