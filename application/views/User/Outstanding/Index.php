<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>E-Payment (JomPAY)</h4>
				</div>
				<div class="panel-body">
					<h4><b>* Select Doc No for payment</b></h4>
					<div class="table-responsive">
						<table id="tbl" class="table table-striped table-hover table-custom footable">
							<thead>
								<tr>
									<th style="font-weight: normal;" data-class="expand">Doc No</th>
									<th style="font-weight: normal;"  data-hide="phone">Transaction Date</th>
									<th style="font-weight: normal;"  data-hide="phone">Description</th>
									<th style="font-weight: normal;"  data-hide="phone">Due Date</th>
									<th style="font-weight: normal;"  data-hide="phone">Outstanding Amount</th>
									<th style="font-weight: normal;"  data-hide="phone">1 Day Float</th>
									<th style="font-weight: normal;"  data-hide="phone">Ref1</th>
									<th style="font-weight: normal;" ><input type="checkbox" class="selectAll" id="selectall">&nbsp;Select/Unselect All</th>
									<th style="font-weight: normal;"  data-hide="phone"><input type="checkbox" class="resetAll" id="resetall">&nbsp;Reset All</th>
								</tr>
							</thead>
							<?php if(count($osList) > 0): { ?>
								<tbody>
									<?php foreach($osList as $item) { ?>
										<tr>
											<td id="docNo"><?php echo $item['docNo']; ?></td>
											<td><?php echo date("d-m-Y",strtotime($item['trxnDate'])); ?></td>
											<td style="text-align:left;"><?php echo $item['desc']; ?></td>
											<td><?php echo date("d-m-Y",strtotime($item['dueDate'])); ?></td>
											<td id="amt"><?php echo number_format(floatval($item['amt']), 2, '.', ''); ?></td>
											<td><?php echo $item['floatAmt']; ?></td>
											<td id="ref1"><?php echo $item['ref1']; ?></td>
											<td name="selectBox"><input type="checkbox" class="selectAll" name="selectData"><label name="selectLbl" /></td>
											<td name="resetBox"><input type="checkbox" class="resetAll" name="resetData"><label name="resetLbl" /></td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot class="footable-pagination">
									<tr>
										<td colspan='6'></td>
										<td style='text-align:left'>
											<b>Total Gross Amount: </b><span id="totalGross"><?php echo number_format((float)$totalGross, 2, '.', ''); ?></span></br>
											<b>Total Unapplied Amount: </b><span id="totalOpen"><?php echo number_format((float)$totalOpen, 2, '.', ''); ?></span></br>
											<b>Net Outstanding: </b><span id="totalNet"><?php echo number_format((float)$totalNet, 2, '.', ''); ?></span>
										</td>
										<td colspan='2' style='text-align:left'><b>Total Selected Amount: </b><span id="ttlSelect">0.00</span></td>
									</tr>
									<tr>
										<td colspan="7"></td>
										<!--Submit-->
										<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
										echo form_open("index.php/Common/Outstanding/Create", $attributes);?>
										<td>
											<div id="btns" style='margin: 0 auto;text-align:center;font-size:12px;'>
												<button type="button" id="Proceed" class="modal-btn" data-toggle="modal" data-target="#modal1" onclick="disableSubmit()">Submit</button>
											</div>
											<!--Modal-->
											<div id="modal1" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title" name="title" id="title">Terms and Conditions</h4>
														</div>
														<div class="modal-body">
															<div class="text-content">
																<input type="checkbox" name="terms" id="terms" onchange="activateButton(this)" />  
																<a href="<?php echo base_url()."application/uploads/files/JomPAY-T&C.pdf";?>" target="_blank"><u>I agree to the Terms and Conditions.</u></a>
															</div>
														</div>
														<div class="modal-footer">
															<input type="submit" id="Submit" name="Submit" value="Submit" class="submit" />
															<input type="reset" id="Cancel" name="Cancel" value="Cancel" class="submit" data-dismiss="modal" onclick="disableCheckbox()"/>
														</div>
													</div>
												</div>
											</div>
											<input id="tmpDocNo" name="tmpDocNo" type="hidden" value=""/>
											<input id="tmpTtlSelect" name="tmpTtlSelect" type="hidden" value=""/>
											<input id="tmpCustType" name="tmpCustType" type="hidden" value="<?php if(isset($item['custType'])){ echo $item['custType']; } ?>"/>
											<input id="jompay" name="jompay" type="hidden" value="<?php echo $company[0]->JomPay; ?>"/>
										<?php echo form_close(); ?>
										</td>
										<!--Reset-->
										<?php $attributes = array("id" => "outstandingform", "name" => "outstandingform");
										echo form_open("index.php/Common/Outstanding/ResetRef1", $attributes);?>
										<td>
											<div id="btns" style='margin: 0 auto;text-align:center;font-size:12px;'>
												<button id="btnReset" class="modal-btn" onclick="return getConfirmation();">Reset Ref1</button>
											</div>
											<input id="tmpRef1" name="tmpRef1" type="hidden" value=""/>
										<?php echo form_close(); ?>
										</td>
									</tr>
									<tr>
										<td colspan="9">
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
					</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('jompay'); ?>
<script language="Javascript">
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
	
	$("#resetall").click(function() {
		$(".resetAll:enabled").prop("checked", $("#resetall").prop("checked"));
		
		var ref1Array = '';
		var docNoArray = '';
		
		$("input[name=resetData]:checked").each(function() {
			var ref1 = $(this).closest("td").siblings('#ref1').map(function() {
				return $(this).text().trim();
			}).get();
			
			var docNo = $(this).closest("td").siblings('#docNo').map(function() {
				return $(this).text().trim();
			}).get();
			
			//to print the value of array
			ref1Array += ref1 + "|";
			docNoArray += docNo + "|";
		})
		
		//assign tmpRef1 into hidden field value
		document.getElementById("tmpRef1").value = ref1Array;
		
		//assign tmpDocNo into hidden field value
		document.getElementById("tmpDocNo").value = docNoArray;
		
	});
	
	$("input[name=resetData]").click(function() {
			$("#resetall").prop("checked", false);
			
			var ref1Array = '';
			var docNoArray = '';
			
			$("input[name=resetData]:checked").each(function() {
				var ref1 = $(this).closest("td").siblings('#ref1').map(function() {
					return $(this).text().trim();
				}).get();
				
				var docNo = $(this).closest("td").siblings('#docNo').map(function() {
					return $(this).text().trim();
				}).get();
				
				//to print the value of array
			    ref1Array += ref1 + "|";
			    docNoArray += docNo + "|";
			})	
			
			//assign tmpRef1 into hidden field value
			document.getElementById("tmpRef1").value = ref1Array;
			
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
			var checkbox1 = tbl.rows[r].cells[7].children[0];
			checkbox1.disabled = true;	
			var checkbox2 = tbl.rows[r].cells[8].children[0];
			checkbox2.disabled = true;
			disableCnt++;
		}
		else{
			var ref1 = tbl.rows[r].cells[6].innerHTML;
			if(ref1 != ""){
				//disable checkbox submit
				var checkbox3 = tbl.rows[r].cells[7].children[0];
				checkbox3.disabled = true;	
				submitCnt++;
			}
			else{
				//disable checkbox reset
				var checkbox4 = tbl.rows[r].cells[8].children[0];
				checkbox4.disabled = true;
				resetCnt++;
			}
		}
		
		//disable select all & reset all
		var enableRow = r-disableCnt;
		var checkbox5 = tbl.rows[0].cells[7].children[0];
		var checkbox6 = tbl.rows[0].cells[8].children[0];
		
		if(submitCnt == enableRow){
			checkbox5.disabled = true;
		}
		else if(resetCnt == enableRow){
			checkbox6.disabled = true;
		}
		else{
			checkbox5.disabled = false;
			checkbox6.disabled = false;
		}
	}
	
	function disableSubmit() {
		document.getElementById("Submit").disabled = true;
		
		//disable double submit for existing Ref1
		var tmpRef = document.getElementById("tmpRef1").value;				
		var res = tmpRef.split("|");
		for(var i=0; i <= res.length-1; i++){	
			if(res[i] != ""){
				alert("Ref1 has been created. Please reset Ref1 to create Ref1 again.");
				$('#btns').find('#Proceed').removeAttr('data-toggle');
				return false;
			}
			else{
				$("#Proceed").attr("data-toggle", "modal");
			}
		}
		
		//disable submit if no selected
		var tmpDocNo = document.getElementById("tmpDocNo").value;
		if(tmpDocNo == ""){
			alert("Please select one of the outstanding to proceed.");
			$('#btns').find('#Proceed').removeAttr('data-toggle');
			return false;
		}
		else{
			$("#Proceed").attr("data-toggle", "modal");
		}
		
		//disable submit if not jompay
		var jompay = document.getElementById("jompay").value;
		if(jompay == ""){
			alert("No E-Payment subscription at the moment...\nPlease contact management office.");
			$('#btns').find('#Proceed').removeAttr('data-toggle');
			return false;
		}
		else{
			$("#Proceed").attr("data-toggle", "modal");
		}
	}
	
	function activateButton(element) {
		if(element.checked) {
			document.getElementById("Submit").disabled = false;
		}
		else  {
			document.getElementById("Submit").disabled = true;
		}
	}
	
	function disableCheckbox() {
		document.getElementById("terms").checked = false;
		document.getElementById("Submit").disabled = true;
	}
	
	function getConfirmation(){	
		var tmpRef = document.getElementById("tmpRef1").value;				
		var res = tmpRef.split("|");
		for(var i=0; i <= res.length-1; i++){	
			if(res[i] != ""){
				var msg = confirm("Do you want to continue?");
				if(msg == true){
				  return true;
				}
				else{
				  return false;
				}
			}
			else{
				alert("Ref1 hasn't been created.");
				return false;
			}
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