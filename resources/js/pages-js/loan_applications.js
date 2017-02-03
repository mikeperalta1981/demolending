var customer_loan_table;
$.fn.bootstrapSwitch.defaults.size = 'normal';
$.fn.bootstrapSwitch.defaults.onColor = 'success';
$(function(){

	
	$('#adduseMututalAid').bootstrapSwitch();
	$('#edituseMututalAid').bootstrapSwitch();
	$('#edituseMututalAid').bootstrapSwitch('disabled',true);
	var stateValue = $("#adduseMututalAid").is(":checked") ? true : false;

	$('#adduseMututalAid').on('switchChange.bootstrapSwitch', function(event, state) {
		  compute_loan('add', state);
		  stateValue = state;
		  if(state){
		  		$('#add-customer-loan-form input[name=mutual_aid]').prop('disabled', false)
		  }
		  else{
		  		$('#add-customer-loan-form input[name=mutual_aid]').prop('disabled', false)
				
		  }
	});

	$('#edituseMututalAid').on('switchChange.bootstrapSwitch', function(event, state) {
		  compute_loan('edit', state);
		  stateValue = state;
		  if(state){
		  		$('#edit-customer-loan-form input[name=mutual_aid]').prop('disabled', false)
		  }
		  else{
		  		$('#edit-customer-loan-form input[name=mutual_aid]').prop('disabled', false)
				
		  }
	});

	customer_loan_table = $("#customer-loan-application-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'loan_applications/get',
		"aoColumnDefs": [
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 6 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 7 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 8 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 9 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 10 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 15 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 16 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 17 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 20 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 22 ] }
	                    ]
	});
	
	$('#add-customer-loan-modal select[name=customer_id').select2({
		placeholder: 'Select Customer'
	}).on("change", function() {
		//alert($(this).val())
	});

	$('#generate-contract').prop('disabled', true);
	$('#generate-cheque').prop('disabled', true);
	$('#btn-view-voucher').prop('disabled', true);
	
	$('#customer-loan-application-table tbody').on( 'click', 'tr', function () {
		
		$('#generate-contract').prop('disabled', false);
		$('#generate-cheque').prop('disabled', false);
		$('#btn-view-voucher').prop('disabled', false);
		$('#generate-contract').hide();

		$("#customer-loan-application-table tr").removeClass('selected');
		$(this).addClass('selected');
		
		var aData = customer_loan_table.fnGetData(this); // get datarow
		
	    if (null != aData)  // null if we clicked on title row
	    {
	    	
	    	$('#btn-view-voucher').data("data", {
	    		loan_id: aData[0],
	    		customer_name: aData[3], 
	    		account_number: aData[2],
	    		loan_amount: aData[4],
	    		net_proceeds: aData[11],
	    		interest_amount: aData[8],
	    		service_fee: aData[10],
	    		address: aData[20],
	    	});
	    	
	    	$("#contract_loan_id").val(aData[0]);
	    	$("#contract_loan_id1").val(aData[0]);
	    	$("#contract_loan_id2").val(aData[0]);
	    	$("#cheque_loan_id").val(aData[0]);
	    	
	    	
	    	if(aData[22]==2){
	    		$('#generate-contract').show();
	    	}
	    	else{
	    		$('#generate-contract').hide();
	    	}
	    	
	    	/*$('#generate-contract').data("data", {
	    		loan_id: aData[0],
	    		customer_name: aData[3], 
	    		account_number: aData[2],
	    		loan_amount: aData[4],
	    		net_proceeds: aData[11],
	    		interest_amount: aData[8],
	    		service_fee: aData[10],
	    		address: aData[20],
	    	});*/
	    	
	    }
		
    });
	
	$("#btn-view-voucher").on('click', function(){
		$loan_id = $(this).data('data').loan_id;
		$(".customer_name").html($(this).data('data').customer_name);
		$(".voucher_account_no").html($(this).data('data').account_number);
		$(".customer_address").html($(this).data('data').address);
		$(".voucher_cheque_no").html("-");
		$(".voucher_loan_amount").html($(this).data('data').loan_amount);
		$(".voucher_net_proceeds").html($(this).data('data').net_proceeds);
		$(".voucher_interest").html($(this).data('data').interest_amount);
		$(".voucher_service_fee").html($(this).data('data').service_fee);
		
		$('#voucher_loan_id').val($loan_id);
				
	})
	
	
	
	
	$('#add-customer-loan-modal').on('shown.bs.modal', function (e) {
		var form = $('#add-customer-loan-form');
		form[0].reset(true);
		$.ajax({
		    type: "POST",
		    url: site_url + 'customers/select_option_customers_add',
		    success: function(result) {
				if(result!=""){
					var $select = $('#add-customer-loan-form select[name="customer_id"]');
					$select.html('');
					$select.append(result);
		    	}
		    		
			}
		});
		
		$('#add-customer-loan-form select[name="mode_of_payment"]').trigger('change');

	});
	
	
	$('#edit-customer-loan-modal').on('shown.bs.modal', function (e) {
		var loan_id = $("#loan_id").val();
		
		var form = $('#edit-customer-loan-form');
		
		/*$.ajax({
		    type: "POST",
		    url: site_url + 'customers/select_option_customers',
		    success: function(result) {
				if(result!=""){
					var $select = $('#edit-customer-loan-form select[name="customer_id"]');
					$select.html('');
					$select.append(result);
		    	}
		    		
			}
		});*/
		
		$('#edit-customer-loan-form select[name="mode_of_payment"]').trigger('change');
		
		
		$.post("loan_applications/edit", { loan_id: loan_id }, function( data ) {
			
			var form_elements = $("#edit-customer-loan-form").find(":input");
			var result = $.parseJSON(data);
			
			for(var i=1; i<=10; i++){
				$('input[name="brand'+ i + '"]').val('');
				$('input[name="make'+ i + '"]').val('');
				$('input[name="serial'+ i + '"]').val('');
			}
			
			$.each(form_elements, function(obj, ele){
								
				if(typeof result.data[ele.name] != 'undefined'){
					if(ele.name=='mode_of_payment'){
						ele.value = result.data['mopid'];
					}

					else{
						ele.value = result.data[ele.name];

					}
				}
				
				
				
			})
			
			if(result.data['application_status']==2){
				$('#edit-customer-loan-form select[name="customer_id"]').prop('disabled', true);
				$('#edit-customer-loan-form select[name="loan_type"]').prop('disabled', true);
				$('#edit-customer-loan-form input[name="loan_amount"]').prop('disabled', true);
				$('#edit-customer-loan-form input[name="loan_amount"]').prop('disabled', true);
				$('#edit-customer-loan-form select[name="mode_of_payment"]').prop('disabled', true);
				$('#edit-customer-loan-form select[name="loan_term"]').prop('disabled', true);
			}
			else{
				$('#edit-customer-loan-form select[name="customer_id"]').prop('disabled', false);
				$('#edit-customer-loan-form select[name="loan_type"]').prop('disabled', false);
				$('#edit-customer-loan-form input[name="loan_amount"]').prop('disabled', false);
				$('#edit-customer-loan-form input[name="loan_amount"]').prop('disabled', false);
				$('#edit-customer-loan-form select[name="mode_of_payment"]').prop('disabled', false);
				$('#edit-customer-loan-form select[name="loan_term"]').prop('disabled', false);
			}
			
		});

		
	});
	
	
	$('#add-customer-loan-form input[type="number"]').numeric();
	$('#edit-customer-loan-form input[type="number"]').numeric();
	
	$('#add-customer-loan-form input[name="loan_amount"]').keyup(function(n){
		compute_loan('add', stateValue);
		/*var $loan_amount = $(this).val();
		
		var $loan_term_duration = $('#add-customer-loan-form input[name="loan_term_duration"]').val();
		var $interest_pct = $('#add-customer-loan-form input[name="interest_pct"]').val();

		var $notarial_fee = 0;
		$.post(site_url + 'loan_applications/get_notarial_fee', {'loan_amount': $loan_amount}, function(response){
			var obj = $.parseJSON(response);
			
			$('#add-customer-loan-form input[name="service_fee_amount"]').val(obj.notarial_fee);
			$notarial_fee = obj.notarial_fee;

			var $loan_amount_per_thousand = Math.floor($loan_amount/1000);
			var $mutual_aid = 0;

			if($loan_amount_per_thousand >= 1){
				$mutual_aid = ($loan_amount_per_thousand * .5) * 4;
			}

			$('#add-customer-loan-form input[name="mutual_aid"]').val($mutual_aid);

			//var $service_fee_pct = $('#add-customer-loan-form input[name="service_fee_pct"]').val();
			var $mode_of_payment = $('#add-customer-loan-form input[name="mode_of_payment"]').val();
			
			var $interest_amount = ($loan_amount * $interest_pct)/100;
			//var $service_fee_amount = ($loan_amount * $service_fee_pct)/100;
			var $service_fee_amount = $notarial_fee;

			var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount - $mutual_aid;
			//var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount;
			
			
			

			var $amortization = $loan_amount/$loan_term_duration;			
			
			
			$('#add-customer-loan-form input[name="interest_amount"]').val($interest_amount);
			$('#add-customer-loan-form input[name="service_fee_amount"]').val($service_fee_amount);
			$('#add-customer-loan-form input[name="loan_proceeds"]').val($loan_proceeds);
			$('#add-customer-loan-form input[name="amortization"]').val($amortization);
		});*/
	
		//console.log($notarial_fee);
		
	});
	
	$('#edit-customer-loan-form input[name="loan_amount"]').keyup(function(n){
		var $loan_amount = $(this).val();
		
		var $loan_term_duration = $('#edit-customer-loan-form input[name="loan_term_duration"]').val();
		var $interest_pct = $('#edit-customer-loan-form input[name="interest_pct"]').val();

		var $notarial_fee = 0;
		$.post(site_url + 'loan_applications/get_notarial_fee', {'loan_amount': $loan_amount}, function(response){
			var obj = $.parseJSON(response);
			
			$('#edit-customer-loan-form input[name="service_fee_amount"]').val(obj.notarial_fee);
			$notarial_fee = obj.notarial_fee;

			var $loan_amount_per_thousand = Math.floor($loan_amount/1000);
			var $mutual_aid = 0;

			if($loan_amount_per_thousand >= 1){
				$mutual_aid = ($loan_amount_per_thousand * .5) * 4;
			}

			$('#edit-customer-loan-form input[name="mutual_aid"]').val($mutual_aid);

			//var $service_fee_pct = $('#edit-customer-loan-form input[name="service_fee_pct"]').val();
			var $mode_of_payment = $('#edit-customer-loan-form input[name="mode_of_payment"]').val();
			
			var $interest_amount = ($loan_amount * $interest_pct)/100;

			//var $service_fee_amount = ($loan_amount * $service_fee_pct)/100;
			var $service_fee_amount = $notarial_fee;

			//var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount - $mutual_aid;
			var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount;
			
			if($mode_of_payment==2){
				$loan_term_duration = $loan_term_duration * 2;
			}
			var $amortization = $loan_amount/$loan_term_duration;			
			
			
			$('#edit-customer-loan-form input[name="interest_amount"]').val($interest_amount);
			$('#edit-customer-loan-form input[name="service_fee_amount"]').val($service_fee_amount);
			$('#edit-customer-loan-form input[name="loan_proceeds"]').val($loan_proceeds);
			$('#edit-customer-loan-form input[name="amortization"]').val($amortization);


		});
	

		
	});
	
	
	
	
	//--add customer loan
	$('#add-customer-loan-form').submit(function(e){
		e.preventDefault();
		var btn = $('#add-customer-loan-form .btn_submit'),
		url = site_url + 'loan_applications/create',
		form = $(this),
		form_data = $(this).serializeArray();
		
		var $customer_id = $('#add-customer-loan-modal select[name=customer_id').val();
		if($customer_id!=''){
			if(confirm('Save this loan?')){
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
			}
		}
		else{
			alert('Please select customer');
			btn.button('reset');
		}
		
		
	});
	
	//--update customer loan
	$('#edit-customer-loan-form').submit(function(e){
		e.preventDefault();
		var btn = $('#edit-customer-loan-form .btn_submit'),
		url = site_url + 'loan_applications/update',
		form = $(this),
		form_data = $(this).serializeArray();
		

		if(confirm('Update this loan?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				btn.button('reset');
				
				if(obj.success)
				{
					customer_loan_table.fnReloadAjax();
					form[0].reset(true);
					//$('input').iCheck('uncheck');
					$('#edit-customer-loan-modal').modal('hide');
					$('.alert_create_loan').html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Well done!</strong> Loan updated successfully.</span></div></div>');
					
				}
			});
		}
		
	});
	
	
	$('#add-customer-loan-form select[name="mode_of_payment"]').change(function(){
	//$("#mode_of_payment").change(function(){
		$.ajax({
		    type: "POST",
		    data: {"mode_of_payment_id": $(this).val()},
		    url: site_url + 'loan_applications/get_loan_terms',
		    success: function(result) {
				if(result){
					$('#add-customer-loan-form select[name="loan_term"]').html(result);
					$('#add-customer-loan-form select[name="loan_term"]').trigger('change');
				}
			}
		});
	})
	
	$('#edit-customer-loan-form select[name="mode_of_payment"]').change(function(){

		$.ajax({
		    type: "POST",
		    data: {"mode_of_payment_id": $(this).val()},
		    url: site_url + 'loan_applications/get_loan_terms',
		    success: function(result) {
				if(result){
					$('#edit-customer-loan-form select[name="loan_term"]').html(result);
					$('#edit-customer-loan-form select[name="loan_term"]').trigger('change');
				}
			}
		});
	})
	
	/*$('#add-customer-loan-form select[name="loan_term"]').change(function(){
		$.ajax({
		    type: "POST",
		    data: {"loan_term_id": $(this).val()},
		    url: site_url + 'loan_applications/get_loan_terms',
		    success: function(result) {
				if(result){
					var obj = $.parseJSON(result);
					$('#add-customer-loan-form input[name="interest_pct"]').val(obj.term_pct);
					$('#add-customer-loan-form input[name="loan_term_duration"]').val(obj.term_duration);
					compute_loan('add');
				}
			}
		});
	})*/
	
	/*$('#edit-customer-loan-form select[name="loan_term"]').change(function(){
		$.ajax({
		    type: "POST",
		    data: {"loan_term_id": $(this).val()},
		    url: site_url + 'loan_applications/get_loan_terms',
		    success: function(result) {
				if(result){
					var obj = $.parseJSON(result);
					$('#edit-customer-loan-form input[name="interest_pct"]').val(obj.term_pct);
					$('#edit-customer-loan-form input[name="loan_term_duration"]').val(obj.term_duration);
					compute_loan('edit');
				}
			}
		});
	});*/
	
	/**
	 * renew loan
	 */
	$('#add-customer-loan-form select[name="loan_type"], #add-customer-loan-form select[name="customer_id"]').change(function(){
		
		if($('#add-customer-loan-form select[name="loan_type"]').val()=='renew' && $('#add-customer-loan-form select[name="customer_id"]').val()!=''){
			$.ajax({
			    type: "POST",
			    data: {
			    	"customer_id": $('#add-customer-loan-form select[name="customer_id"]').val()
			    },
			    url: site_url + 'loan_applications/renew_loan',
			    success: function(result) {
			    	var obj = $.parseJSON(result);
					if(obj.success){
						if(typeof obj.loan_info !== 'undefined'){
							console.log(obj.loan_info);
							var form_elements = $("#add-customer-loan-form").find(":input");
							var $mop = {
								'Daily':1,
								'Semi-monthly':2,
								'Monthly':3
							};	
							
							$.each(obj.loan_info, function($a, $b){
								
								if($a=='mode_of_payments'){
									$b = $mop[$b];
								}
								
								if($("#add-customer-loan-form input[name='"+$a+"']")){
									$("#add-customer-loan-form input[name='"+$a+"']").val($b);
								}
							})
							
							var $i=1;
							
							$.each(obj.loan_info['collaterals'], function($c, $d){
								$.each($d, function($e, $f){
								
								if($("#add-customer-loan-form input[name='"+$e + $i+"']")){
									$("#add-customer-loan-form input[name='"+$e + $i+"']").val($f);
								}
									
								
								})
								$i++;
							})
							
							/*$("#add-customer-loan-form input[name='loan_amount']").val(obj.loan_info['loan_amount']);
							$("#add-customer-loan-form select[name='mode_of_payment']").val(obj.loan_info['mopid']);
							$("#add-customer-loan-form select[name='loan_term']").val(obj.loan_info['loan_term']);
							$("#add-customer-loan-form input[name='loan_proceeds']").val(obj.loan_info['loan_proceeds']);
							$("#add-customer-loan-form input[name='amortization']").val(obj.loan_info['amortization']);
							$("#add-customer-loan-form input[name='id_presented']").val(obj.loan_info['id_presented']);
							$("#add-customer-loan-form input[name='loan_purpose']").val(obj.loan_info['loan_purpose']);
							$("#add-customer-loan-form input[name='collateral']").val(obj.loan_info['collateral']);*/
							
							/*$.each(form_elements, function(obj, ele){
								
								var item_value = obj.loan_info[ele.name];
								if(ele.name=='mode_of_payment'){
									ele.value = obj.loan_info['mopid'];
								}
								else if(ele.name=='loan_id'){
									ele.value = '';
								}
								else{
									ele.value = obj.loan_info[ele.name];
								}
								
								
							})*/
						}
						else{
							alert(obj.message);	
							$("#add-customer-loan-form input[name='loan_amount']").val('');
							$("#add-customer-loan-form select[name='mode_of_payment']").val('');
							$("#add-customer-loan-form select[name='loan_term']").val('1');
							$("#add-customer-loan-form input[name='loan_proceeds']").val('0');
							$("#add-customer-loan-form input[name='amortization']").val('0');
							$("#add-customer-loan-form input[name='id_presented']").val('');
							$("#add-customer-loan-form input[name='loan_purpose']").val('');
							$("#add-customer-loan-form input[name='collateral']").val('');
						}
						
					}
				}
			});
		}
		else{
			if($('#add-customer-loan-form select[name="loan_type"]').val()=='new'){
				$("#add-customer-loan-form input[name='loan_amount']").val('');
				//$("#add-customer-loan-form select[name='mode_of_payment']").val('');
				$("#add-customer-loan-form select[name='loan_term']").val('1');
				$("#add-customer-loan-form input[name='loan_proceeds']").val('0');
				$("#add-customer-loan-form input[name='amortization']").val('0');
				$("#add-customer-loan-form input[name='id_presented']").val('');
				$("#add-customer-loan-form input[name='loan_purpose']").val('');
				$("#add-customer-loan-form input[name='collateral']").val('');
			}
		}
	});
	
	
	$('#add-customer-loan-form select[name="customer_id"], #edit-customer-loan-form select[name="customer_id"]').change(function(){
		$.ajax({
		    type: "POST",
		    data: {"id": $(this).val()},
		    url: site_url + 'loan_applications/check_customer_loan',
		    success: function(result) {
		    	var obj = $.parseJSON(result);
				if(obj.success){
					if(obj.datacount>0){
						$(".alert_loan_exists").html('<div class="col-xs-12"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Opps!</strong> This customer has an active loan.</span></div></div>');
						$(".btn_save_loan").prop('disabled', true);
					}
					else{
						$(".alert_loan_exists").html('');
						$(".btn_save_loan").prop('disabled', false);
					}
				}
			}
		});
	})
	
	


	function compute_loan(loan_action, useMutualAid){
		var $loan_amount = $('#'+loan_action+'-customer-loan-form input[name="loan_amount"]').val();
		//var $loan_term = $('#loan_term').val();
		var $loan_term = $('#'+loan_action+'-customer-loan-form select[name="loan_term"]').val();
		var $loan_term_text = $('#'+loan_action+'-customer-loan-form input[name="loan_term"]').text();
		var $loan_term_duration = $('#'+loan_action+'-customer-loan-form input[name="loan_term_duration"]').val();
		var $interest_pct = $('#'+loan_action+'-customer-loan-form input[name="interest_pct"]').val();

		var $notarial_fee = 0;
		//alert($('#'+loan_action+'-customer-loan-form input[name="loan_amount"]').val());

		$.post(site_url + 'loan_applications/get_notarial_fee', {'loan_amount': $loan_amount}, function(response){
				var obj = $.parseJSON(response);
			
			$('#'+ loan_action + '-customer-loan-form input[name="service_fee_amount"]').val(obj.notarial_fee);
			$notarial_fee = obj.notarial_fee;

			var $loan_amount_per_thousand = Math.floor($loan_amount/1000);
			var $mutual_aid = 0;

			if(useMutualAid){
				if($loan_amount_per_thousand >= 1){
					$mutual_aid = ($loan_amount_per_thousand * .5) * 4;
				}	
			}
			

			$('#'+ loan_action + '-customer-loan-form input[name="mutual_aid"]').val($mutual_aid);

			//var $service_fee_pct = $('#add-customer-loan-form input[name="service_fee_pct"]').val();
			var $mode_of_payment = $('#'+ loan_action + '-customer-loan-form input[name="mode_of_payment"]').val();
			
			var $interest_amount = ($loan_amount * $interest_pct)/100;
			//var $service_fee_amount = ($loan_amount * $service_fee_pct)/100;
			var $service_fee_amount = $notarial_fee;

			if(useMutualAid){
				var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount - $mutual_aid;	
			}
			else{
				var $loan_proceeds = $loan_amount - $interest_amount - $service_fee_amount;	
			}
			
			
			

			var $amortization = $loan_amount/$loan_term_duration;			
			
			
			$('#'+ loan_action + '-customer-loan-form input[name="interest_amount"]').val($interest_amount);
			$('#'+ loan_action + '-customer-loan-form input[name="service_fee_amount"]').val($service_fee_amount);
			$('#'+ loan_action + '-customer-loan-form input[name="loan_proceeds"]').val($loan_proceeds);
			$('#'+ loan_action + '-customer-loan-form input[name="amortization"]').val($amortization);
		});
	
		

		
	}
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.loan_grouping").addClass('active');
	$("ul.sidebar-menu>li.loan_grouping>ul.treeview-menu").css('display', 'block');
	$("ul.sidebar-menu>li.loan_applications").addClass('active');
	$("#application_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
	
	$( "input[name=maker_id_issue_date], input[name=co_maker1_id_issue_date], input[name=co_maker2_id_issue_date], input[name=co_borrower_id_issue_date]" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});
	
});	




function edit_loan(loan_id){
	$('#loan_id').val(loan_id);
	$.ajax({
	    type: "POST",
	    url: site_url + 'customers/select_option_customers',
	    success: function(result) {
			if(result!=""){
				var $select = $('#edit-customer-loan-form select[name="customer_id"]');
				$select.html('');
				$select.append(result);
				
				$('#edit-customer-loan-modal').modal('show');
	    	}
	    		
		}
	});
	
}

function approve_loan(loan_id, customer_name){
	
	bootbox.dialog({
	        title: "Release the loan of " + customer_name + "?",
	        message: '<div class="row">  ' +
	            '<div class="col-md-12"> ' +
	            '<form class="form-horizontal"> ' +
	            '<div class="form-group"> ' +
	            '<label class="col-md-4 control-label" for="name">Date released</label> ' +
	            '<div class="col-md-4"> ' +
	            '<input class="form-control" placeholder="Date released" type="text" name="date_released" id="approve_date">' +
	            '</div> ' +
	            '</form> </div>  </div>',
	        buttons: {
	            success: {
	                label: "Release",
	                className: "btn-success",
	                callback: function () {
	                	if($('#approve_date').val()==''){
	                		$('#approve_date').focus();
	                		return false; 
	                	}
	                	else{
	                		$.ajax({
							    type: "POST",
							    url: site_url + 'loan_applications/approve_loan',
							    data:{
							    	'loan_id': loan_id,
							    	'date_released': $("#approve_date").val()
							    },
							    success: function(res) {
							    	var obj = $.parseJSON(res);
							    	
							    	if(obj.success){
							    		alert('Loan released successfully');
							    		customer_loan_table.fnReloadAjax();
							    		location.reload();
							    	}
							    	
								}
							});
	                	}
	                	
	                }
	            }
	        }
	    }
	);
	$( "#approve_date" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});
}

function update_loan_status(loan_id, customer_name){
	
	bootbox.confirm("Update loan status to pending?", function(result){ 
		if(result){
			$.ajax({
			    type: "POST",
			    url: site_url + 'loan_applications/update_to_pending',
			    data:{
			    	'loan_id': loan_id
			    	//,'date_released': $("#approve_date_edit").val()
			    },
			    success: function(res) {
			    	var obj = $.parseJSON(res);
			    	
			    	if(obj.success){
			    		alert('Loan status updated');
			    		customer_loan_table.fnReloadAjax();
			    		location.reload();
			    	}
			    	
				}
			});
		}
	})
	

}

function recommend_loan(loan_id, customer_name){
	bootbox.confirm("Approve the loan of <strong>"+customer_name+"</strong>?", function(result) {
		if(result){
			$.ajax({
			    type: "POST",
			    data: {"loan_id": loan_id},
			    url: site_url + 'loan_applications/recommend_loan',
			    success: function(result) {
			    	var obj = $.parseJSON(result);
			    	if(obj.success){
			    		alert('Saved Successfully');
			    		customer_loan_table.fnReloadAjax();
			    		location.reload();
			    	}
				}
			});
		}
	}); 
}


function deny_loan(loan_id, customer_name){
	
	bootbox.dialog({
	        title: "Deny the loan of " + customer_name + "?",
	        message: '<div class="row">  ' +
	            '<div class="col-md-12"> ' +
	            '<form class="form-horizontal"> ' +
	            '<div class="form-group"> ' +
	            '<label class="col-md-4 control-label" for="name">Reasons</label> ' +
	            '<div class="col-md-4"> ' +
	            '<input class="form-control" placeholder="Reason" type="text" name="reason_denied" id="reason_denied" required>' +
	            '</div> ' +
	            '</form> </div>  </div>',
	        buttons: {
	            success: {
	                label: "Save",
	                className: "btn-success",
	                callback: function () {
	                	if($('#reason_denied').val()==''){
	                		$('#reason_denied').focus();
	                		return false; 
	                	}
	                	else{
	                		$.ajax({
							    type: "POST",
							    url: site_url + 'loan_applications/deny_loan',
							    data:{
							    	'loan_id': loan_id,
							    	'reason_denied': $("#reason_denied").val()
							    },
							    success: function(res) {
							    	var obj = $.parseJSON(res);
							    	
							    	if(obj.success){
							    		alert('Saved Successfully');
							    		customer_loan_table.fnReloadAjax();
							    		location.reload();
							    	}
							    	
								}
							});
	                	}
	                	
	                }
	            }
	        }
	    }
	);
	
}

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