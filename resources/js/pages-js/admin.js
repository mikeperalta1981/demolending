$(function(){
	
	var area_table = $("#area-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'admin/get_area_table',
		"aoColumnDefs": [
		                  { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
		                
       ],
		"columnDefs": [
           {
               "targets": [ 0 ],
               "visible": false,
               "searchable": false
           }
       ]
	});

	var collector_table = $("#collector-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'admin/get_collector_table',
		"aoColumnDefs": [
		                  { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
		                
       ],
		"columnDefs": [
           {
               "targets": [ 0 ],
               "visible": false,
               "searchable": false
           }
       ]
	});
	
	
	var user_table = $("#user-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'admin/get_users_table',
		"aoColumnDefs": [
		                  { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
		                
       ],
		"columnDefs": [
           {
               "targets": [ 0 ],
               "visible": false,
               "searchable": false
           }
       ]
	});
	
	$( "#born" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
		endDate: '+0d'
	})
	
	$('#born').on('show', function(e){
	    if ( e.date ) {
	         $(this).data('stickyDate', e.date);
	    }
	    else {
	         $(this).data('stickyDate', null);
	    }
	});

	$('#born').on('hide', function(e){
	    var stickyDate = $(this).data('stickyDate');

	    if ( !e.date && stickyDate ) {
	        $(this).datepicker('setDate', stickyDate);
	        $(this).data('stickyDate', null);
	    }
	});
	
	$( "#edit-area-form input[name=born]" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
		endDate: '+0d'
	})
	
	$( "#edit-area-form input[name=born]").on('show', function(e){
	    if ( e.date ) {
	         $(this).data('stickyDate', e.date);
	    }
	    else {
	         $(this).data('stickyDate', null);
	    }
	});

	$( "#edit-area-form input[name=born]").on('hide', function(e){
	    var stickyDate = $(this).data('stickyDate');

	    if ( !e.date && stickyDate ) {
	        $(this).datepicker('setDate', stickyDate);
	        $(this).data('stickyDate', null);
	    }
	});
	
	//--add customer
	$('#add-area-form').submit(function(e){
		e.preventDefault();
		var btn = $('#add-area-form .btn_submit'),
		url = site_url + 'admin/create_area',
		form = $(this),
		form_data = $(this).serializeArray();
		
		if(confirm('Are you sure?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				
				btn.button('reset');
				
				if(obj.success)
				{
					area_table.fnReloadAjax();
					form[0].reset(true);
					$('#add-area-modal').modal('hide');
					alert('Create Success');
				}
				
			});
		}
		
	});
	
	//--edit customer
	$('#edit-area-form').submit(function(e){
		e.preventDefault();
		var btn = $('#edit-area-form .btn_submit'),
		url = site_url + 'admin/update',
		form = $(this),
		form_data = $(this).serializeArray();
		
		btn.button('loading');					
		$.post(url, form_data, function(response){
			var obj = $.parseJSON(response);
			
			btn.button('reset');
			
			if(obj.success)
			{
				area_table.fnReloadAjax();
				form[0].reset(true);
				
				$('#edit-area-modal').modal('hide');
				alert('Update Success');
			}
			else
			{
				
			}
		});
	})
	
	
	$('#edit-collector-form').submit(function(e){
		e.preventDefault();
		var btn = $('#edit-collector-form .btn_submit'),
		url = site_url + 'admin/update_collector',
		form = $(this),
		form_data = $(this).serializeArray();
		
		btn.button('loading');					
		$.post(url, form_data, function(response){
			var obj = $.parseJSON(response);
			
			btn.button('reset');
			
			if(obj.success)
			{
				collector_table.fnReloadAjax();
				form[0].reset(true);
				
				$('#edit-collector-modal').modal('hide');
				alert('Update Success');
			}
			else
			{
				
			}
		});
	});
	
	$('#edit-user-form').submit(function(e){
		e.preventDefault();
		var btn = $('#edit-user-form .btn_submit'),
		url = site_url + 'admin/update_user',
		form = $(this),
		form_data = $(this).serializeArray();
		
		if(confirm('Are you sure?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				
				btn.button('reset');
				
				if(obj.success)
				{
					user_table.fnReloadAjax();
					form[0].reset(true);
					
					$('#edit-user-modal').modal('hide');
					alert('Update Success');
				}
				else
				{
					
				}
			});
		}
		
	})
	
	//--edit customer
	$("#area-table").on('click', '.edit-area', function(){
		var area_id = $(this).data('id');
		
		$.post("admin/get_area_by_id", { id: area_id }, function( data ) {
			
			var form_elements = $("#edit-area-form").find(":input");
			var result = $.parseJSON(data);
			
			$.each(form_elements, function(obj, ele){
				
				var item_value = result[0][ele.name];
				if(typeof item_value != 'undefined'){
					ele.value = result[0][ele.name]
				}
				else{}
				
			
			})
			
		});
		
		$("#edit-area-modal").modal('show');
		//$("#edit-area-form input[name=area_name]").val(obj.area_name);
		$("#edit-area-form input[name=area_name]").prop('readonly', true);	
	});
	
	//--edit customer
	$("#collector-table").on('click', '.edit-collector', function(){
		var collector_id = $(this).data('id');
		
		$.post("admin/get_collector_by_id", { id: collector_id }, function( data ) {
			
			var form_elements = $("#edit-collector-form").find(":input");
			
			var result = $.parseJSON(data);
			//console.log(result);
			$.each(form_elements, function(obj, ele){
				
				var item_value = result[0][ele.name];
				if(typeof item_value != 'undefined'){
					ele.value = result[0][ele.name]
				}
				else{}
				
				
				$("#c_area_id").val(result[0]['area_id']);
			
			})
			
		});
		
		$("#edit-collector-modal").modal('show');
		//$("#edit-area-form input[name=area_name]").val(obj.area_name);
		//$("#edit-collector-form input[name=area_name]").prop('readonly', true);	
	});
	
	
	//--edit customer
	$("#user-table").on('click', '.edit-user', function(){
		var user_id = $(this).data('id');
		
		$.post("admin/get_user_by_id", { id: user_id }, function( data ) {
			
			var form_elements = $("#edit-user-form").find(":input");
			
			var result = $.parseJSON(data);
			//console.log(result);
			$.each(form_elements, function(obj, ele){
				
				var item_value = result[0][ele.name];
				if(typeof item_value != 'undefined'){
					if(ele.name=='password'){
						ele.value = ''
					}
					else{
						ele.value = result[0][ele.name]
					}
					
				}
				else{}
				
				
				//$("#c_area_id").val(result[0]['area_id']);
			
			})
			
		});
		
		$("#edit-user-modal").modal('show');
		//$("#edit-area-form input[name=area_name]").val(obj.area_name);
		//$("#edit-collector-form input[name=area_name]").prop('readonly', true);	
	});
	
	
	//--edit customer
	$("#user-table").on('click', '.deactivate-user', function(){
		var user_id = $(this).data('id');
		var name = $(this).data('name')
		
		if(confirm('Deactivate ' + name + '?')){
			$.ajax({
			    type: "POST",
			    url: site_url + 'admin/deactivate_user',
			    data: {
			    	id: user_id
			    },
			    success: function(result) {
			    	var obj = $.parseJSON(result);
			    	
			    	if(obj.success){
			    		alert('Success');
			    		user_table.fnReloadAjax();
					}
				}
			});
		}
			
	});
	
	//--edit customer
	$("#user-table").on('click', '.activate-user', function(){
		var user_id = $(this).data('id');
		var name = $(this).data('name')
		
		if(confirm('Deactivate ' + name + '?')){
			$.ajax({
			    type: "POST",
			    url: site_url + 'admin/activate_user',
			    data: {
			    	id: user_id
			    },
			    success: function(result) {
			    	var obj = $.parseJSON(result);
			    	
			    	if(obj.success){
			    		alert('Success');
			    		user_table.fnReloadAjax();
					}
				}
			});
		}
			
	});
	
	
	$('#add-area-modal').on('shown.bs.modal', function (e) {
		$.ajax({
		    type: "POST",
		    url: site_url + 'admin/get_area_name',
		    success: function(result) {
		    	var obj = $.parseJSON(result);
		    	//console.log(obj);
				$("#add-area-form input[name=area_name]").val(obj.area_name);
				$("#add-area-form input[name=area_name]").prop('readonly', true);	
			}
		});
	});
	
	$('#edit-collector-modal').on('shown.bs.modal', function (e) {
		$.ajax({
		    type: "POST",
		    data: {
		    	'id': '1'
		    },
		    url: site_url + 'admin/get_branch_areas',
		    success: function(result) {
				$("#edit-collector-form select[name=area_id]").html(result);
					
				$("#edit-collector-form select[name=area_id]").val($('#c_area_id').val());
			}
		});
	});
	
	
	$('#add-area-modal').on('hidden.bs.modal', function (e) {
		var form = $('#add-area-form');
		form[0].reset(true);
	});
	$('#edit-area-modal').on('hidden.bs.modal', function (e) {
		var form = $('#edit-area-form');
		form[0].reset(true);
	});
	
	
	$('#add-collector-modal').on('shown.bs.modal', function (e) {
		$.ajax({
		    type: "POST",
		    data: {
		    	'id': '1'
		    },
		    url: site_url + 'admin/get_branch_areas_no_collector',
		    success: function(result) {
		    	
		    	//console.log(result);
				$("#add-collector-form select[name=area_id]").html(result);
					
			}
		});
	});
	
	$('#edit-collector-modal').on('hidden.bs.modal', function (e) {
		var form = $('#edit-collector-form');
		form[0].reset(true);
	});
	
	$('#add-collector-modal').on('hidden.bs.modal', function (e) {
		var form = $('#add-collector-form');
		form[0].reset(true);
	});
	
	$('#edit-user-modal').on('hidden.bs.modal', function (e) {
		var form = $('#edit-user-form');
		form[0].reset(true);
	});
	
	$('#add-user-modal').on('hidden.bs.modal', function (e) {
		var form = $('#add-user-form');
		form[0].reset(true);
	});
	
	
	$('#add-collector-form').submit(function(e){
		e.preventDefault();
		var btn = $('#add-collector-form .btn_submit'),
		url = site_url + 'admin/create_collector',
		form = $(this),
		form_data = $(this).serializeArray();
		
		if(confirm('Are you sure?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				
				btn.button('reset');
				
				if(obj.success)
				{
					collector_table.fnReloadAjax();
					form[0].reset(true);
					$('#add-collector-modal').modal('hide');
					alert('Create Success');
				}
				
			});
		}
		
	});
	
	$('#add-user-form').submit(function(e){
		e.preventDefault();
		var btn = $('#add-user-form .btn_submit'),
		url = site_url + 'admin/create_user',
		form = $(this),
		form_data = $(this).serializeArray();
		
		if(confirm('Are you sure?')){
			btn.button('loading');					
			$.post(url, form_data, function(response){
				var obj = $.parseJSON(response);
				
				btn.button('reset');
				
				if(obj.success)
				{
					user_table.fnReloadAjax();
					form[0].reset(true);
					$('#add-user-modal').modal('hide');
					alert('Create Success');
				}
				
			});
		}
		
		
	});
	
	$("#btn_backup").click(function(){
		if(confirm('Backup database?')){
			$.ajax({
			    type: "POST",
			    url: site_url + 'admin/backup_database',
			    success: function(result) {
			    	var obj = $.parseJSON(result);
			    	if(obj.success){
			    		alert('Backup Success');
			    	}
				}
			});
		}
	})
	
	$("#add-user-form input[name=username]").keyup(function(){
		$.ajax({
		    type: "POST",
		    url: site_url + 'admin/check_username',
		    data: {
		    	'username': $(this).val()
		    },
		    success: function(result) {
		    	var obj = $.parseJSON(result);
		    	if(obj.success){
		    		
		    		$("#add-user-form .btn_submit").prop('disabled', false);
		    	}
		    	else{
		    		alert('Username already exists');
		    		$("#add-user-form .btn_submit").prop('disabled', true);
		    	}
			}
		});
	})
	$("#edit-user-form input[name=username]").keyup(function(){
		$.ajax({
		    type: "POST",
		    url: site_url + 'admin/check_username',
		    data: {
		    	'username': $(this).val()
		    },
		    success: function(result) {
		    	var obj = $.parseJSON(result);
		    	if(obj.success){
		    		$("#edit-user-form .btn_submit").prop('disabled', false);
		    	}
		    	else{
		    		alert('Username already exists');
		    		$("#edit-user-form .btn_submit").prop('disabled', true);
		    	}
			}
		});
	})
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.admin").addClass('active');
	
});	

