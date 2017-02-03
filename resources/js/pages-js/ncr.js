$(function(){
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.reports_grouping").addClass('active');
	$("ul.sidebar-menu>li.reports_grouping>ul.treeview-menu").css('display', 'block');
	$(".ncr").addClass('active');
	$("#ncr_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
	
	
	$( "#ncrdp" ).datepicker({
		format: 'yyyy-mm',
		autoclose: true,
		viewMode: "months", 
	    minViewMode: "months"
	});

	var table = $('#ncr_table').DataTable( {
      	scrollY:        "450px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        searching: false,
        fixedColumns:   {
            leftColumns: 2
        }
    });
    
})

