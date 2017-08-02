<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div id="page-wrapper" ng-app="myApp" ng-controller="myCtrl" ng-cloak>
		<div class="row">
			<div class="page-header"><h2><i class="fa fa-dashboard"></i> POS</h2></div>		

			<!--== Cahshire ==-->
			<div class="col-lg-12">				     
			<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#POS" aria-controls="POS" role="tab" data-toggle="tab">POS</a></li>
					<li role="presentation" ng-click="tab_print_invoice()"><a href="#invoice" aria-controls="invoice" role="tab" data-toggle="tab">Reprint invoice</a></li>
					<li role="presentation"><a href="<?php echo base_url('POS/updateInvoice')?>">Edit invoice</a></li>		    
					<li role="presentation"><a href="<?php echo base_url('POS/delivery_transaction')?>">Delivery</a></li>
					<li role="presentation"><a href="<?php echo base_url('POS/printReceipt');?>">Receipt</a></li>
					<li role="presentation"><a href="<?php echo base_url('POS/confirm_user');?>">Close shift</a></li>
					<li role="presentation"><a href="<?php echo base_url('Report/sale_report_daily');?>">View Sale Report</a></li>
					<li role="presentation"><a href="<?php echo base_url('Report/sale_report_detail');?>">View Sale Report Detail</a></li>		    		    
				</ul>
			<!-- End Nav tabs -->

				<!-- Tab panels -->
				<div class="tab-content">
					<!--== POS ==-->		  	
						<div role="tabpanel" class="tab-pane active" id="POS">
							<!--== product ==-->
							<div class="col-lg-5"  style="overflow: scroll; height: 630px; -webkit-overflow-scrolling: touch; overflow-x: hidden;">
								<div class="row" style="margin-top:10px; margin-bottom: 10px;">				
									<div class="col-lg-6">										
										<select class="form-control" name="ddlCategory" id="ddlCategory" ng-model="ddlCategory" ng-change="category(ddlCategory)">
											<option style="display: none;" value="">Choose Categories</option>
											<option value="">All</option>					
											<?php if(isset($category)):foreach($category as $cat):?>
												<option value="<?php echo $cat->cat_id?>"><?php echo $cat->cat_name;?></option>					  
											<?php endforeach;endif;?>
										</select>						
									</div>
									<div class="col-lg-6">										
										<input type="text" placeholder="Search Category...." ng-model="search_cat" class="form-control">						
									</div>
								</div>
								<div class="row">						
									<div class="col-lg-12">
										<div class="row">					
											<div class="col-lg-4" ng-repeat="x in product|filter:search_cat">
												<a style="cursor: pointer" class="thumbnail" ng-click="clickProduct(x.id,x.name,x.price_usd,x.price_riel,1)">
													<img id="menuImg" class="img-responsive"  src="<?php echo base_url()?>assets/uploads/{{x.image}}" style="height: 150px;">	                        		                        
													<i>{{x.name}}</i>	                          		                        
													<i style="color: red; float:right;">{{x.price_usd ? (x.price_usd|currency) : "R "+(x.price_riel|number)}}</i></p>
												</a>
											</div>					
										</div>			          			                  			                   		              
									</div><!-- tab content -->



								</div>        
							</div>
							<!--== Endp roduct ==-->



							<!--== checkout ==-->
							<div class="col-lg-7">
								<?php echo form_open(base_url()."POS/checkout",array('id'=>'form_print')); ?>
								<div class="row" style="margin-top:10px;">
									<div class="col-lg-12">
										<div ng-show='stock_msg'>
											<!--===error stock_qty===-->                  
											<div class="alert alert-warning alert-dismissible" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<strong>Warning!</strong> Sorry! The Product name " {{name1}} " not enought. Remaining only {{qty1}}.
											</div>                                      
											<!--===end error stock_qty===-->
										</div>
									</div>

									<!--== validation error ==-->
									<div class="col-lg-12">
										<?php
										if(!empty($require_msg) OR validation_errors())
										{
											?>
											<div class="alert alert-danger" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
												<strong>Attention!</strong><div><?php if(!empty($require_msg)){echo $require_msg;}?></div><?php if(validation_errors()){echo validation_errors();}?>
											</div>
											<?php }?>
										</div>
										<!--== end validation error==-->
										<div class="col-lg-12"><?php if(isset($msg)){echo $msg;}?></div>		    		
									</div>
									<!--== The form choose customer && Credid type==-->			    
									<div class="row" style="margin-bottom: 10px;">
										<div class="col-lg-12">										
											<select class="form-control" name="ddlCustomerId" id="ddlCustomerId" ng-model="ddlCustomerId" ng-change="customer(ddlCustomerId)">
												<option style="display: none;" value="">Choose Customer name</option>															    								
												<?php if(isset($customer)):foreach($customer as $cus):?>
													<option value="<?php echo $cus->per_id?>" <?php echo set_select("ddlCustomerId",$cus->per_id);?>><?php echo $cus->per_name;?></option>					  
												<?php endforeach;endif;?>
											</select>						
										</div>			    	
									</div>
									<!--== end The form choose customer && Credid type==-->
									<div class="row">
										<div class="col-lg-12">			    		
											<div class="panel panel-default" style="border-left: none; border-radius: 0px; overflow: scroll; height: 400px; -webkit-overflow-scrolling: touch; overflow-x: hidden;">		                  
												<div class="panel-body">
													<table class="table table-striped table-hover">
														<thead>
															<tr>
																<th>No</th>
																<th>Name</th>			    								
																<th>Price usd</th>
																<th>Price riel</th>
																<th>Qty</th>
																<th>Total usd</th>
																<th>Total riel</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody></tbody>			    						
														<tr ng-repeat="x in order">
															<td>{{$index+1}}</td>
															<td><a href="" style="font-size: 15px; font-weight: bold;" ng-click="removeOne($index,x[2],x[3])">{{x[1]}}</a></td>			    								
															<td>{{x[2] ? (x[2]|currency) : (x[3] / exchange_rate[0].exRate|currency)}}</td>
															<td>{{x[3] ? 'R '+(x[3]|number) : 'R '+riel(x[2] * exchange_rate[0].exRate|number)}}</td>
															<td>{{x[4]}}</td>
															<td>{{x[2] ? (x[2]*x[4]|currency) : (x[3] * x[4] / exchange_rate[0].exRate|currency)}}</td>
															<td>{{x[3] ? 'R '+(x[3]*x[4]|number) : 'R '+riel(x[2] * x[4] * exchange_rate[0].exRate|number)}}</td>
															<td><a style="cursor: pointer;color: red; font-size: 17px;" ng-click="removeMenu($index,x[2]*x[4],x[3]*x[4])"><span class="glyphicon glyphicon-trash"></span></a></td>
														</tr>			    						
													</tbody>                  
												</table>		              
											</div>


										</div>			    				    		
									</div>
								</div>			    				    		    			    		
								<div class="row">
									<div class="col-lg-3"><b>Grand total USD:</b></div>
									<div class="col-lg-9">{{grandTotalUSD ? (grandTotalUSD|currency) : '$00'}}</div>
								</div>			    					    		
								<div class="row">
									<div class="col-lg-3"><b>Grand total Riel:</b></div>
									<div class="col-lg-9">{{grandTotalRiel ? 'R '+(grandTotalRiel|number) : 'R 00'}}</div>
								</div><hr>
								<div class="row">
									<div class="col-lg-12">
										<input type="button" id="btnCheckout" class="btn btn-success" value="Checkout" onclick="printInvoice()" ng-disabled="dis">
									</div>
								</div>		    				    			    		

								<input type="hidden" name="str" id="str">		
								<input type="hidden" name="cust" id="cust">		
								<input type="hidden" name="inv_num" id="inv_num">		
								
							<?php form_close();?>
							</div>
							<!--== End checkout ==-->		    
						</div>		   
					<!--== End POS ==-->

					<!--== Print_and_checkout==-->												
						<div id="print_inv" style="display: none;">
							<h3 style="text-align:center;">Stock Management</h3>
							<p style="text-align:center;">#21,Street 388</p>
							<p style="text-align:center;">Sangkat Toul SvayPrey1 Khan Chamkarmorn</p>
							<h3 style="text-align:center;color:red;border-bottom:2px solid black;">Invoice No: {{inv_number}}</h3>
							<div class="pull-left">											
								<h6>Cashier <?php echo $this->session->userLogin;?></h6>
								<h6 style="float:left;">Customer: {{customer1[0].cust_name}}</h6>										
							</div>										
							<div class="pull-right">
								<div class="pull-right">
									<?php date_default_timezone_set("Asia/Phnom_Penh");;?>
									<h6 style="margin-right:10px;"><?php echo date("d-M-Y");?></h6>
									<h6 style="margin-right:10px;"><?php echo date("h:i:s a");?></h6>																								
								</div>											
							</div>

							<table class="table table-striped">
								<thead>											
									<tr style="border-top:2px solid black;font-size:13px;">
										<th>Product</th>
										<th>Qty</th>
										<th>Price usd</th>
										<th>Price riel</th>
										<th>Total usd</th>
										<th>Total riel</th>
									</tr>
								</thead>
								<tbody>									
									<tr ng-repeat="x in order">										
										<td>{{x[1]}}</td>
										<td>{{x[4]}}</td>			    								
										<td>{{x[2] ? (x[2]|currency) : (x[3] / exchange_rate[0].exRate|currency)}}</td>
										<td>{{x[3] ? 'R '+(x[3]|number) : 'R '+riel(x[2] * exchange_rate[0].exRate|number)}}</td>										
										<td>{{x[2] ? (x[2]*x[4]|currency) : (x[3] * x[4] / exchange_rate[0].exRate|currency)}}</td>
										<td>{{x[3] ? 'R '+(x[3]*x[4]|number) : 'R '+riel(x[2] * x[4] * exchange_rate[0].exRate|number)}}</td>
									</tr>																				
								
								<tr style="border-top:2px solid black;">																	
									<td colspan="6" style="text-align: right;">Grand Total USD:<strong> {{grandTotalUSD ? (grandTotalUSD|currency) : '$00'}}</strong></td>
								</tr>
								<tr>
									<td colspan="6" style="text-align: right;">Grand Total Riel:<strong> {{grandTotalRiel ? 'R '+(grandTotalRiel|number) : 'R 00'}}</strong></td>
								</tr>
							</tbody>
							</table>
						</div>																	
					<!--== End Print_and_checkout==-->

					<!--== Reprint Invoice ==-->
						<div role="tabpanel" class="tab-pane" id="invoice">
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="invoice">
									<div class="row" style="margin-top:20px;">

										<?php if(isset($invoice)):foreach($invoice as $key =>$inv):?>
											<div class="col-sm-4 col-md-6">
												<div class="thumbnail">
													<div style="height:240px;overflow:scroll;">
														<div id="invoice0">
															<h3 style="text-align:center;">Stock Management</h3>
															<p style="text-align:center;">#21,Street 388</p>
															<p style="text-align:center;">Sangkat Toul SvayPrey1 Khan Chamkarmorn</p>
															<h3 style="text-align:center;color:red;border-bottom:2px solid black;">Invoice No <?php echo $inv->inv_no;?></h3>
															<div class="pull-left">											
																<h6>Cashier <?php echo $inv->user_crea;?></h6>
																<h6 style="float:left;">Customer: <?php echo $inv->per_name;?></h6>										
															</div>										
															<div class="pull-right">
																<div class="pull-right">
																	<?php date_default_timezone_set("Asia/Phnom_Penh");;?>
																	<h6 style="margin-right:10px;"><?php echo date("d-M-Y");?></h6>
																	<h6 style="margin-right:10px;"><?php echo date("h:i:s a");?></h6>																								
																</div>											
															</div>

															<table class="table table-striped">
																<thead>											
																	<tr style="border-top:2px solid black;font-size:13px;">
																		<th>Product</th>
																		<th>Qty</th>
																		<th>Price usd</th>
																		<th>Price riel</th>
																		<th>Total usd</th>
																		<th>Total riel</th>
																	</tr>
																</thead>
																<tbody>
																	<?php $grand_ttl_usd=0;$grand_ttl_riel=0;if(isset($product)):foreach($product[$key] as $pro):?>
																	<tr>
																		<td><?php echo $pro->pro_name;?></td>
																		<td><?php echo $pro->qty;?></td>
																		<td><?php echo '$'.number_format($pro->price_usd,2) ;?></td>
																		<td><?php echo 'R '.number_format($pro->price_riel) ;?></td>
																		<td><?php echo '$'.number_format(($pro->price_usd * $pro->qty),2);?></td>
																		<td><?php echo 'R '.number_format($pro->price_riel * $pro->qty);?></td>																		
																		<?php $grand_ttl_usd+=$pro->price_usd * $pro->qty?>
																		<?php $grand_ttl_riel+=$pro->price_riel * $pro->qty?>																																																
																	</tr>												
																<?php endforeach;endif;?>
																
																<tr style="border-top:2px solid black;">																	
																	<td colspan="6" style="text-align: right;">Grand Total USD:<strong> <?php echo  '$'.number_format($grand_ttl_usd,2);?></strong></td>
																</tr>
																<tr>
																	<td colspan="6" style="text-align: right;">Grand Total Riel:<strong> <?php echo  'R '.number_format($grand_ttl_riel);?></strong></td>
																</tr>
															</tbody>
														</table>

													</div>
												</div>
												<hr>												
												<a onclick="reprint_invoice('invoice<?php echo $key?>')" href="<?php echo base_url('POS/print_invoice')?>"class="btn btn-primary btn-lg">Print Invoice</a>
											</div>
										</div>
									<?php endforeach;endif;?>

								</div>
							</div>
						</div>
						</div>
					<!--==End Reprint Invoice ==-->

			</div>
			<!-- End Tab panels -->

		</div>		
		<!--== Cashire ==-->
	</div>
</div> 



<!--java script-->
<script type="text/javascript">
 var arr=[];
  var arr2=[];
  var arr3=[];
  var i = 0;
  var total_usd=0;
  var total_riel=0;
  var qty2=1;  

	angular.module('myApp',[]).controller('myCtrl',function($scope,$http)
  {  
  //load exchange rate
   $http.get("<?php echo base_url();?>ng/loadExchRate.php")        
      .then(function (response) {$scope.exchange_rate=response.data.records;});
 //Tab POS     
      //load product
      $http.get("<?php echo base_url();?>ng/loadProduct.php?cat_id")        
      .then(function (response) {$scope.product=response.data.records;});
      //when click category select product follow by category id
      $scope.category=function(id)
      {         	      	
      	$http.get("<?php echo base_url();?>ng/loadProduct.php?cat_id="+id)        
      .then(function (response) {$scope.product=response.data.records;});	
      }      
      //ciel the riel
      $scope.riel=function(value='')
      {
      	x1=value.toString();        
    	var x = x1.slice(-2);
        if(x!=00){return (100 - x) + value;}
        else{return value;}      	
      }      
      $scope.clickProduct=function(id,name,price_usd,price_riel,qty)
      {         	       	  	      	
      	$scope.stock_msg=false;
      	$http.get("<?php echo base_url()?>ng/get_qty_stock.php?id="+id)
        .then(function (response)
        {        	
          var x=response.data.records;                    
          if(x[0]['quantity']>qty && x[0]['quantity']!=0)
          {   
          	var found = arr2.indexOf(name);            
	          if(found!=-1)
	          {  	          		
	       		if(x[0]['quantity']>arr3[found])
	            {	            	
	              arr3[found] = arr3[found]+1;
	              arr[found][4]=arr3[found];
	            }
	            else
	            {
	             	$scope.stock_msg=true;
		            $scope.qty1=x[0]['quantity'];
		            $scope.name1=x[0]['name'];
	            }                    	                                          
	          }
	          else 
	          {                
	              arr[i] = [id,name,price_usd,price_riel,qty];
	              arr2[i] = name;
	              arr3[i] = qty;
	              i = i+1;
	              qty2=0;
	          }
          }
          else
          {
          	$scope.stock_msg=true;
            $scope.qty1=x[0]['quantity'];
            $scope.name1=x[0]['name'];
          }	      	  	            
        });
        $scope.order = arr;
        total_usd = total_usd + (price_usd* qty);
        total_riel = total_riel + (price_riel * qty);
        total_usd1 = total_usd + (total_riel / $scope.exchange_rate[0].exRate);
        total_riel1 = total_riel + (total_usd * $scope.exchange_rate[0].exRate);
        x1=total_riel1.toString();        
        var x = x1.slice(-2);            
        if(x!=00){var total_riel2 = (100 - x) + total_riel1;}
        else{total_riel2 = total_riel1;}
        $scope.grandTotalUSD = total_usd1;        
        $scope.grandTotalRiel = total_riel2;            
     }

     	 $scope.removeMenu = function(id,ttl_usd,ttl_riel)
	  	{	
	  		$scope.stock_msg=false;  		
	        arr.splice(id,1);
	        arr2.splice(id,1);
	        i = i-1;
	        total_usd = total_usd - ttl_usd;	        
	        total_riel = total_riel - ttl_riel;
	        total_usd1 = total_usd - (-total_riel / $scope.exchange_rate[0].exRate);
	        total_riel1 = total_riel - (-total_usd * $scope.exchange_rate[0].exRate);
	        x1=total_riel1.toString();        
        	var x = x1.slice(-2);
	        if(x!=00){var total_riel2 = (100 - x) + total_riel1;}
	        else{total_riel2 = total_riel1;}
	        $scope.grandTotalUSD = total_usd1;
	        $scope.grandTotalRiel = total_riel2;
	        qty2=0;
	    }
      	$scope.removeOne = function(index,ttl_usd,ttl_riel)
      	{  
      		$scope.stock_msg=false;    	      			
	        arr3[index] = arr3[index]-1;
	        arr[index][4] = arr3[index];
	        total_usd = total_usd - ttl_usd;
	        total_riel = total_riel - ttl_riel;
	        total_usd1 = total_usd - (-total_riel / $scope.exchange_rate[0].exRate);
	        total_riel1 = total_riel - (-total_usd * $scope.exchange_rate[0].exRate);
	       	x1=total_riel1.toString();        
        	var x = x1.slice(-2);
	        if(x!=00){var total_riel2 = (100 - x) + total_riel1;}
	        else{total_riel2 = total_riel1;}
	        $scope.grandTotalUSD = total_usd1;	        
	        $scope.grandTotalRiel = total_riel2;

	        if(arr3[index]==0)
	        {
	          arr.splice(index,1);
	          arr2.splice(index,1);
	          arr3.splice(index,1);
	          i = i-1;	          
	        }			
      	}  
//get_customer
      	$scope.dis=true;
      	$scope.customer=function(id)
      	{
  			$http.get("<?php echo base_url();?>ng/load_customer.php?id="+id)        
	      .then(function (response) {$scope.customer1=response.data.records;$('#cust').val($scope.customer1[0].cust_id);});
	      $scope.dis=false;	      	
      	}
//convert the invoice_number
      	$http.get("<?php echo base_url();?>POS/angular_inv_number")
	    .then(function (response){$scope.inv_number = response.data;$('#inv_num').val(response.data);});     	     	

//Tab print invoice
         $scope.tab_print_invoice=function()
         {
         	//each invoice hdr
         	$http.get("<?php echo base_url();?>ng/loadInvoice_hdr.php?inv_id")        
		      .then(function (response) {$scope.invoice=response.data.records;});
		      //each products according to invoice hdr

		  	$http.get("<?php echo base_url();?>ng/loadInvoice.php?inv_id")        
		      .then(function (response) {$scope.product1=response.data.records;});		         
		  }    			                		  
 });
</script>
<script type="text/javascript">
	function printInvoice()
    {
    	$('#str').val(JSON.stringify(arr));                                            
        var restorepage = document.body.innerHTML;
        var printinvoice = document.getElementById("print_inv").innerHTML;
        document.body.innerHTML = printinvoice;
        window.print();	        
        document.body.innerHTML = restorepage;
        document.getElementById("form_print").submit();     
    }//PrintInvoice

	function reprint_invoice(el)
    {
        var restorepage = document.body.innerHTML;
        var printinvoice = document.getElementById(el).innerHTML;
        document.body.innerHTML = printinvoice;
        window.print();
        document.body.innerHTML = restorepage;

    }//Reprint PrintInvoice    
</script>

