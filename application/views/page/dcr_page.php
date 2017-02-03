            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Daily Collection Record
                        <small>Daily Collection Record</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li>Reports</li>
                        <li class="active">DCR</li>
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
                                	<h3 class="box-title">Transaction Date:</h3>
                                    <div class="box-tools">
                                    	
                                    	<input name="dcr_date" type="text" value="<?php echo date('Y-m-d')?>" id="dcr_date">
                                    		<select name="area_id" id="area_id">
                                        		<option value="" data-collector="" selected="selected">All</option>
                                        		<?php foreach($areas as $val):?>
                                        			<option value="<?php echo $val['id']?>" data-collector="<?php echo $val['collector_name']?>"><?php echo $val['area_name']?></option>
                                        		<?php endforeach;?>
                                        	</select>
                                    	
                                    	<form action="<?php echo base_url('reports/generate_dcr')?>" method="post" class="pull-right" id="frm_dcr">
                                        	<input name="dcr_date" value="<?php echo date('Y-m-d')?>" id="generate_dcr_date" type="hidden">
                                        	<input name="area_id" type="hidden" value="">
                                        	<input name="collector_name" value="" type="hidden">
                                            <button class="btn btn-success" type="submit">Generate PDF</button>
                                        </form>   	
                                      
                                       	<!-- <button class="btn btn-primary btn-sm" id="btn-view-dcr" data-toggle="tooltip" data-placement="bottom" title="Print DCR"><i class="fa fa-certificate"></i> View DCR</button> -->
                                    </div>
                                    
                                    
                                    	
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                   	<table id="dcr-table" class="table table-bordered table-striped" width="100%">
	                                	<thead>
	                                    	<tr>
	                                        	<th>Loan Id</th>
												<th>Account Number</th>
	                                            <th>Account Name</th>
	                                            <!-- <th>Loan Amount</th>
	                                            <th>Remaining Balance</th>
	                                            <th>Amort Date</th>
	                                            <th>Amort of the day</th> -->
	                                            <th>Payment</th>
	                                            <th>Type of collection</th>
												<th>Area name</th>
	                                        </tr>
	                                    </thead>
	                                </table>
	                            </div>
	                            <div class="box-footer dcr_footer">
	                            	
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
									                            Name of FC: <strong id="cfc-name-of-fc"></strong>
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
									                                <tbody  id="cfc-tbody">
									                                </tbody>
									                            </table>
									                        </div><!-- /.col -->
									                    </div><!-- /.row -->
									                    
									                    <div class="row no-print">
									                        <div class="col-xs-12">
									                            <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
									                            <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button> -->
									                            <button type="button" class="btn btn-danger btn_cancel pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									                            <form id="cfc_form" action="reports/generate_cfc" method="post">
									                            <input type="hidden" name="area_id" value="">
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