<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Forms/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Forms</h4>
				</div>			
				<?php $attributes = array("id" => "menuform", "name" => "menuform");
				echo form_open_multipart("index.php/Common/Forms/Update/".$formID, $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="FormType" class="create-label col-md-2">Form Type *</label>
                            <div class="col-md-5">
                                <?php $attributes = 'class = "form-control" id = "FormType"';
								echo form_dropdown('FormType',$formType,set_value('FormType', $formRecord['type']),$attributes);?>
								<span class="text-danger"><?php echo form_error('FormType'); ?></span>
                            </div>
						</div>
						<div class="form-group">
							<label for="FormName" class="create-label col-md-2">Form Name *</label>
                            <div class="col-md-5">
                                <input id="FormName" name="FormName" placeholder="Form Name" type="text" class="form-control" value="<?php echo $formRecord['name']; ?>" />
								<span class="text-danger"><?php echo form_error('FormName'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="FormFile" class="create-label col-md-2">Form File</label>
                            <div class="col-md-5">
                                <input type="file" name="FormFile" value="<?php echo $formRecord['file']; ?>"/>
								<span class="text-danger"><?php echo form_error('FormFile'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Level" class="create-label col-md-2">Level *</label>
                            <div class="col-md-3">
                                <?php $attributes = 'class = "form-control" id = "Level"';
								echo form_dropdown('Level',$level,set_value('Level', $formRecord['level']),$attributes);?>
								<span class="text-danger"><?php echo form_error('Level'); ?></span>
                            </div>
						</div>
						<div class="form-group">
							<label for="ParentID" class="create-label col-md-2">Parent ID</label>
                            <div class="col-md-3">
                                <?php $attributes = 'class = "form-control" id = "ParentID"';
								echo form_dropdown('ParentID',$parentID,set_value('ParentID', $formRecord['parentID']),$attributes);?>
								<span class="text-danger"><?php echo form_error('ParentID'); ?></span>
                            </div>
						</div>
						<div class="form-group">
							<label for="Sequence" class="create-label col-md-2">Sequence</label>
                            <div class="col-md-3">
                                <input id="Sequence" name="Sequence" placeholder="Sequence" type="text" class="form-control" value="<?php echo $formRecord['sequence']; ?>" />
								<span class="text-danger"><?php echo form_error('Sequence'); ?></span>
                            </div>
						</div>
						<div class="form-group">
							<label for="UserGroup" class="create-label col-md-2">User Group</label>
                            <div class="col-md-3">
                                Management&nbsp;&nbsp;
								<input type="checkbox" id="Mgmt" name="Mgmt" value="<?php echo $formRecord['mgmt']; ?>" <?php echo set_checkbox('Mgmt','1'); ?> <?php if ($formRecord['mgmt'] == "1") {echo "checked = checked";} ?>/>&nbsp;
								<span class="text-danger"><?php echo form_error('Mgmt'); ?></span>
								Owner&nbsp;&nbsp;
								<input type="checkbox" id="Owner" name="Owner" value="<?php echo $formRecord['owner']; ?>" <?php echo set_checkbox('Owner','1'); ?> <?php if ($formRecord['owner'] == "1") {echo "checked = checked";} ?>/>&nbsp;
								<span class="text-danger"><?php echo form_error('Owner'); ?></span>
								Tenant&nbsp;&nbsp;
								<input type="checkbox" id="Tenant" name="Tenant" value="<?php echo $formRecord['tenant']; ?>" <?php echo set_checkbox('Tenant','1'); ?> <?php if ($formRecord['tenant'] == "1") {echo "checked = checked";} ?>/>&nbsp;
								<span class="text-danger"><?php echo form_error('Tenant'); ?></span>
								JMB&nbsp;&nbsp;
								<input type="checkbox" id="JMB" name="JMB" value="<?php echo $formRecord['jmb']; ?>" <?php echo set_checkbox('JMB','1'); ?> <?php if ($formRecord['jmb'] == "1") {echo "checked = checked";} ?>/>&nbsp;
								<span class="text-danger"><?php echo form_error('JMB'); ?></span>
                            </div>
                        </div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" value="Submit" class="submit" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script language="Javascript">
	$("#Mgmt").click(function() {
		var mgmt = document.getElementById("Mgmt").value;
		if(mgmt == '1'){
			document.getElementById("Mgmt").value = '0';
		}
		else{
			document.getElementById("Mgmt").value = '1';
		}
	});
	
	$("#Owner").click(function() {
		var owner = document.getElementById("Owner").value;
		if(owner == '1'){
			document.getElementById("Owner").value = '0';
		}
		else{
			document.getElementById("Owner").value = '1';
		}
	});
	
	$("#Tenant").click(function() {
		var tenant = document.getElementById("Tenant").value;
		if(tenant == '1'){
			document.getElementById("Tenant").value = '0';
		}
		else{
			document.getElementById("Tenant").value = '1';
		}
	});
	
	$("#JMB").click(function() {
		var jmb = document.getElementById("JMB").value;
		if(jmb == '1'){
			document.getElementById("JMB").value = '0';
		}
		else{
			document.getElementById("JMB").value = '1';
		}
	});
</script>