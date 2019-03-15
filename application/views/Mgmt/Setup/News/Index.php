<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<div id="page-wrapper">
		<div class="row"></div>
		<div class="row row-header">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>News/Events</h4>
					</div>
					<div class="panel-body">
						<div><a href="<?php echo base_url()."index.php/Common/News/Create";?>">Create New</a></div></br>
						<div class="table-responsive">
							<table class="table table-striped table-hover footable" data-page-size="10">
								<thead>
									<tr>
										<th data-class="expand">News Type</th>
										<th data-hide="phone,tablet">Title</th>
										<th data-hide="phone,tablet">Created By</th>
										<th data-hide="phone,tablet">Created Date</th>
										<th data-hide="phone,tablet"></th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < count($newsList); ++$i) { ?>
										<tr>
											<td><?php echo $newsList[$i]->Description; ?></td>
											<td><?php echo $newsList[$i]->Title; ?></td>
											<td><?php echo $newsList[$i]->CreatedBy; ?></td>
											<td><?php echo date("d-m-Y", strtotime($newsList[$i]->CreatedDate)) ?></td>
											<td>
												<div class="btn btn-sm btn-grey" style="text-align:center">
													<a href="<?php echo base_url()."index.php/Common/News/Update/".$newsList[$i]->NewsID; ?>" style="text-align:center">Edit</a>
												</div>
												<div class="btn btn-sm btn-grey" style="text-align:center">
													<a href="<?php echo base_url()."index.php/Common/News/Delete/".$newsList[$i]->NewsID; ?>" style="text-align:center">Delete</a>
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
