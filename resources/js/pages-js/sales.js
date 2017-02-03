$(function(){
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.reports_grouping").addClass('active');
	$("ul.sidebar-menu>li.reports_grouping>ul.treeview-menu").css('display', 'block');
	$(".sales").addClass('active');
	$("#sales_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
	
	/*
	var customer_loan_payments_table = $("#customer-loan-payments-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'loan_payments/get_daily_collectibles',
		"columnDefs": [
               {
                   "targets": [ 0 ],
                   "visible": false,
                   "searchable": false
               }
           ]
		,"aoColumnDefs": [
            { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
            ,{ "bSearchable": false, "bVisible": false, "aTargets": [ 3 ] }
            ,{ "bSearchable": false, "bVisible": false, "aTargets": [ 4 ] }
            //,{ "bSearchable": false, "bVisible": false, "aTargets": [ 6 ] }
        ],
        "fnInitComplete": function(oSettings, json) {
        	$('.inputpayment').numeric();
        }
	});
	
	
	$("#btn-post").click(function(){
		 var data = customer_loan_payments_table.$('input, select').serializeArray();
		 
		 if(data.length>0){
			 $.ajax({
				    type: "POST",
				    url: site_url + 'loan_payments/post_payments',
				    data: {
				    	'params': data
				    },
				    success: function(result) {
				    	var obj = $.parseJSON(result);
						if(obj.success){
							$(".alert_post_success").html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_post_msg"><strong>Well done!</strong> Loan posting success.</span></div></div>');
							customer_loan_payments_table.fnReloadAjax();
				    	}
						else{
							$(".alert_post_success").html('<div class="col-xs-12"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_post_msg"><strong>Opps!</strong> No postings made.</span></div></div>');
							customer_loan_payments_table.fnReloadAjax();
						}
				    		
					}
				});
		 }
		 else{
			 alert('There is no data to be submitted.');
		 }
	});
	*/
})

