<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</nav>
	<div id="page-wrapper" ng-app="myApp" ng-controller="myCtrl">
		<div class="container_fluid" style="margin-top:40px;">
		<div class="row">
			<div class="col-lg-12">
				<?php echo isset($multipart)?form_open_multipart($action):form_open($action)?>
				<h1 class="page-header">Form Add <?php echo $pageHeader;?></h1>
				<div class="row">
					<div class="col-lg-12">
					<?php
						if(!empty($error) OR validation_errors())
						{
					?>
						<div class="alert alert-danger" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<strong>Attention!</strong><?php if(!empty($error)){echo $error;}if(validation_errors()){echo validation_errors();}?>
						</div>
					<?php }?>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $pageHeader?> Information</h3>
					</div>
					<div class="panel-body">
					<div class="page-header"><h4><b>Product Form</b></h4></div>											
						<div class="row">
							<div class="col-lg-3">                                        
								<div class="form-group">
									<label class="control-label">Category</label>
									<select class="form-control" name="ddlCategoryName">
										<option value="">Choose One</option>                                                
										<?php if(isset($category)):foreach($category as $value):?>                                                                                                    
											<option value="<?php echo $value->cat_id;?>" <?php echo set_select("ddlCategoryName",$value->cat_id);?>><?php echo $value->cat_name;?></option>
										<?php endforeach;endif;?>
									</select>
								</div>                                        
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label class="control-label">Product name</label>
									<input type="text" name="txtProductName" id="txtProductName" class="form-control" placeholder="Enter product name" value="<?php echo set_value('txtProductName');?>">
								</div>    
							</div>
							<div class="col-lg-3">                                        
								<div class="form-group">
									<label class="control-label">Product Status</label>
									<select class="form-control" name="ddlProStatus">
										<option value="1" <?php echo set_select("ddlStatus",1);?>>Enable</option>
										<option value="0" <?php echo set_select("ddlStatus",0);?>>Disable</option>										                                                										
									</select>
								</div>                                        
							</div>
							<div class="col-lg-3"><label>Image</label>                                        
								<div class="form-group">									
									<button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">Upload Image</button>
								</div>                                        
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Product Description</label>
									<textarea name="txtProDesc" class="form-control">
										<?php echo set_value('txtProDesc')?>

									</textarea>
								</div>
							</div>
						</div>






						<div class="page-header"><h4><b>Purchase Form</b></h4></div>
						<div class="row">
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Supplyer name</label>
									<select class="form-control" name="ddlSupplyerName">
										<option value="">Choose One</option>                                                
										<?php if(isset($customer)):foreach($customer as $value):?>                                                                                                    
											<option value="<?php echo $value->per_id;?>" <?php echo set_select("ddlSupplyerName",$value->per_id);?>><?php echo $value->per_name;?></option>
										<?php endforeach;endif;?>
									</select>
								</div>                                        
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Purchase Quantity</label>
									<input type="text" name="txtPchQty" id="txtPchQty" class="form-control" placeholder="Enter Purchase Quantity" value="<?php echo set_value('txtPchQty');?>">
								</div>    
							</div>														
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Purchase Price USD</label>
									<input type="text" name="txtPchPriceInUSD" id="txtPchPriceInUSD" class="form-control" placeholder="Enter Purchase Price USD" value="<?php echo set_value('txtPchPriceInUSD');?>" ng-model="txtPchPriceInUSD" ng-change="PurchaseUSD('txtPchPriceInUSD')" ng-disabled="dis_PurchaseUSD">
								</div>    
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Purchase Price Riel</label>
									<input type="text" name="txtPchPriceInRiel" id="txtPchPriceInRiel" class="form-control" placeholder="Enter Purchase Price Riel" value="<?php echo set_value('txtPchPriceInRiel');?>"  ng-model="txtPchPriceInRiel" ng-change="PurchaseRiel('txtPchPriceInRiel')" ng-disabled="dis_PurchaseRiel">
								</div>    
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Purchase Price USD</label>
									<input type="text" name="txtPchPriceOutUSD" id="txtPchPriceOutUSD" class="form-control" placeholder="Enter Purchase Price USD" value="<?php echo set_value('txtPchPriceOutUSD');?>" ng-model="txtPchPriceOutUSD" ng-change="SaleUSD()" ng-disabled="dis_SaleUSD">
								</div>    
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Purchase Price Riel</label>
									<input type="text" name="txtPchPriceOutRiel" id="txtPchPriceOutRiel" class="form-control" placeholder="Enter Purchase Price Riel" value="<?php echo set_value('txtPchPriceOutRiel');?>" ng-model="txtPchPriceOutRiel" ng-change="SaleRiel('txtPchPriceOutRiel')"  ng-model="txtPchPriceOutUSD" ng-change="SaleUSD('txtPchPriceOutRiel')" ng-disabled="dis_SaleRiel">
								</div>    
							</div>
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Purchase Status</label>
									<select class="form-control" name="ddlPchStatus">
										<option value="1" <?php echo set_select("ddlStatus",1);?>>Enable</option>
										<option value="0" <?php echo set_select("ddlStatus",0);?>>Disable</option>										                                                										
									</select>
								</div>                                        
							</div>													
							<div class="col-lg-4">
								<label class="control-label">Valid</label>
								<div class="input-group datetimepicker">
									<input type="text" name="txtValid" value="<?php echo set_value('txtValid')?>" class="form-control datetimepicker" placeholder="Valid" id="txtValid">                                          
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>                                
								</div>
							</div>
							<div class="col-lg-4">
								<label class="control-label">Expire</label>
								<div class="input-group datetimepicker">
									<input type="text" name="txtExpire" value="<?php echo set_value('txtExpire')?>" class="form-control datetimepicker" placeholder="Expire" id="txtExpire">                                          
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>                                
								</div>
							</div>							
						</div>
						<div class="row">                                                                                                                                 							
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Purchase Description</label>
									<textarea name="txtPchDesc" class="form-control">
										<?php echo set_value('txtPchDesc');?>
									</textarea>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Browse Image</h4>
										  </div>
										  <div class="modal-body">
											<input	type="file" name="txtUpload" />
											<input type="hidden" id="txtImgName" name="txtImgName" />
											<div id="response" style="margin-top:10px;color:green;font-weight:bold;"></div>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
										  </div>
										</div>
									  </div>
									</div>
							</div>
						</div>
						
						<hr />
						<div class="row">
							<div class="col-lg-12">
								<?php echo form_submit('btnSubmit','Save','class="btn btn-success"');?>
								<?php echo form_button('btnCancel','Cancel','id="btnCancel" class="btn btn-default"');?>
							</div>
						</div>																				
						
					</div>
				</div>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div>

<script>
	function uploadFile() {
		var formData = new FormData();
		formData.append('image', $('input[type=file]')[0].files[0]); 
		$.ajax({
			url: '<?php echo base_url()?>ng/upload.php',
			data: formData,
			type: 'POST',
			// THIS MUST BE DONE FOR FILE UPLOADING
			contentType: false,
			processData: false,
			// ... Other options like success and etc
			
			success: function(data) {
				document.getElementById("response").innerText = "Upload Complete!"; 
				document.getElementById("txtImgName").value = data;
			}
			
		});
		
	}
</script>
<script>
	$("#btnCancel").click(function(){
    	window.location.assign('<?php echo base_url().$cancel?>');
	});
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
<script type="text/javascript">
	angular.module('myApp',[]).controller('myCtrl',function($scope,$http)
  	{
  		$scope.PurchaseUSD=function()
  		{
  			if($scope.txtPchPriceInUSD.length>0)
  			{
  				$scope.dis_PurchaseRiel=true;  				

  				$("#txtPchPriceInRiel").attr("value", "<?php echo $exchange_rate;?>");
  				<?php echo '$("#txtPchPriceInUSD").val()';echo 1221;?>
  				//alert($("#txtPchPriceInUSD").val());
  			}
  			else{$scope.dis_PurchaseRiel=false;}
  		}
  		$scope.PurchaseRiel=function()
  		{
  			if($scope.txtPchPriceInRiel.length>0){$scope.dis_PurchaseUSD=true;}
  			else{$scope.dis_PurchaseUSD=false;}
  		}
  		$scope.SaleUSD=function()
  		{
  			if($scope.txtPchPriceOutUSD.length>0){$scope.dis_SaleRiel=true;}
  			else{$scope.dis_SaleRiel=false;}
  		}
  		$scope.SaleRiel=function()
  		{
  			if($scope.txtPchPriceOutRiel.length>0){$scope.dis_SaleUSD=true;}
  			else{$scope.dis_SaleUSD=false;}
  		}
  	});
</script>
