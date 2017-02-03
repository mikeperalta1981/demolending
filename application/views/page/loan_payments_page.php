<?php $user_info = $this->session->userdata('logged_in');?>
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Loan Payments
                        <small>Loan Payments Posting</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Loan Payments</li>
                    </ol>
                </section>

                <!-- Main content -->
                 
                <section class="content">
					
					<div class="row alert_post_success">
                	</div>
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12">
                        	<div class="box box-solid box-primary">
                                <div class="box-header">
                                	<h3 class="box-title">Loan Collectibles:</h3>
                                    <div class="box-tools">
                                    	
                                    		<input name="lc_date" type="text" value="<?php echo date('Y-m-d')?>" id="lc_date" readonly>
                                    	
                                        	<select name="area_id" id="area_id">
                                        		<option value="" data-collector='' selected="selected">All</option>
                                        		<?php foreach($areas as $val):?>
                                        			<option value="<?php echo $val['id']?>" data-collector='<?php echo $val["collector_name"]?>'><?php echo $val['area_name']?></option>
                                        		<?php endforeach;?>
                                        	</select>
                                        	<!-- <button type="button" id="btn_area_id">Submit</button> -->
                                        	<button type="button"class="btn btn-primary btn-sm pull-right" id="btn-view-cfc" data-toggle="tooltip" data-placement="bottom" title="Print CFC"><i class="fa fa-print"></i> View CFC</button>
                                      
                                       	<!-- <button class="btn btn-primary btn-sm" id="btn-view-dcr" data-toggle="tooltip" data-placement="bottom" title="Print DCR"><i class="fa fa-certificate"></i> View DCR</button> -->
                                    </div>
                                    
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                   	<table id="customer-loan-payments-table" class="table table-bordered table-striped" width="100%">
	                                	<thead>
	                                    	<tr>
	                                        	<th>Loan Id</th>
												<th>Account<br>Number</th>
	                                            <th>Account Name</th>
	                                            <th>Loan<br>Amount</th>
	                                            <th>Remaining<br>Balance</th>
	                                            <!-- <th>Mode of Payment</th> -->
	                                            <th>Amort<br>Date</th>
	                                            <th>Amort of<br>the day</th>
	                                            <th>Payment</th>
	                                            <th>Type of<br>collection</th>
	                                            <th>Action</th>
												<th>Area<br>name</th>
												<th>tmppayments</th>
	                                        </tr>
	                                    </thead>
	                                    <tfoot>
	                                    	<tr style="background-color: lightblue">
	                                    		<th colspan="7" style="text-align:right">
	                                    			Total:
	                                    		</th>
	                                    		<th>
	                                    			<strong id="overall_total_payments"></strong>
	                                    		</th>
	                                    		<th colspan="3">
	                                    			
	                                    			<button type="button" id="btn-select-all" class="btn btn-success btn-xs hidden" style="margin-left: 5px;">Select All</button>
	                                    			<button type="button" id="btn-clear" class="btn btn-danger btn-xs hidden">Clear</button>
	                                    			
	                                    		</th>
	                                    		<th>
	                                    		</th>
	                                    	</tr>
	                                    </tfoot>
	                                </table>
	                            </div>
	                            
	                            <div class="box-footer text-center">
	                            	<div class="btn-group"> 
	                            		<input type="hidden" id="tmp_usertype" value="<?php echo $user_info['user_type']?>">
	                            		<input type="hidden" id="tmp_lpdate" value="<?php echo date('Y-m-d')?>">
	                            		
	                            		<?php if($user_info['user_type']!=3):?>
	                            			<?php if($user_info['user_type']<=2 || $user_info['user_type']==4):?>
                                        		<button type="button" id="btn-post" class="btn btn-primary">Post Payments</button>
                                        		<?php if($user_info['user_type']<=2):?>
                                        			<button type="button" id="btn-approve" class="btn btn-success" style="margin-left: 5px;">Approve All Payments</button>
                                        		<?php endif;?>
                                        	<?php endif;?>
                                        <?php endif;?>
                                        <!-- <button type="button" id="btn-select-all" class="btn btn-warning" style="margin-left: 5px;">Select All</button> -->
                                    </div>
                                </div>
                            </div>
                            
                            <!-- CFC MODAL -->					        
					        <div class="modal fade" id="cfc-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog modal-lg">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-list"></i> CUSTOMERS FOR COLLECTION</h4>
					                    </div>
					                     <div class="modal-body">
					                     	<div class="row">
									            <aside>
									                <!-- Main content -->
									                <section class="content invoice">
									                    <div class="row invoice-info">
									                        <div class="col-sm-6 invoice-col">
									                            Area: <strong id="cfc-area"></strong><br>
									                            Name of FC: <strong id="collector_name"></strong>
									                        </div><!-- /.col -->
									                        <div class="col-sm-6 invoice-col">
									                            Date of Transaction: <strong id="cfc-date-of-trans"><?php echo date('Y-m-d')?></strong><br>
									                            Number of Accounts: <strong id="cfc-num-of-accounts"></strong>
									                        </div><!-- /.col -->
									                    </div><!-- /.row -->
														<br>
														<br>
									                    <div class="row">
									                        <!-- accepted payments column -->
									                        <div class="col-xs-12 table-responsive">
									                        	<!-- <h4>PAYMENT RECORD</h4> -->
									                            <table class="table table-striped" width="100%">
									                                <thead>
									                                    <tr>
									                                        <th>Account Number</th>
									                                        <th>Name of Customer</th>
									                                        <th>Daily Amort</th>
									                                        <th>Amount Paid</th>
									                                    </tr>
									                                </thead>
									                                <tbody id="cfc-tbody">
									                                </tbody>
									                            </table>
									                        </div><!-- /.col -->
									                    </div><!-- /.row -->
									                    
									                    <div class="row no-print">
									                        <div class="col-xs-12">
									                            <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
									                            <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button> -->
									                            <button type="button" class="btn btn-danger btn_cancel pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									                            <form id="cfc_form" action="loan_payments/generate_cfc" method="post">
									                            <input type="hidden" name="area_id" value="">
									                            <input type="hidden" name="collector_name" value=""/>
									                            <button class="btn btn-primary pull-right" type="submit" style="margin-right: 5px;" id="generate-cfc-pdf"><i class="fa fa-download"></i> Generate PDF</button>
									                            </form>
									                        </div>
									                    </div>
									                </section><!-- /.content -->
									            </aside><!-- /.right-side -->
			                                </div>
				                        </div>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
                            
                        </section>
                        
                    </div><!-- /.row (main row) -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->