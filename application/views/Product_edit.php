<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</nav>
	<div id="page-wrapper">
		<div class="container_fluid" style="margin-top:40px;">
		<div class="row">
			<div class="col-lg-12">
				<?php echo isset($multipart)?form_open_multipart($action):form_open($action)?>
				<h1 class="page-header">Form Edit <?php echo $pageHeader?></h1>
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
						<div class="row">
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Category</label>
									<select class="form-control" name="ddlCategoryName">
										<option value="">Choose One</option>                                                
										<?php if(isset($category)):foreach($category as $value):?>                                                                                                    
											<option value="<?php echo $value->cat_id;?>" <?php if(isset($product)):if($value->cat_id==$product->cat_id):echo 'selected';endif;endif;?>><?php echo $value->cat_name;?></option>
										<?php endforeach;endif;?>
									</select>
								</div>                                        
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Product name</label>
									<input type="text" name="txtProductName" id="txtProductName" class="form-control" placeholder="Enter product name" value="<?php if(isset($product)):echo $product->pro_name;endif; ?>">
								</div>    
							</div>
							<div class="col-lg-4">                                        
								<div class="form-group">
									<label class="control-label">Product Status</label>
									<select class="form-control" name="ddlProStatus">
										<option value="1" <?php if(isset($product)):if($product->pro_status=='1'):echo 'selected';endif;endif;?>>Enable</option>
										<option value="0" <?php if(isset($product)):if($product->pro_status=='0'):echo 'selected';endif;endif;?>>Disable</option>										                                                										
									</select>
								</div>                                        
							</div>
							<div class="col-lg-3">                                        
								<div class="form-group">									
									<button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">Upload Image</button>
								</div>                                        
							</div>
							<div class="col-lg-1">
								<img src="<?php if(isset($product)):echo base_url('assets/uploads/'.$product->pro_image);endif;?>" class="img-thumbnail img-responsive">
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Product Description</label>
									<textarea name="txtProDesc" class="form-control">
										<?php if(isset($product)):echo $product->pro_desc;endif;?>
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
								<?php echo form_submit('btnSubmit','Update','class="btn btn-success"');?>
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
</script>
