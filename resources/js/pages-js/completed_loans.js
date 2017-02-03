$(function(){
	
	var customer_loan_table = $("#customer-loan-table").DataTable({
		"bProcessing": true,
		//"bServerSide": true,
		"sAjaxSource": site_url + 'completed_loans/get',
		"aoColumnDefs": [
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 6 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 7 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 8 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 9 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 10 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 12 ] },
	                        { "bSearchable": false, "bVisible": false, "aTargets": [ 15 ] }
	                    ]
	});
	//var customer_loan_payment_table = $("#customer-loan-payment-table").DataTable();
	var customer_loan_payment_table;
	$("#noloan").show();
	$("#customer-loan-payment-table").hide();
	

	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.loan_grouping").addClass('active');
	$("ul.sidebar-menu>li.loan_grouping>ul.treeview-menu").css('display', 'block');
	$("ul.sidebar-menu>li.completed_loans").addClass('active');
	$("#completed_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
});	


function view_payments($this){
	
	$loan_id = $($this).data('id');
	$("#soa-customer-name").html($($this).data('customer_name'));
	$("#soa-account-number").html($($this).data('account_number'));
	$("#soa-loan-amount").html($($this).data('loan_amount'));
	$("#soa-amortization").html($($this).data('amortization'));
	$("#soa-date-released").html($($this).data('date_released'));
	$("#soa-maturity-date").html($($this).data('maturity_date'));
	$("#soa-date_completed").html($($this).data('date_completed'));
	
	$('#soa_loan_id').val($loan_id);
	
	var $total_loan_amount = $($this).data('loan_amount');
	
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