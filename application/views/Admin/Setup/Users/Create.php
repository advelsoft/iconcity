<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Users/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
				</div>			
				<?php $attributes = array("id" => "userform", "name" => "userform");
				echo form_open("index.php/Common/Users/Create", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">				
						<div class="form-group">
							<label for="LoginID" class="create-label col-md-4">Login ID</label>
                            <div class="col-md-8">
                                <input id="LoginID" name="LoginID" placeholder="Login ID" type="text" class="form-control"  value="" />
								<span class="text-danger"><?php echo form_error('LoginID'); ?></span>
                            </div>
                        </div>								
						<div class="form-group">
							<label for="LoginPassword" class="create-label col-md-4">Login Password</label>
                            <div class="col-md-8">
                                <input id="LoginPassword" name="LoginPassword" placeholder="Login Password" type="password" class="form-control"  value="" />
								<span class="text-danger"><?php echo form_error('LoginPassword'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Name" class="create-label col-md-4">Name</label>
                            <div class="col-md-8">
                                <input id="Name" name="Name" placeholder="Name" type="text" class="form-control"  value="" />
								<span class="text-danger"><?php echo form_error('Name'); ?></span>
                            </div>
                        </div>					
						<div class="form-group">
							<label for="Email" class="create-label col-md-4">Email</label>
                            <div class="col-md-8">
                                <input id="Email" name="Email" placeholder="Email" type="text" class="form-control"  value="" />
								<span class="text-danger"><?php echo form_error('Email'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Phone" class="create-label col-md-4">Phone Number</label>
							<div class="col-md-8">
								<input id="Phone" name="Phone" placeholder="Phone Number" type="text" class="form-control"  value="" />
								<span class="text-danger"><?php echo form_error('Phone'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Role" class="create-label col-md-4">Role</label>
                            <div class="col-md-8">
                                <?php $attributes = 'class = "form-control" id = "Role"';
								echo form_dropdown('Role',$userRole,set_value('Role'),$attributes);?>
								<span class="text-danger"><?php echo form_error('Role'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="CondoSeq" class="create-label col-md-4">Condo</label>
                            <div class="col-md-8">
                                <?php $attributes = 'class = "form-control" id = "CondoSeq"';
								echo form_dropdown('CondoSeq',$condo,set_value('CondoSeq'),$attributes);?>
								<span class="text-danger"><?php echo form_error('CondoSeq'); ?></span>
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