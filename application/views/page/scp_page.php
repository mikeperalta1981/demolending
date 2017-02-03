 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Sales and Collection Report
                        <small>Sales and Collection Report</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Report</a></li>
                        <li class="active">SCP</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">For the month of</h3> 
                                    <div class="box-tools">
                                        <div class="input-group pull-right">
                                        	<form action="<?php echo base_url('reports/generate_scp')?>" method="post">
	                                        	<input name="yearmonth" type="hidden" value="<?php echo $yearmonth;?>">
	                                        	<input name="dateday" type="hidden" value="<?php echo $date_day;?>">
	                                        	<input name="sort" type="hidden" value="<?php echo $sort?>"> 
	                                            <button class="btn btn-success" type="submit">Generate PDF</button>
                                            </form>
                                        </div> 
                                        <div>
                                        	<form action="<?php echo base_url("reports/scp")?>" method="post" id="frm_scp">
                                        	<input name="yearmonth" type="text" value="<?php echo $yearmonth?>" id="scpdp">
                                        	<select name="dateday" id="cutoff" style="height: 28px;">
                                        		
                                                <?php if($date_day>0 && $date_day<=7):?>
                                                    <option value="0">Whole month</option>
                                                    <option value="1" selected="selected">cutoff1</option>
                                                    <option value="8">cutoff2</option>
                                                    <option value="16">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                                <?php elseif ($date_day>7 && $date_day<16):?>
                                                    <option value="0">Whole month</option>
                                                    <option value="1">cutoff1</option>
                                                    <option value="8" selected="selected">cutoff2</option>
                                                    <option value="16">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                                <?php elseif ($date_day>15 && $date_day<24):?>
                                                    <option value="0">Whole month</option>
                                                    <option value="1">cutoff1</option>
                                                    <option value="8">cutoff2</option>
                                                    <option value="16" selected="selected">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                                <?php elseif($date_day==0): ?>
                                                    <option value="0" selected="selected">Whole month</option>
                                                    <option value="1">cutoff1</option>
                                                    <option value="8">cutoff2</option>
                                                    <option value="16">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                                <?php else:?>
                                                    <option value="0">Whole month</option>
                                                    <option value="1">cutoff1</option>
                                                    <option value="8">cutoff2</option>
                                                    <option value="16">cutoff3</option>
                                                    <option value="24" selected="selected">cutoff4</option>
                                                    <option value="custom">Custom</option>
                                                <?php endif;?>
                                        	</select>
                                        	<input placeholder="Date From" type="text" name="custom_date_from" id="custom_date_from">
                                            <input placeholder="Date To" type="text" name="custom_date_to" id="custom_date_to">
                                        	<button type="submit">Submit</button>
                                        	</form>
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                <?php ksort($collection_data); ksort($sales_data)?>
                                <br>
                                	<strong>Collection Performance</strong>
                                    <table class="table table-striped table-bordered">
                                    	<thead>
                                    				<tr>
                                    				<th>Area</th>
                                    				<th>Due</th>
                                    				<th>Overdue</th>
                                    				<th>Payment Due + Overdue</th>
                                    				<th>Advance</th>
                                    				<th>Collection Performance</th>
                                    				</tr>
                                    	</thead>
                                    	<tbody>
                                    		<?php $total_due = 0; $total_od = 0; $total_pdo = 0; $total_adv = 0; $total_cp = 0;
                                    			$total_due_plus_od = 0;
                                    		?>
											<?php foreach($collection_data as $val):?>
												<tr>
													<td><?php echo $val['area_name']?></td>
													<td><?php echo number_format($val['due'], 2); $total_due+= $val['due']?></td>
													<td><?php echo number_format($val['overdue'], 2); $total_od+= $val['overdue']?></td>
													<td><?php echo number_format($val['pdo'], 2); $total_pdo+= $val['pdo']?></td>
													<td><?php echo number_format($val['advance'], 2); $total_adv+=$val['advance']?></td>
													<td><?php echo number_format($val['cp'], 2); $total_cp=($total_pdo/($total_due + $total_od>0?$total_due + $total_od:1))*100?> %</td>
												</tr>
											<?php endforeach;?>	
                                        </tbody>
                                        <tfoot>
                                    				<tr>
	                                    				<th style="text-align: right">TOTAL:</th>
	                                    				<th><?php echo number_format($total_due, 2)?></th>
	                                    				<th><?php echo number_format($total_od, 2)?></th>
	                                    				<th><?php echo number_format($total_pdo, 2)?></th>
	                                    				<th><?php echo number_format($total_adv, 2)?></th>
	                                    				<th><?php echo number_format($total_cp, 2)?>%</th>
                                    				</tr>
                                    	</tfoot>
                                    </table>
                                    <br>
                                    <br>
                                    <strong>Sales Performance</strong>
                                    <table class="table table-striped table-bordered">
                                    	<thead>
                                    				<tr>
                                    				<th>Area</th>
                                    				<th>Age of Area (Months)</th>
                                    				<th>Minimum Sales Target</th>
                                    				<th>Actual Sales</th>
                                    				<th>Sales Performance</th>
                                    				</tr>
                                    	</thead>
                                    	<tbody>
                                    		<?php $total_as = 0; $total_sp = 0; $total_mst = 0;?>
											<?php foreach($sales_data as $val):?>
											     <?php $val['mst'] = 600000; ?>
												<tr>
													<td><?php echo $val['area_name']?></td>
													<td><?php echo $val['age_of_area']?></td>
													<td><?php echo number_format($val['mst'], 2); $total_mst+=$val['mst']?></td>
													<td><?php echo number_format($val['actual_sales'], 2); $total_as+=$val['actual_sales']?></td>
													<td><?php echo number_format($val['sp'], 2); $total_sp = $total_mst==0 ?  $total_sp : ($total_as/$total_mst)*100?> %</td>
												</tr>
											<?php endforeach;?>
                                        </tbody>
                                        <tfoot>
                                    				<tr>
                                    				<th colspan="2" style="text-align: right">TOTAL:</th>
                                    				<th><?php echo number_format($total_mst, 2)?></th>
                                    				<th><?php echo number_format($total_as, 2)?></th>
                                    				<th><?php echo number_format($total_sp, 2)?>%</th>
                                    				</tr>
                                    	</tfoot>
                                    </table>
                                    <br>
                                    <br>
                                    <strong>List of Customers</strong>
                                    
                                    <table class="table table-striped table-bordered">
                                    	<thead>
                                    				<tr>
                                    				<th>#</th>
                                    				<th><a href="<?php echo base_url('reports/scp?sort=name')?>">Name</a></th>
                                    				<th><a href="<?php echo base_url('reports/scp?sort=loan_amount')?>">Loan Amount</a></th>
                                    				<th><a href="<?php echo base_url('reports/scp?sort=date_released')?>">Date Released</a></th>
                                    				<th><a href="<?php echo base_url('reports/scp?sort=loan_type')?>">Loan type</a></th>
                                    				<th><a href="<?php echo base_url('reports/scp?sort=area')?>">Area</a></th>
                                    				</tr>
                                    	</thead>
                                    	<tbody>
                                    		<?php $la_total = 0; $i=1;?>
                                    		<?php foreach($customer_list as $val):?>
                                    			<tr>
                                    				<td><?php echo $i?></td>
                                    				<td><?php echo $val['name']?></td>
                                    				<td><?php echo number_format($val['loan_amount'], 2); $la_total += $val['loan_amount']?></td>
                                    				<td><?php echo $val['date_released']?></td>
                                    				<td><?php echo $val['loan_type']?></td>
                                    				<td><?php echo $val['area']?></td>
                                    			</tr>
                                    		<?php $i++; endforeach;?>
                                        </tbody>
                                        <tfoot>
                                    				<tr>
                                    				<th colspan="2" style="text-align: right">TOTAL:</th>
                                    				<th><?php echo number_format($la_total, 2)?></th>
                                    				<th></th>
                                    				<th></th>
                                    				</tr>
                                    	</tfoot>
                                    </table>
                                    
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <br>
                    </div>
                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->