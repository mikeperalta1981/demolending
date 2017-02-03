$(function(){
	$("#datepicker").datepicker( {
	    format: "yyyy-mm",
	    viewMode: "months", 
	    minViewMode: "months",
	    setDate: new Date()
	}).on('changeDate', function(ev){
		
		$.ajax({
		    type: "POST",
		    url: site_url + 'reports/ncr_by_month',
		    data: {
		    	param: $("#datepicker").val()
		    },
		    success: function(result) {
				/*if(result!=""){
					var $select = $('#add-customer-loan-form select[name="customer_id"]');
					$select.html('');
					$select.append(result);
		    	}*/
		    		
		    	//console.log(result);
			}
		});
		
    });

})

