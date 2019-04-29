<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Users</h4>
				</div>
				<div class="panel-body">
					<?php $attributes = array("id" => "forgetaccountform", "name" => "forgetaccountform"); echo form_open("index.php/Common/ResetPassword/Search/", $attributes);?>
					<!-- <h4>Search</h4> -->
					<div class="row">
						<div class="col-lg-2">
							<input type="text" class="form-control" placeholder="Unit No. : A-01-1" id="propertyNo" name="propertyNo" required>
						</div>
						<div class="col-lg-1">
							<button type="submit" class="btn btn-success pull-right">Search</button>
						</div>
					</div>
					<?php echo form_close(); ?>
					<br><br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-hide="phone,tablet">Unit No</th>
									<th data-hide="phone,tablet">Login ID</th>
									<th data-hide="phone,tablet">Owner Name</th>
									<th data-hide="phone,tablet">Email</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($usersList as $item) { ?>
								<tr>
									<td><?php echo $item['propertyNo']; ?></td>
									<td><?php echo $item['loginID']; ?></td>
									<td><?php echo $item['ownerName']; ?></td>
									<td><?php echo $item['email']; ?></td>
									<td>  
										<a href="<?php echo base_url()."index.php/Common/ResetPassword/ResetPassword/".$item['userID']; ?>" >
											<div class="btn btn-sm btn-grey">Reset Password</div>
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="10">
										<div><?php echo $this->pagination->create_links();?></div>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});

  	$( function() {
	    var availableTags = [
	      <?php if(isset($unitNo) && count($unitNo) > 0){
	      			foreach($unitNo as $unit){
	      				echo '"'.trim($unit->PROPERTYNO).'",';
	      } } ?>
	    ];
	    $( "#propertyNo" ).autocomplete({
	      	source: availableTags,
	      	appendTo: "#forgetaccountform"
	    });
	} );
</script>