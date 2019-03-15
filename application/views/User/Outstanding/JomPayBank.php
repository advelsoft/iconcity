<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>JomPAY Bank</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<?php $attributes = array("id" => "jompaybankform", "name" => "jompaybankform");
							echo form_open("index.php/Common/Outstanding/JomPayBank", $attributes);?>
							<tbody>
								<tr>
									<?php foreach( $jomBankList as $i => $item ) { ?>
										<?php if ( $i != 0 && $i++ % 5 == 0 ) { ?>
											</tr><tr>
										<?php } ?>
										 <td align="center">
											<!--<a href="<?php echo $item['bankURL']; ?>"><?php echo $item['bankName']; ?></b></br>
												<img src="<?php echo base_url()."content/img/banks/".$item['bankImg'];?>" alt="Bank">
											</a>-->
											<div id="bankName" class="bankName" align="center">
												<span><?php echo $item['bankName']; ?></span><br>
												<img src="<?php echo base_url()."content/img/banks/".$item['bankImg'];?>" alt="Bank"><br>
												<input type="radio" class="BankSelect" id="JomPayBank" name="JomPayBank" />
											</div>
										 </td>
									<?php } ?>
								</tr>
							</tbody>
							<tfoot class="footable-pagination">
								<tr>
									<td colspan="5">
										<input type="submit" id="Submit" name="Submit" value="Submit" class="submit" />
										<input id="tmpBankName" name="tmpBankName" type="hidden" value="" />
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<div><?php echo $this->pagination->create_links();?></div>
									</td>
								</tr>
							</tfoot>
							<?php echo form_close(); ?>
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<script language="Javascript">
	$('input[name="JomPayBank"]').click(function() {
		radioButtonText = $('input[name=JomPayBank].BankSelect:checked');
		var bankName = radioButtonText.closest('div').find('span').html();
		document.getElementById("tmpBankName").value = bankName;
	});
</script>