<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>BitDefender</h4>
				</div>
				<div class="panel-body">
					<div><a href="<?php echo base_url()."index.php/Common/BitDefender/Create";?>">Create New</a></div></br>
					<div class="table-responsive">
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th data-class="expand">Product Name</th>
									<th data-hide="phone,tablet">Promo Date</th>
									<th data-hide="phone,tablet">Promo Price</th>
									<th data-hide="phone,tablet">Created By</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet">Modified By</th>
									<th data-hide="phone,tablet">Modified Date</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0; $i < count($bitdefList); ++$i) { ?>
									<tr>
										<td><?php echo $bitdefList[$i]->ProductName; ?></td>
										<td><?php if ($bitdefList[$i]->PromoDate != '') { echo date("d-m-Y", strtotime($bitdefList[$i]->PromoDate)); } ?></td>
										<td><?php echo $bitdefList[$i]->PromoPrice; ?></td>
										<td><?php echo $bitdefList[$i]->C_Name; ?></td>
										<td><?php if ($bitdefList[$i]->CreatedDate != '') { echo date("d-m-Y", strtotime($bitdefList[$i]->CreatedDate)); } ?></td>
										<td><?php echo $bitdefList[$i]->M_Name; ?></td>
										<td><?php if ($bitdefList[$i]->ModifiedDate != '') { echo date("d-m-Y", strtotime($bitdefList[$i]->ModifiedDate)); } ?></td>
										<td>
											<a href="<?php echo base_url()."index.php/Common/BitDefender/Update/".$bitdefList[$i]->UID; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
											</a>
											<a href="<?php echo base_url()."index.php/Common/BitDefender/Delete/".$bitdefList[$i]->UID; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Delete</div>
											</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>