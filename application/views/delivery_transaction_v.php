<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Form Delivery Transaction</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row"><!--add and search-->
            <div class="col-lg-5">
                <a href="<?php echo base_url('POS/insert_del');?>" class="btn btn-success" style="margin-bottom:5px;">Add</a>                                          
            </div>                                        
        </div>        
        <div class="row">
            <div class="col-lg-12"><!--table-->                        
                <div class="panel panel-primary"><!--panel-->
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-5">Delivery Information</div>                                                                                     
                        </div>                    
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="mydata">
                        <thead>
                            <tr>
                               <th>NO</th>
                               <th>Customer name</th>
                               <th>Invoice NO</th>
                               <th>Deliver name</th>
                               <th>Status</th>
                               <th>Address</th>
                               <th>Date</th>
                               <th>User Create</th>
                               <th>Date Create</th>
                               <th>User Update</th>
                               <th>Date Update</th>
                               <th>Action</th>                                                                  
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;if(isset($delivery)):foreach($delivery as $del):?>                            
                           <tr>
                           		<td><?php echo $i;$i++;?></td>
                           		<td><?php echo $del->per_name;?></td>
                           		<td><?php echo $del->inv_no;?></td>
                           		<td><?php echo $del->staff_name;?></td>
                           		<td>
                           			<?php echo $del->status==0?'Not yet':($del->status==1?'Be deliverying':'Finished');?>                           				
                           		</td>                                                                       
                           		<td><?php echo $del->del_addr1;?></td>
                           		<td><?php echo $del->del_tr_date;?></td>
                           		<td><?php echo $del->user_crea;?></td>
                           		<td><?php echo $del->date_crea;?></td>
                           		<td><?php echo $del->user_updt;?></td>
                           		<td><?php echo $del->date_updt;?></td>
                               <td>                                                                                                 	
                                    <a href="<?php echo base_url('POS/update_del').'/'.$del->del_tr_id;?>" style="margin-right:5px" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="<?php echo base_url('POS/omit_del').'/'.$del->del_tr_id;?>" class="btn btn-large confirModal del" title="Delete" data-confirm-title="Confirm Delete !" data-confirm-message="Are you sure you want to Delete this ?"><i class="fa fa-trash"></i></a>                                                                
                                </td>                                    
                            </tr>
                        <?php endforeach;endif;?>                                                       
                        </tbody>                         
                        </table>
                    </div>
                </div><!--end panel-->    
            </div><!--end table -->
            
        </div>        
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<script>
    $(document).ready(function(){
        //data table
        $('#mydata').DataTable();
        //comfirm delete
        $('.del').confirmModal(); 
    });
</script>  
</body>
</html>

