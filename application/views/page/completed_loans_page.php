 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Completed Loans
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
                        <div class="col-xs-12">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Customers Loan Information</h3>
                                    <div class="box-tools pull-right">
                                       	<!-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-customer-loan-modal"><i class="fa fa-plus-square"></i> Add Loan</button>
                                       	<button class="btn btn-primary btn-sm" id="apply_pep" disabled="disabled"><i class="fa fa-pencil"></i> Apply PEP</button> -->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="customer-loan-table" class="table table-bordered table-striped" width="100%">
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
                                                <th>Date Completed</th>
                                                <th>Payment Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div><!-- row -->
					
					<input type="hidden" id="loan_id_hidden">
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

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
				                        	Maturity Date: <strong id="soa-maturity-date"></strong><br>
				                        	Date Completed: <strong id="soa-date_completed"></strong><br>
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
				                            <!-- 
				                            <form id="soa_form" action="loans/generate_soa" method="post">
				                            <input name="soa_loan_id" type="hidden" id="soa_loan_id">
				                            <button class="btn btn-primary pull-right" type="submit" style="margin-right: 5px;" id="generate-pdf"><i class="fa fa-download"></i> Generate PDF</button>
				                            </form>
				                             -->
				                        </div>
				                    </div>
				                </section><!-- /.content -->
				            </aside><!-- /.right-side -->
                                </div>
	                        </div>
		                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
