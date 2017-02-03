<?php $user_info = $this->session->userdata('logged_in');?>
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Loans page
                        <small>Customers Loan Information</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Loans</li>
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
                        <div class="col-xs-8">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Customers Loan Information</h3>
                                    <div class="box-tools pull-right">
                                       <?php if($user_info['user_type'] < 2):?>	
                                       		<button class="btn btn-primary btn-sm" id="apply_pep" disabled="disabled"><i class="fa fa-pencil"></i> Apply PEP</button>
                                       	<?php endif;?>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="customer-loan-table" class="table table-bordered" width="100%">
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
                                                <!--<th>Status</th>
                                                 <th>Action</th> -->
                                            </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        </div>
                        
                        <div class="col-xs-4">
                        	<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h5 class="box-title">Payment Details</h5>
                                    <div class="box-tools pull-right">
                                    	<?php if($user_info['user_type'] < 2):?>
                                    	<button class="btn btn-primary btn-sm" id="btn-add-payment" disabled data-toggle="tooltip" data-placement="bottom" title="Add Payment"><i class="fa fa-plus"></i></button>
                                    	<?php endif;?>
                                    	<button class="btn btn-primary btn-sm" id="btn-view-ledger" disabled data-toggle="tooltip" data-placement="bottom" title="View All Payments"><i class="fa fa-eye"></i></button>
                                    	<button class="btn btn-primary btn-sm" id="btn-view-soa" disabled data-toggle="tooltip" data-placement="bottom" title="View Soa"><i class="fa fa-list"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive" id="payments_container">
                                <h3 id="loan_details_title">-None Selected-</h3>
                                <div class="row" id="loan_details_container">
                                	<div class="col-xs-6">
                                		Due: &nbsp; <span id="cutoff_due" class="loan_info">-</span><br>
                                		Overdue: &nbsp; <span id="cutoff_overdue" class="loan_info">-</span><br>
                                		Total Payments: &nbsp; <span id="cutoff_totalpayments" class="loan_info">-</span><br>
                                		<span id="pep_startdate"></span>
                                		<span id="lapses"></span>
                                	</div>
                                	<div class="col-xs-6">
                                		Payables: &nbsp;<span id="cutoff_payables" class="loan_info">-</span><br>
                                		Balance: &nbsp;<span id="loan_balance" class="loan_info">-</span><br>
                                		<span id="odcounter"></span><br>
                                		<span id='countdown'>Countdown:</span> <span id="remaining_days" class="loan_info">-</span><br>
                                		<span id="pep_enddate"></span>
                                	</div>
                                </div>
                                	
                                    <table id="customer-loan-payment-table" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                            	<th>Payment Date</th>
                                            	<th>Amort</th>
                                                <th>Amount Paid</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div><!-- row -->
					<!-- ADD CUSTOMER LOAN MODAL -->
					        <div class="modal fade" id="add-customer-loan-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-money"></i> Add New Loan</h4>
					                    </div>
					                    
					                    <form action="#" method="post" id="add-customer-loan-form">
					                        <div class="modal-body">
					                        	<div class="alert_loan_exists">
					                   			</div>
					                        	<div class="form-group">
		                                            <label>Loan type</label>
		                                            <select class="form-control" name="loan_type" id="loan_type">
		                                            	<option value="new">New</option>
		                                            	<option value="renew">Renewal</option>	
		                                            </select>
		                                        </div>
					                        	<div class="form-group">
		                                            <label>Customer name</label>
		                                            <select class="form-control" name="customer_id" id="customer_id">
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
														<select class="form-control" name="mode_of_payment" required="required" id="mode_of_payment">
															<?php echo $payment_mode;?>
														</select>
														<span class="input-group-btn">
												        	<button class="btn btn-default" type="button">+</button>
												      	</span>
				                                    </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Loan term</label>
		                                            <div class="input-group">
														<select class="form-control" name="loan_term" required="required" id="loan_term">
															<option value="">-Select-</option>
														</select>
<!-- 														<span class="input-group-btn"> -->
<!-- 												        	<button class="btn btn-default" type="button">+</button> -->
<!-- 												      	</span> -->
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
		                                            <label>Release Date</label>
		                                            <input class="form-control" placeholder="Release Date" type="text" name="date_released" id="date_released">
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
					
					                            <button type="submit" class="btn btn-primary btn_submit" id="btn_save_loan"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
                            
                            <!-- EDIT CUSTOMER MODAL -->
					        <div class="modal fade" id="edit-customer-loan-modal" tabindex="-1" role="dialog" aria-hidden="true">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-user"></i> Edit Customer</h4>
					                    </div>
					                    <form action="#" method="post" id="edit-customer-form">
					                    	<input type="hidden" name="id">
					                        <div class="modal-body">
					                        	<div class="nav-tabs-custom">
					                                <ul class="nav nav-tabs">
					                                    <li class="active"><a href="#ec-personal_info" data-toggle="tab">Personal Info</a></li>
					                                    <li><a href="#ec-contact_info" data-toggle="tab">Contact Info</a></li>
					                                    <li><a href="#ec-income_summary" data-toggle="tab">Income Summary</a></li>
					                                    <li><a href="#ec-current_assets" data-toggle="tab">Current Assets</a></li>
					                                    <li><a href="#ec-spouse_info" data-toggle="tab">Spouse's Info</a></li>
					                                    <li><a href="#ec-personal_references" data-toggle="tab">Personal References</a></li>
					                                </ul>
					                                <div class="tab-content">
					                                    <div class="tab-pane active" id="ec-personal_info" >
					                                    	<!-- customer info -->
					                                    	<div class="form-group">
					                                            <label>Account No.</label>
					                                            <input class="form-control" placeholder="Account No." type="text" name="account_no" required="required">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Surname</label>
					                                            <input class="form-control" placeholder="Surname" type="text" name="surname" required="required">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>First name</label>
					                                            <input class="form-control" placeholder="First name" type="text" name="firstname" required="required">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Middle name</label>
					                                            <input class="form-control" placeholder="Middle name" type="text" name="middlename" required="required">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Nickname</label>
					                                            <input class="form-control" placeholder="Nickname" type="text" name="nickname">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Birthdate</label>
					                                            <input class="form-control" placeholder="Birthdate" type="text" name="birthdate" id="ec-birthdate">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Age</label>
					                                            <input class="form-control" placeholder="Age" type="number" min="0" step="1" name="age" id="ec-age" readonly="readonly">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Marital Status</label>
					                                            <select class="form-control" name="marital_status">
					                                                <option value="SINGLE">Single</option>
					                                                <option value="MARRIED">Married</option>
					                                                <option value="WIDOWED">Widowed</option>
					                                                <option value="SEPARATED">Separated</option>
					                                            </select>
					                                        </div>
					                                    </div>
					                                    <div class="tab-pane" id="ec-contact_info" >
					                                    	<div class="form-group">
					                                            <label>Home no.</label>
					                                            <input class="form-control" placeholder="Home no." type="text" name="address_home_no">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Street name</label>
					                                            <input class="form-control" placeholder="Street name" type="text" name="address_st_name">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Barangay</label>
					                                            <input class="form-control" placeholder="Barangay" type="text" name="address_brgy">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Municipality</label>
					                                            <input class="form-control" placeholder="Municipality" type="text" name="address_municipality">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>City</label>
					                                            <input class="form-control" placeholder="City" type="text" name="address_city">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Province</label>
					                                            <input class="form-control" placeholder="Province" type="text" name="address_prov">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Postal</label>
					                                            <input class="form-control" placeholder="Province" type="text" name="postal_code">
					                                        </div>
					                                        <div class="form-group">
					                                            <div class="checkbox">
					                                            	<?php foreach($house_type as $val):?>
					                                            		<label class="">
					                                                    <div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_minimal">
					                                                    	<input style="position: absolute; opacity: 0;" type="checkbox" id="house_type<?php echo $val['id'];?>" name="house_type[]" value="<?php echo $val['id'];?>">
					                                                    	<ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
					                                                    </div>
					                                                    <?php echo $val['house_type']?>
					                                                </label>
					                                            	<?php endforeach;?>
					                                            	
					                                            </div>
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Residence phone</label>
					                                            <input class="form-control" placeholder="Residence phone" type="text" name="residence_phone">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Mobile phone</label>
					                                            <input class="form-control" placeholder="Mobile phone" type="text" name="mobile_phone">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Length of stay</label>
					                                            <input class="form-control" placeholder="Length of stay" type="text" name="length_of_stay">
					                                        </div>
					                                    </div>
					                                    <div class="tab-pane" id="ec-income_summary" >
					                                    	<!-- income summary -->
					                                    	<div class="form-group">
					                                            <label>Type of business</label>
					                                            <input class="form-control" placeholder="Type of business" type="text" name="type_of_business">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Years in operation</label>
					                                            <input class="form-control" placeholder="Years in operation" type="text" name="years_in_operation">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Gross income (monthly)</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Gross income (monthly)" type="text" name="gross_income_monthly">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
					                                            
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Monthly expenses (amount)</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Monthly expenses (amount)" type="text" name="monthly_expenses">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
					                                            
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Other source of income</label>
					                                            <input class="form-control" placeholder="Other source of income" type="text" name="other_source_of_income">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Gross income (monthly)</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Gross income (monthly)" type="text" name="osi_gross_income">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Monthly expenses (amount)</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Monthly expenses (amount)" type="text" name="osi_monthly_expenses">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
					                                        </div>
					                                    </div>
					                                    <div class="tab-pane" id="ec-current_assets" >
					                                    	<div class="form-group">
					                                    		<?php foreach($assets as $val):?>
					                                    		<div class="checkbox">
					                                                <label class="">
					                                                    <div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_minimal">
					                                                    	<input style="position: absolute; opacity: 0;" type="checkbox" id="assets<?php echo $val['id'];?>" name="assets[]" value="<?php echo $val['id'];?>">
					                                                    	<ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
					                                                    </div>
					                                                    <?php echo $val['asset']?>
					                                                </label>
					                                            </div>
					                                    		<?php endforeach;?>	
					                                    		
					                                        </div>
					                                    </div>
					                                    <div class="tab-pane" id="ec-spouse_info" >
					                                    	<div class="form-group">
					                                            <label>Surname</label>
					                                            <input class="form-control" placeholder="Surname" type="text" name="spouse_surname">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>First name</label>
					                                            <input class="form-control" placeholder="First name" type="text" name="spouse_firstname">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Middle name</label>
					                                            <input class="form-control" placeholder="Middle name" type="text" name="spouse_middlename">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Nickname</label>
					                                            <input class="form-control" placeholder="Nickname" type="text" name="spouse_nickname">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Source of income</label>
					                                            <input class="form-control" placeholder="Source of income" type="text" name="spouse_source_of_income">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>For self employed (Business type)</label>
					                                            <input class="form-control" placeholder="Type of business" type="text" name="spouse_business_type">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Years in operation</label>
					                                            <input class="form-control" placeholder="Years in operation" type="text" name="spouse_business_type_years_in_operation">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Sector</label>
					                                            <select class="form-control" name="spouse_priv_govt">
					                                            	<option value="">-Please select-</option>
					                                                <option value="private">Private sector</option>
					                                                <option value="government">Government</option>
					                                            </select>
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Name of present employer</label>
					                                            <input class="form-control" placeholder="Monthly expenses (amount)" type="text" name="spouse_present_employer">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Gross income</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Gross Income" type="text" name="spouse_gross_income">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
					                                            
					                                        </div>
					                                    </div>
					                                    <div class="tab-pane" id="ec-personal_references" >
					                                    	<div class="box-body table-responsive no-padding">
							                                    <table class="table table-hover">
							                                        <tbody>
								                                        <tr>
								                                            <th>Surname</th>
								                                            <th>Firstname</th>
								                                            <th>Middle name</th>
								                                            <th>Relationship</th>
								                                            <th>School employer</th>
								                                            <th>Age</th>
								                                            <th>Dependent</th>
								                                        </tr>
								                                        <tr>
								                                        	<input class="form-control" placeholder="id" type="hidden" name="cr_id1">
								                                            <td><input class="form-control" placeholder="Surname" type="text" name="cr_surname1"></td>
								                                            <td><input class="form-control" placeholder="First name" type="text" name="cr_firstname1"></td>
								                                            <td><input class="form-control" placeholder="Middle name" type="text" name="cr_middlename1"></td>
								                                            <td><input class="form-control" placeholder="Relationship" type="text" name="cr_relationship1"></td>
								                                            <td><input class="form-control" placeholder="School employer" type="text" name="cr_school_employer1"></td>
								                                            <td><input class="form-control" placeholder="Age" type="number" name="cr_age1"></td>
								                                            <td>
								                                            	<select class="form-control" name="cr_is_dependent1">
								                                            		<option value=""></option>
						                                                			<option value="yes">Yes</option>
						                                                			<option value="no">No</option>
					                                            				</select>
						                                            		</td>
								                                        </tr>
								                                        <tr>
								                                        	<input class="form-control" placeholder="id" type="hidden" name="cr_id2">
								                                            <td><input class="form-control" placeholder="Surname" type="text" name="cr_surname2"></td>
								                                            <td><input class="form-control" placeholder="First name" type="text" name="cr_firstname2"></td>
								                                            <td><input class="form-control" placeholder="Middle name" type="text" name="cr_middlename2"></td>
								                                            <td><input class="form-control" placeholder="Relationship" type="text" name="cr_relationship2"></td>
								                                            <td><input class="form-control" placeholder="School employer" type="text" name="cr_school_employer2"></td>
								                                            <td><input class="form-control" placeholder="Age" type="number" name="cr_age2"></td>
								                                            <td>
								                                            	<select class="form-control" name="cr_is_dependent2">
						                                                			<option value=""></option>
						                                                			<option value="yes">Yes</option>
						                                                			<option value="no">No</option>
					                                            				</select>
						                                            		</td>
								                                        </tr>
								                                        <tr>
								                                        	<input class="form-control" placeholder="id" type="hidden" name="cr_id3">
								                                            <td><input class="form-control" placeholder="Surname" type="text" name="cr_surname3"></td>
								                                            <td><input class="form-control" placeholder="First name" type="text" name="cr_firstname3"></td>
								                                            <td><input class="form-control" placeholder="Middle name" type="text" name="cr_middlename3"></td>
								                                            <td><input class="form-control" placeholder="Relationship" type="text" name="cr_relationship3"></td>
								                                            <td><input class="form-control" placeholder="School employer" type="text" name="cr_school_employer3"></td>
								                                            <td><input class="form-control" placeholder="Age" type="number" name="cr_age3"></td>
								                                            <td>
								                                            	<select class="form-control" name="cr_is_dependent3">
						                                                			<option value=""></option>
						                                                			<option value="yes">Yes</option>
						                                                			<option value="no">No</option>
					                                            				</select>
						                                            		</td>
								                                        </tr>
								                                        <tr>
								                                        	<input class="form-control" placeholder="id" type="hidden" name="cr_id4">
								                                            <td><input class="form-control" placeholder="Surname" type="text" name="cr_surname4"></td>
								                                            <td><input class="form-control" placeholder="First name" type="text" name="cr_firstname4"></td>
								                                            <td><input class="form-control" placeholder="Middle name" type="text" name="cr_middlename4"></td>
								                                            <td><input class="form-control" placeholder="Relationship" type="text" name="cr_relationship4"></td>
								                                            <td><input class="form-control" placeholder="School employer" type="text" name="cr_school_employer4"></td>
								                                            <td><input class="form-control" placeholder="Age" type="number" name="cr_age4"></td>
								                                            <td>
								                                            	<select class="form-control" name="cr_is_dependent4">
						                                                			<option value=""></option>
						                                                			<option value="yes">Yes</option>
						                                                			<option value="no">No</option>
					                                            				</select>
						                                            		</td>
								                                        </tr>
								                                        <tr>
								                                        	<input class="form-control" placeholder="id" type="hidden" name="cr_id5">
								                                            <td><input class="form-control" placeholder="Surname" type="text" name="cr_surname5"></td>
								                                            <td><input class="form-control" placeholder="First name" type="text" name="cr_firstname5"></td>
								                                            <td><input class="form-control" placeholder="Middle name" type="text" name="cr_middlename5"></td>
								                                            <td><input class="form-control" placeholder="Relationship" type="text" name="cr_relationship5"></td>
								                                            <td><input class="form-control" placeholder="School employer" type="text" name="cr_school_employer5"></td>
								                                            <td><input class="form-control" placeholder="Age" type="number" name="cr_age5"></td>
								                                            <td>
								                                            	<select class="form-control" name="cr_is_dependent5">
						                                                			<option value=""></option>
						                                                			<option value="yes">Yes</option>
						                                                			<option value="no">No</option>
					                                            				</select>
						                                            		</td>
								                                        </tr>
							                                    	</tbody>
							                                    </table>
							                                </div>
					                                    </div>
					                                </div><!-- /.tab-content -->
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					
					                            <button type="submit" class="btn btn-primary pull-left btn_submit"><i class="fa fa-share"></i> Update</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
                            
                            <!-- Add payment modal -->					        
					        <div class="modal fade" id="add-payment-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-money"></i> Add Loan Payment for <strong class="customer_name"></strong></h4> 
					                    </div>
					                    <form action="#" method="post" id="add-payment-form">
					                        <div class="modal-body">
					                        	<div class="form-group">
		                                            <label>Date of payment</label>
		                                            <input class="form-control hidden" type="text" name="loan_id" id="loan_id">
		                                            <input class="form-control" placeholder="Date of payment" type="text" name="payment_date" id="payment_date" required>
		                                        </div>
					                        	<div class="form-group">
		                                            <label>Amount</label>
		                                            <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
				                                        <input class="form-control" placeholder="Amount" type="text" name="amount" required id="payment_amount">
				                                        <span class="input-group-addon">.00</span>
				                                    </div>
		                                        </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					                            <button type="submit" class="btn btn-primary btn_submit"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        <!-- Soa modal -->					        
					        <div class="modal fade" id="soa-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-list"></i> STATEMENT OF ACCOUNT</h4>
					                    </div>
					                     <div class="modal-body">
					                     	<div class="row">
									            <aside>
									                <!-- Main content -->
									                <section class="content invoice">
									                    <div class="row invoice-info">
									                        <div class="col-sm-4 invoice-col">
									                            Name: <strong id="soa-customer-name"></strong><br>
									                            Account #: <strong id="soa-account-number"></strong><br>
									                            <!-- <span id="ps">Payment Status:</span> <strong id="payment-status"></strong> -->
									                            Outstanding balance: <strong id="outstanding-balance"></strong>
									                        </div><!-- /.col -->
									                        <div class="col-sm-4 invoice-col">
									                            Loan Amount: <strong id="soa-loan-amount"></strong><br>
									                            Amortization: <strong id="soa-amortization"></strong><br>
									                           
									                        </div><!-- /.col -->
									                        <div class="col-sm-4 invoice-col">
									                        	Date Released: <strong id="soa-date-released"></strong><br>
									                        	Maturity Date: <strong id="soa-maturity-date"></strong>
									                        </div><!-- /.col -->
									                    </div><!-- /.row -->
														<br>
														
									                    <div class="row">
									                        <!-- accepted payments column -->
									                        <div class="col-xs-12 table-responsive">
									                        	<h4>PAYMENT RECORD</h4>
									                            <table class="table table-striped">
									                                <thead>
									                                    <tr>
									                                        <th>Date of payment</th>
									                                        <th>Amount paid</th>
									                                    </tr>
									                                </thead>
									                                <tbody  id="payment-record">
									                                </tbody>
									                                <tfoot>
									                                	<tr>
									                                		<th>TOTAL PAYMENTS
									                                		</th>
									                                		<th id="total-payments">
									                                		</th>
									                                	</tr>
									                                </tfoot>
									                            </table>
									                        </div><!-- /.col -->
									                    </div><!-- /.row -->
									                    <div class="row no-print">
									                        <div class="col-xs-12">
									                            <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
									                            <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button> -->
									                            <button type="button" class="btn btn-danger btn_cancel pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									                            <form id="soa_form" action="loans/generate_soa" method="post">
									                            <input name="soa_loan_id" type="hidden" id="soa_loan_id">
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
					        
					        <!-- ledger modal -->
					        <div class="modal fade" id="ledger-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-bars"></i> Payment Summary of <strong class="customer_name"></strong></h4>
					                    </div>
					                     <div class="modal-body">
					                     	<div class="row">
									            <aside>
									                <!-- Main content -->
									                <section class="content invoice">
									                    <div class="row invoice-info">
									                        <div class="col-sm-6 invoice-col">
									                            Due: <strong id="ledger-due"></strong><br>
									                            Overdue #: <strong id="ledger-overdue"></strong><br>
									                            Total Payments: <strong id="ledger-total-payments"></strong>
									                        </div><!-- /.col -->
									                        <div class="col-sm-6 invoice-col">
									                            Payables: <strong id="ledger-payables"></strong><br>
									                            Balance: <strong id="ledger-balance"></strong><br>
									                            Countdown: <strong id="ledger-countdown"></strong>
									                           
									                        </div><!-- /.col -->
									                        
									                    </div><!-- /.row -->
														<br>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
						                                            <label>Cutoff Month</label>
						                                            <select class="form-control" id="cutoff_months"></select>
						                                        </div>
															</div>
															<div class="col-sm-6">
																<div class="form-group">
						                                            <label>Cutoff days</label>
						                                            <select class="form-control" id="cutoff_days"></select>
						                                        </div>
															</div>
														</div>
									                    <div class="row">
									                        <!-- accepted payments column -->
									                        <div class="col-xs-12 table-responsive">
									                            <table id="tbl-payment-summary" class="table table-bordered" width="100%">
							                                        <thead>
							                                            <tr>
							                                            	<th>Payment Date</th>
							                                            	<th>Daily Amort</th>
							                                                <th>Amount Paid</th>
							                                            </tr>
							                                        </thead>
							                                        <tbody id="tbl-payment-summary-tbody">
							                                        </tbody>
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
					<input type="hidden" id="loan_id_hidden">
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->