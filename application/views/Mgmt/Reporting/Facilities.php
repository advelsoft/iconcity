<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Search Facilities</h4>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<?php $attributes = array("id" => "searchform", "name" => "searchform");
						echo form_open_multipart("index.php/Common/Reporting/SearchFacilities", $attributes);?>
						<div class="form-group">
							<label for="status" class="create-label col-md-1">Sort By</label>
                            <div class="col-md-2">
								<select name="keyword" id="keyword">
									<!--<optgroup label="Status">
										<option value="All">All</option>
										<?php for ($i = 0; $i < count($status); ++$i) { ?>
											<?php if($keyword == trim($status[$i]->BStatusID)) { ?>
												<?php echo '<option value="'.trim($status[$i]->BStatusID).'" selected="selected">'.$status[$i]->Status.'</option>'; ?>
											<?php } else { ?>
												<?php echo '<option value="'.trim($status[$i]->BStatusID).'">'.$status[$i]->Status.'</option>'; ?>
											<?php } ?>
										<?php } ?>
									</optgroup>-->
									<optgroup label="Booking Type">
										<option value="All">All</option>
										<?php for ($i = 0; $i < count($bookingType); ++$i) { ?>
											<?php if($keyword == trim($bookingType[$i]->BookingTypeID)) { ?>
												<?php echo '<option value="'.trim($bookingType[$i]->BookingTypeID).'" selected="selected">'.$bookingType[$i]->Description.'</option>'; ?>
											<?php } else { ?>
												<?php echo '<option value="'.trim($bookingType[$i]->BookingTypeID).'">'.$bookingType[$i]->Description.'</option>'; ?>
											<?php } ?>
										<?php } ?>
									</optgroup>
								</select>
                            </div>
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit" value="Search"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if(isset($results)) { ?>
		<div class="row" style="padding: 0 15px;">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Reporting Facilities</h4>
						<div align="right">
							<a href="<?php echo base_url()."index.php/Common/Reporting/FacilitiesExcel/".$keyword; ?>" style="text-align:center">
								<div class="btn btn-sm btn-grey" style="text-align:center">Convert to Excel</div>
							</a>
							<a href="<?php echo base_url()."index.php/Common/Reporting/FacilitiesPdf/".$keyword; ?>" target="_blank" style="text-align:center">
								<div class="btn btn-sm btn-grey" style="text-align:center">Convert to Pdf</div>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-hover table-custom footable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Facilities</th>
										<th>Unit No</th>
										<th>Date From</th>
										<th>Time From</th>
										<th>Time To</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($results as $item):?>
									<tr>
										<td><?php echo $item['bookingID']; ?></td>
										<td><?php echo $item['bookingType']; ?></td>
										<td><?php echo $item['unitNo']; ?></td>
										<td><?php echo $item['dateFrom']; ?></td>
										<td><?php $timeFrom = new DateTime($item['timeFrom']); echo $timeFrom->format('h:i A'); ?></td>
										<td><?php $timeTo = new DateTime($item['timeTo']); echo $timeTo->format('h:i A'); ?></td>
										<td><?php echo $item['status']; ?></td>
									</tr>
									<?php endforeach;?>
								</tbody>
								<tfoot class="footable-pagination">
									<tr>
										<td colspan="9">
											<div><?php echo $this->pagination->create_links();?></div>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<?php echo form_close(); ?>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>