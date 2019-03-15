<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Upload</h4>
				</div>
				<div class="panel-body">
					<div><a href="<?php echo base_url()."index.php/Common/Upload/Create";?>">Create New</a></div></br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">File</th>
									<th data-hide="phone,tablet">Reference</th>
									<th data-hide="phone,tablet">Type</th>
									<th data-hide="phone,tablet">Created By</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($uploadList as $item) { ?>
									<tr>
										<td><?php echo $item['file']; ?></td>
										<td style="text-transform:none;"><?php echo 'Add following as image source: </br>src="application/uploads/files/'.$item['file'].'"'; ?></td>
										<td><?php echo $item['type']; ?></td>
										<td><?php echo $item['createdBy']; ?></td>
										<td><?php if ($item['createdDate'] != '') { echo date("d-m-Y", strtotime($item['createdDate'])); } ?></td>
										<td>
											<a href="<?php echo base_url()."index.php/Common/Upload/Detail/".$item['uploadID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">View</div>
											</a>
											<a href="<?php echo base_url()."index.php/Common/Upload/Update/".$item['uploadID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
											</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="6">
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
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>