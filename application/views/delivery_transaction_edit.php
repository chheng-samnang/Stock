<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</nav>
	<div id="page-wrapper" ng-app="myApp" ng-controller="myCtrl">
		<div class="container_fluid" style="margin-top:40px;">
		<div class="row">
			<div class="col-lg-12">
				<?php echo form_open('POS/update_del/'.$delivery->del_tr_id);?>
				<h1 class="page-header">Form Edit Delivery</h1>
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
							<strong>Attention!</strong><?php echo validation_errors()?>
						</div>
					<?php }?>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Delivery Information</h3>
					</div>
					<div class="panel-body">					
						<div class="row">
							<div class="col-lg-12">                                        
								<div class="form-group">
									<label class="control-label">Customer name</label>
									<select class="form-control" name="ddlCustomName">
										<option value="">Choose One</option>                                                
										<?php if(isset($customer)):foreach($customer as $value):?>                                                                                                    
											<option value="<?php echo $value->del_id;?>" <?php if(isset($delivery)){if($delivery->del_id==$value->del_id)echo 'selected';};?>><?php echo $value->customer;?></option>
										<?php endforeach;endif;?>
									</select>
								</div>                                        
							</div>
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Invoice number</label>
									<select class="form-control" name="ddlInvoiceNo">
										<option value="">Choose One</option>                                                
										<?php if(isset($invoice)):foreach($invoice as $value):?>                                                                                                    
											<option value="<?php echo $value->inv_hdr_id;?>" <?php if(isset($delivery)){if($delivery->inv_hdr_id==$value->inv_hdr_id)echo 'selected';}?>><?php echo $value->inv_no;?></option>
										<?php endforeach;endif;?>
									</select>
								</div>                                        
							</div>
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Deliver name</label>
									<select class="form-control" name="ddlStaffName">
										<option value="">Choose One</option>                                                
										<?php if(isset($staff)):foreach($staff as $value):?>                                                                                                    
											<option value="<?php echo $value->staff_id;?>"  <?php if(isset($delivery)){if($delivery->staff_id==$value->staff_id)echo 'selected';}?>><?php echo $value->staff_name;?></option>
										<?php endforeach;endif;?>
									</select>
								</div>                                        
							</div>
							
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Delivery Status</label>
									<select class="form-control" name="ddlStatus">
										<option value="0" <?php if(isset($delivery)){if($delivery->status=='0')echo 'selected';}?>>Not yet</option>
										<option value="1" <?php if(isset($delivery)){if($delivery->status=='1')echo 'selected';}?>>Be Deliverying</option>
										<option value="2" <?php if(isset($delivery)){if($delivery->status=='2')echo 'selected';}?>>Finished</option>										                                                										
									</select>
								</div>                                        
							</div>														
						</div>

						<hr />
						<div class="row">
							<div class="col-lg-12">
								<?php echo form_submit('btnSubmit','Change','class="btn btn-success"');?>
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
<script type="text/javascript">
	$("#btnCancel").click(function(){
    	window.location.assign("<?php echo base_url('POS/delivery_transaction')?>");
	});
</script>