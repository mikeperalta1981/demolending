 <!-- Right side column. Contains the navbar and content of the page -->
 <?php $user_info = $this->session->userdata('logged_in');?>
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Loan Application
                        <small>Customers Loan Application Information</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Loan applications</li>
                    </ol>
                </section>
                

                <!-- Main content -->
                <section class="content">
                	
                	<div class="row alert_create_loan">
                	</div>
                	<div class="row alert_create_pep">
                	</div>
                	<div class="row alert_payment">
                	</div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Customers Loan Application Information</h3>
                                    <?php //if($user_info['user_type'] < 4):?>
                                    <div class="box-tools pull-right">
                                    	<button class="btn btn-danger btn-sm" data-toggle="modal" id="btn-view-voucher" data-target="#view-voucher-modal"><i class="fa fa-eye"></i> View Voucher</button>
                                       	<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-customer-loan-modal"><i class="fa fa-plus-square"></i> Add Loan</button>
                                    </div>
                                    <form id="cheque_form" action="loan_applications/generate_cheque" method="post">
									     	<input name="cheque_loan_id" type="hidden" id="cheque_loan_id">
									        <button class="btn btn-warning pull-right" type="submit" style="margin-right: 5px;" id="generate-cheque"><i class="fa fa-download"></i> Generate Cheque</button>
		                            </form>
		                            <form id="contract_form" action="loan_applications/generate_contract" method="post">
									     	<input name="contract_loan_id" type="hidden" id="contract_loan_id2">
									        <button class="btn btn-primary pull-right" type="submit" style="margin-right: 5px;" id="generate-contract"><i class="fa fa-download"></i> Contract </button>
		                            </form>
		                            <!--
                                    <form id="contract_form_data" action="loan_applications/generate_contract_data" method="post">
									     	<input name="contract_loan_id" type="hidden" id="contract_loan_id">
									        <button class="btn btn-success pull-right" type="submit" style="margin-right: 5px;" id="generate-contract_data"><i class="fa fa-download"></i> PNTR Data</button>
		                            </form>
		                            
		                            <form id="contract_form" action="loan_applications/generate_contract_form" method="post">
									     	<input name="contract_loan_id" type="hidden" id="contract_loan_id1">
									        <button class="btn btn-default pull-right" type="submit" style="margin-right: 5px;" id="generate-contract_form"><i class="fa fa-download"></i> PNTR FORM</button>
		                            </form>
		                            -->
		                            <?php //endif;?>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="customer-loan-application-table" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                            	<th>ID</th>
                                            	<th>MOP ID</th>
                                                <th>Account Number</th>
                                                <th>Account Name</th>
                                                <th>Loan Amount</th>
                                                <th>Mode of Payment</th>
                                                <th>Duration</th>
                                                <th>Interest %</th>
                                                <th>Interest Amount</th>
                                                <th>Service Fee %</th>
                                                <th>Service Fee Amount</th>
                                                <th>Loan Proceeds</th>
                                                <th>Amort</th>
                                                <th>Date Released</th>
                                                <th>Maturity Date</th>
                                                <th>Customer Id</th>
                                                <th>Loan Cycle</th>
                                                <th>PEP</th>
                                                <th>Status</th>
                                                <th width="10%">Action</th>
                                                <th>Address</th>
                                                <th>Area Name</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        </div>
                    </div><!-- row -->
							<!-- ADD CUSTOMER LOAN MODAL -->
					        <div class="modal fade" id="add-customer-loan-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-money"></i> Add New Loan</h4>
					                    </div>
					                    
					                    <form action="#" method="post" id="add-customer-loan-form" class="form-horizontal">
					                        <div class="modal-body">
					                        	<div class="alert_loan_exists">
					                   			</div>
					                        	<div class="form-group">
					                        		<label for="loan_type" class="col-sm-3 control-label">Loan type:</label>
		                                            <div class="col-sm-7">
												      	<select class="form-control" name="loan_type" id="loan_type">
			                                            	<option value="new">New</option>
			                                            	<option value="renew">Renewal</option>	
		                                            	</select>
												    </div>
		                                        </div>
					                        	<div class="form-group">
					                        		<label for="customer_id" class="col-sm-3 control-label">Customer name:</label>
		                                            <div class="col-sm-7">
		                                            	<select class="form-control" name="customer_id" id="customer_id" style="width: 100%">
		                                            	</select>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="loan_amount" class="col-sm-3 control-label">Loan amount:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Loan amount" type="number" name="loan_amount" id="loan_amount" required="required">
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="mode_of_payment" class="col-sm-3 control-label">Mode of payment:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
															<select class="form-control" name="mode_of_payment" id="mode_of_payment" required="required">
																<?php echo $payment_mode;?>
															</select>
					                                    </div>
				                                    </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                        	<label for="loan_term" class="col-sm-3 control-label">Loan term:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
															<select class="form-control" name="loan_term" id="loan_term" required="required">
																<option value="">-Select-</option>
															</select>
													      	<input class="form-control hidden" type="number" name="loan_term_duration" value='100'>
					                                    </div>
					                                 </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                        	<label for="interest_pct" class="col-sm-3 control-label">Interest percentage:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <input class="form-control" placeholder="Interest Percentage" type="number" value='16' name="interest_pct" id="interest_pct" readonly>
					                                        <span class="input-group-addon">%</span>
					                                    </div>
					                                </div>
		                                        </div>

		                                        <div class="form-group">
		                                        	<label for="interest_amount" class="col-sm-3 control-label">Interest amount:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Interest amount" type="number" min="0" step="1" name="interest_amount" id="interest_amount" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>	

		                                        <div class="form-group hidden">
		                                        	<label for="service_fee_pct" class="col-sm-3 control-label">Service fee percentage:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <input class="form-control" placeholder="Service Fee Percentage" type="number" value="1" name="service_fee_pct" id="service_fee_pct">
					                                        <span class="input-group-addon">%</span>
					                                    </div>
					                                </div>
		                                        </div>
		                                        
		                                        <div class="form-group">
		                                        	<label for="service_fee_amount" class="col-sm-3 control-label">Service fee amount:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Service fee amount" type="number" min="0" step="1" name="service_fee_amount" id="service_fee_amount" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>

		                                        <div class="form-group">
		                                        	<label for="mutual_aid" class="col-sm-3 control-label">Mutual aid:</label>
		                                            <div class="col-sm-6">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Mutual aid" type="text" name="mutual_aid" id="mutual_aid" readonly>
					                                        <span class="input-group-addon">.00</span>&nbsp;
					                                        <input id="adduseMututalAid" type="checkbox">
					                                    </div>
					                                </div>
		                                        </div>

		                                        <div class="form-group">
		                                        	<label for="loan_proceeds" class="col-sm-3 control-label">Loan proceeds:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Loan proceeds" type="number" min="0" step="1" name="loan_proceeds" id="loan_proceeds" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="amortization" class="col-sm-3 control-label">Amortization:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Amortization" type="number" min="0" step="1" name="amortization" id="amortization" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="loan_purpose" class="col-sm-3 control-label">Loan Purpose:</label>
		                                        	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Loan Purpose" type="text" name="loan_purpose" id="loan_purpose">
												  	</div>
												</div>
												<div class="form-group">
													<label for="type_of_business" class="col-sm-3 control-label">Type of business:</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Type of business" type="text" name="type_of_business" id="type_of_business">
												  	</div>
												</div>
												
												<div class="form-group">
													<label for="co_maker1" class="col-sm-3 control-label">Co-maker 1:</label>
													<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1" type="text" name="co_maker1" id="co_maker1">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker1_address" class="col-sm-3 control-label">Co-maker 1 Address</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1 Address" type="text" name="co_maker1_address" id="co_maker1_address">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker1_id" class="col-sm-3 control-label">Co-maker 1 Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1 Id Presented" type="text" name="co_maker1_id" id="co_maker1_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker1_id_issue_date" class="col-sm-3 control-label">Co-maker 1 Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1 Id Issue Date" type="text" name="co_maker1_id_issue_date" id="co_maker1_id_issue_date">
												  	</div>
												</div>
												
												<div class="form-group">
												  	<label for="co_maker2" class="col-sm-3 control-label">Co-maker 2</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2" type="text" name="co_maker2" id="co_maker2">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker2_address" class="col-sm-3 control-label">Co-maker 2 Address</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2 Address" type="text" name="co_maker2_address" id="co_maker2_address">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker2_id" class="col-sm-3 control-label">Co-maker 2 Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2 Id Presented" type="text" name="co_maker2_id" id="co_maker2_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker2_id_issue_date" class="col-sm-3 control-label">Co-maker 2 Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2 Id Issue Date" type="text" name="co_maker2_id_issue_date" id="co_maker2_id_issue_date">
												  	</div>
												</div>
												
		                                        <div class="form-group">
												  	<label for="witness1" class="col-sm-3 control-label">Witness 1</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Witness 1" type="text" name="witness1" id="witness1">
												  	</div>
												</div>
												
												<div class="form-group">
												  	<label for="witness2" class="col-sm-3 control-label">Witness 2</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Witness 2" type="text" name="witness2" id="witness2">
												  	</div>
												</div>
												<div class="form-group">
					                        		<label for="useSpouse" class="col-sm-3 control-label">Use spouse as co-borrower:</label>
		                                            <div class="col-sm-7">
												      	<select class="form-control" name="useSpouse" id="useSpouse">
			                                            	<option value="0">No</option>
			                                            	<option value="1">Yes</option>	
		                                            	</select>
												    </div>
		                                        </div>
		                                        <div class="form-group">
					                        		<label for="collateral_address" class="col-sm-3 control-label">Collateral Address:</label>
		                                            <div class="col-sm-7">
												      	<input class="form-control" placeholder="Collateral_address" type="text" name="collateral_address" id="collateral_address">
												    </div>
		                                        </div>
		                                        
		                                        <div class="form-group">
												  	<label for="maker_id" class="col-sm-3 control-label">Maker Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Maker Id Presented" type="text" name="maker_id" id="maker_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="maker_id_issue_date" class="col-sm-3 control-label">Maker Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Maker Id Issue Date" type="text" name="maker_id_issue_date" id="maker_id_issue_date">
												  	</div>
												</div>
		                                        
		                                        <div class="form-group">
												  	<label for="co_borrower_id" class="col-sm-3 control-label">Co-borrower Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-borrower Id Presented" type="text" name="co_borrower_id" id="co_borrower_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_borrower_id_issue_date" class="col-sm-3 control-label">Co-borrower Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-borrower Id Issue Date" type="text" name="co_borrower_id_issue_date" id="co_borrower_id_issue_date">
												  	</div>
												</div>
		                                        
		                                        <div class="box-group" id="accordion">
			                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
			                                        <div class="panel box box-primary">
			                                            <div class="box-header">
			                                                <h4 class="box-title">
			                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="">
			                                                        Collaterals
			                                                    </a>
			                                                </h4>
			                                            </div>
			                                            <div id="collapseOne" class="panel-collapse in" style="height: auto;">
			                                                <div class="box-body">
			                                                    <table class="table table-bordered">
							                                        <thead>
							                                        	<tr>
								                                            <th style="width: 10px">#</th>
								                                            <th>BRAND</th>
								                                            <th>MAKE/MODEL</th>
								                                            <th>SERIAL NUMBER</th>
								                                        </tr>	
							                                        </thead>
							                                        <tbody>
							                                        <?php for($i=1; $i<=10; $i++):?>
							                                        	<tr>
								                                            <td><?php echo $i;?></td>
								                                            <td><input class="form-control brand" placeholder="" type="text" name="brand<?php echo $i?>"></td>
								                                            <td><input class="form-control make" placeholder="" type="text" name="make<?php echo $i?>"></td>
								                                            <td><input class="form-control serial" placeholder="" type="text" name="serial<?php echo $i?>"></td>
								                                        </tr>	
							                                        <?php endfor;?>
							                                        
							                                        
							                                        
							                                        
							                                    </tbody></table>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
		                                        
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					
					                            <button type="submit" class="btn btn-primary btn_submit btn_save_loan"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
                            
                            <!-- EDIT CUSTOMER MODAL -->
                            
                            <div class="modal fade" id="edit-customer-loan-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-money"></i> Edit Loan</h4>
					                    </div>
					                    
					                    <form action="#" method="post" id="edit-customer-loan-form" class="form-horizontal">
					                        <div class="modal-body">
					                        	<div class="alert_loan_exists">
					                   			</div>
					                        	<div class="form-group">
					                        		<label for="loan_type" class="col-sm-3 control-label">Loan type:</label>
		                                            <div class="col-sm-7">
												      	<select class="form-control" name="loan_type" id="loan_type">
			                                            	<option value="new">New</option>
			                                            	<option value="renew">Renewal</option>	
		                                            	</select>
												    </div>
		                                        </div>
					                        	<div class="form-group">
					                        		<label for="customer_id" class="col-sm-3 control-label">Customer name:</label>
		                                            <div class="col-sm-7">
		                                            	<select class="form-control" name="customer_id" id="customer_id">
		                                            	</select>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="loan_amount" class="col-sm-3 control-label">Loan amount:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Loan amount" type="number" name="loan_amount" id="loan_amount" required="required">
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="mode_of_payment" class="col-sm-3 control-label">Mode of payment:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
															<select class="form-control" name="mode_of_payment" id="mode_of_payment" required="required">
																<?php echo $payment_mode;?>
															</select>
					                                    </div>
				                                    </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                        	<label for="loan_term" class="col-sm-3 control-label">Loan term:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
															<select class="form-control" name="loan_term" id="loan_term" required="required">
																<option value="">-Select-</option>
															</select>
													      	<input class="form-control hidden" type="number" name="loan_term_duration" value='100'>
					                                    </div>
					                                 </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="interest_pct" class="col-sm-3 control-label">Interest percentage:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <input class="form-control" placeholder="Interest Percentage" type="number" value='16' name="interest_pct" id="interest_pct" readonly>
					                                        <span class="input-group-addon">%</span>
					                                    </div>
					                                </div>
		                                        </div>

		                                        <div class="form-group">
		                                        	<label for="interest_amount" class="col-sm-3 control-label">Interest amount:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Interest amount" type="number" min="0" step="1" name="interest_amount" id="interest_amount" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>	

		                                        <div class="form-group hidden">
		                                        	<label for="service_fee_pct" class="col-sm-3 control-label">Service fee percentage:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <input class="form-control" placeholder="Service Fee Percentage" type="number" value="1" name="service_fee_pct" id="service_fee_pct">
					                                        <span class="input-group-addon">%</span>
					                                    </div>
					                                </div>
		                                        </div>
		                                        
		                                        <div class="form-group">
		                                        	<label for="service_fee_amount" class="col-sm-3 control-label">Service fee amount:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Service fee amount" type="number" min="0" step="1" name="service_fee_amount" id="service_fee_amount" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>

		                                        <div class="form-group">
		                                        	<label for="mutual_aid" class="col-sm-3 control-label">Mutual aid:</label>
		                                            <div class="col-sm-6">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Mutual aid" type="text" name="mutual_aid" id="mutual_aid" readonly>
					                                        <span class="input-group-addon">.00</span>&nbsp;
					                                        <input id="edituseMututalAid" type="checkbox">
					                                    </div>
					                                </div>
		                                        </div>



		                                        <div class="form-group">
		                                        	<label for="loan_proceeds" class="col-sm-3 control-label">Loan proceeds:</label>
		                                        	<div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Loan proceeds" type="number" min="0" step="1" name="loan_proceeds" id="loan_proceeds" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="amortization" class="col-sm-3 control-label">Amortization:</label>
		                                            <div class="col-sm-7">
			                                            <div class="input-group">
					                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
					                                        <input class="form-control" placeholder="Amortization" type="number" min="0" step="1" name="amortization" id="amortization" readonly>
					                                        <span class="input-group-addon">.00</span>
					                                    </div>
					                                </div>
		                                        </div>
		                                        <div class="form-group">
		                                        	<label for="loan_purpose" class="col-sm-3 control-label">Loan Purpose:</label>
		                                        	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Loan Purpose" type="text" name="loan_purpose" id="loan_purpose">
												  	</div>
												</div>
												<div class="form-group">
													<label for="type_of_business" class="col-sm-3 control-label">Type of business:</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Type of business" type="text" name="type_of_business" id="type_of_business">
												  	</div>
												</div>
												
												<div class="form-group">
													<label for="co_maker1" class="col-sm-3 control-label">Co-maker 1:</label>
													<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1" type="text" name="co_maker1" id="co_maker1">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker1_address" class="col-sm-3 control-label">Co-maker 1 Address</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1 Address" type="text" name="co_maker1_address" id="co_maker1_address">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker1_id" class="col-sm-3 control-label">Co-maker 1 Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1 Id Presented" type="text" name="co_maker1_id" id="co_maker1_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker1_id_issue_date" class="col-sm-3 control-label">Co-maker 1 Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 1 Id Issue Date" type="text" name="co_maker1_id_issue_date" id="co_maker1_id_issue_date">
												  	</div>
												</div>
												
												<div class="form-group">
												  	<label for="co_maker2" class="col-sm-3 control-label">Co-maker 2</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2" type="text" name="co_maker2" id="co_maker2">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker2_address" class="col-sm-3 control-label">Co-maker 2 Address</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2 Address" type="text" name="co_maker2_address" id="co_maker2_address">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker2_id" class="col-sm-3 control-label">Co-maker 2 Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2 Id Presented" type="text" name="co_maker2_id" id="co_maker2_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_maker2_id_issue_date" class="col-sm-3 control-label">Co-maker 2 Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-maker 2 Id Issue Date" type="text" name="co_maker2_id_issue_date" id="co_maker2_id_issue_date">
												  	</div>
												</div>
												
		                                        <div class="form-group">
												  	<label for="witness1" class="col-sm-3 control-label">Witness 1</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Witness 1" type="text" name="witness1" id="witness1">
												  	</div>
												</div>
												
												<div class="form-group">
												  	<label for="witness2" class="col-sm-3 control-label">Witness 2</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Witness 2" type="text" name="witness2" id="witness2">
												  	</div>
												</div>
												<div class="form-group">
					                        		<label for="useSpouse" class="col-sm-3 control-label">Use spouse as co-borrower:</label>
		                                            <div class="col-sm-7">
												      	<select class="form-control" name="useSpouse" id="useSpouse">
			                                            	<option value="0">No</option>
			                                            	<option value="1">Yes</option>	
		                                            	</select>
												    </div>
		                                        </div>
		                                        <div class="form-group">
					                        		<label for="collateral_address" class="col-sm-3 control-label">Collateral Address:</label>
		                                            <div class="col-sm-7">
												      	<input class="form-control" placeholder="Collateral_address" type="text" name="collateral_address" id="collateral_address">
												    </div>
		                                        </div>
		                                        <div class="form-group">
												  	<label for="maker_id" class="col-sm-3 control-label">Maker Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Maker Id Presented" type="text" name="maker_id" id="maker_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="maker_id_issue_date" class="col-sm-3 control-label">Maker Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Maker Id Issue Date" type="text" name="maker_id_issue_date" id="maker_id_issue_date">
												  	</div>
												</div>
												
												<div class="form-group">
												  	<label for="co_borrower_id" class="col-sm-3 control-label">Co-borrower Id Presented</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-borrower Id Presented" type="text" name="co_borrower_id" id="co_borrower_id">
												  	</div>
												</div>
												<div class="form-group">
												  	<label for="co_borrower_id_issue_date" class="col-sm-3 control-label">Co-borrower Id Issue Date</label>
												  	<div class="col-sm-7">
												  		<input class="form-control" placeholder="Co-borrower Id Issue Date" type="text" name="co_borrower_id_issue_date" id="co_borrower_id_issue_date">
												  	</div>
												</div>
												
		                                        <div class="box-group" id="accordion">
			                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
			                                        <div class="panel box box-primary">
			                                            <div class="box-header">
			                                                <h4 class="box-title">
			                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="">
			                                                        Collaterals
			                                                    </a>
			                                                </h4>
			                                            </div>
			                                            <div id="collapseOne" class="panel-collapse in" style="height: auto;">
			                                                <div class="box-body">
			                                                    <table class="table table-bordered">
							                                        <thead>
							                                        	<tr>
								                                            <th style="width: 10px">#</th>
								                                            <th>BRAND</th>
								                                            <th>MAKE/MODEL</th>
								                                            <th>SERIAL NUMBER</th>
								                                        </tr>	
							                                        </thead>
							                                        <tbody>
							                                        <?php for($i=1; $i<=10; $i++):?>
							                                        	<tr>
								                                            <td><?php echo $i;?></td>
								                                            <td><input class="form-control brand" placeholder="" type="text" name="brand<?php echo $i?>"></td>
								                                            <td><input class="form-control make" placeholder="" type="text" name="make<?php echo $i?>"></td>
								                                            <td><input class="form-control serial" placeholder="" type="text" name="serial<?php echo $i?>"></td>
								                                        </tr>	
							                                        <?php endfor;?>
							                                        
							                                        
							                                        
							                                        
							                                    </tbody></table>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
		                                        
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					
					                            <button type="submit" class="btn btn-primary btn_submit btn_save_loan"><i class="fa fa-share"></i> Update</button>
					                        </div>
					                        <input name="loan_id" id="loan_id" type="hidden">
					                        <input name="application_status" id="application_status" type="hidden">
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div>
                            
                            
                            
                            
                            
                            <!-- ################################### -->
                            <!-- 
					        <div class="modal fade" id="edit-customer-loan-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-money"></i> Edit Loan</h4>
					                    </div>
					                    
					                    <form action="#" method="post" id="edit-customer-loan-form">
					                        <div class="modal-body">
					                        	<div class="alert_loan_exists">
					                   			</div>
					                        	<div class="form-group">
		                                            <label>Loan type</label>
		                                            <select class="form-control" name="loan_type">
		                                            	<option value="new">New</option>
		                                            	<option value="renew">Renewal</option>	
		                                            </select>
		                                        </div>
					                        	<div class="form-group">
		                                            <label>Customer name</label>
		                                            <select class="form-control" name="customer_id" disabled>
		                                            </select>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Loan amount</label>
		                                            <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
				                                        <input class="form-control" placeholder="Loan amount" type="number" name="loan_amount" required="required">
				                                        <span class="input-group-addon">.00</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Mode of payment</label>
		                                            <div class="input-group">
														<select class="form-control" name="mode_of_payment" required="required">
															<?php //echo $payment_mode;?>
														</select>
														<span class="input-group-btn">
												        	<button class="btn btn-default" type="button">+</button>
												      	</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Loan term</label>
		                                            <div class="input-group">
														<select class="form-control" name="loan_term" required="required">
															<option value="">-Select-</option>
														</select>

												      	<input class="form-control hidden" type="number" name="loan_term_duration">
				                                    </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                            <label>Interest percentage</label>
		                                            <div class="input-group">
				                                        <input class="form-control" placeholder="Interest Percentage" type="number" name="interest_pct" readonly>
				                                        <span class="input-group-addon">%</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                            <label>Service fee percentage</label>
		                                            <div class="input-group">
				                                        <input class="form-control" placeholder="Service Fee Percentage" type="number" value="1" name="service_fee_pct">
				                                        <span class="input-group-addon">%</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                            <label>Interest amount</label>
		                                            <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
				                                        <input class="form-control" placeholder="Interest amount" type="number" min="0" step="1" name="interest_amount" readonly>
				                                        <span class="input-group-addon">.00</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group hidden">
		                                            <label>Service fee amount</label>
		                                            <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
				                                        <input class="form-control" placeholder="Service fee amount" type="number" min="0" step="1" name="service_fee_amount" readonly>
				                                        <span class="input-group-addon">.00</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Loan proceeds</label>
		                                            <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
				                                        <input class="form-control" placeholder="Loan proceeds" type="number" min="0" step="1" name="loan_proceeds" readonly>
				                                        <span class="input-group-addon">.00</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Amortization</label>
		                                            <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
				                                        <input class="form-control" placeholder="Amortization" type="number" min="0" step="1" name="amortization" readonly>
				                                        <span class="input-group-addon">.00</span>
				                                    </div>
		                                        </div>
		                                        
		                                      
		                                         
												<div class="form-group">
												  	<label for="id_presented">Id Presented</label>
												  	<textarea class="form-control" rows="3" name="id_presented"></textarea>
												</div>
												<div class="form-group">
												  	<label for="collateral">Collateral</label>
												  	<textarea class="form-control" rows="3" name="collateral"></textarea>
												</div>
		                                        <div class="form-group">
												  	<label for="loan_purpose">Loan purpose</label>
												  	<textarea class="form-control" rows="3" name="loan_purpose"></textarea>
												</div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					
					                            <button type="submit" class="btn btn-primary btn_submit btn_save_loan"><i class="fa fa-share"></i> Update</button>
					                        </div>
					                        <input name="loan_id" id="loan_id" type="hidden">
					                    </form>
					                </div>
					            </div>
					        </div>
                             -->
                            
                            <!-- VIEW VOUCHER -->
					        
					        <div class="modal fade" id="view-voucher-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-list"></i> VOUCHER</h4>
					                    </div>
					                     <div class="modal-body">
					                     	<div class="row">
									            <aside>
									                <!-- Main content -->
									                <section class="content invoice">
									                    <div class="row invoice-info">
									                        <div class="col-sm-6 invoice-col">
									                        	<!--<img src="<?php //echo get_template_dir('img/Picture1.png');?>" alt="Logo" /><br>-->
									                            <div style="padding: 15px">
										                            PAID TO: <strong class="customer_name">NAME</strong><br>
										                            ADDRESS: <strong class="customer_address">ADDRESS</strong><br>
									                            </div>
									                        </div><!-- /.col -->
									                        <div class="col-sm-6 invoice-col">
									                        	<strong style="color:white; background-color: black; font-size: 20px" class="pull-right">CHEQUE VOUCHER</strong><br>
									                        	<div style="text-align: left; padding: 15px; margin: 24px 0px 0px 76px;">
										                            DATE: <strong class="voucher_date"><?php echo date('Y-m-d')?></strong><br>
										                            ACCOUNT #: <strong class="voucher_account_no">ACCOUNT NO</strong><br>
										                            CHEQUE #: <strong class="voucher_cheque_no">CHEQUE NO</strong>
									                            </div>
									                        </div><!-- /.col -->
									                        
									                    </div><!-- /.row -->
														<br>
														
									                    <div class="row"  style="border: 2px solid black; padding: 10px">
									                    		<div class="col-sm-3">
									                    			Loan Amount: <br>
									                    			Less:
									                    			<br>
									                    			<br>
									                    			<br>
									                    			NET PROCEEDS:	 
									                    		</div>
									                    		<div class="col-sm-5">
									                    			<br>
									                    			INTEREST @ 16% FOR 100 DAYS<br>
									                    			DOCUMENTARY STAMP AND NOTARIAL FEE<br>
									                    			OTHERS
									                    		</div>
									                    		<div class="col-sm-1">
									                    			P
									                    			<br>
									                    			<br>
									                    			<br>
									                    			<br>
									                    			P 
									                    		</div>
									                    		<div class="col-sm-3">
									                    			<strong class="voucher_data voucher_loan_amount">5561</strong><br>
									                    			<strong class="voucher_data voucher_interest">655</strong><br>
									                    			<strong class="voucher_data voucher_service_fee">200</strong><br>
									                    			<strong class="voucher_data voucher_others">0</strong><br>
									                    			<strong class="voucher_data voucher_net_proceeds">516151</strong><br>
									                    		</div>
									                    </div>
									                	<br>
									                	<br>
									                    <div class="row">
									                    	<div class="col-sm-6">
									                    	APPROVED BY:
									                    	<br><br>
									                    	_______________
									                    	</div>
									                    	<div class="col-sm-6" style="padding-left: 106px;">
									                    	RECEIVED BY:
									                    	<br><br>
									                    	<span class="customer_name">MORALEDA ANDREW</span><br>
									                    	<span style="font-size: 10px">Signature over printed name</span>
									                    	</div>
									                    </div>
									                    <br>
									                    <br>
									                    <div class="row no-print">
									                        <div class="col-xs-12">
									                            <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
									                            <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button> -->
									                            <button type="button" class="btn btn-danger btn_cancel pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									                            <form id="voucher_form" action="loan_applications/generate_voucher" method="post">
									                            <input name="voucher_loan_id" type="hidden" id="voucher_loan_id">
									                            <button class="btn btn-primary pull-right" type="submit" style="margin-right: 5px;" id="generate-pdf"><i class="fa fa-download"></i> Generate PDF</button>
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
                            
                            
					<input type="hidden" id="loan_id_hidden">
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
