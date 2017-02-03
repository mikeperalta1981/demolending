 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Collection Performance Report
                        <small>Collection Performance Report</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Report</a></li>
                        <li class="active">Collection Performance</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Date:</h3> 
                                    <div class="box-tools">
                                        <div class="input-group pull-right">
                                        	<form id="frm_generate_cp" action="<?php echo base_url('reports/generate_collection')?>" method="post" target="_blank">
                                                <input name="branch_id" type="hidden" value="">
                                                <input name="rp_date" type="hidden" value="<?php echo date('Y-m-d')?>">
                                                <input name="area_id" type="hidden" value="">
                                                <button class="btn btn-success" type="submit">Generate PDF</button>
                                            </form>
                                        </div> 
                                        <div>
                                        	<form action="#" method="post" id="frm_cpr">
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
                                    <table id="cpr_table" class="display" cellspacing="0" width="100%">
                                    	<thead>
                            				<tr>
                                				<th rowspan="2">Branch</th>
                                                <th rowspan="2">Area</th>
                                                <th rowspan="2">Total Loan Amount</th>
                                                <th rowspan="2">Total Daily Amortization</th>
                                                <th rowspan="2">Total Due</th>
                                				<th rowspan="2">Total Payments</th>
                                                <th colspan="2" style='text-align: center'>Collection Performance</th>
                            				</tr>
                                                <th>(vs ADC)</th>
                                                <th>(vs Loan Amount)</th>
                                    	</thead>
                                        
                                    	<tbody>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th id='total_loan_amount' style='text-align: right'></th>
                                                <th id='total_daily_amort' style='text-align: right'></th>
                                                <th id='total_due' style='text-align: right'></th>
                                                <th id='total_payments' style='text-align: right'></th>
                                                <th id='col_perf_adc' style='text-align: right'></th>
                                                <th id='col_perf_tl' style='text-align: right'></th>
                                            </tr>
                                        </tfoot>
                                       
                                    </table>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                    <!-- Collection Performance Graph -->
                    <div class="row hidden">
                        <div class="col-xs-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"></h3> 
                                    <div class="box-tools">
                                        <div class="input-group pull-right">
                                            <form action="#" method="post" target="_blank">
                                            
                                            <!-- <button class="btn btn-success" type="submit">Generate PDF</button> -->
                                            </form>
                                        </div> 
                                        <div>
                                            <form action="#" method="post" id="frm_cpchart">

                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;View Type:</span>
                                            <select name="view_type" id="view_type" style='height: 27px;'>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>    

                                            <input name="cp_date" type="text" value="<?php echo date('Y-m')?>" id="cp_date">

                                            <input name="cp_year" type="text" value="<?php echo date('Y')?>" id="cp_year">


                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;Branch:</span>
                                            <select name="branch_id" id="branch_id" style='height: 27px;'>
                                                <!-- <option value="" selected="selected">All</option> -->
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
                                    <div id="collectionchart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                    <!-- </div> -->
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->


             