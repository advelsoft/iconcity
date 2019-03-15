<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade" id="sms">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="SMSUSERNAME" class="create-label col-md-2">SMS Username</label>
							<div class="col-md-6">
								<input id="SMSUSERNAME" name="SMSUSERNAME" placeholder="SMS Username" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('SMSUSERNAME'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="SMSPASSWORD" class="create-label col-md-2">SMS Password</label>
							<div class="col-md-6">
								<input id="SMSPASSWORD" name="SMSPASSWORD" placeholder="SMS Password" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('SMSPASSWORD'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="SMSSERVERSCRIPT" class="create-label col-md-2">SMS Server Script</label>
							<div class="col-md-6">
								<input id="SMSSERVERSCRIPT" name="SMSSERVERSCRIPT" placeholder="SMS Server Script" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('SMSSERVERSCRIPT'); ?></span>
							</div>
						</div>
					</div>
					<div align="center">
						<input type="submit" class="btn btn-lg btn-default" value="OK" />
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>