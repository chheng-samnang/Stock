<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
<?php if(isset($balance)):?>
	<div class="row">
		<div class="page-header"><h2>Close shift</h2></div>									
		<!--=== start closeshift===-->		
		<div class="row" style="margin-top:20px;">					
			<div class="col-md-8 col-lg-offset-2">
				<div class="thumbnail">								
					<div id="invoice">
						<h3 style="text-align:center;">Stock Management</h3>
						<p style="text-align:center;">#21,Street 388</p>
						<p style="text-align:center;">Sangkat Toul SvayPrey1 Khan Chamkarmorn</p>
						<h4 style="text-align:center;">Close shift report</h4>										
						<div class="pull-left">
							<h6><b>Cashier: <?php echo $this->session->userLogin;?></b></h6>
							<h6><b>Exchange rate: <?php echo "R ".$balance->exchange_rate;?></b></h6>
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
									<th>OpenBal($)</th>
									<th>OpenBal(R)</th>
									<th>Total($)</th>
									<th>Total(R)</th>
									<th>Cash($)</th>
									<th>Cash(R)</th>
									<th>Exch($)</th>
									<th>Exch(R)</th>													
									<th>EndingBal($)</th>
									<th>EndingBal(R)</th>													
								</tr>
							</thead>
							<tbody>												
								<tr>
									<?php 
									$ending_bal_usd = $balance->open_bal_usd + $balance->total_usd;
									$ending_bal_riel = $balance->open_bal_riel + $balance->total_riel;
									?>												
									<td><?php echo "$".number_format($balance->open_bal_usd,2);?></td>
									<td><?php echo "R ".number_format($balance->open_bal_riel);?></td>
									<td><?php echo "$".number_format($balance->total_usd,2);?></td>
									<td><?php echo "R ".number_format($balance->total_riel);?></td>
									<td><?php echo "$".number_format($balance->cash_usd,2);?></td>
									<td><?php echo "R ".number_format($balance->cash_riel);?></td>
									<td><?php echo "$".number_format($balance->ex_usd,2);?></td>
									<td><?php echo "R ".number_format($balance->ex_riel);?></td>
									<td><b><?php echo "$".number_format($ending_bal_usd,2);?></b></td>
									<td><b><?php echo "R ".number_format($ending_bal_riel);?></b></td>																																																			
								</tr>																																				

							</tbody>
						</table>

					</div>							
					<hr>							
					<a href="<?php echo base_url('POS/insert_closeshift');?>" onclick="printInvoice()" class="btn btn-primary btn-lg">Print</a>	
				</div>
			</div>			
		</div>
		<!--=== End closeshift ===-->
	</div>
<?php endif;?>
</div>
<script type="text/javascript">
	function printInvoice()
    {
        var restorepage = document.body.innerHTML;
        var printinvoice = document.getElementById('invoice').innerHTML;
        document.body.innerHTML = printinvoice;
        window.print();
        document.body.innerHTML = restorepage;
    }//PrintInvoice    
</script>

