<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade" id="sendpw">
	<div class="row">
		<div class="col-lg-12">
			<?php $attributes = array("id" => "emailform", "name" => "emailform");
			echo form_open("index.php/Common/Setup/SendPwSetup/".$CondoSeq, $attributes);?>
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="SENDPASSWORDTEXT" class="create-label col-md-2">Send Password Text</label>
									<div class="col-md-10">
										<textarea class="form-control" id="SENDPASSWORDTEXT" name="SENDPASSWORDTEXT" rows="15"><?php if (count($setupList) != 0) { echo $setupList[0]->SENDPASSWORDTEXT; } ?></textarea>
										<span class="text-danger"><?php echo form_error('SENDPASSWORDTEXT'); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--<div class="col-lg-3">
					<div class="panel panel-default">
						<div class="panel-heading">Token</div>
						<div class="panel-body">
							<div class="form-group">

							</div>
							<div class="form-group">

							</div>
							<div class="form-group">

							</div>
							<div class="form-group">

							</div>
							<div class="form-group">

							</div>
						</div>
					</div>
				</div>-->
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
<?php echo $this->session->flashdata('sendpw'); ?>