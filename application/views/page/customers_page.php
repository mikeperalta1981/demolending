<?php $user_info = $this->session->userdata('logged_in'); ?>
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Customers page
                        <small>Customers Information</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Customers</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="row alert_create_customer">
                	</div>
                	<div class="row alert_update_customer">
                	</div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Customers Information</h3>
                                    <div class="box-tools pull-right">
                                    	
                                    	<?php if($user_info['user_type'] < 4):?>
                                       	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-customer-modal"><i class="fa fa-plus-square"></i> Add Customer</button>
                                       	<?php endif;?>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="customer-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            	<th>ID</th>
                                                <th>Account Number</th>
                                                <th>Account Name</th>
                                                <th>Address</th>
                                                <th>Home Phone</th>
                                                <th>Mobile Phone</th>
                                                <th>Enrolled Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            <!-- ADD CUSTOMER MODAL -->
					        <div class="modal fade" id="add-customer-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-user"></i> Add New Customer</h4>
					                    </div>
					                    <form action="#" method="post" id="add-customer-form">
					                        <div class="modal-body">
					                        	<div class="nav-tabs-custom">
					                                <ul class="nav nav-tabs">
					                                    <li class="active"><a href="#ac-personal_info" data-toggle="tab">Personal Info</a></li>
					                                    <li><a href="#ac-contact_info" data-toggle="tab">Contact Info</a></li>
					                                    <!-- <li><a href="#ac-income_summary" data-toggle="tab">Income Summary</a></li>
					                                    <li><a href="#ac-current_assets" data-toggle="tab">Current Assets</a></li> -->
					                                    <li><a href="#ac-spouse_info" data-toggle="tab">Spouse's Info</a></li>
					                                    <!-- <li><a href="#ac-personal_references" data-toggle="tab">Personal References</a></li> -->
					                                </ul>
					                                <div class="tab-content">
					                                    <div class="tab-pane active" id="ac-personal_info" >
					                                    	<!-- customer info -->
					                                    	<div class="form-group">
						                                    	<select class="form-control" name="branch_id">
																	<?php foreach($branches as $val):?>
																		<option value="<?php echo $val['id']?>"><?php echo $val['branch_name']?></option>
																	<?php endforeach;?>
			                                            		</select>
		                                            		</div>
		                                            		<div class="form-group">
						                                    	<select class="form-control" name="area_id">
			                                            		</select>
		                                            		</div>
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
					                                            <input class="form-control" placeholder="Birthdate" type="text" name="birthdate" id="ac-birthdate">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Age</label>
					                                            <input class="form-control" placeholder="Age" type="number" name="age" id="ac-age" readonly="readonly">
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
					                                        <!-- 
					                                        <div class="form-group">
					                                            <label>Type of business</label>
					                                            <input class="form-control" placeholder="Type of business" type="text" name="type_of_business">
					                                        </div>
					                                         -->
					                                    </div>
					                                    <div class="tab-pane" id="ac-contact_info" >
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
					                                        <!-- 
					                                        <div class="form-group">
					                                            <div class="checkbox">
					                                            	<?php //foreach($house_type as $val):?>
					                                            		<label class="">
					                                                    <div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_minimal">
					                                                    	<input style="position: absolute; opacity: 0;" type="checkbox" name="house_type[]" value="<?php echo $val['id'];?>">
					                                                    	<ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
					                                                    </div>
					                                                    <?php //echo $val['house_type']?>
					                                                </label>
					                                            	<?php //endforeach;?>
					                                            	
					                                            </div>
					                                        </div>
					                                         -->
					                                        <div class="form-group">
					                                            <label>Residence phone</label>
					                                            <input class="form-control" placeholder="Residence phone" type="text" name="residence_phone">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Mobile phone</label>
					                                            <input class="form-control" placeholder="Mobile phone" type="text" name="mobile_phone">
					                                        </div>
					                                        <!-- 
					                                        <div class="form-group">
					                                            <label>Length of stay</label>
					                                            <input class="form-control" placeholder="Length of stay" type="text" name="length_of_stay">
					                                        </div>
					                                         -->
					                                    </div>
					                                    <!-- 
					                                    <div class="tab-pane" id="ac-income_summary" >
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
					                                     -->
					                                     
					                                     <!-- 
					                                    <div class="tab-pane" id="ac-current_assets" >
					                                    	<div class="form-group">
					                                    	
					                                    		<?php //foreach($assets as $val):?>
					                                    		<div class="checkbox">
					                                                <label class="">
					                                                    <div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_minimal">
					                                                    	<input style="position: absolute; opacity: 0;" type="checkbox" name="assets[]" value="<?php //echo $val['id'];?>">
					                                                    	<ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
					                                                    </div>
					                                                    <?php //echo $val['asset']?>
					                                                </label>
					                                            </div>
					                                    		<?php //endforeach;?>	
					                                    		
					                                        </div>
					                                    </div>
					                                    
					                                     -->
					                                    
					                                    <div class="tab-pane" id="ac-spouse_info" >
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
					                                        <!-- 
					                                        <div class="form-group">
					                                            <label>Gross income</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Gross Income" type="text" name="spouse_gross_income">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
							                                    
					                                        </div>
					                                         -->
					                                    </div>
					                                    <!-- 
					                                    <div class="tab-pane" id="ac-personal_references" >
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
					                                     -->
					                                    
					                                </div><!-- /.tab-content -->
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
													
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
                            
                            <!-- EDIT CUSTOMER MODAL -->
					        <div class="modal fade" id="edit-customer-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
					                                    <!-- <li><a href="#ec-income_summary" data-toggle="tab">Income Summary</a></li> 
					                                    <li><a href="#ec-current_assets" data-toggle="tab">Current Assets</a></li>-->
					                                    <li><a href="#ec-spouse_info" data-toggle="tab">Spouse's Info</a></li>
					                                    <!-- <li><a href="#ec-personal_references" data-toggle="tab">Personal References</a></li> -->
					                                </ul>
					                                <div class="tab-content">
					                                    <div class="tab-pane active" id="ec-personal_info" >
					                                    	<!-- customer info -->
					                                    	<div class="form-group">
						                                    	<select class="form-control" name="branch_id">
																	<?php foreach($branches as $val):?>
																		<option value="<?php echo $val['id']?>"><?php echo $val['branch_name']?></option>
																	<?php endforeach;?>
			                                            		</select>
		                                            		</div>
		                                            		<div class="form-group">
						                                    	<select class="form-control" name="area_id">
			                                            		</select>
		                                            		</div>
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
					                                            <input class="form-control" placeholder="Age" type="number" name="age" id="ec-age" readonly="readonly">
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
					                                        <div class="form-group">
					                                            <label>Type of business</label>
					                                            <input class="form-control" placeholder="Type of business" type="text" name="type_of_business">
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
					                                        <!-- 
					                                        <div class="form-group">
					                                            <div class="checkbox">
					                                            	<?php //foreach($house_type as $val):?>
					                                            		<label class="">
					                                                    <div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_minimal">
					                                                    	<input style="position: absolute; opacity: 0;" type="checkbox" id="house_type<?php //echo $val['id'];?>" name="house_type[]" value="<?php //echo $val['id'];?>">
					                                                    	<ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
					                                                    </div>
					                                                    <?php //echo $val['house_type']?>
					                                                </label>
					                                            	<?php //endforeach;?>
					                                            
					                                            </div>
					                                        </div>
					                                         -->
					                                        <div class="form-group">
					                                            <label>Residence phone</label>
					                                            <input class="form-control" placeholder="Residence phone" type="text" name="residence_phone">
					                                        </div>
					                                        <div class="form-group">
					                                            <label>Mobile phone</label>
					                                            <input class="form-control" placeholder="Mobile phone" type="text" name="mobile_phone">
					                                        </div>
					                                        <!-- 
					                                        <div class="form-group">
					                                            <label>Length of stay</label>
					                                            <input class="form-control" placeholder="Length of stay" type="text" name="length_of_stay">
					                                        </div>
					                                         -->
					                                    </div>
					                                    
					                                    <!-- 
					                                    <div class="tab-pane" id="ec-income_summary" >
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
					                                    
					                                     -->
					                                    <!-- 
					                                    <div class="tab-pane" id="ec-current_assets" >
					                                    	<div class="form-group">
					                                    		<?php //foreach($assets as $val):?>
					                                    		<div class="checkbox">
					                                                <label class="">
					                                                    <div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_minimal">
					                                                    	<input style="position: absolute; opacity: 0;" type="checkbox" id="assets<?php //echo $val['id'];?>" name="assets[]" value="<?php //echo $val['id'];?>">
					                                                    	<ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
					                                                    </div>
					                                                    <?php //echo $val['asset']?>
					                                                </label>
					                                            </div>
					                                    		<?php //endforeach;?>	
					                                    	
					                                    		
					                                        </div>
					                                    </div>
					                                     -->
					                                    
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
					                                        <!--
					                                         
					                                        <div class="form-group">
					                                            <label>Gross income</label>
					                                            <div class="input-group">
							                                        <span class="input-group-addon"><i class="fa fa-fw fa-rub"></i></span>
							                                        <input class="form-control" placeholder="Gross Income" type="text" name="spouse_gross_income">
							                                        <span class="input-group-addon">.00</span>
							                                    </div>
					                                            
					                                        </div>
					                                        
					                                         -->
					                                    </div>
					                                    <!-- 
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
								                                            <td><input class="form-control" placeholder="Age" type="number" min="0" step="1" name="cr_age1"></td>
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
								                                            <td><input class="form-control" placeholder="Age" type="number" min="0" step="1" name="cr_age2"></td>
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
								                                            <td><input class="form-control" placeholder="Age" type="number" min="0" step="1" name="cr_age3"></td>
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
								                                            <td><input class="form-control" placeholder="Age" type="number" min="0" step="1" name="cr_age4"></td>
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
								                                            <td><input class="form-control" placeholder="Age" type="number" min="0" step="1" name="cr_age5"></td>
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
					                                    -->
					                                    
					                                </div><!-- /.tab-content -->
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
												<?php if($user_info['user_type'] == 1):?>
                                       				<!-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-customer-modal"><i class="fa fa-plus-square"></i>Add Customer</button> -->
                                       				<button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Update</button>
                                       			<?php endif;?>	
					                            
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
                            
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->