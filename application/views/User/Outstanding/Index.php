<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<h3>E-Payment (Outstanding Bills)</h3><br><br>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#outstanding" data-toggle="tab">Unpaid Bills <span class="label label-danger"><?php echo count($osList); ?></span></a></li>
				<li><a href="#pending" data-toggle="tab">Pending Payment <span class="label label-danger"><?php echo count($pending); ?></span></a></li>
			</ul>
			<div class="tab-content">
				<?php echo $tab1; ?>
				<?php echo $tab2; ?>
			</div>
					 <!-- <h4><b>* Select Doc No for payment</b></h4>
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th data-class="expand">Doc No</th>
									<th data-hide="phone">Transaction Date</th>
									<th data-hide="phone">Description</th>
									<th data-hide="phone">Due Date</th>
									<th data-hide="phone">Outstanding Amount</th>
									<th><input type="checkbox" class="selectAll" id="selectall">&nbsp;Select/Unselect All</th>
								</tr>
							</thead>
							<?php if(count($osList) > 0): { ?>
								<tbody>
									<?php foreach($osList as $item) { ?>
										<tr>
											<td id="docNo"><?php echo $item['docNo']; ?></td>
											<td><?php echo $item['trxnDate']; ?></td>
											<td style="text-align:left;"><?php echo $item['desc']; ?></td>
											<td><?php echo $item['dueDate']; ?></td>
											<td id="amt"><?php echo number_format(floatval($item['amt']), 2, '.', ''); ?></td>
											<td name="selectBox"><input type="checkbox" class="selectAll" name="selectData"><label name="selectLbl" /></td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot class="footable-pagination">
									<tr>
										<td colspan='4'></td>
										<td style='text-align:left'>
											<b>Total Gross Amount: </b><span id="totalGross"><?php echo number_format((float)$totalGross, 2, '.', ''); ?></span></br>
											<b>Total Unapplied Amount: </b><span id="totalOpen"><?php echo number_format((float)$totalOpen, 2, '.', ''); ?></span></br>
											<b>Net Outstanding: </b><span id="totalNet"></span>
										</td>
										<td colspan='2' style='text-align:left'><b>Total Selected Amount: </b><span id="ttlSelect">0.00</span></td>
									</tr>
									<tr>
										<td colspan="5"></td> -->
										<!--Submit
										<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
										echo form_open("index.php/Common/Outstanding/PayInfo", $attributes);?>
										<td>
											<input type="submit" value="Submit" class="submit" onclick="return submitConfirm();" />
											<input id="tmpDocNo" name="tmpDocNo" type="hidden" value=""/>
											<input id="tmpTtlSelect" name="tmpTtlSelect" type="hidden" value=""/>
											<input id="tmpCustType" name="tmpCustType" type="hidden" value="<?php if(isset($item['custType'])){ echo $item['custType']; } ?>"/>
											<input id="jompay" name="jompay" type="hidden" value="<?php echo $company[0]->JomPay; ?>"/>
										<?php echo form_close(); ?>
										</td>
									</tr>
									<tr>
										<td colspan="7">
											<div><?php echo $this->pagination->create_links();?></div>
										</td>
									</tr>
								</tfoot>
							<?php } ?>
							<?php else: {  ?>
								<tbody>
									<tr><td colspan="9">No Records</td></tr>
								</tbody>
							<?php } ?>
							<?php endif;?>
						</table>
					</div> -->
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('jompay'); ?>
<script language="Javascript">
	var totalGross = document.getElementById("totalGross").innerHTML;
	var totalOpen = document.getElementById("totalOpen").innerHTML;
	var totalNet = parseFloat(totalGross)+parseFloat(totalOpen);
	document.getElementById("totalNet").innerHTML = totalNet.toFixed(2);

	$("#selectall").click(function() {
		$(".selectAll:enabled").prop("checked", $("#selectall").prop("checked"));
		
		var total = 0;
		var docNoArray = '';
		
		$("input[name=selectData]:checked").each(function() {
			//for each checked checkbox, iterate through its parent's siblings
			var docNo = $(this).closest("td").siblings('#docNo').map(function() {
				return $(this).text().trim();							
			}).get();

			//sum of amount that been checked
			total += parseFloat($(this).closest('td').siblings('#amt').text());
			
			//to print the value of array
			docNoArray += docNo + "|";
		})
		//assign total of amount that been checked to 2 decimal places
		document.getElementById("ttlSelect").innerHTML = total.toFixed(2);
		document.getElementById("tmpTtlSelect").value = total.toFixed(2);
		
		//assign tmpDocNo into hidden field value
		document.getElementById("tmpDocNo").value = docNoArray;
	});
	
	$("input[name=selectData]").click(function() {
			$("#selectall").prop("checked", false);
			
			var total = 0;
			var docNoArray = '';
			
			$("input[name=selectData]:checked").each(function() {
				//for each checked checkbox, iterate through its parent's siblings
				var docNo = $(this).closest("td").siblings('#docNo').map(function() {
					return $(this).text().trim();							
				}).get();
				
				//sum of amount that been checked
				total += parseFloat($(this).closest('td').siblings('#amt').text());
				
				//to print the value of array
			   docNoArray += docNo + "|";
			})
			//assign total of amount that been checked to 2 decimal places
			document.getElementById("ttlSelect").innerHTML = total.toFixed(2);
			document.getElementById("tmpTtlSelect").value = total.toFixed(2);
			
			//assign tmpDocNo into hidden field value
			document.getElementById("tmpDocNo").value = docNoArray;
		});
	
	var tbl = document.getElementById('tbl');
	var disableCnt = 0;
	var submitCnt = 0;
	var resetCnt = 0;
	
	//check if will display data or not
	for (var r = 1; r < tbl.rows.length-3; r++) {
		var amount = tbl.rows[r].cells[4].innerHTML;
		if(amount < 0){
			var checkbox1 = tbl.rows[r].cells[5].children[0];
			checkbox1.disabled = true;	
			disableCnt++;
		}
	}
	
	function submitConfirm(){	
		var msg = confirm("Do you want to continue?");
		if(msg == true){
		  return true;
		}
		else{
		  return false;
		}
	}

	$(document).ready(function(){
		$('.table-custom').footable({
			calculateWidthOverride: function() {
				return { width: $(window).width() };
			}
		});
	});
</script>