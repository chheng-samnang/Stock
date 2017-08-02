<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper" ng-app="myApp" ng-controller="myCtrl" ng-claok>
	<div class="row">
		<div class="page-header"><h2>Print Receipts</h2>		
			<!--=== start receipt===-->
				<div class="row">
					<?php foreach ($receipt as $key1 => $value): ?>						
						<div class="col-sm-4 col-md-6">
							<div class="thumbnail">
								<div style="display:none;">
									<div id="receipt<?php echo $key1?>">
										<table class="table table-striped">
											<tr>
												<td colspan="4" style="text-align: center; border-top: none;">
													<h3 style="text-align:center;">Stock Management</h3>
													<p style="text-align:center;">#21,Street 388</p>
													<p style="text-align:center;">Sangkat Toul SvayPrey1 Khan Chamkarmorn</p>
													<h3 style="text-align:center;color:red;border-bottom:2px solid black;">Invoice No <?php echo $value->inv_no;?></h3>
												</td>
											</tr>
											<tr style="border-top:2px solid black;">
												<td colspan="4">
													<div class="pull-left">											
														<h6>Cashier <?php echo $value->user_crea;?></h6>
														<h6 style="float:left;">Customer: <?php echo $value->per_name;?></h6>										
													</div>										
													<div class="pull-right">
														<?php date_default_timezone_set("Asia/Phnom_Penh");;?>
														<h6 style="margin-right:10px;"><?php echo date("d-M-Y");?></h6>
														<h6 style="margin-right:10px;"><?php echo date("h:i:s a");?></h6>																								
													</div>
												</td>
											</tr>
										</table>
										<table class="table table-striped">
											<thead>
												<tr style="border-top:2px solid black;font-size:13px;">
													<th>Product</th>
													<th>Qty</th>
													<th>Price($)</th>
													<th>Price(R)</th>
													<th>Total($)</th>
													<th>Total(R)</th>
												</tr>
											</thead>
											<tbody>
												<?php $grand_ttl_usd=0;$grand_ttl_riel=0;if(isset($product_rec)):foreach($product_rec[$key1] as $pro):?>
												<tr>
													<td><?php echo $pro->pro_name;?></td>
													<td><?php echo $pro->qty;?></td>
													<td><?php echo '$'.number_format($pro->price_usd,2);?></td>
													<td><?php echo 'R '.number_format($pro->price_riel);?></td>
													<td><?php echo '$'.number_format(($pro->price_usd * $pro->qty),2);?></td>
													<td><?php echo 'R '.number_format(($pro->price_riel * $pro->qty));?></td>
													<?php $grand_ttl_usd+=$pro->price_usd * $pro->qty?>
													<?php $grand_ttl_riel+=$pro->price_riel * $pro->qty?>
												</tr>												
											<?php endforeach;endif;?>																						
												<tr>
													<td colspan="5" style="text-align: right;">Grand total USD: </td>
													<td style="text-align: left;"><b><?php echo "$".number_format($grand_ttl_usd,2);?></b></td>
												</tr>
												<tr>
													<td colspan="5" style="text-align: right;">Grand total Riel: </td>
													<td style="text-align: left;"><b><?php echo 'R '.number_format($grand_ttl_riel);?></b></td>
												</tr>												
												<tr>
													<td colspan="5" style="text-align: right;">Cash USD: </td>
													<td style="text-align: left;"><b>{{cash_in_usd|currency}}</b></td>
												</tr>
												<tr>
													<td colspan="5" style="text-align: right;">Cash Riel: </td>
													<td style="text-align: left;"><b>R {{cash_in_riel|number}}</b></td>
												</tr>
												<tr>
													<td colspan="5" style="text-align: right;">Exchange USD: </td>
													<td style="text-align: left;"><b>{{excUSD|currency}}​</b></td>
												</tr>
												<tr>
													<td colspan="5" style="text-align: right;">Exchange Riel: </td>
													<td style="text-align: left;"><b>R {{exRiel|number}}</b></td>
												</tr>
											</tbody>
										</table>
										<h5 style="text-align:center"><i>Thank Please come again!</i></h5>

									</div>
								</div>
								<form method="post" id="form<?php echo $key1?>" action="<?php echo base_url('POS/printReceipt/'.$value->inv_hdr_id)?>">																							
									<div class="form-group">
										<label for="">Grand Total USD</label>												
										<label for="" class="pull-right" style="color:red;"><?php echo $value->inv_no?></label>
										<input type="text" readonly="" name="txtGrandTtlUsd" class="form-control" value="<?php echo $grand_ttl_usd;?>" >
									</div>
									<div class="form-group">
										<label for="">Grand Total Riel</label>
										<input type="text" readonly=""  class="form-control " name="txtGrandTtlRiel" value="<?php echo $grand_ttl_riel;?>" >
										<input type="hidden" readonly="" id="grandTtlRiel<?php echo $key1?>" name="txtGrandTtlRiel" class="form-control " value="<?php echo $grand_ttl_riel;?>" >
									</div>
									<div class="form-group">
										<label for="">Cash USD</label>
										<input type="text" class="form-control" 
										ng-change="calExUsd(cashInUsd<?php echo $key1?>,<?php echo $grand_ttl_usd?>,<?php echo $key1?>)" 
										 name="txtCashInUsd" value="{{cashInUsd<?php echo $key1?>}}" ng-model="cashInUsd<?php echo $key1?>" id="cashInUsd<?php echo $key1?>">										
									</div>
									<div class="form-group">
										<label for="">Cash Riel</label>
										<input type="text" class="form-control"  ng-change="calExRiel(cashInRiel<?php echo $key1?>,<?php echo $grand_ttl_riel?>,<?php echo $key1?>)" name="txtCashInRiel" value="{{cashInRiel<?php echo $key1?>}}" ng-model="cashInRiel<?php echo $key1?>" id="cashInRiel<?php echo $key1?>">
									</div>
									<div class="form-group">
										<label for="">Exchange USD</label>
										<input type="text" name="exUsd" id="exUsd<?php echo $key1?>" readonly  class="form-control " value="<?php echo $grand_ttl_usd * (-1).'.00'?>">										
									</div>									
									<div class="form-group">
										<label for="">Exchange Riel</label>
										<input type="text" id="exRiel<?php echo $key1?>" name="exRiel" readonly class="form-control " value="<?php echo $grand_ttl_riel * (-1)?>">
									</div>																									
									<div id="blockPrint" style="display:block;">												
										<button type="button" id="btnPrint<?php echo $key1?>" disabled name="button" onclick="printReceipt('receipt<?php echo $key1?>','<?php echo $key1?>')" class="btn btn-primary btn-lg">Print</button>
									</div>
								</form>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<!--=== End receipt===-->			
		</div>
	</div>
</div>
<script type="text/javascript">
  var app = angular.module("myApp",[]);
  app.controller("myCtrl",function($scope)
  {   
    $scope.cashInUsd = 0;
    $scope.cashInRiel = 0;
    $scope.exUsd = 0;    
		var exRate = "<?php echo $exchange;?>";
		var cashExUsd2Riel = 0;
    $scope.calExUsd = function(val,grandTtl,key1)
    {    	
     	var tmp = (val - grandTtl).toFixed(2);     	
		var ttlRiel = parseFloat($("#grandTtlRiel"+key1).val());
		var exUsd = Math.floor(tmp);
		var exRiel = ttlRiel-(val*exRate);
			$("#btnPrint"+key1).attr("disabled","disabled");
			if(tmp>0)
			{					
				$("#exUsd"+key1).val(tmp);				
				$("#exRiel"+key1).val(tmp*exRate);				
				$scope.cash_in_usd = $("#cashInUsd"+key1).val();
				$scope.cash_in_riel = $("#cashInRiel"+key1).val();
				$scope.excUSD = $("#exUsd"+key1).val();
				$scope.exRiel = $("#exRiel"+key1).val();
				$("#btnPrint"+key1).removeAttr("disabled");
				$("#exUsd"+key1).attr("value",$("#exUsd"+key1).val());						
				$("#exRiel"+key1).attr("value",$("#exRiel"+key1).val());
			}
			else
			{				
				if(tmp==0) {
					$("#exUsd"+key1).val(0);
					$("#exRiel"+key1).val(0);
					$scope.cash_in_usd = $("#cashInUsd"+key1).val();
					$scope.cash_in_riel = $("#cashInRiel"+key1).val();
					$scope.excUSD = $("#exUsd"+key1).val();
					$scope.exRiel = $("#exRiel"+key1).val();
					$("#btnPrint"+key1).removeAttr("disabled");
					$("#exUsd"+key1).attr("value",$("#exUsd"+key1).val());						
					$("#exRiel"+key1).attr("value",$("#exRiel"+key1).val());
				}else {
					$("#exUsd"+key1).val(tmp);
					$("#exRiel"+key1).val(tmp*exRate);
					$scope.cash_in_usd = $("#cashInUsd"+key1).val();
					$scope.cash_in_riel = $("#cashInRiel"+key1).val();
					$scope.excUSD = $("#exUsd"+key1).val();
					$scope.exRiel = $("#exRiel"+key1).val();
					$("#btnPrint"+key1).attr("disabled","disabled");
					$("#exUsd"+key1).attr("value",$("#exUsd"+key1).val());						
					$("#exRiel"+key1).attr("value",$("#exRiel"+key1).val());
				}

			}
    }
	$scope.calExRiel = function(val,grandTtl,key1)
	{				
		var tmp = val - grandTtl;
		var cashUsd = $("#cashInUsd"+key1).val();
		var total =0;
		$("#btnPrint"+key1).attr("disabled","disabled");
		if(cashUsd=="")
		{
				if(tmp==0)
				{
					$("#exUsd"+key1).val(0);
					$("#exRiel"+key1).val(0);
					$scope.cash_in_usd = $("#cashInUsd"+key1).val();
					$scope.cash_in_riel = $("#cashInRiel"+key1).val();
					$scope.excUSD = $("#exUsd"+key1).val();
					$scope.exRiel = $("#exRiel"+key1).val();
					$("#btnPrint"+key1).removeAttr("disabled");
					$("#exUsd"+key1).attr("value",$("#exUsd"+key1).val());						
					$("#exRiel"+key1).attr("value",$("#exRiel"+key1).val());
				}
				else if(tmp>0)
				{
					$("#exUsd"+key1).val(0);
					$("#exRiel"+key1).val(tmp);
					$scope.cash_in_usd = $("#cashInUsd"+key1).val();
					$scope.cash_in_riel = $("#cashInRiel"+key1).val();
					$scope.excUSD = $("#exUsd"+key1).val();
					$scope.exRiel = $("#exRiel"+key1).val();
					$("#btnPrint"+key1).removeAttr("disabled");					
					$("#exUsd"+key1).attr("value",$("#exUsd"+key1).val());						
					$("#exRiel"+key1).attr("value",$("#exRiel"+key1).val());
				}
				else {
					$("#btnPrint"+key1).attr("disabled","disabled");
				}
				// $("#btnPrint"+key1).removeAttr("disabled");
		}
		else
		{
				if(val=="")
				{					
					val=0;
				}
				cashExUsd2Riel = cashUsd * exRate;
				total = parseInt(cashExUsd2Riel) + parseInt(val);
				tmp = total - grandTtl;
				$("#exRiel"+key1).val(tmp);
				if(tmp>=0)
				{									
					$("#exUsd"+key1).val(0);					
					$scope.cash_in_usd = $("#cashInUsd"+key1).val();
					$scope.cash_in_riel = $("#cashInRiel"+key1).val();					
					$scope.excUSD = $("#exUsd"+key1).val();
					$scope.exRiel = $("#exRiel"+key1).val();																	
					$("#btnPrint"+key1).removeAttr("disabled");
					$("#exUsd"+key1).attr("value",$("#exUsd"+key1).val());						
					$("#exRiel"+key1).attr("value",$("#exRiel"+key1).val());												           
				}
		}

	}
  }); 
    function printReceipt(el,form_id)
    {
        var restorepage = document.body.innerHTML;
        var printreceipt = document.getElementById(el).innerHTML;
        document.body.innerHTML = printreceipt;
        window.print();
        document.body.innerHTML = restorepage;
        $("#form"+form_id).submit();
    }// PrintReceipt
</script>
