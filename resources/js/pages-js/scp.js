$(function(){
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.reports_grouping").addClass('active');
	$("ul.sidebar-menu>li.reports_grouping>ul.treeview-menu").css('display', 'block');
	$(".sales").addClass('active');
	$("#sales_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
	$( "#scpdp" ).datepicker({
		format: 'yyyy-mm',
		autoclose: true,
		viewMode: "months", 
	    minViewMode: "months"
	});

	$( "#custom_date_from, #custom_date_to" ).hide();
	
	$('select[name=dateday]').change(function(){
		if($(this).val()==''){
			$( "#custom_date_from, #custom_date_to" ).show();
			$('#scpdp').prop('disabled', true);	
			$( "#custom_date_from, #custom_date_to" ).inputmask("9999-99-99", {placeholder: 'YYYY/MM/DD' });		
		}
		else{
			$( "#custom_date_from, #custom_date_to" ).hide();
			$('#scpdp').prop('disabled', false);		
		}	
	})
	
})

