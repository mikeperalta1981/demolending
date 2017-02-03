<?php 
 $area_colors = array(
        '1' => 'yellow',
        '2' => '#ADFF2F',
        '3' => 'blue',
        '4' => 'red'
    );
?>
 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Notes and Collection Report
                        <small>Notes and Collection Report</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Report</a></li>
                        <li class="active">NCR</li>
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
                                        	<form action="<?php echo base_url('reports/generate_ncr')?>" method="post" target="_blank">
                                        	<input name="yearmonth" type="hidden" value="<?php echo $yearmonth;?>">
                                        	<input name="dateday" type="hidden" value="<?php echo $date_day;?>">
                                        	<input name="area_id" type="hidden" value="<?php echo $area_id;?>">
                                            <button class="btn btn-success" type="submit">Generate PDF</button>
                                            </form>
                                        </div> 
                                        <div>
                                        	<form action="<?php echo base_url("reports/ncr")?>" method="post" id="frm_rpp">
                                        	<input name="yearmonth" type="text" value="<?php echo $yearmonth?>" id="ncrdp">
                                        	<select name="dateday" id="cutoff">
                                        		<?php if($date_day>0 && $date_day<=7):?>
                                        			<option value="1" selected="selected">cutoff1</option>
                                        			<option value="8">cutoff2</option>
                                        			<option value="16">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                        		<?php elseif ($date_day>7 && $date_day<=15):?>
                                        			<option value="1">cutoff1</option>
                                                    <option value="8" selected="selected">cutoff2</option>
                                                    <option value="16">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                                <?php elseif ($date_day>15 && $date_day<=23):?>
                                                    <option value="1">cutoff1</option>
                                                    <option value="8">cutoff2</option>
                                                    <option value="16" selected="selected">cutoff3</option>
                                                    <option value="24">cutoff4</option>
                                        		<?php else: ?>
                                        			<option value="1">cutoff1</option>
                                                    <option value="8">cutoff2</option>
                                                    <option value="16">cutoff3</option>
                                                    <option value="24" selected="selected">cutoff4</option>
                                        		<?php endif;?>
                                        	</select>
                                        	
                                        	<select name="area_id" id="area_id">
                                        		<option value="" selected="selected">All</option>
                                        		<?php foreach($areas as $val):?>
                                        			<?php if($area_id==$val['id']):?>
                                        				<option value="<?php echo $val['id']?>" selected='selected'><?php echo $val['area_name']?></option>
                                        			<?php else:?>
                                        				<option value="<?php echo $val['id']?>"><?php echo $val['area_name']?></option>
                                        			<?php endif;?>
                                        		<?php endforeach;?>
                                        	</select>
                                        	
                                        	<button type="submit">Submit</button>
                                        	<span class="label label-primary" style="font-size: 14px;">Number of customers: <?php echo $number_of_customer;?></span>
                                        	</form>
                                        	
                                        	
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <!-- <table class="table table-striped table-bordered" style="font-size: 10px;"> -->
                                    <table id="ncr_table" class="display" cellspacing="0" width="100%">
                                    	<thead>
                                    	<?php //foreach ($data as $account_no => $fields):?>
                                    	<?php foreach ($data as $key => $fields):?>
                                    				<tr>
                                    				<th>Account No.</th>
                                    				<th>Account Name</th>
                                    				<!-- <th>LC</th> -->
                                    				<?php $i = $date_day;?>
                                    				<?php while($i <= $end_day):?>
                                    					<th><?php echo date('d-M', strtotime($yearmonth . "-" . $i))?></th>	
                                    					<?php $i++;?>
                                    				<?php endwhile;?>
                                    				
                                    				<th>Total</th>
                                    				<th>Due</th>
                                    				<th>Overdue</th>
                                    				<th>Collectible</th>
                                    				<th>Balance</th>
                                    				<th>Date Released</th>
                                    				<th>Maturity Date</th>
                                    				<th>Daily</th>
                                    				</tr>
                                    			<?php break;?>
                                    	<?php endforeach;?>
                                    	</thead>
                                    	<tbody>
                                    	<?php 
                                    		$days_payments_total = array();
                                    		$current_cutoff_total_payments = 0;
                                    		$due = 0;
                                    		$overdue = 0;
                                    		$collectible = 0;
                                    		$loan_balance = 0;
                                    		$amortization = 0;
                                    	?>
                                    	<?php //foreach ($data as $account_no => $fields):?>
                                    	<?php foreach ($data as $key => $fields):?>
                                    		    <?php 
                                                    if(strlen($end_day)==1)
                                                            $end_day = "0" . $end_day;
                                                    
                                                    //if($fields['maturity_date'] < date('Y-m-d')): 
                                                    if($fields['maturity_date'] < $yearmonth . '-' . $end_day):

                                                ?> 


                                                    <?php if($fields['loan_balance'] > 0): ?>  
                                    				<tr style="background-color: <?php echo $area_colors[$fields['area_id']]; ?>">
                                                    <?php else: ?>
                                                    <tr>    
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <tr>
                                                <?php endif; ?>
                                    				<td class="center"><?php echo $fields['account_no']?></td>
                                    				<td class="left"><?php echo $fields['name']?></td>
                                    				<!-- <td>td</td> -->
                                    				<?php $i = $date_day;?>
                                    				<?php while($i <= $end_day):?>
                                    					<?php if(strlen($i)==1)$i = "0" . $i;?>

                                                        <?php 
                                                            if(! isset($days_payments_total[$yearmonth . "-" . $i]))
                                                                $days_payments_total[$yearmonth . "-" . $i] = 0; 

                                                        ?>

                                    					<?php if(isset($fields['loan_payments'][$yearmonth . "-" . $i])):?>
                                    						<?php 
                                    							if(array_key_exists($yearmonth . "-" . $i, $days_payments_total)){
                                    								$days_payments_total[$yearmonth . "-" . $i] += $fields['loan_payments'][$yearmonth . "-" . $i];
                                    							}	
                                    							else{
                                    								$days_payments_total[$yearmonth . "-" . $i] = $fields['loan_payments'][$yearmonth . "-" . $i];
                                    							}
                                    						
                                    						
                                    						?>
                                    						<td class="right" style='text-align: right'><?php echo number_format($fields['loan_payments'][$yearmonth . "-" . $i], 2);?></td>
                                    					<?php else:?>

                                    						<td class="right">-</td>
                                    					<?php endif;?>
                                    						
                                    					<?php $i++;?>
                                    				<?php endwhile;?>
                                    				<?php if(strlen($end_day)==1)
															$end_day = "0" . $end_day;
													?>
                                    				<td class="right" style='text-align: right'><?php echo number_format($fields['current_cutoff_total_payments'], 2); $current_cutoff_total_payments += $fields['current_cutoff_total_payments']; ?></td>
                                    				<td class="right" style='text-align: right'><?php echo number_format($fields['due'], 2); $due+=$fields['due']>0?$fields['due']:0;?></td>
                                    				<td class="right" style='text-align: right'><?php echo number_format($fields['overdue'], 2); $overdue+=$fields['overdue']>0?$fields['overdue']:0;?></td>
                                    				<td class="right" style='text-align: right'><?php echo number_format($fields['collectible'], 2); $collectible+=$fields['collectible']>0?$fields['collectible']:0;?></td>
                                    				<td class="right" style='text-align: right'><?php echo number_format($fields['balance'], 2);$loan_balance+=$fields['balance'];?></td>
                                    				<td class="center"><?php echo $fields['date_released']?></td>
                                    				<td class="center"><?php echo $fields['maturity_date']?></td>
                                    				<td class="right" style='text-align: right'><?php

														if($fields['date_completed'] == '0000-00-00' || $fields['date_completed'] >=$yearmonth . '-' . $end_day){
														//if($fields['balance'] > $fields['amortization']){


                                                            if($fields['balance']>0){
                                                                echo number_format($fields['amortization'], 2);     
                                                            }
                                                            else{
                                                                echo '0.00'; 
                                                            }

															
															//echo $fields['date_completed'] . '=='. $yearmonth . '-' . $end_day;
															$amortization+=$fields['amortization'];
														}
														else{
															
															if($fields['balance'] > $fields['amortization']){
																echo number_format($fields['amortization'], 2); 
																//$amortization+=$fields['amortization'];
															}
															else{
																echo '0.00'; 
															}
															/*echo number_format($fields['amortization'], 2); 
                                                            $amortization+=$fields['amortization'];*/
															
														}
														
														/* echo number_format($fields['amortization'], 2); 
														$amortization+=$fields['amortization'];	 */
													?></td>
                                    				</tr>
                                    		
                                    	<?php endforeach;?>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<th colspan="2" style="text-align:right">TOTAL </th>
                                        		<?php ksort($days_payments_total);?>
                                        		<?php foreach($days_payments_total as $key => $val):?>
                                        			<th class="right" style="text-align:right"><?php echo number_format($val, 2);?></th>
                                        		<?php endforeach;?>
                                        		<th class="right" style="text-align:right"><?php echo number_format($current_cutoff_total_payments, 2)?></th>
                                        		<th class="right" style="text-align:right"><?php echo number_format($due, 2)?></th>
                                        		<th class="right" style="text-align:right"><?php echo number_format($overdue, 2)?></th>
                                        		<th class="right" style="text-align:right"><?php echo number_format($collectible, 2)?></th>
                                        		<th class="right" style="text-align:right"><?php echo number_format($loan_balance, 2)?></th>
                                        		<th></th>
                                        		<th></th>
                                        		<th class="right" style="text-align:right"><?php echo number_format($amortization, 2) ?></th>
                                        	</tr>
                                        </tfoot>
                                    </table>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->