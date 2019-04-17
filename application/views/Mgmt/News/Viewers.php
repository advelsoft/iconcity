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
					<div class="table-responsive">
						<table class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Property No.</th>
									<th data-hide="phone,tablet">Date Time Read</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($viewers as $item) { ?>
									<tr>
										<td><?php echo $item['PROPERTYNO']; ?></td>
										<td><?php echo date("d-m-Y H:i", strtotime($item['dateread'])); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>