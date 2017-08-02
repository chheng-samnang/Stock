</nav>
<style media="screen">
  th{text-align:center;}
</style>
<div id="page-wrapper" ng-app="myApp" ng-controller="myCtrl" ng-cloak>
<div class="container-fluid">
<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <h1 class="page-header">Report Dialy Detail</h1>
      <div class="panel panel-default">
        <div class="panel-heading">

            <h3 class="panel-title">Filter</h3>

            <button onclick="printReport('report')" style="float: right; margin-top: -25px;" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Print</button>

        </div>
        <div class="panel-body">
          <form method="post" action="<?php echo base_url('Report/sale_report_detail')?>" class="form-inline">
                <div class="form-group">
                  <label for="exampleInputEmail2">Invoice No</label>
                  <select name="ddlInv" ng-model="ddlInv" class="form-control" ng-change="filter(ddlInv)">
                    <option value="" style="display: none;">Choose invoice</option>
                    <?php if(isset($invoice)):foreach($invoice as $invoices):?>
                    <option value="<?php echo $invoices->inv_hdr_id;?>"><?php echo $invoices->inv_no;?></option>
                  <?php endforeach;endif;?>
                  </select>                        
                  </div>

                  <div class="form-group">
                  <label for="exampleInputEmail2">Search</label>
                  <input type="text" name="serach" ng-model="search" class="form-control" placeholder="Search...">                       
                  </div>              
            </form>
            <hr>

            <div id="report">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Qty</th>
                  <th>Price usd</th>
                  <th>Price riel</th>                  
                  <th>Total usd</th>                  
                  <th>Total riel</th>                  
                </tr>
              </thead>
              <tbody>

                <tr ng-repeat="x in inv|filter:search">
                  <td style="text-align:center;">{{$index+1}}</td>
                  <td style="text-align:left;">{{x.product}}</td>
                  <td style="text-align:center;">{{x.qty}}</td>
                  <td style="text-align:right;">{{x.price_usd|currency}}</td>
                  <td style="text-align:right;">R{{x.price_riel|number}}</td>
                  <td style="text-align:right;">{{(x.price_usd * x.qty)|currency}}</td>
                  <td style="text-align:right;">R{{(x.price_riel * x.qty)|number}}</td>
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

<script type="text/javascript">
  var app = angular.module("myApp",[]);
  app.controller("myCtrl",function($scope,$http){
    $scope.filter = function(id){      
      $http.get("<?php echo base_url()?>ng/loadInvoice_hdr_id.php?inv_id="+id)
       .then(function(response) {
           $scope.inv = response.data.records;
       });
    }
  });

</script>
