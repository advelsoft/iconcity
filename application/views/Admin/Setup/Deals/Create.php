<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/Deals/".$condoSeq;?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Deals</h4>
				</div>			
				<?php $attributes = array("id" => "promoform", "name" => "promoform");
				echo form_open_multipart("index.php/Common/Deals/Create/".$condoSeq, $attributes);?>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="Title" class="create-label col-md-2">Title</label>
                            <div class="col-md-5">
                                <input id="Title" name="Title" placeholder="Title" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('Title'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Summary" class="create-label col-md-2">Summary</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Summary" name="Summary" rows="4"></textarea>
								<span class="text-danger"><?php echo form_error('Summary'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Description" class="create-label col-md-2">Description</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
								<span class="text-danger"><?php echo form_error('Description'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="Introduction" class="create-label col-md-2">Introduction</label>
							<div class="col-md-10">
								<textarea class="form-control" id="Introduction" name="Introduction" rows="4"></textarea>
								<span id="maxContentPost"></span>
								<span class="text-danger"><?php echo form_error('Introduction'); ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="PromoCode" class="create-label col-md-2">Promo Price</label>
                            <div class="col-md-4">
                                <input id="PromoPrice" name="PromoPrice" placeholder="Promo Price" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('PromoPrice'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="PromoDateFrom" class="create-label col-md-2">Promo Date From</label>
                            <div class="col-md-4">
								<input id="PromoDateFrom" name="PromoDateFrom" placeholder="Promo Date From" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('PromoDateFrom'); ?></span>
							</div>
							<label for="PromoDateTo" class="create-label col-md-2">Promo Date To</label>
                            <div class="col-md-4">
								<input id="PromoDateTo" name="PromoDateTo" placeholder="Promo Date To" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('PromoDateTo'); ?></span>
							</div>
                        </div>
						<div class="form-group">
							<label for="PromoUrl" class="create-label col-md-2">Promotion Link</label>
                            <div class="col-md-4">
                                <input id="PromoUrl" name="PromoUrl" placeholder="URL" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('PromoUrl'); ?></span>
                            </div>
							<label for="PromoCode" class="create-label col-md-2">Promo Code</label>
                            <div class="col-md-4">
                                <input id="PromoCode" name="PromoCode" placeholder="Promo Code" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('PromoCode'); ?></span>
                            </div>
                        </div>
						<div class="form-group">
							<label for="Display" class="create-label col-md-2">Display</label>
                            <div class="col-md-4">
                                <?php $attributes = 'class = "form-control" id = "Display"';
								echo form_dropdown('Display',$display,set_value('Display'),$attributes);?>
								<span class="text-danger"><?php echo form_error('Display'); ?></span>
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
		$('#Summary').summernote({
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
		
		$('#Introduction').summernote({
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
			],
			callbacks: {
				onFocus: function(e) {
					var t = e.currentTarget.innerText;
					$('#maxContentPost').text(120 - t.trim().length);
				},
				onKeydown: function (e) { 
					var t = e.currentTarget.innerText; 
					if (t.trim().length >= 120) {
						//delete key
						if (e.keyCode != 8)
						e.preventDefault(); 
					} 
				},
				onKeyup: function (e) {
					var t = e.currentTarget.innerText;
					$('#maxContentPost').text(120 - t.trim().length);
				},
				onPaste: function (e) {
					var t = e.currentTarget.innerText;
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					var all = t + bufferText;
					document.execCommand('insertText', false, all.trim().substring(0, 120));
					$('#maxContentPost').text(120 - t.length);
				}
			}
		});
    });
	
	$(document).ready(function(){
		$('#PromoDateFrom').datepicker({
			firstDay: 1,
			showOtherMonths: true,
			dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			dateFormat: "dd/mm/yy",
			minDate: 0,
			onSelect: function(dateText) {
				$(this).change();
			}
		});
		
		$('#PromoDateTo').datepicker({
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