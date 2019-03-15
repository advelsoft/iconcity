<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Search Feedback</h4>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<?php $attributes = array("id" => "searchform", "name" => "searchform");
						echo form_open_multipart("index.php/Common/Reporting/SearchFeedbacks", $attributes);?>
						<div class="form-group">
							<label for="status" class="create-label col-md-1">Sort By</label>
                            <div class="col-md-2">
								<select name="keyword" id="keyword">
									<optgroup label="Status">
										<option value="All">All</option>
										<?php for ($i = 0; $i < count($status); ++$i) { ?>
											<?php if($keyword == trim($status[$i]->Status)) { ?>
												<?php echo '<option value="'.trim($status[$i]->Status).'" selected="selected">'.$status[$i]->Status.'</option>'; ?>
											<?php } else { ?>
												<?php echo '<option value="'.trim($status[$i]->Status).'">'.$status[$i]->Status.'</option>'; ?>
											<?php } ?>
										<?php } ?>
									</optgroup>
									<optgroup label="Category">
										<option value="All">All</option>
										<?php for ($i = 0; $i < count($category); ++$i) { ?>
											<?php if($keyword == trim($category[$i]->Department)) { ?>
												<?php echo '<option value="'.trim($category[$i]->Department).'" selected="selected">'.$category[$i]->Department.'</option>'; ?>
											<?php } else { ?>
												<?php echo '<option value="'.trim($category[$i]->UID).'">'.$category[$i]->Department.'</option>'; ?>
											<?php } ?>
										<?php } ?>
									</optgroup>
								</select> 
                            </div>
							<div class="input-group-btn">
								<button class="btn btn-default btn-search" type="submit" value="Search"><i class="glyphicon glyphicon-search"></i></button>
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
						<h4>Reporting Feedback</h4>
						<div align="right">
							<a href="<?php echo base_url()."index.php/Common/Reporting/FeedbackExcel/".$keyword; ?>" style="text-align:center">
								<div class="btn btn-sm btn-grey" style="text-align:center">Convert to Excel</div>
							</a>
							<a href="<?php echo base_url()."index.php/Common/Reporting/FeedbackPdf/".$keyword; ?>" target="_blank" style="text-align:center">
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
										<th>Date</th>
										<th>Unit No</th>
										<th>Priority</th>
										<th>Status</th>
										<th>Category</th>
										<th>Subject</th>
										<th>Closing Date</th>
										<th>Days Taken</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($results as $item):?>
									<tr>
										<td><?php echo $item['feedbackID']; ?></td>
										<td><?php echo $item['createdDate']; ?></td>
										<td><?php echo $item['unitNo']; ?></td>
										<td><?php echo $item['priority']; ?></td>
										<td><?php echo $item['status']; ?></td>
										<td><?php echo $item['category']; ?></td>
										<td><?php echo $item['subject']; ?></td>
										<td><?php echo $item['closedDate']; ?></td>
										<td><?php echo $item['daysTaken']; ?></td>
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
						<table class="table2" width="100%">
							<tbody>
								<tr><td colspan="<?php echo count($totalCat)+1; ?>"><b>All Total: </b><?php echo $feedCnt; ?></td></tr>
								<tr><td></br></td></tr>
								<tr>
									<td><b>Status</b></td>
									<?php for ($i = 0; $i < count($totalStat); ++$i) { ?>
										<td><b><?php echo trim($totalStat[$i]->Status); ?>:</b> <?php echo $totalStat[$i]->cntTotal; ?></td>
									<?php } ?>
								</tr>
								<tr><td></br></td></tr>
								<tr>
									<td><b>Category</b></td>
									<?php for ($i = 0; $i < count($totalCat); ++$i) { ?>
										<td><b><?php echo trim($totalCat[$i]->Department); ?>:</b> <?php echo $totalCat[$i]->cntTotal; ?></td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</div>
					<?php echo form_close(); ?>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>