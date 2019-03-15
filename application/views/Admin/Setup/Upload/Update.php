<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
    <div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Upload/Index";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Upload</h4>
				</div>	
				<div class="panel-body">
					<div class="form-horizontal">
						<label for="File" class="create-label col-md-2">Previous File</label>
						<div class="col-md-10">
							<input type="image" src="<?php echo base_url().'application/uploads/files/'.$uploadRecord['file'];?>" alt="File">
						</div>
					<?php $attributes = array("id" => "uploadform", "name" => "uploadform");
					echo form_open_multipart("index.php/Common/Upload/Update/".$uploadID, $attributes);?>
					<div class="form-group">
						<label for="File" class="create-label col-md-2">New File</label>
						<div class="col-md-10">
							<input type="file" name="File" value=""/>
							<span class="text-danger"><?php echo form_error('File'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="Type" class="create-label col-md-2">Type</label>
						<div class="col-md-10">
							<?php $attributes = 'class = "form-control" id = "Type"';
							echo form_dropdown('Type',$uploadType,set_value('Type', $uploadRecord['type']),$attributes);?>
							<span class="text-danger"><?php echo form_error('Type'); ?></span>
						</div>
					</div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" value="SUBMIT" class="submit" />
					<a href="<?php echo base_url()."index.php/Common/Upload/Delete/".$uploadRecord['uploadID']; ?>" style="text-align:center">
						<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
					</a>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>