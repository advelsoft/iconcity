<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade" id="jompay">
	<div class="row">
		<div class="col-lg-12">
			<?php $attributes = array("id" => "jompayform", "name" => "jompayform");
			echo form_open("index.php/Common/Setup/Jompay/".$CondoSeq, $attributes);?>
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="JompayChck" class="create-label col-md-2">Jompay</label>
									<div class="col-md-6">
										<input type="checkbox" id="JompayChck" name="JompayChck" value="<?php echo $jompay[0]->JomPay; ?>" <?php echo set_checkbox('JompayChck','1'); ?> <?php if ($jompay[0]->JomPay == "0") {echo "checked = checked";} ?>/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div align="center">
					<input type="submit" value="Submit" class="submit" />
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('jompay'); ?>