<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
    <div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/News/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Newsfeeds</h4>
				</div>	
				<?php $attributes = array("id" => "newsform", "name" => "newsform");
				echo form_open_multipart("index.php/Common/News/Update/".$newsID, $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="NewsType" class="create-label col-md-2">Newsfeeds Type</label>
							<div class="col-md-10">
								<?php $attributes = 'class = "form-control" id = "NewsType"';
								echo form_dropdown('NewsType',$newsType,set_value('NewsType', $newsRecord[0]->NewsfeedTypeID),$attributes);?>
								<span class="text-danger"><?php echo form_error('NewsType'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Title" class="create-label col-md-2">Title</label>
							<div class="col-md-10">
								<input id="Title" name="Title" placeholder="Title" type="text" class="form-control" value="<?php echo $newsRecord[0]->Title; ?>" />
								<span class="text-danger"><?php echo form_error('Title'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="NewsType" class="create-label col-md-2">Summary *(Maxlength:300)</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Summary" name="Summary" placeholder="Summary (Maxlength:300)" rows="5" maxlength="300"><?php echo $newsRecord[0]->Summary?></textarea>
								<span class="text-danger"><?php echo form_error('Summary'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="NewsType" class="create-label col-md-2">Description</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Description" name="Description" rows="5"><?php echo $newsRecord[0]->Description; ?></textarea>
								<span class="text-danger"><?php echo form_error('Description'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="NewsfeedDate" class="create-label col-md-2">Newsfeeds Date</label>
                            <div class="col-md-4">
								<input id="NewsfeedDate" name="NewsfeedDate" placeholder="News/Events Date" type="text" class="form-control" value="<?php echo date("d/m/Y", strtotime($newsRecord[0]->NewsfeedDate));?>" />
								<span class="text-danger"><?php echo form_error('NewsfeedDate'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Attachment1" class="create-label col-md-2">Attachment</label>
							<div class="col-md-10 field_wrapper">
								<input class="col-md-5" type="file" name="Attachment1" value=""/>
								<a href="javascript:void(0);" class="add_button col-md-5" title="Add field"><img src="<?php echo base_url()."content/img/add-icon.png";?>" /></a>
								<span class="text-danger"><?php echo form_error('Attachment1'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="PublishDateFrom" class="create-label col-md-2">Publish Date From</label>
                            <div class="col-md-4">
								<input id="PublishDateFrom" name="PublishDateFrom" placeholder="Publish Date From" type="text" class="form-control" value="<?php echo date("d/m/Y", strtotime($newsRecord[0]->PublishDateFrom));?>" />
								<span class="text-danger"><?php echo form_error('PublishDateFrom'); ?></span>
							</div>
							<label for="PublishDateTo" class="create-label col-md-1">Publish Date To</label>
                            <div class="col-md-4">
								<input id="PublishDateTo" name="PublishDateTo" placeholder="Publish Date To" type="text" class="form-control" value="<?php echo date("d/m/Y", strtotime($newsRecord[0]->PublishDateTo));?>" />
								<span class="text-danger"><?php echo form_error('PublishDateTo'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Publish" class="create-label col-md-2">Publish</label>
							<div class="col-md-1">
								<input type="checkbox" id="Publish" name="Publish" class="form-control" value="1" <?php echo ($newsRecord[0]->Publish == '1' ? 'checked' : null); ?>>
								<span class="text-danger"><?php echo form_error('Publish'); ?></span>
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
<script>
	/*$(function() {
		$('#Description').summernote({
			height: 300,
			popover: ['air', ['']],
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['fontsize', ['fontname', 'fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'picture']],
				['insert', ['table', 'hr']],
				['misc', ['fullscreen', 'codeview', 'help']]
			]
		});
    });*/
	
	$(document).ready(function(){
		$('#NewsfeedDate').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
		
		$('#PublishDateFrom').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
		
		$('#PublishDateTo').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
	});
</script>