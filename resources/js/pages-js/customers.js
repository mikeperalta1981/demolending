$(function(){
	
	var customer_table = $("#customer-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'customers/customer_datatable',
		"columnDefs": [
           {
               "targets": [ 0 ],
               "visible": false,
               "searchable": false
           }
       ]
	});
	
	
	
	/*var customer_table = $('#customer_table').DataTable({
		processing: false,
		pagingType: 'full_numbers',
		responsive: true,
		ajax: {
			url: site_url + 'customers/get'
		},
		lengthChange: true,
		info: true,
		ordering: true,
		searching: true,
		columns: [
		    {'data':'id'},
			{'data':'account_no'},
			{'data':'account_name'},
			{'data':'loan_amount'},
			{'data':'loan_proceeds'},
			{'data':'date_released'},
			{'data':'maturity_date'},
			{'data':'daily_amort'},
			{'data':'action'}
		],
		language: {
	        processing: 'Processing...',
	    },
	    columnDefs: [
             {
                 "targets": [ 0 ],
                 "visible": false,
                 "searchable": false
             }
         ]
	
	});*/
	
	
	/*$( "#ac-birthdate" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});*/
	
	$( "#ac-birthdate" ).inputmask("9999-99-99", {placeholder: 'YYYY/MM/DD' });

	$("#ac-birthdate").change(function(){
		var dob = new Date($(this).val());
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
		$("#ac-age").val(age);
	})
	
	/*$( "#ec-birthdate" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});*/
	
	$( "#ec-birthdate" ).inputmask("9999-99-99", {placeholder: 'YYYY/MM/DD' });

	$("#ec-birthdate").change(function(){
		var dob = new Date($(this).val());
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
		$("#ec-age").val(age);
	})
	
	
	//$('input[name=position_date_start], input[name=position_date_end], input[name=birthday], input[name=date_hired], input[name=date]').inputmask("9999-99-99", {placeholder: 'YYYY/MM/DD' });


	//--add customer
	$('#add-customer-form').submit(function(e){
		e.preventDefault();

		var btn = $('#add-customer-form .btn_submit'),
		url = site_url + 'customers/create',
		form = $(this),
		form_data = $(this).serializeArray();
	
		if(confirm('Save this customer?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				
				btn.button('reset');
				
				if(obj.success)
				{
					customer_table.fnReloadAjax();
					form[0].reset(true);
					$('input').iCheck('uncheck');
					$('#add-customer-modal').modal('hide');
					$('.alert_create_customer').html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Well done!</strong> Customer created successfully.</span></div></div>');
				}
				else
				{
					alert('Customer already exists!');
				}
			});
		}		
			

	})
	
	//--edit customer
	$('#edit-customer-form').submit(function(e){
		e.preventDefault();
		var btn = $('#edit-customer-form .btn_submit'),
		url = site_url + 'customers/update',
		form = $(this),
		form_data = $(this).serializeArray();
		

		if(confirm('Update this customer?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				
				btn.button('reset');
				
				if(obj.success)
				{
					customer_table.fnReloadAjax();
					form[0].reset(true);
					$('input').iCheck('uncheck');
					$('#edit-customer-modal').modal('hide');
					$('.alert_update_customer').html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_msg_msg"><strong>Well done!</strong> Customer updated successfully.</span></div></div>');
				}
				else
				{
					
				}
			});
		}
			
	})
	
	//--edit customer
	$("#customer-table").on('click', '.edit-customer', function(){
		var customer_id = $(this).data('id');
		
		$.post("customers/get_customer_by_id", { id: customer_id }, function( data ) {
			$('input').iCheck('uncheck');
			var form_elements = $("#edit-customer-form").find(":input");
			var result = $.parseJSON(data);
			
			$.each(form_elements, function(obj, ele){
				
				var item_value = result.customers_data[0][ele.name];
				if(typeof item_value != 'undefined'){
					ele.value = result.customers_data[0][ele.name]
				}
				else{
					
					if(ele.name.substring(0, 3)=="cr_"){
						
						var noprefix = ele.name.substring(3);
						var inputname = noprefix.substring(0, noprefix.length - 1);
						var lastChar = ele.name.substr(ele.name.length - 1) - 1;
						
						if(typeof result.customers_references_data[lastChar]!= 'undefined'){
							ele.value = result.customers_references_data[lastChar][inputname];
						}
						
					}
					else{
						if(ele.name=="house_type[]"){
							var house_type = $.parseJSON(result.customers_data[0].house_type);
							var house_type_id = ele.id.substr(ele.id.length - 1);
							if(! $.isEmptyObject(house_type)){
								$.each(house_type, function(o, e){
									if(house_type_id==e){
										$("#" + ele.id).iCheck('check');
									}
								})
							}
							
						}
						
						if(ele.name=="assets[]"){
							var assets = $.parseJSON(result.customers_data[0].assets);
							var asset_id = ele.id.substr(ele.id.length - 1);
							if(! $.isEmptyObject(assets)){
								$.each(assets, function(o, e){
									if(asset_id==e){
										$("#" + ele.id).iCheck('check');
									}
								})
							}
							
						}
						
						
						
						
					}
					
				}
				
			
			})
			
		});
		
		$("#edit-customer-modal").modal('show');
	});
	
	
	$('#add-customer-modal').on('shown.bs.modal', function (e) {
		$.ajax({
		    type: "POST",
		    url: site_url + 'customers/get_account_no',
		    success: function(result) {
		    	var obj = $.parseJSON(result);
		    	
				$("input[name=account_no]").val(obj.account_no);
				$("input[name=account_no]").prop('readonly', true);	
			}
		});
	});
	$('#edit-customer-modal').on('shown.bs.modal', function (e) {
		$("#edit-customer-form input[name=account_no]").prop('readonly', true);
	});
	
	
	$('#add-customer-modal').on('hidden.bs.modal', function (e) {
		var form = $('#add-customer-form');
		form[0].reset(true);
	});
	$('#edit-customer-modal').on('hidden.bs.modal', function (e) {
		var form = $('#edit-customer-form');
		form[0].reset(true);
	});
	
	
	$('#add-customer-form select[name="branch_id"]').on('change',function(){
		$.ajax({
		    type: "POST",
		    url: site_url + 'customers/get_branch_areas',
		    data: {
		    	"id": $(this).val()
		    },
		    success: function(result) {
				if(result!=""){
					var $select = $('#add-customer-form select[name="area_id"]');
					$select.html('');
					$select.append(result);
		    	}
		    		
			}
		});
	}).trigger('change');
	
	$('#edit-customer-form select[name="branch_id"]').on('change',function(){
		$.ajax({
		    type: "POST",
		    url: site_url + 'customers/get_branch_areas',
		    data: {
		    	"id": $(this).val()
		    },
		    success: function(result) {
				if(result!=""){
					var $select = $('#edit-customer-form select[name="area_id"]');
					$select.html('');
					$select.append(result);
		    	}
		    		
			}
		});
	}).trigger('change');
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.customers").addClass('active');
	
});	


