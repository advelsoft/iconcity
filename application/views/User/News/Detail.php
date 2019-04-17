<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-top">
				<a href="<?php echo base_url()."index.php/Common/News/Index";?>">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to List
				</a>
			</h4>
		</div>
	</div>
	<div class="row row-header">
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Newsfeed Info</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-custom">
						<tbody>
							<tr>
								<td>Newsfeed Type</td>
								<td class="col-md-10"><?php echo $newsRecord['Type']; ?></td>
							</tr>
							<tr>
								<td>Title</td>
								<td class="col-md-10"><?php echo $newsRecord['Title']; ?></td>
							</tr>
							<tr>
								<td>Newsfeed Date</td>
								<td class="col-md-10"><?php echo date("d/m/Y", strtotime($newsRecord['EventDate'])); ?></td>
							</tr>
							<!-- <tr>
								<td>Summary</td>
								<td class="col-md-10"><?php echo $newsRecord['Summary']; ?></td>
							</tr> -->
							<?php if (trim($newsRecord['Description']) != ""): ?>
							<tr>
								<td>Description</td>
								<td class="col-md-10"><?php echo $newsRecord['Description']; ?></td>
							</tr>
							<?php endif;?>
							<?php if (isset($newsRecord['Attachment1'])): ?>
							<tr>
								<td>Attachment</td>
								<td class="col-md-10">
									<!--Attachment1-->
									<?php if (strpos($newsRecord['Attachment1'], 'pdf') !== false) { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord['Attachment1'].'" width="800px" height="800px" />'; ?>
									<?php } else { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord['Attachment1'].'" width="800px" height="800px" />'; ?>
									<?php } ?>
									<!--Attachment2-->
									<?php if ($newsRecord['Attachment2'] == 0) { ?>
										<?php echo ''; ?>
									<?php } else { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord['Attachment2'].'" width="800px" height="800px" />'; ?>
									<?php } ?>
									<!--Attachment3-->
									<?php if ($newsRecord['Attachment3'] == 0) { ?>
										<?php echo ''; ?>
									<?php } else { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord['Attachment3'].'" width="800px" height="800px" />'; ?>
									<?php } ?>
									<!--Attachment4-->
									<?php if ($newsRecord['Attachment4'] == 0) { ?>
										<?php echo ''; ?>
									<?php } else { ?>
										<?php echo '<embed style="margin-bottom: 10px;" src="'.$newsRecord['Attachment4'].'" width="800px" height="800px" />'; ?>
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