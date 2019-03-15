<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<div id="page-wrapper">
		<div class="row"></div>
		<div class="row row-header">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Booking Type</h4>
					</div>
					<div class="panel-body">
						<div><a href="<?php echo base_url()."index.php/Common/UploadType/Create";?>">Create New</a></div></br>
						<div class="table-responsive">
							<table class="table table-striped table-hover table-custom footable">
								<thead>
									<tr>
										<th>Description</th>
										<th>Created By</th>
										<th>Created Date</th>
										<th>Modified By</th>
										<th>Modified Date</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < count($uploadTypeList); ++$i) { ?>
									<tr>
										<td><?php echo $uploadTypeList[$i]->Description; ?></td>
										<td><?php echo $uploadTypeList[$i]->CreatedBy; ?></td>
										<td><?php if ($uploadTypeList[$i]->CreatedDate != '') { echo date("d-m-Y", strtotime($uploadTypeList[$i]->CreatedDate)); } ?></td>
										<td><?php echo $uploadTypeList[$i]->ModifiedBy; ?></td>
										<td><?php if ($uploadTypeList[$i]->ModifiedDate != '') { echo date("d-m-Y", strtotime($uploadTypeList[$i]->ModifiedDate)); }?></td>
										<td><div class="btn btn-sm btn-grey" style="text-align:center">
												<a href="<?php echo base_url()."index.php/Common/UploadType/Detail/".$item['uploadID']; ?>" style="text-align:center">View</a>
											</div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
