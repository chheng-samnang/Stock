<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Form <?php if(isset($pageHeader)){echo $pageHeader;}?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>        
        <div class="row">
            <div class="col-lg-12"><!--table-->                        
                <div class="panel panel-primary"><!--panel-->
                    <div class="panel-heading"><?php if(isset($pageHeader)){echo $pageHeader;}?> Information</div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="mydata">
                        <thead>
                            <tr>
                                <?php if(isset($tbl_hdr))
                                {
                                    echo "<th>No.</th>";
                                    foreach($tbl_hdr as $th){echo "<th>".$th."</th>";}                                    
                                }?>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;if(!empty($tbl_body[0])){foreach($tbl_body as $body)
                            {
                                echo "<tr>";                                    
                                    echo "<td>".$i."</td>";
                                    $j=0;
                                    foreach($tbl_hdr as $th)
                                    {
                                        echo "<td>".$body[$j]."</td>";
                                        $j++;
                                    }                                                                                                                                     
                                echo "</tr>";
                            $i++;}}?>                            
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
    });
</script>  
</body>
</html>

