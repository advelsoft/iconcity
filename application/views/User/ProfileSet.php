<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/User/Home/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Profile Setting</h4>
				</div>			
				<?php $attributes = array("id" => "changepwform", "name" => "changepwform");
				echo form_open("index.php/Common/ProfileSet/ProfileSet", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="OldUser" class="create-label col-md-3">Old Username</label>
							<div class="col-md-9">
								<input id="OldUser" name="OldUser" placeholder="Old Username" type="text" class="form-control" value="<?php echo $profileSet[0]->LOGINID; ?>" readonly />
								<span class="text-danger"><?php echo form_error('OldUser'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="NewUser" class="create-label col-md-3">New Username</label>
							<div class="col-md-9">
								<input id="NewUser" name="NewUser" placeholder="New Username" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('NewUser'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="OldPw" class="create-label col-md-3">Old Password</label>
							<div class="col-md-9">
								<input id="OldPw" name="OldPw" placeholder="Old Password" type="password" class="form-control" value="<?php echo $profileSet[0]->LOGINPASSWORD; ?>" />
								<span class="text-danger"><?php echo form_error('OldPw'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="NewPw" class="create-label col-md-3">New Password</label>
							<div class="col-md-9">
								<input id="NewPw" name="NewPw" placeholder="New Password" type="password" class="form-control" value=""
								 placeholder="Password must be atleast 8 characters long." />
								<span class="text-danger"><?php echo form_error('NewPw'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="ConfirmPw" class="create-label col-md-3">Confirm New Password</label>
							<div class="col-md-9">
								<input id="ConfirmPw" name="ConfirmPw" placeholder="Confirm New Password" type="password" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('ConfirmPw'); ?></span>
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