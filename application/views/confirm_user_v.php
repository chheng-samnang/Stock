<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
	<div class="row">
		<div class="page-header"><h2>Confirm User</h2></div>									
		<!--=== start confirm===-->
		<div class="row">
			<div class="col-lg-3 col-lg-offset-4">									
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Confirm User</h3>
					</div>
					<div class="panel-body">
					<!--== validation error ==-->
						
							<?php
							if(!empty($error_msg) OR validation_errors())
							{
								?>
								<div class="alert alert-danger" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<strong>Attention!</strong><div><?php if(!empty($error_msg)){echo $error_msg;}?></div><?php if(validation_errors()){echo validation_errors();}?>
								</div>
							<?php }?>
						
						<!--== end validation error==-->
						<?php echo form_open('POS/confirm_user')?>
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="txtUsername" type="text" autofocus autocomplete="off">
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="txtPassword" type="password" autocomplete="off">
								</div>								
								<!-- Change this to a button or input when using this as a form -->
								<input type="submit" name="btnLogin" class="btn btn-lg btn-success btn-block" value="Login">
							</fieldset>
						<?php form_close();?>
					</div>
				</div>
			</div>
		</div>
		<!--=== End confirm ===-->
	</div>
</div>

