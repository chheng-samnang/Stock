<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
        $(function () {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD'
             });
        });
    </script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
    <script src="<?php echo base_url('assets/canvas/canvas.min.js')?>"></script>       
    <!--======== All chart are here...=======-->

        <script type="text/javascript">
            $(function () {
                var chart = new CanvasJS.Chart("chartMenuCategory",
                {
                    theme: "theme2",
                    title:{
                        text: "Category"
                    },
                    exportFileName: "New Year Resolutions",
                    exportEnabled: true,
                    animationEnabled: true,     
                    data: [
                    {       
                        type: "pie",
                        showInLegend: true,
                        toolTipContent: "{name}: <strong>{y}%</strong>",
                        indexLabel: "{name} {y}%",
                        dataPoints: <?php echo json_encode($query, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
            });
            //stock
            $(function () {
            var chart1 = new CanvasJS.Chart("chartStock",
            {
                animationEnabled: true,
                theme: "theme2",
                exportEnabled: true,
                title:{
                    text: "Stock"
                },
                data: [
                {
                    type: "column", //change type to bar, line, area, pie, etc                   
                    indexLabel: "{y}",                    
                    dataPoints: <?php echo json_encode($stock, JSON_NUMERIC_CHECK); ?>                                     
                }
                ]
            });

            chart1.render();
        });
// menu
    $(function () {
            var chart2 = new CanvasJS.Chart("chartMenu",
            {
                animationEnabled: true,
                theme: "theme2",
                //exportEnabled: true,
                title:{
                    text: "Menu"
                },
                data: [
                {
                    type: "column", //change type to bar, line, area, pie, etc 
                    indexLabel: "{y}",                    
                    dataPoints: <?php echo json_encode($menu_sale, JSON_NUMERIC_CHECK); ?>                   
                }
                ]
            });

            chart2.render();
        });
        </script>
        <div id="page-wrapper">
           <div class="row">
              <div class="col-lg-12">
                 <h1 class="page-header">Main Form</h1>	        
             </div>
         </div>
         <div class="row">
            <div class="col-lg-6">                    
                <div class="panel panel-default" style="height:470px;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Summary of Sale Category Daily</h3>
                    </div>
                    <div class="panel-body">
                        <div id="chartMenuCategory"></div>                       
                    </div>
                </div>         
            </div><!-- col-lg-6 -->

            <div class="col-lg-6">
                <div class="panel panel-default"  style="height:470px;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Summary of Stock Remaining</h3>
                    </div>
                    <div class="panel-body">
                        <div id="chartStock"></div>                                                   
                    </div>
                </div>
            </div>
        </div> <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default"  style="height:500px;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Summary of Sale Product</h3>
                    </div>
                    <?php echo form_open(base_url('Main'))?>
                    <div class="panel-body">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-2">                              
                              <div class="input-group datetimepicker">
                                 <input type="text" name="txtFrom" class="input-sm form-control datetimepicker" placeholder="From" id="txtFrom">
                                 <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>                                
                            </div>
                          </div>
                          <div class="col-lg-2">                              
                              <div class="input-group datetimepicker">
                                 <input type="text" name="txtTo" class=" input-sm form-control datetimepicker" placeholder="To" id="txtTo">
                                 <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>                                
                            </div>
                          </div>
                          <div class="col-lg-1">
                            <input type="submit" name="btnSubmit" value="Search" class="btn btn-default btn-sm">
                          </div>                          
                        </div>
                      <div id="chartMenu"></div>                                                                         
                  </div>
                  <?php form_close();?>                  
                </div>
            </div>                     
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default"">                    
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>                                            
                                    <th>USD</th>
                                    <th>KHR</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Sale</td>
                                    <td><?php echo '$ '.number_format((float)$total->total_usd, 2, '.', '');?></td>
                                    <td><?php echo 'R '.number_format($total->total_riel);?></td>
                                </tr>
                                <tr>
                                    <td>Cash In</td>
                                    <td><?php echo '$ '.number_format((float)$total->cash_usd1, 2, '.', '')?></td>
                                    <td><?php echo 'R '.number_format($total->cash_riel1);?></td>
                                </tr>
                                <tr>
                                    <td>Exchange</td>
                                    <td><?php echo '$ '.number_format((float)$total->exchange_usd1, 2, '.', '');?></td>
                                    <td><?php echo 'R '.number_format($total->exchange_riel1);?></td>
                                </tr>                                                                                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
            

