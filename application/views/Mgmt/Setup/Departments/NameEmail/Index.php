<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Name/Email List</h4>
				</div>
				<div class="panel-body">
					<div>
						<a href="<?php echo base_url()."index.php/Common/NameEmail/Create";?>">
							<div class="btn btn-new btn-sm btn-light-blue" style="text-align:center">Create New</div>
						</a>
					</div>
					</br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Name</th>
									<th data-hide="phone,tablet">Email</th>
									<th data-hide="phone,tablet">Department</th>
									<th data-hide="phone,tablet">Position</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($deptEmList as $item) { ?>
								<tr>
									<td><?php echo $item['name']; ?></td>
									<td style="text-transform: none;"><?php echo $item['email']; ?></td>
									<td><?php echo $item['department']; ?></td>
									<td><?php echo $item['position']; ?></td>
									<td>
										<a href="<?php echo base_url()."index.php/Common/NameEmail/Update/".$item['UID']; ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
										</a>
										<a href="<?php echo base_url()."index.php/Common/NameEmail/Delete/".$item['UID']; ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="5">
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