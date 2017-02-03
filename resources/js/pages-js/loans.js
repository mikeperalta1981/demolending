$(function(){
	
	var customer_loan_table = $("#customer-loan-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'loans/get',
		"aoColumnDefs": [
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 6 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 7 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 8 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 9 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 10 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 12 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 15 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 16 ] }
	                    ]
	});
	//var customer_loan_payment_table = $("#customer-loan-payment-table").DataTable();
	var customer_loan_payment_table;
	

	$("#noloan").show();
	$("#customer-loan-payment-table").hide();
	$('#customer-loan-table tbody').on( 'click', 'tr', function () {
		$("#customer-loan-table tr").removeClass('selected');
		$(this).addClass('selected');
		
		var aData = customer_loan_table.fnGetData(this); // get datarow
	    if (null != aData)  // null if we clicked on title row
	    {
	    	$("#customer-loan-payment-table").show();
	    	var $loan_id = aData[0];
	    	var $mop_id = aData[1];
	    	var $mode_of_payment = aData[5];
	    	var $duration = aData[6];
	    	var $pep = aData[17];
	    	
	    	$('#btn-add-payment').data("data", {date_released: aData[13]})

	    	$(".customer_name").html(aData[3]);
	    	
	    	$("#loan_id_hidden").val($loan_id);
	    	
	    	$("#loan_details_title").html(aData[3] + " (" + aData[2] + ")")
	    	$('#add-payment-form input[name="loan_id"]').val($loan_id);
	    	$('#btn-view-soa').data("data", {
	    		loan_id: $loan_id, 
	    		customer_name: aData[3], 
	    		account_number: aData[2],
	    		loan_amount: aData[4],
	    		amortization: aData[12],
	    		date_released: aData[13],
	    		maturity_date: aData[14],
	    		mode_of_payment: $mode_of_payment
	    	});
	    	
	    	$('#btn-view-ledger').data("data", {
	    		loan_id: $loan_id, 
	    		customer_name: aData[3], 
	    		account_number: aData[2],
	    		loan_amount: aData[4],
	    		amortization: aData[12],
	    		date_released: aData[13],
	    		maturity_date: aData[14]
	    	});
	    	
	    	if($mode_of_payment=='Daily' && $duration=='100'){
	    		$('#apply_pep').prop('disabled', false);
	    		$('#apply_pep').data("data", {loan_id: $loan_id, customer_id: aData[15], customer_name: aData[3], account_number: aData[2]});
	    	}
	    	else{
	    		$('#apply_pep').prop('disabled', true);
	    	}
	    	
	    	if($mode_of_payment=='Daily'){
	    		$("#btn-view-ledger").prop('disabled', false);
	    	}
	    	else{
	    		$("#btn-view-ledger").prop('disabled', true);
	    	}
	    	
	    	customer_loan_payment_table = $("#customer-loan-payment-table").DataTable({
	    		"bDestroy": true,
	    		"bProcessing": true,
	    		//"bServerSide": true,
	    		"sServerMethod": "POST",
	    		"bFilter": false,
	    		"bSort": false,
	    		"bInfo": false,
	    		"bPaginate": false,
	    		"sAjaxSource": site_url + 'loans/get_payment_details',
	    		// "fnServerParams": function ( aoData ) {
	    		 //     aoData.push( { "name": "loan_id", "value": $loan_id } )
	    	    //},
	    	    "fnInitComplete": function(oSettings, json) {
	    	       
	    	       $("#cutoff_due").html(json.due);
	    	       $("#cutoff_overdue").html(json.overdue);
	    	       $("#cutoff_payables").html(json.payables);
	    	       $("#loan_balance").html(json.balance);
	    	       if(json.pep_startdate !=''){
	    	    	   $("#pep_startdate").html("<span>PEP Start date: <span class='loan_info'>"+json.pep_startdate+"</span></span>");   
	    	       }
	    	       else{
	    	    	   $("#pep_startdate").html('');
	    	       }
	    	       if(json.pep_enddate != ''){
	    	    	   $("#pep_enddate").html("<span>PEP End date: <span class='loan_info'>"+json.pep_enddate+"</span></span>")   
	    	       }
	    	       else{
	    	    	   $("#pep_enddate").html('');
	    	       }
	    	       
	    	       if(json.mode_of_payment == 1){
	    	    	   $("#lapses").html("<span>Payment Status: <span class='loan_info'>"+json.lapses+"</span></span>");   
	    	       }
	    	       else{
	    	    	   $("#lapses").html('');
	    	       }
	    	       
	    	       if(json.mode_of_payment == 1){
	    	    	   $("#odcounter").html("<span>OD Count: <span class='loan_info'>"+json.odcounter+"</span></span>");   
	    	       }
	    	       else{
	    	    	   $("#odcounter").html("");
	    	       }
	    	       
	    	       	    	       
	    	       if(json.overdue!='0.00' && json.mode_of_payment==1){
	    	    	   $('#apply_pep').prop('disabled', false);
	    	       }
	    	       else{
	    	    	   $('#apply_pep').prop('disabled', true);
	    	       }
	    	       
	    	       if(json.mode_of_payment==1){
	    	    	   $("#btn-view-ledger").prop('disabled', false);
	    	       }
	    	       else{
	    	    	   $("#btn-view-ledger").prop('disabled', true);
	    	       }
	    	       
	    	       	    	
	    	       $("#btn-add-payment").prop('disabled', false);
	    	       $("#btn-view-soa").prop('disabled', false);
	    	       
	    	    },
	    	    "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
	    	    	aoData.push( { "name": "loan_id", "value": $loan_id } );
	    	    	aoData.push( { "name": "mode_of_payment", "value": $mode_of_payment } );
	    	    	aoData.push( { "name": "mode_of_payment_id", "value": $mop_id } );
	    	    	aoData.push( { "name": "is_pep", "value": $pep } );
	    	        oSettings.jqXHR = $.ajax( {
	    	          "dataType": 'json',
	    	          "type": "POST",
	    	          "url": sSource,
	    	          "data": aoData,
	    	          "success": [fnCallback, updateData]
	    	        } );
	    	      }
	    	});
	    	
	    	
	    }
		
    });

	function updateData(json){
		var $due = json.due;
		var $overdue = json.overdue;
		var $payables = json.payables;
		var $balance = json.balance;
		var $totalpayments = json.totalpayments;
		var $daysleft = json.daysleft;
		var $mop = json.mode_of_payment;
		
		$("#cutoff_due").html($due);
		$("#cutoff_overdue").html($overdue);
		$("#cutoff_payables").html($payables);
		$("#loan_balance").html($balance);
		$("#cutoff_totalpayments").html($totalpayments);
		
		if($mop==1){
			$("#countdown").show();
			$("#remaining_days").show();
			$("#remaining_days").html($daysleft + " days left");
		}
		else{
			$("#countdown").hide();
			$("#remaining_days").hide();
		}
		
		
	}
	
	
	$('#add-customer-loan-modal').on('shown.bs.modal', function (e) {
		var form = $('#add-customer-loan-form');
		form[0].reset(true);
		$.ajax({
		    type: "POST",
		    url: site_url + 'customers/select_option_customers',
		    success: function(result) {
				if(result!=""){
					var $select = $('#add-customer-loan-form select[name="customer_id"]');
					$select.html('');
					$select.append(result);
		    	}
		    		
			}
		});
		
		$("#mode_of_payment").trigger('change');
	});
	
	
	//--view ledger
	$('#soa-modal').on('shown.bs.modal', function (event) {
		
	});
	
	$('#add-payment-modal').on('shown.bs.modal', function (e) {
		$("#payment_amount").numeric();
	});
	
	
	
	$('#add-customer-loan-form input[type="number"]').numeric();
	
	
	
	$('#add-customer-loan-form input[name="loan_amount"]').keyup(function(n){
		var $loan_amount = $(this).val();
		
		var $loan_term_duration = $('#add-customer-loan-form input[name="loan_term_duration"]').val();
		var $interest_pct = $('#add-customer-loan-form input[name="interest_pct"]').val();
		var $service_fee_pct = $('#add-customer-loan-form input[name="service_fee_pct"]').val();
		var $mode_of_payment = $('#add-customer-loan-form input[name="mode_of_payment"]').val();
		
		var $interest_amount = ($loan_amount * $interest_pct)/100;
		var $service_fee_amount = ($loan_amount * $service_fee_pct)/100;
		var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount;
		
		if($mode_of_payment==2){
			$loan_term_duration = $loan_term_duration * 2;
		}
		var $amortization = $loan_amount/$loan_term_duration;			
		
		
		$('#add-customer-loan-form input[name="interest_amount"]').val($interest_amount);
		$('#add-customer-loan-form input[name="service_fee_amount"]').val($service_fee_amount);
		$('#add-customer-loan-form input[name="loan_proceeds"]').val($loan_proceeds);
		$('#add-customer-loan-form input[name="amortization"]').val($amortization);
	});
	
	
	
	
	//--add customer loan
	$('#add-customer-loan-form').submit(function(e){
		e.preventDefault();
		var btn = $('#add-customer-loan-form .btn_submit'),
		url = site_url + 'loans/create',
		form = $(this),
		form_data = $(this).serializeArray();
		btn.button('loading');					

		$.post(url, form_data, function(response){
			var obj = $.parseJSON(response);
			btn.button('reset');
			
			if(obj.success)
			{
				customer_loan_table.fnReloadAjax();
				form[0].reset(true);
				//$('input').iCheck('uncheck');
				$('#add-customer-loan-modal').modal('hide');
				$('.alert_create_loan').html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Well done!</strong> Loan created successfully.</span></div></div>');
				
			}
		});
	});
	
	$( "#date_released" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});
	
	$( "#payment_date" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});
	
	
	//add loan payments
	$("#btn-add-payment").on('click', function(){
		$('#add-payment-modal').modal('show');
		$( "#payment_date" ).datepicker("setStartDate", $(this).data('data').date_released);
	});
	
	//view soa
	$("#btn-view-soa").on('click', function(){
		$loan_id = $(this).data('data').loan_id;
		$("#soa-customer-name").html($(this).data('data').customer_name);
		$("#soa-account-number").html($(this).data('data').account_number);
		$("#soa-loan-amount").html($(this).data('data').loan_amount);
		$("#soa-amortization").html($(this).data('data').amortization);
		$("#soa-date-released").html($(this).data('data').date_released);
		$("#soa-maturity-date").html($(this).data('data').maturity_date);
		/*if($(this).data('data').mode_of_payment=='Daily'){
			$("#payment-status").html($("#lapses .loan_info").html());
		}
		else{
			$("#ps").html('');
		}*/
		
		$('#soa_loan_id').val($loan_id);
		
		var $total_loan_amount = $(this).data('data').loan_amount;
		
		$.ajax({
		    type: "POST",
		    url: site_url + 'loans/get_loan_payments',
		    data: {
		    	"loan_id": $loan_id
		    },
		    success: function(result) {
		    	var $obj = $.parseJSON(result)
		    	var $html = "";
		    	var $total_payments = 0;
		    	var $outstanding_balance = 0;
		    	
				if($obj.length>0){
					$.each($obj, function(obj, ele){
						$html += '<tr>';
						$html += '<td>' + ele.payment_date;
						$html += '</td>';
						$html += '<td>' + number_format(ele.amount, 2, '.', ',');
						$html += '</td>';
						$html += '</tr>';
						$total_payments += parseFloat(ele.amount);
					});
					
					$outstanding_balance = parseFloat($total_loan_amount) - $total_payments;
					
					$("#payment-record").html($html);
					$("#total-payments").html("Php " + number_format($total_payments, 2, '.', ','));
					$("#outstanding-balance").html("<strong>Php " + number_format($outstanding_balance, 2, '.', ',') + "</strong>");
					
					$('#soa-modal').modal('show');
		    	}
				else{
					alert('No payments made yet.')
				}
		    		
			}
		});
		
	})
	
	//view ledger
	$("#btn-view-ledger").on('click', function(){
		$loan_id = $(this).data('data').loan_id;
		$customer_name = $(this).data('data').customer_name;
		$account_number = $(this).data('data').account_number;
		$loan_amount = $(this).data('data').loan_amount;
		$amortization = $(this).data('data').amortization;
		$date_released = $(this).data('data').date_released;
		$maturity_date = $(this).data('data').maturity_date;
		$total_loan_amount = $(this).data('data').loan_amount;
		
		$.ajax({
		    type: "POST",
		    url: site_url + 'loans/get_ledger',
		    data: {
		    	"loan_id": $loan_id
		    },
		    success: function(result) {
		    	if(result){
					var $obj = $.parseJSON(result);
					$("#tbl-payment-summary-tbody").html($obj.tbldata);
					$("#ledger-due").html($obj.due);
					$("#ledger-overdue").html($obj.overdue);
					$("#ledger-total-payments").html($obj.totalpayments);
					$("#ledger-payables").html($obj.payables);
					$("#ledger-balance").html($obj.balance);
					$("#ledger-countdown").html($obj.remainingdays);
					
					var $months_options = "";
					$.each($obj.months, function(o, e){
						if($obj.currmonth==e){
							$months_options += "<option value='"+e+"' selected>"+e+"</option>";
						}
						else{
							$months_options += "<option value='"+e+"'>"+e+"</option>";
						}
						
					})
					$("#cutoff_months").html($months_options);
					
					var $days_options = "";
					$.each($obj.days, function(o, e){
						if($obj.currcutoff==o){
							//$months_options = "<option value='"+o.start_date+"' selected>"+o+"</option>";
							$days_options += "<option value='"+e+"' selected>"+o+"</option>";
						}
						else{
							$days_options += "<option value='"+e+"'>"+o+"</option>";
						}
						
					})
					$("#cutoff_days").html($days_options)
					
					$('#ledger-modal').modal('show');
		    	}
				/*else{
					alert('No payments made yet.')
				}*/
		    		
			}
		});
		
	})
	
	$("#cutoff_months").change(function(n){
		var $year_month = $(this).val();
		var $days = $("#cutoff_days").val();
		var $loan_id = $("#loan_id_hidden").val();
		
		$.ajax({
		    type: "POST",
		    url: site_url + 'loans/get_ledger',
		    data: {
		    	"loan_id": $loan_id,
		    	"year_month": $year_month,
		    	"days": $days
		    },
		    success: function(result) {
		    			    	
		    	var $obj = $.parseJSON(result);
				$("#tbl-payment-summary-tbody").html($obj.tbldata);
				$("#ledger-due").html($obj.due);
				$("#ledger-overdue").html($obj.overdue);
				$("#ledger-total-payments").html($obj.totalpayments);
				$("#ledger-payables").html($obj.payables);
				$("#ledger-balance").html($obj.balance);
				$("#ledger-countdown").html($obj.remainingdays);
					
			}
		});
		
		
	})
	
	$("#cutoff_days").change(function(n){
		var $year_month =$("#cutoff_months").val();
		var $days = $(this).val();
		var $loan_id = $("#loan_id_hidden").val();
		
		$.ajax({
		    type: "POST",
		    url: site_url + 'loans/get_ledger',
		    data: {
		    	"loan_id": $loan_id,
		    	"year_month": $year_month,
		    	"days": $days
		    },
		    success: function(result) {
		    			    	
		    	var $obj = $.parseJSON(result);
				$("#tbl-payment-summary-tbody").html($obj.tbldata);
				$("#ledger-due").html($obj.due);
				$("#ledger-overdue").html($obj.overdue);
				$("#ledger-total-payments").html($obj.totalpayments);
				$("#ledger-payables").html($obj.payables);
				$("#ledger-balance").html($obj.balance);
				$("#ledger-countdown").html($obj.remainingdays);
					
			}
		});
	})
	
	
	//--add customer loan
	$('#add-payment-form').submit(function(e){
		e.preventDefault();
		if(confirm('Are you sure?')){
			
			var btn = $('#add-payment-form .btn_submit'),
			url = site_url + 'loans/payments',
			form = $(this),
			form_data = $(this).serializeArray();
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				btn.button('reset');
				
				if(obj.success)
				{
					customer_loan_payment_table.fnReloadAjax();
					customer_loan_table.fnReloadAjax();
					$('#add-payment-modal').modal('hide');
					$('.alert_payment').html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Well done!</strong> Payment posting success.</span></div></div>');
				}
				else
				{
					
				}
			});
		}
		
	});
	
	$("#mode_of_payment").change(function(){
		$.ajax({
		    type: "POST",
		    data: {"mode_of_payment_id": $(this).val()},
		    url: site_url + 'loans/get_loan_terms',
		    success: function(result) {
				if(result){
					$("#loan_term").html(result);
					$("#loan_term").trigger('change');
				}
			}
		});
	})
	
	$("#loan_term").change(function(){
		$.ajax({
		    type: "POST",
		    data: {"loan_term_id": $(this).val()},
		    url: site_url + 'loans/get_loan_terms',
		    success: function(result) {
				if(result){
					var obj = $.parseJSON(result);
					$('#add-customer-loan-form input[name="interest_pct"]').val(obj.term_pct);
					$('#add-customer-loan-form input[name="loan_term_duration"]').val(obj.term_duration);
					compute_loan()
				}
			}
		});
		
		
		
	})
	
	
	$('#add-customer-loan-form select[name="customer_id"]').change(function(){
		$.ajax({
		    type: "POST",
		    data: {"id": $(this).val()},
		    url: site_url + 'loans/check_customer_loan',
		    success: function(result) {
		    	var obj = $.parseJSON(result);
				if(obj.success){
					if(obj.datacount>0){
						$(".alert_loan_exists").html('<div class="col-xs-12"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Opps!</strong> This customer has an active loan.</span></div></div>');
						$("#btn_save_loan").prop('disabled', true);
					}
					else{
						$(".alert_loan_exists").html('');
						$("#btn_save_loan").prop('disabled', false);
					}
				}
			}
		});
	})

	function compute_loan(){
		var $loan_amount = $('#add-customer-loan-form input[name="loan_amount"]').val();
		var $loan_term = $('#loan_term').val();
		var $loan_term_text = $('#add-customer-loan-form input[name="loan_term"]').text();
		var $loan_term_duration = $('#add-customer-loan-form input[name="loan_term_duration"]').val();
		var $interest_pct = $('#add-customer-loan-form input[name="interest_pct"]').val();
		var $service_fee_pct = $('#add-customer-loan-form input[name="service_fee_pct"]').val();
		var $mode_of_payment = $('#mode_of_payment').val();
		
		var $interest_amount = ($loan_amount * $interest_pct)/100;
		var $service_fee_amount = ($loan_amount * $service_fee_pct)/100;
		var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount;

		//PAYMENT ON THE 15TH OR 30TH
		if($mode_of_payment==2){
			$loan_term_duration = $loan_term_duration * 2;
		}
		var $amortization = Math.ceil($loan_amount/$loan_term_duration);			
		
		$('#add-customer-loan-form input[name="interest_amount"]').val($interest_amount);
		$('#add-customer-loan-form input[name="service_fee_amount"]').val($service_fee_amount);
		$('#add-customer-loan-form input[name="loan_proceeds"]').val($loan_proceeds);
		$('#add-customer-loan-form input[name="amortization"]').val($amortization);
	}
	
	$("#apply_pep").click(function(){
		if(typeof $(this).data('data') !=='undefined'){
			
			$loan_id = $(this).data('data').loan_id;
			$customer_id = $(this).data('data').customer_id;
			
			bootbox.dialog({
	                title: "Applicatin of PEP for " + $(this).data('data').customer_name + ".",
	                message: '<div class="row">  ' +
	                    '<div class="col-md-12"> ' +
	                    '<form class="form-horizontal"> ' +
	                    '<div class="form-group"> ' +
	                    '<label class="col-md-4 control-label" for="name">Start Date</label> ' +
	                    '<div class="col-md-4"> ' +
	                    '<input class="form-control" placeholder="Start Date" type="text" name="pep_start_date" id="pep-start-date" required>' +
	                    '</div> ' +
	                    '</form> </div>  </div>',
	                buttons: {
	                    success: {
	                        label: "Apply",
	                        className: "btn-primary",
	                        callback: function () {
	                        	$.ajax({
	    						    type: "POST",
	    						    url: site_url + 'loans/apply_pep',
	    						    data:{
	    						    	'loan_id': $loan_id,
	    						    	'pep_start_date': $("#pep-start-date").val(),
	    						    	'customer_id': $customer_id
	    						    },
	    						    success: function(res) {
	    						    	customer_loan_table.fnReloadAjax();
	    						    	//customer_loan_payment_table.fnReloadAjax();
	    						    	$("#loan_details_title").html('-None Selected-');
	    						    	$("#cutoff_due").html('-');
	    						    	$("#cutoff_overdue").html('-');
	    						    	$("#cutoff_totalpayments").html('-');
	    						    	$("#pep_startdate").html('');
	    						    	$("#lapses").html('');
	    						    	$("#cutoff_payables").html('-');
	    						    	$("#loan_balance").html('-');
	    						    	$("#remaining_days").html('SOON...');
	    						    	$("#pep_enddate").html('');
	    						    	
	    						    	$(".alert_create_pep").html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_pep_msg_msg"><strong>Well done!</strong> Loan was successfully transfered to PEP.</span></div></div>');
	    						    	
	    								$("#apply_pep").prop('disabled', true);
	    								$("#btn-add-payment").prop('disabled', true);
	    								$("#btn-view-soa").prop('disabled', true);
	    								$("#btn-view-ledger").prop('disabled', true);
	    							}
	    						});
	                        }
	                    }
	                }
	            }
	        );
			$( "#pep-start-date" ).datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
				todayBtn: true,
				todayHighlight: true
			});
		}
		else{
			bootbox.alert("Please select loan on the list.");
		}
		
	})
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.loan_grouping").addClass('active');
	$("ul.sidebar-menu>li.loan_grouping>ul.treeview-menu").css('display', 'block');
	$("ul.sidebar-menu>li.loan_details").addClass('active');
	$("#detail_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
});	


function number_format(number, decimals, dec_point, thousands_sep) {
	  //  discuss at: http://phpjs.org/functions/number_format/
	  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // improved by: davook
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Theriault
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // bugfixed by: Michael White (http://getsprink.com)
	  // bugfixed by: Benjamin Lupton
	  // bugfixed by: Allan Jensen (http://www.winternet.no)
	  // bugfixed by: Howard Yeend
	  // bugfixed by: Diogo Resende
	  // bugfixed by: Rival
	  // bugfixed by: Brett Zamir (http://brett-zamir.me)
	  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  //  revised by: Luke Smith (http://lucassmith.name)
	  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
	  //    input by: Jay Klehr
	  //    input by: Amir Habibi (http://www.residence-mixte.com/)
	  //    input by: Amirouche
	  //   example 1: number_format(1234.56);
	  //   returns 1: '1,235'
	  //   example 2: number_format(1234.56, 2, ',', ' ');
	  //   returns 2: '1 234,56'
	  //   example 3: number_format(1234.5678, 2, '.', '');
	  //   returns 3: '1234.57'
	  //   example 4: number_format(67, 2, ',', '.');
	  //   returns 4: '67,00'
	  //   example 5: number_format(1000);
	  //   returns 5: '1,000'
	  //   example 6: number_format(67.311, 2);
	  //   returns 6: '67.31'
	  //   example 7: number_format(1000.55, 1);
	  //   returns 7: '1,000.6'
	  //   example 8: number_format(67000, 5, ',', '.');
	  //   returns 8: '67.000,00000'
	  //   example 9: number_format(0.9, 0);
	  //   returns 9: '1'
	  //  example 10: number_format('1.20', 2);
	  //  returns 10: '1.20'
	  //  example 11: number_format('1.20', 4);
	  //  returns 11: '1.2000'
	  //  example 12: number_format('1.2000', 3);
	  //  returns 12: '1.200'
	  //  example 13: number_format('1 000,50', 2, '.', ' ');
	  //  returns 13: '100 050.00'
	  //  example 14: number_format(1e-8, 8, '.', '');
	  //  returns 14: '0.00000001'

	  number = (number + '')
	    .replace(/[^0-9+\-Ee.]/g, '');
	  var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function (n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + (Math.round(n * k) / k)
	        .toFixed(prec);
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
	    .split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
	    .length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1)
	      .join('0');
	  }
	  return s.join(dec);
	}