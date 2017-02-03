 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Repayment Performance Report
                        <small>Repayment Performance Report</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Report</a></li>
                        <li class="active">Repayment Performance</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Date:</h3> 
                                    <div class="box-tools">
                                        <div class="input-group pull-right">
                                        	<form id="frm_generate_rp" action="<?php echo base_url('reports/generate_repayment')?>" method="post" target="_blank">
                                                <input name="branch_id" type="hidden" value="">
                                                <input name="rp_date" type="hidden" value="<?php echo date('Y-m-d')?>">
                                                <input name="area_id" type="hidden" value="">
                                                <button class="btn btn-success" type="submit">Generate PDF</button>
                                            </form>
                                        </div> 
                                        <div>
                                        	<form action="#" method="post" id="frm_rpr">
                                        	<input name="rp_date" type="text" value="<?php echo date('Y-m-d')?>" id="rp_date">
                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;Branch:</span>
                                        	<select name="branch_id" id="branch_id" style='height: 27px;'>
                                        		<option value="" selected="selected">All</option>
                                        		<?php foreach($branches as $val):?>
                                        			<option value="<?php echo $val['id']?>"><?php echo $val['branch_name']?></option>
                                        		<?php endforeach;?>
                                        	</select>

                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;Area:</span>
                                            <select name="area_id" id="area_id" style='height: 27px;'>
                                                <option value="" selected="selected">All</option>
                                                <?php foreach($areas as $val):?>
                                                    <option value="<?php echo $val['id']?>"><?php echo $val['area_name']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        	
                                        	</form>
                                        	
                                        	
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <!-- <table class="table table-striped table-bordered" style="font-size: 10px;"> -->
                                    <table id="rpr_table" class="display" cellspacing="0" width="100%">
                                    	<thead>
                                    	
                            				<tr>
                                				<th rowspan="2">Account No.</th>
                                				<th rowspan="2">Customer Name</th>
                                                <th rowspan="2">Branch</th>
                                                <th rowspan="2">Area</th>
                                                <th rowspan="2">Loan Amount</th>
                                				<th rowspan="2">Date Released</th>
                                				<th rowspan="2">Maturity Date</th>
                                                <th rowspan="2">Daily Amort</th>
                                				<th rowspan="2">Total Due</th>
                                				<th rowspan="2">Total Payments</th>
												<th rowspan="2">Total Balance</th>
                                                <th colspan="2" style='text-align: center'>Repayment Performance</th>
                                                <th rowspan="2">Action</th>
                            				</tr>
                                            <tr>
                                                <th>(vs ADC)</th>
                                                <th>(vs Loan Amount)</th>
                                            </tr>
                                    	
                                    	</thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align: right" id="tmptotal"></th>
                                                <th id='total_loan_amount' style="text-align: right"></th>
                                                <th></th>
                                                <th></th>
                                                <th id='total_daily_amort' style="text-align: right"></th>
                                                <th id='total_due' style="text-align: right"></th>
                                                <th id='total_payments' style="text-align: right"></th>
												<th id='total_balance' style="text-align: right"></th>
                                                <th id='total_repayment_performance_adc' style="text-align: right"></th>
                                                <th id='total_repayment_performance_tl' style="text-align: right"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    	<tbody>
                                            
                                        </tbody>

                                       
                                    </table>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->


             <!-- customer payments modal -->
                <div class="modal fade" id="customer-payments-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content"  style='width: 620px'>
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></i><strong class="customer_name"></strong> - Payments as of <strong id='payment_as_of'></strong></h4>
                            </div>
                             <div class="modal-body">
                                <div class="row">
                                    <aside>
                                        <!-- Main content -->
                                        <section class="content invoice">
                                            <div class="row invoice-info">
                                                <div class="col-sm-6 invoice-col">
                                                    Loan Amount: <strong id="rp_loan_amount"></strong><br>
                                                    Date Released: <strong id="rp_date_released"></strong><br>
                                                    Maturity Date: <strong id="rp_maturity_date"></strong><br>
                                                </div><!-- /.col -->
                                                <div class="col-sm-6 invoice-col">
                                                    Daily Amortization: <strong id="rp_daily_amort"></strong><br>
                                                    Total Due: <strong id="rp_total_due"></strong><br>
                                                    Total Payments: <strong id="rp_total_payments"></strong><br>
                                                </div><!-- /.col -->
                                                <!-- <div class="col-sm-12 invoice-col">
                                                    Total Repayment performance: <strong id="total_rp"></strong><br>
                                                </div> -->
                                                
                                            </div><!-- /.row -->
                                            <br>
                                            <div class="row">
                                                <!-- accepted payments column -->
                                                <div class="col-xs-12 table-responsive">
                                                    <table id="tbl-customer-payments" class="" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Day</th>
                                                                <th rowspan="2">Payment Date</th>
                                                                <th rowspan="2">Daily Payment</th>
                                                                <th rowspan="2">Actual Payment</th>
                                                                <th colspan="2">Repayment Performance</th>
                                                            </tr>
                                                            <tr>
                                                                <th>(vs ADC)</th>
                                                                <th>(vs Loan Amount)</th>
                                                            </tr>
                                                        </thead>
                                                        <!-- <tfoot>
                                                            <tr>
                                                                <th>Payment Date</th>
                                                                <th>Daily Payment</th>
                                                                <th>Actual Payment</th>
                                                                <th>Repayment Performance</th>
                                                            </tr>
                                                        </tfoot> -->
<!--                                                         <tbody>

                                                        </tbody> -->
                                                    </table>
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </section><!-- /.content -->
                                    </aside><!-- /.right-side -->
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->