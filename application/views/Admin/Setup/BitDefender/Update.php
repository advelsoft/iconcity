<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
    <div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/BitDefender";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>BitDefender</h4>
				</div>	
					<?php $attributes = array("id" => "bitdefenderform", "name" => "bitdefenderform");
					echo form_open_multipart("index.php/Common/BitDefender/Update".$UID, $attributes);?>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="ProductName" class="create-label col-md-2">Product Name</label>
								<div class="col-md-5">
									<input id="ProductName" name="ProductName" placeholder="Product Name" type="text" class="form-control" value="<?php echo $bitdefRecord[0]->ProductName; ?>" />
									<span class="text-danger"><?php echo form_error('ProductName'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="ProductImage" class="create-label col-md-2">Product Image</label>
								<div class="col-md-10">
									<textarea class="form-control" id="ProductImage" name="ProductImage" rows="4"><?php echo $bitdefRecord[0]->ProductImage; ?></textarea>
									<span class="text-danger"><?php echo form_error('ProductImage'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="Description" class="create-label col-md-2">Description</label>
								<div class="col-md-10">
									<textarea class="form-control" id="Description" name="Description" rows="4"><?php echo $bitdefRecord[0]->ProductDesc; ?></textarea>
									<span class="text-danger"><?php echo form_error('Description'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="NormalPrice" class="create-label col-md-2">Normal Price</label>
								<div class="col-md-4">
									<input id="NormalPrice" name="NormalPrice" placeholder="Normal Price" type="text" class="form-control" value="<?php echo $bitdefRecord[0]->NormalPrice; ?>" />
									<span class="text-danger"><?php echo form_error('NormalPrice'); ?></span>
								</div>
							</div>
							<div class="form-group">
								<label for="PromoDate" class="create-label col-md-2">Promo Date</label>
								<div class="col-md-4">
									<input id="PromoDate" name="PromoDate" placeholder="Promo Date" type="text" class="form-control" value="<?php if ($bitdefRecord[0]->PromoDate != '') { echo date("d/m/Y", strtotime($bitdefRecord[0]->PromoDate)); } ?>" />
									<span class="text-danger"><?php echo form_error('PromoDate'); ?></span>
								</div>
								<label for="PromoPrice" class="create-label col-md-2">Promo Price</label>
								<div class="col-md-4">
									<input id="PromoPrice" name="PromoPrice" placeholder="Promo Price" type="text" class="form-control" value="<?php echo $bitdefRecord[0]->PromoPrice; ?>" />
									<span class="text-danger"><?php echo form_error('PromoPrice'); ?></span>
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
	$(function() {
		$('#ProductImage').summernote({
			height: 260,
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
		
		$('#Description').summernote({
			height: 250,   
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
    });
	
	$(document).ready(function(){
		$('#PromoDate').datepicker({
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