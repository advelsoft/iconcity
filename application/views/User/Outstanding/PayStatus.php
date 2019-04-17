<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Payment Confirmation Page</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom">
								<tr>
									<th>Payment Status</th>
									<td>
										<?php echo $status; ?>
									</td>
								</tr>
								<tr>
									<th>Reference No.</th>
									<td>
										<?php echo $payRef; ?>
									</td>
								</tr>
								<tr>
									<th>Amount Paid (RM)</th>
									<td><?php echo $sAmt; ?></td>
								</tr>
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<a href="<?php echo base_url()."index.php/Common/Outstanding/History";?>" class="submit">View Receipt</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('paid'); ?>