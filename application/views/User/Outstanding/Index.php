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
		<?php $jompay = $_SESSION['ResidentJompay']; if(isset($jompay) && $_SESSION['ResidentJompay']){ ?>
			var msg = confirm("Do you want to continue?");
			if(msg == true){
			  return true;
			}
			else{
			  return false;
			}
		<?php } else { ?>
			alert("No E-Payment subscription at the moment...\nPlease contact management office.");
			return false;
		<?php } ?>
	}

	$(document).ready(function(){
		$('.table-custom').footable({
			calculateWidthOverride: function() {
				return { width: $(window).width() };
			}
		});
	});
</script>