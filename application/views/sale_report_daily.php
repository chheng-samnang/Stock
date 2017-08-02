</nav>
<style media="screen">
  th{text-align:center;}
</style>
<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <h1 class="page-header">Sale Report Daily</h1>
      <div class="panel panel-default">
        <div class="panel-heading">

            <h3 class="panel-title">Filter</h3>

            <button onclick="printReport('report')" style="float: right; margin-top: -25px;" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Print</button>

        </div>
        <div class="panel-body">
          <form method="post" action="<?php echo base_url('Report/sale_report_daily')?>" class="form-inline">
              <div class="form-group">
                <label for="exampleInputEmail2">From</label>
                  <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" placeholder="Click here to pick date" name="txtDateF" onKeyup="checkform()"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

              <script type="text/javascript">
                                $(function () {
                                    $('#datetimepicker1').datetimepicker({
                                format: 'YYYY-MM-DD'
                             });
                                     $('#datetimepicker2').datetimepicker({
                                format: 'YYYY-MM-DD'
                             });
                                });
                            </script>
              <div class="form-group">
                <label for="exampleInputEmail2">To</label>
                  <div class='input-group date' id='datetimepicker2'>
                      <input type='text' class="form-control" placeholder="Click here to pick date" name="txtDateT" onKeyup="checkform()" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail2">Receipt No</label>
                        <input type='text' class="form-control" placeholder="Enter keyword here..." name="txtSearch" />
                  </div>
              <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
            </form>
            <hr>
            <div id="report">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Reciept No</th>
                  <th>Date</th>
                  <th>Cashier</th>                  
                  <th>Total usd</th>
                  <th>Total Riel</th>
                  <th>Cash usd</th>                  
                  <th>Cash riel</th>                                                                       
                  <th>Exch usd</th>                                                                       
                  <th>Exch riel</th>                                                                       
                </tr>
              </thead>
              <tbody>
                <?php $g_total_usd=0;$g_total_riel=0;$c_usd=0;$c_riel=0;$ex_usd=0;$ex_riel=0; 
                foreach ($receipt as $key => $value) {?>
                 
                  <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value->rec_no ?></td>
                    <td><?php $d = strtotime($value->rec_date);echo date("Y-m-d h:i:sa",$d);?></td>
                    <td><?php echo $value->user_crea ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($value->ttl_usd,2);?></td>
                    <td style="text-align:right;"><?php echo "R ".number_format($value->ttl_riel);?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($value->cash_usd,2);?></td>
                    <td style="text-align:right;"><?php echo "R ".number_format($value->cash_riel) ?></td>
                    <td style="text-align:right;"><?php echo "$".number_format($value->exchange_usd,2);?></td>
                    <td style="text-align:right;"><?php echo "R ".number_format($value->exchange_riel) ?></td>                   
                  </tr>
                  <?php $g_total_usd += $value->ttl_usd;
                        $g_total_riel += $value->ttl_riel;
                        $c_usd += $value->cash_usd;
                        $c_riel += $value->cash_riel;
                        $ex_usd += $value->exchange_usd;
                        $ex_riel += $value->exchange_riel;
                } ?>
                  <tr>
                    <td colspan="4" style="text-align:center;">
                      <strong><?php echo $this->lang->line("grandTtl") ?></strong>
                    </td>
                    <td style="text-align:right;"><strong><?php echo "$".number_format($g_total_usd,2); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo "R ".number_format($g_total_riel);?></strong></td>
                    <td style="text-align:right;"><strong><?php echo "$".number_format($c_usd,2)?></strong></td>
                    <td style="text-align:right;"><strong><?php echo "R ".number_format($c_riel);?></strong></td>
                    <td style="text-align:right;"><strong><?php echo "$".number_format($ex_usd,2)?></strong></td>
                    <td style="text-align:right;"><strong><?php echo "R ".number_format($ex_riel);?></strong></td>

                  </tr>


              </tbody>
            </table>

            </div>



        </div>
      </div>

    </div>
  </div>
</div>
</div>
</div>
<script>
        $(document).ready(function(){
            $('#mydata').DataTable();
        });
</script>

<script>
  function printReport(el)
    {

        var restorepage = document.body.innerHTML;
        var printReport = document.getElementById(el).innerHTML;
        document.body.innerHTML = printReport;
        window.print();
        document.body.innerHTML = restorepage;

    }

</script>
