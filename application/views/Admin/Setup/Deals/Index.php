<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/Promotion/Index/".$condoSeq;?>">
					<span class="glyphicon glyphicon-arrow-left" ></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Deals</h4>
				</div>
				<div class="panel-body">
					<div><a href="<?php echo base_url()."index.php/Common/Deals/Create/".$condoSeq;?>">Create New</a></div></br>
					<div class="table-responsive">
						<table class="table table-striped table-hover footable" data-page-size="10">
							<thead>
								<tr>
									<th data-class="expand">Title</th>
									<th data-hide="phone,tablet">Promo Date From</th>
									<th data-hide="phone,tablet">Promo Date To</th>
									<th data-hide="phone,tablet">Created By</th>
									<th data-hide="phone,tablet">Created Date</th>
									<th data-hide="phone,tablet">Modified By</th>
									<th data-hide="phone,tablet">Modified Date</th>
									<th data-hide="phone,tablet"></th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0; $i < count($promoList); ++$i) { ?>
									<tr>
										<td><?php echo $promoList[$i]->Title; ?></td>
										<td><?php if ($promoList[$i]->PromoDateFrom != '') { echo date("d-m-Y", strtotime($promoList[$i]->PromoDateFrom)); } ?></td>
										<td><?php if ($promoList[$i]->PromoDateTo != '') { echo date("d-m-Y", strtotime($promoList[$i]->PromoDateTo)); } ?></td>
										<td><?php echo $promoList[$i]->C_Name; ?></td>
										<td><?php if ($promoList[$i]->CreatedDate != '') { echo date("d-m-Y", strtotime($promoList[$i]->CreatedDate)); } ?></td>
										<td><?php echo $promoList[$i]->M_Name; ?></td>
										<td><?php if ($promoList[$i]->ModifiedDate != '') { echo date("d-m-Y", strtotime($promoList[$i]->ModifiedDate)); } ?></td>
										<td>
											<a href="<?php echo base_url()."index.php/Common/Deals/Update/".$promoList[$i]->PromoID; ?>" style="text-align:center">
												<div class="btn btn-sm btn-grey" style="text-align:center">Edit</div>
											</a>
											<a href="<?php echo base_url()."index.php/Common/Deals/Delete/".$promoList[$i]->PromoID; ?>" style="text-align:center">
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