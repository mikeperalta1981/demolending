$(function(){
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.reports_grouping").addClass('active');
	$("ul.sidebar-menu>li.reports_grouping>ul.treeview-menu").css('display', 'block');
	$(".progress_report").addClass('active');
	$("#progress_report_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
	
})

