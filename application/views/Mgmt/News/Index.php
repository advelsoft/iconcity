<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Newsfeeds</h4>
				</div>
				<div class="panel-body">
					<div>
						<a href="<?php echo base_url()."index.php/Common/News/Create";?>">
							<div class="btn btn-new btn-sm btn-light-blue" style="text-align:center">Create Newsfeeds</div>
						</a>
					</div>
					</br>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Newsfeeds Type</th>
									<th data-hide="phone,tablet">Title</th>
									<th data-hide="phone,tablet">Publish Status</th>
									<th data-hide="phone,tablet">Created By</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($newsList as $item) { ?>
									<tr>
										<td><?php echo $item['description']; ?></td>
										<td><?php echo $item['title']; ?></td>
										<td><?php if($item['Publish']){ echo '<span class="label label-success">PUBLISHED</span>'; }
													else { echo '<span class="label label-danger">NOT PUBLISH</span>'; }  ?></td>
										<td><?php echo $item['createdBy']; ?></td>
										<td><?php echo date("d-m-Y", strtotime($item['createdDate'])) ?></td>
										<td>
											<a href="<?php echo base_url()."index.php/Common/News/Detail/".$item['newsID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">View</div>
											</a>
											<a href="<?php echo base_url()."index.php/Common/News/Update/".$item['newsID']; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
											</a>
											<?php if(!$item['Publish']){ ?>
												<a href="<?php echo base_url()."index.php/Common/News/Delete/".$item['newsID']; ?>" style="text-align:center">
													<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
												</a>
											<?php } ?>
											<?php if($item['Publish']){ ?>
												<a href="<?php echo base_url()."index.php/Common/News/Viewers/".$item['newsID']; ?>" style="text-align:center">
													<div class="btn btn-sm btn-grey" style="text-align:center">List of Viewers</div>
												</a>
											<?php } ?>
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
<?php echo $this->session->flashdata('msg'); ?>
<script>
	$(document).ready(function(){
		$('.table-custom').footable();
	});
</script>