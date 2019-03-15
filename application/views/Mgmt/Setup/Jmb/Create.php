<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Jmb/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>JMB</h4>
				</div>
				<?php $attributes = array("id" => "userform", "name" => "userform");
				echo form_open("index.php/Common/Jmb/Create", $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">				
						<div class="form-group">
							<label for="PropertyNo" class="create-label col-md-4">Property No</label>
                            <div class="col-md-8">
                                <?php echo form_multiselect('PropertyNo[]', $usersList, array(), 'id="PropertyNo" size="10"'); ?>
								<span class="text-danger"><?php echo form_error('PropertyNo'); ?></span>
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