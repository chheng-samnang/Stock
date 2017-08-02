<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper" ng-app="myApp" ng-controller="myCtrl" ng-cloak>
	<div class="row">
		<div class="page-header"><h2>Edit invoice</h2></div>	    	
		<?php echo form_open("POS/updateInvoice")?>
			<!--== validation errors ==--> 
				<div class="row">
					<div class="col-lg-12">
					<?php
						if(validation_errors())
						{
					?>
						<div class="alert alert-danger" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<strong>Attention!</strong><?php echo validation_errors();?>
						</div>
					<?php }?>
					</div>
				</div>   		            
			<!--== Endvalidation errors ==-->    		            
	        <!--== Error stock message ==-->      			            
	            <div class="row">			                        
	                <div class="col-lg-12">
	                  <div ng-show="stock_msg">
	                    <div class="alert alert-warning alert-dismissible" role="alert">
	                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                      <strong>Warning! The menu name " {{name}} " not enough. Remaining only {{quantity}}</strong>
	                    </div>
	                  </div>                                        
	                </div>                             			                            
	            </div>
	        <!--== End Error stock message ==-->
	        <!--==Dublicate errore ==-->
	        	<div class="row">			                        
	                <div class="col-lg-12">
	                  <div ng-show="dublicate">
	                    <div class="alert alert-warning alert-dismissible" role="alert">
	                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                      <strong>Warning! The menu name dublicated.</strong>
	                    </div>
	                  </div>                                        
	                </div>                             			                            
	            </div>  
	        <!--==End dublicate errore ==-->    

	        <!--== Form Control ==-->
		        <div class="row" style="margin-top: 15px;">
		        	<div class="col-lg-3">
		        		<div class="form-group">                  
		        			<label class="control-label">Invoice Number</label>
		        			<select name="ddlInvoice" class="form-control" ng-model="ddlInvoice" ng-change="invoice_filter()">
		        				<option value="" style="display: none;">Choose Invoice No</option>
		        				<?php if(isset($invoice_edit)):foreach($invoice_edit as $inv_edit):?>
		        					<option value="<?php echo $inv_edit->inv_hdr_id;?>" <?php echo set_select("ddlInvoice",$inv_edit->inv_hdr_id);?>><?php echo $inv_edit->inv_no;?></option>
		        				<?php endforeach;endif;?>
		        			</select>              			                                                         
		        		</div>
		        	</div>			        	             
		        	<div class="col-lg-3">
		        		<div class="form-group">                  
		        			<label for="exampleInputName2" class="control-label">Product name</label>                         
		        			<select name="ddlProduct" class="form-control" ng-model="ddlProduct" ng-change="product_filter()">
		        				<option value="" style="display: none;">Choose product</option>
		        				<?php if(isset($product_edit)):foreach($product_edit as $pro_edit):?>
		        					<option value="<?php echo $pro_edit->pro_id;?>" <?php echo set_select("ddlProduct",$pro_edit->pro_id);?>><?php echo $pro_edit->pro_name;?></option>
		        				<?php endforeach;endif;?>
		        			</select>
		        		</div>
		        	</div>				        	             			            
		        </div>
	        <!--== End Form Control ==-->           

	            <hr>
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>No</th>
	                  <th>Name</th>
	                  <th>Quantity</th>
	                  <th>Price USD</th>
	                  <th>Price Riel</th>
	                  <th>Total USD</th>
	                  <th>Total Riel</th>
	                  <th>Action</th>
	                </tr>
	              </thead>
	              <tbody>
	                <tr ng-repeat="x in invoice_filter1">
	                <input type="hidden" id="{{x.id}}" value="{{x.id}}">
	                  <td>{{$index+1}}</td>	                  
	                  <td>{{x.product}} <input type="hidden" name="txtProID{{$index}}" value="{{x.id}}" ng-model="proid" ng-init="proid=x.id" id="proid{{$index}}"></td>
	                  <td>
		                  <div style="float:left; width: 100px;">
	                  		<input type="text" readonly class="form-control"  name="txtQty{{$index}}" ng-model="qtyOld" id="qtyOld{{$index}}" ng-init="qtyOld=x.qty">                  		
		                  </div>
		                  <div style="float:left; line-height:30px;margin:0px 5px;"><label>+</label></div>
		                  <div style="float:left; width: 100px;">
	                  		<input type="text" class="form-control" ng-model="qtyAdd" id="qtyAdd{{$index}}" ng-init="qtyAdd=0" ng-change="cal($index,x.qty,qtyAdd,x.price_usd,x.price_riel,x.id)" ng-disabled="dis{{$index}}" autocomplete="off">                  		
		                  </div>
	                  </td>
	                  <td><input type="text" readonly name="txtPriceUSD{{$index}}" class="form-control" id="price_usd{{$index}}" ng-model="price_usd" ng-init="price_usd=x.price_usd"></td>

	                  <td><input type="text" readonly name="txtPriceRiel{{$index}}" class="form-control" id="price_riel{{$index}}" ng-model="price_riel" ng-init="price_riel=x.price_riel"></td>	

	                  <td><input type="text" readonly class="form-control"  id="total_usd{{$index}}" value="" ng-model="total_usd" ng-init="total_usd=(x.qty*x.price_usd|currency)"></td>

	                  <td><input type="text" readonly class="form-control"  id="total_riel{{$index}}" value="" ng-model="total_riel" ng-init="total_riel='R '+(x.qty*x.price_riel|number)"></td>

	                  <td><button type="button" ng-click="remove(x.id,$index)" name="btnRemove" class="btn btn-danger" ng-disabled="dis_remove"><i class="fa fa-trash"></i> remove</button></td>                                                      
	                </tr>                              
	              </tbody>
	            </table>
	            <hr>			            
	            <input type="submit" name="btnSubmit" class="btn btn-success pull-right" value="Save change" ng-disabled="stock_msg">  	        
	  <?php form_close() ?>						    		    		 		
	</div>
</div> 



<!--java script-->
<script type="text/javascript">	
	angular.module('myApp',[]).controller('myCtrl',function($scope,$http)
	{     
		//laod exchange rate
		$http.get("<?php echo base_url();?>ng/loadExchRate.php")        
      .then(function (response) {$scope.exchange_rate = response.data.records;});
		

		$scope.invoice_filter=function()
		{						
			$http.get("<?php echo base_url();?>ng/loadInvoice.php?inv_id="+$scope.ddlInvoice)        
			.then(function (response){$scope.invoice_filter1=response.data.records;});							          
		};				

		$scope.product_filter=function()		
		{   
			if($("#"+$scope.ddlProduct).val()==undefined)
			{
				$scope.dublicate=false;
				$http.get("<?php echo base_url()?>ng/get_qty_stock.php?id="+$scope.ddlProduct).then(function (response)        
				{				
		       	x1=total_riel1.toString();        
	        	var x = x1.slice(-2);
		        if(x!=00){var total_riel2 = (100 - x) + total_riel1;}
		        else{total_riel2 = total_riel1;}


					var x=response.data.records;
					if(x[0]['quantity']>0)
					{  	                 
						$http.get("<?php echo base_url()?>ng/get_pro_id.php?id="+$scope.ddlProduct)
						.then(function (response)
						{	              	
							var value=response.data.records;
							var i1 = value[0]["price_usd"] * $scope.exchange_rate[0].exRate;
							var i = i1.toString();
							var y = i.slice(-2);
							var convert_riel = 0;
							if(y!=00){convert_riel = (100 - y) + i1;}
							else{convert_riel = i1;}
							var usd = value[0]['price_usd']!=''? value[0]["price_usd"] : value[0]["price_riel"] / $scope.exchange_rate[0].exRate;
							var riel =value[0]['price_riel']!=''? value[0]["price_riel"] : convert_riel;

							$scope.invoice_filter1[$scope.invoice_filter1.length]=
							{product:value[0]["product"],
							qty:1,											
							price_usd:usd,
							price_riel:riel,						
							id:value[0]["id"]};
						});
						$scope.stock_msg=false;                
					}        
					else
					{
						$scope.stock_msg=true;
						$scope.name=x[0]['name'];
						$scope.quantity=x[0]['quantity'];                     
					}            
				});
			}
			else
			{
				$scope.dublicate=true;
			}  			
		}                
		$scope.cal = function(index,qty,qtyAdd,price_usd,price_riel,pro_id)
		{	   					
			var qtyOld = parseInt(qty);
			var qtyNew = parseInt(qtyAdd);									
			if(qtyNew>0)
			{
				$http.get("<?php echo base_url()?>ng/get_qty_stock.php?id="+pro_id).then(function (response)       
				{   
					var x=response.data.records;    	        	                    
					if(x[0]['quantity']>=qtyNew)
					{
						var total_usd = (qtyOld + qtyNew) * price_usd;
						var total_riel = (qtyOld + qtyNew) * price_riel;
						$("#total_usd"+index).val('$'+total_usd+'.00');
						$("#total_riel"+index).val('R '+total_riel);
						$scope.stock_msg=false;
						for(i=0;i<=$scope.invoice_filter1.length;i++)
						{
							$("#qtyAdd"+i).removeAttr("disabled");							    
						}
						$("#qtyOld"+index).val(qtyOld + (qtyNew));
						$scope.dis_remove=false;
					}	          
					else
					{
						$scope.stock_msg=true;
						$scope.name=x[0]['name'];
						$scope.quantity=x[0]['quantity'];	                        
						for(i=0;i<=$scope.invoice_filter1.length;i++)
						{
							if(i!=index)
							{
								$("#qtyAdd"+i).attr("disabled","disabled");								 								
							}                  
						}
						$scope.dis_remove=true;                              	           
						var total_usd = (qtyOld + qtyNew) * price_usd;
						var total_riel = (qtyOld + qtyNew) * price_riel;
						$("#total_usd"+index).val('$'+total_usd+'.00');
						$("#total_riel"+index).val('R '+total_riel);                               
					}                                                                            	        
				});
			}
			else
			{				
				$scope.dis_remove=true; 
				$("#qtyOld"+index).val(qtyOld + (qtyNew));                             	           
				var total_usd = (qtyOld + qtyNew) * price_usd;
				var total_riel = (qtyOld + qtyNew) * price_riel;
				$("#total_usd"+index).val('$'+total_usd+'.00');
				$("#total_riel"+index).val('R '+total_riel);
			}			

		}			 				                                       
		$scope.remove = function(id,index)
		{	  	
			$scope.invoice_filter1.splice(index,1);
			$scope.stock_msg=false;      
			for(i=0;i<=$scope.invoice_filter1.length;i++)
			{
				$("#qtyAdd"+i).removeAttr("disabled");    
			}
		}
	});
</script>

