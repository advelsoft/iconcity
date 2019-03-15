<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>JMB</h4>
				</div>
				<div class="panel-body">
					<div>
						<a href="<?php echo base_url()."index.php/Common/Jmb/Create";?>">
							<div class="btn btn-new btn-sm btn-light-blue" style="text-align:center">Create New</div>
						</a>
					</div>
					</br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Property No</th>
									<th data-hide="phone,tablet">Owner Name</th>
									<th data-hide="phone,tablet">Created By</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet">Modified By</th>
									<th data-hide="phone,tablet">Modified Date</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($jmbList as $item) { ?>
								<tr>
									<td><?php echo $item['propertyNo']; ?></td>
									<td><?php echo $item['ownerName']; ?></td>
									<td><?php echo $item['createdBy']; ?></td>
									<td><?php echo date("d-m-Y", strtotime($item['createdDate'])) ?></td>
									<td><?php echo $item['modifiedBy']; ?></td>
									<td>
										<?php if ($item['modifiedBy'] == ''): ?>
										<?php { echo ''; } ?>
										<?php else: ?>
										<?php { echo date("d-m-Y", strtotime($item['modifiedDate'])); } ?>
										<?php endif;?>
									</td>
									<td>
										<!--<a href="<?php echo base_url()."index.php/Common/Jmb/Update/".$item['UID']; ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
										</a>-->
										<a href="<?php echo base_url()."index.php/Common/Jmb/Delete/".$item['UID']; ?>" style="text-align:center">
											<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
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
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
	<?php echo $this->session->flashdata('msg'); ?>
</div>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>