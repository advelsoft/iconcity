<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane fade in active" id="email">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<?php $attributes = array("id" => "emailform", "name" => "emailform");
				echo form_open("index.php/Common/Setup/EmailSetup/".$CondoSeq, $attributes);?>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-8">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="EMAILSERVER" class="create-label col-md-2">Email Server</label>
									<div class="col-md-6">
										<input id="EMAILSERVER" name="EMAILSERVER" placeholder="Email Server" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->EMAILSERVER; } ?>" />
										<span class="text-danger"><?php echo form_error('EMAILSERVER'); ?></span>
									</div>
								</div>
								<div class="form-group">
									<label for="SERVERPORT" class="create-label col-md-2">Email Port</label>
									<div class="col-md-6">
										<input id="SERVERPORT" name="SERVERPORT" placeholder="Email Port" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->SERVERPORT; } ?>" />
										<span class="text-danger"><?php echo form_error('SERVERPORT'); ?></span>
									</div>
								</div>
								<!--<div class="form-group">
									<label for="WEBPORTALUSER" class="create-label col-md-2">Web Portal User</label>
									<div class="col-md-6">
										<input id="WEBPORTALUSER" name="WEBPORTALUSER" placeholder="Web Portal User" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->WEBPORTALUSER; } ?>" />
										<span class="text-danger"><?php echo form_error('WEBPORTALUSER'); ?></span>
									</div>
								</div>-->
							</div>
						</div>
					</div>						
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">Sender</div>
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="EMAILSENDER" class="create-label col-md-2">Email Sender</label>
											<div class="col-md-6">
												<input id="EMAILSENDER" name="EMAILSENDER" placeholder="Email Sender" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->EMAILSENDER; } ?>" />
												<span class="text-danger"><?php echo form_error('EMAILSENDER'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="EMAILCC" class="create-label col-md-2">Email CC</label>
											<div class="col-md-6">
												<input id="EMAILCC" name="EMAILCC" placeholder="Email CC" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->EMAILCC; } ?>" />
												<span class="text-danger"><?php echo form_error('EMAILCC'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="EMAILBCC" class="create-label col-md-2">Email BCC</label>
											<div class="col-md-6">
												<input id="EMAILBCC" name="EMAILBCC" placeholder="Email BCC" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->EMAILBCC; } ?>" />
												<span class="text-danger"><?php echo form_error('EMAILBCC'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="AUTHUSER" class="create-label col-md-2">Auth User</label>
											<div class="col-md-6">
												<input id="AUTHUSER" name="AUTHUSER" placeholder="Auth User" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->AUTHUSER; } ?>" />
												<span class="text-danger"><?php echo form_error('AUTHUSER'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="AUTHPASSWORD" class="create-label col-md-2">Password</label>
											<div class="col-md-6">
												<input id="AUTHPASSWORD" name="AUTHPASSWORD" placeholder="Password" type="password" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->AUTHPASSWORD; } ?>" />
												<span class="text-danger"><?php echo form_error('AUTHPASSWORD'); ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">Complaint Receive</div>
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="COMPLAINTEMAIL" class="create-label col-md-2">Email</label>
											<div class="col-md-6">
												<input id="COMPLAINTEMAIL" name="COMPLAINTEMAIL" placeholder="Email" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->COMPLAINTEMAIL; } ?>" />
												<span class="text-danger"><?php echo form_error('COMPLAINTEMAIL'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="COMPLAINTUSERNAME" class="create-label col-md-2">Username</label>
											<div class="col-md-6">
												<input id="COMPLAINTUSERNAME" name="COMPLAINTUSERNAME" placeholder="Username" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->COMPLAINTUSERNAME; } ?>" />
												<span class="text-danger"><?php echo form_error('COMPLAINTUSERNAME'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="COMPLAINTPASSWORD" class="create-label col-md-2">Password</label>
											<div class="col-md-6">
												<input id="COMPLAINTPASSWORD" name="COMPLAINTPASSWORD" placeholder="Password" type="password" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->COMPLAINTPASSWORD; } ?>" />
												<span class="text-danger"><?php echo form_error('COMPLAINTPASSWORD'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="COMPLAINTACTIVE" class="create-label col-md-2">Activate</label>
											<div class="col-md-6">
												<input type="checkbox" id="COMPLAINTACTIVE" name="COMPLAINTACTIVE" <?php if (count($setupList) != 0) { if ($setupList[0]->COMPLAINTACTIVE == "1") {echo "checked = checked";} } ?> />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">Enquiry Receive</div>
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="ENQUIRYEMAIL" class="create-label col-md-2">Email</label>
											<div class="col-md-6">
												<input id="ENQUIRYEMAIL" name="ENQUIRYEMAIL" placeholder="Email" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->ENQUIRYEMAIL; } ?>" />
												<span class="text-danger"><?php echo form_error('ENQUIRYEMAIL'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="ENQUIRYUSERNAME" class="create-label col-md-2">Username</label>
											<div class="col-md-6">
												<input id="ENQUIRYUSERNAME" name="ENQUIRYUSERNAME" placeholder="Username" type="text" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->ENQUIRYUSERNAME; }  ?>" />
												<span class="text-danger"><?php echo form_error('ENQUIRYUSERNAME'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="ENQUIRYPASSWORD" class="create-label col-md-2">Password</label>
											<div class="col-md-6">
												<input id="ENQUIRYPASSWORD" name="ENQUIRYPASSWORD" placeholder="Password" type="password" class="form-control" value="<?php if (count($setupList) != 0) { echo $setupList[0]->ENQUIRYPASSWORD; } ?>" />
												<span class="text-danger"><?php echo form_error('ENQUIRYPASSWORD'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<label for="ENQUIRYACTIVE" class="create-label col-md-2">Activate</label>
											<div class="col-md-6">
												<input type="checkbox" id="ENQUIRYACTIVE" name="ENQUIRYACTIVE" <?php if (count($setupList) != 0) { if ($setupList[0]->ENQUIRYACTIVE == "1") { echo "checked = checked"; } } ?> />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="ATTACHMENTPATH" class="create-label col-md-2">Attachment Path</label>
											<div class="col-md-6">
												<?php echo form_open_multipart('"index.php/Common/Setup/Upload/"');?>
												<input type="text" name="ATTACHMENTPATH" />
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>-->		
					<div class="row">
						<div class="col-lg-12">
							<div align="center">
								<input type="submit" value="Submit" class="submit" />
							</div>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('email'); ?>