<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Mgmt/Home/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Newsfeeds Info</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-custom">
						<tbody>
							<tr>
								<td>Newsfeeds Type</td>
								<td class="col-md-10"><?php echo $newsRecord[0]->NewsType; ?></td>
							</tr>
							<tr>
								<td>Title</td>
								<td class="col-md-10"><?php echo $newsRecord[0]->Title; ?></td>
							</tr>
							<tr>
								<td>Newsfeeds Date</td>
								<td class="col-md-10"><?php echo date("d/m/Y", strtotime($newsRecord[0]->NewsfeedDate)); ?></td>
							</tr>
							<tr>
								<td>Summary</td>
								<td class="col-md-10"><?php echo $newsRecord[0]->Summary; ?></td>
							</tr>
							<?php if (trim($newsRecord[0]->Description) != ""): ?>
							<tr>
								<td>Description</td>
								<td class="col-md-10"><?php echo $newsRecord[0]->Description; ?></td>
							</tr>
							<?php endif;?>
							<?php if (isset($newsRecord[0]->Attachment1)): ?>
							<tr>
								<td>Attachment</td>
								<td class="col-md-10">
									<!--Attachment1-->
									<?php if (strpos($newsRecord[0]->Attachment1, 'pdf') !== false) { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord[0]->Attachment1.'" width="800px" height="800px" />'; ?>
									<?php } else if ($newsRecord[0]->Attachment1 != "") { ?>
										<?php echo '<img style="margin-bottom: 10px; width: 40%;" src="'.$newsRecord[0]->Attachment1.'" alt="Attachment1">'; ?>
									<?php } ?>
									<!--Attachment2-->
									<?php if (strpos($newsRecord[0]->Attachment2, 'pdf') !== false) { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord[0]->Attachment2.'" width="800px" height="800px" />'; ?>
									<?php } else if ($newsRecord[0]->Attachment2 != "") { ?>
										<?php echo '<img style="margin-bottom: 10px; width: 40%;" src="'.$newsRecord[0]->Attachment2.'" alt="Attachment2">'; ?>
									<?php } ?>
									<!--Attachment3-->
									<?php if (strpos($newsRecord[0]->Attachment3, 'pdf') !== false) { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord[0]->Attachment3.'" width="800px" height="800px" />'; ?>
									<?php } else if ($newsRecord[0]->Attachment3 != ""){ ?>
										<?php echo '<img style="width: 40%;" src="'.$newsRecord[0]->Attachment3.'" alt="Attachment3">'; ?>
									<?php } ?>
									<!--Attachment4-->
									<?php if (strpos($newsRecord[0]->Attachment4, 'pdf') !== false) { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord[0]->Attachment4.'" width="800px" height="800px" />'; ?>
									<?php } else if ($newsRecord[0]->Attachment4 != ""){ ?>
										<?php echo '<img style="width: 40%;" src="'.$newsRecord[0]->Attachment4.'" alt="Attachment4">'; ?>
									<?php } ?>
								</td>
							</tr>
							<?php endif;?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>