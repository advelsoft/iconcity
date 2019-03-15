<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Condo</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Condo Name</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i = 0; $i < count($condoList); ++$i) { ?>
							<tr data-href="<?php echo base_url()."index.php/Common/Forms/Index/".$condoList[$i]->CONDOSEQ; ?>">      
								<td><?php echo $condoList[$i]->DESCRIPTION; ?></td>      							
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
