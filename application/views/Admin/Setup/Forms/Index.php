<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Forms/Lists";?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Forms</h4>
				</div>
				<div class="panel-body">
					<div><a href="<?php echo base_url()."index.php/Common/Forms/Create/".$condoSeq;?>">Create New</a></div></br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th>Title</th>
									<th>Link</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($formList as $item) { ?>
									<tr>
										<td><?php echo $item['name']; ?></td>
										<td><?php echo $item['file']; ?></td>
										<td>
											<a href="<?php echo base_url()."index.php/Common/Forms/Update/".$condoSeq."/".$item['formID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
											</a>
											<a href="<?php echo base_url()."index.php/Common/Forms/Delete/".$condoSeq."/".$item['formID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
											</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="3">
										<div><?php echo $this->pagination->create_links();?></div>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>