var customer_loan_payments_table;
$(function(){
	
	customer_loan_payments_table = $("#customer-loan-payments-table").DataTable({
		"bProcessing": true,
		"iDisplayLength": 100,
		//"bServerSide": true,
		//"sAjaxSource": site_url + 'loan_payments/get_daily_collectibles',
		"sAjaxSource": site_url + 'loan_payments/get_daily_collectibles'
		,"aoColumnDefs": [
            { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
            ,{ "bSearchable": true, "bVisible": true, "aTargets": [ 1 ],  "sWidth": "70px"}
            ,{ "bSearchable": false, "bVisible": false, "aTargets": [ 3 ] }
            ,{ "bSearchable": false, "bVisible": false, "aTargets": [ 4 ] }
            ,{ "bSearchable": true, "bVisible": true, "aTargets": [ 5 ],  "sWidth": "100px"}
            ,{ "bSearchable": true, "bVisible": true, "aTargets": [ 6 ],  "sWidth": "100px"}
            ,{ "bSearchable": true, "bVisible": true, "aTargets": [ 8 ],  "sWidth": "100px"}
            ,{ "bSearchable": true, "bVisible": true, "aTargets": [ 9 ],  "sWidth": "80px"}
            ,{ "bSearchable": true, "bVisible": true, "aTargets": [ 10 ],  "sWidth": "70px"}
            ,{ "bSearchable": false, "bVisible": false, "aTargets": [ 11 ] }
        ],
        "fnInitComplete": function(oSettings, json) {
        	$('.inputpayment').numeric();
        	//calculate_total();	
        },
        "fnFooterCallback": function(nFoot, aData, iStart, iEnd, aiDisplay){
        	
        	var $overall_total_payments = 0;
        	$.each(aData, function(o,e){
        		var $x = e[7];
        		var $y = $.parseHTML($x);
        		
        		if ($y !== null && $y !== undefined){
        			if(typeof $y[0].value !== 'undefined' && $y[0].value!=''){
            			/*if(! isNaN($y[0].value)){
            				console.log($y[0].value);
            			}*/
            			
            			$overall_total_payments += parseFloat($y[0].value)
            			//;
            		}
        		}
        		
        		//console.log($overall_total_payments);
        		
        		
        	});
        	
        	//$("#overall_total_payments").html("P " + number_format($overall_total_payments));
        	//calculate_total();
        },
        "fnDrawCallback":function(oSettings) {
        	var $payments = 0;
        	//console.log(oSettings.aoData);
        	var $locked = false;
        	var $locked = false;
        	$.each(oSettings.aoData, function(o, e){
        		var x = $.parseHTML(e._aData[11]);
        		$payments = $payments + parseFloat(x[0].innerHTML);
        		/*var p_status = e._aData[9];
        		console.log(p_status);
        		if(p_status=="<span class='label label-success'>Approved</span>"){
        			$locked = true;
        		}*/
        		
        		//console.log(e._aData[9]);
        		if(e._aData[9]=="<span class='label label-success'>Approved</span>"){
        			$locked = true;
        		}
        		
        	});
        	
        	if($locked==true){
        		$("#btn-post").hide();
    			$("#btn-approve").hide();
        	}
        	
        	//console.log($locked);
        	//console.log($payments);
        	$html = "";
    		$html += "<strong>P " + number_format($payments) + "</strong>";
    		$("#overall_total_payments").html($html);
    		//calculate_total();
    		
        }
	});
	
	$("#btn_area_id").click(function(){
		
		customer_loan_payments_table.fnReloadAjax(site_url + 'loan_payments/get_daily_collectibles?area_id=' + $("#area_id").val());
	})
	
	
	
	$("#btn-post").click(function(){
		 //var data = customer_loan_payments_table.$('input, select').serializeArray();
		var data = customer_loan_payments_table.$('input').serializeArray();
		var tc_data = customer_loan_payments_table.$('select').serializeArray();
		 var $submit = false;
		 
		 $.each(data, function(o, e){
			 if($submit==false){
				 if(parseFloat(e.value)>0){
					 $submit = true;
				 }	
			 }
			 
		 });
		
		 if($submit){
			 
			 if(confirm('Post this payments?')){
				 $.ajax({
					    type: "POST",
					    url: site_url + 'loan_payments/post_payments',
					    data: {
					    	'params': data,
					    	'tc_data': tc_data,
					    	'date' : $("#lc_date").val()
					    },
					    success: function(result) {
					    	var obj = $.parseJSON(result);
							if(obj.success){
								//$(".alert_post_success").html('<div class="col-xs-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_post_msg"><strong>Well done!</strong> Loan posting success.</span></div></div>');
								alert('Loan posting success.');
								customer_loan_payments_table.fnReloadAjax();
								
					    	}
							else{
								//$(".alert_post_success").html('<div class="col-xs-12"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><span id="alert_post_msg"><strong>Opps!</strong> No postings made.</span></div></div>');
								alert('No posting made.');
								customer_loan_payments_table.fnReloadAjax();
							}
							
					    		
						}
					});
			 }
			 
			 
		 }
		 else{
			 alert('There is no data to be submitted.');
		 }
	});
	
	
	//view cfc
	$("#btn-view-cfc").on('click', function(){
		$.ajax({
		    type: "POST",
		    url: site_url + 'loan_payments/get_cfc',
		    data: {
		    	'area_id' : $("#area_id").val()
		    },
		    success: function(result) {
		    	var $obj = $.parseJSON(result);
		    	var $html = "";
				if($obj.success){
					
					$("#cfc-num-of-accounts").html($obj.num_of_accounts)
					
					$.each($obj.data, function(o, e){
						$html += "<tr>";
						$html += "<td>" + e.account_no;
						$html += "</td>";
						$html += "<td>" + e.name;
						$html += "</td>";
						$html += "<td>" + e.amortization;
						$html += "</td>";
						$html += "<td>";
						$html += "</td>";
						$html += "</tr>";
						
					})
					$("#cfc-tbody").html($html);
					$("#cfc-area").html($obj.area_name);
					$("input[name=area_id]").val($obj.area_id);
					$('#cfc-modal').modal('show');
		    	}
				else{
					alert('No payments made yet.')
				}
		    		
			}
		});
		
	});
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.loan_grouping").addClass('active');
	$("ul.sidebar-menu>li.loan_grouping>ul.treeview-menu").css('display', 'block');
	$("ul.sidebar-menu>li.loan_payments").addClass('active');
	$("#posting_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');

	
	$("#btn-approve").click(function(){
		$("#btn-select-all").trigger('click');
		var params = $('input[name="chkbox_payments"]:checked').serializeArray();
		var tc_data = customer_loan_payments_table.$('select').serializeArray();
		var $payment_date = $('#lc_date').val();
		
		if(params.length>0){
			if(confirm('Approve all payments?')){
				$.ajax({
				    type: "POST",
				    url: site_url + 'loan_payments/approve_payment',
				    data: {
				    	'params' : params,
				    	'tc_data': tc_data,
				    	'payment_date': $payment_date
				    },
				    success: function(result) {
				    	var $obj = $.parseJSON(result);
				    	if($obj.success){
				    		alert('Update Success');
				    		customer_loan_payments_table.fnReloadAjax();
				    	}
					}
				});
			}
			else{
				$("#btn-clear").trigger('click');
			}
		}
		else{
			alert('No payments selected yet.')
		}
		
	})
	
	$("#btn-select-all").click(function(){
		$('input[name="chkbox_payments"]').each(function(){
				this.checked = true
		})
		
	})
	$("#btn-clear").click(function(){
		$('input[name="chkbox_payments"]').each(function(){
				this.checked = false
		})
		
	})
	
	$( "#lc_date" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
		endDate: '+0d'
	}).on('changeDate', function(ev){
		customer_loan_payments_table.fnReloadAjax(site_url + 'loan_payments/get_daily_collectibles?area_id=' + $("#area_id").val() + '&date=' + $('#lc_date').val());
		if($("#tmp_usertype").val()==3){
			/*$("#btn-post").prop('disabled', true);
			$("#btn-approve").prop('disabled', true);*/
			$("#btn-post").hide();
			$("#btn-approve").hide();
			
		}
		else{
			if($("#tmp_usertype").val()<=2 || $("#tmp_usertype").val()==4){
				if($('#lc_date').val()==$("#tmp_lpdate").val()){
					/*$("#btn-post").prop('disabled', false);
					$("#btn-approve").prop('disabled', false);*/
					$("#btn-post").show();
					if($("#tmp_usertype").val()<=2){
						$("#btn-approve").show();
					}
					else{
						$("#btn-approve").hide();
					}
					
				}
				else{
					/*$("#btn-post").prop('disabled', true);
					$("#btn-approve").prop('disabled', true);*/
					$("#btn-post").show();
					if($("#tmp_usertype").val()<=2){
						$("#btn-approve").show();
					}
					else{
						//$("#btn-post").hide();
						$("#btn-approve").hide();
					}
					
					
					
					
				}
			}
		}
		
    });
	
	$('#lc_date').on('show', function(e){
	    if ( e.date ) {
	         $(this).data('stickyDate', e.date);
	    }
	    else {
	         $(this).data('stickyDate', null);
	    }
	});

	$('#lc_date').on('hide', function(e){
	    var stickyDate = $(this).data('stickyDate');

	    if ( !e.date && stickyDate ) {
	        $(this).datepicker('setDate', stickyDate);
	        $(this).data('stickyDate', null);
	    }
	});
	
	$("select[name='area_id']").change(function(){
		var $collector_name = $(this).find(':selected').data('collector')
		
		$("#collector_name").html($collector_name);
		$("#cfc_form input[name=collector_name]").val($collector_name);
		customer_loan_payments_table.fnReloadAjax(site_url + 'loan_payments/get_daily_collectibles?area_id=' + $(this).val() + '&date=' + $('#lc_date').val());
	});
})

function calculate_total(thisval, id){
	
	var alldata  = customer_loan_payments_table.fnGetData();
	var data = customer_loan_payments_table._('tr', {"filter":"applied"});
	$.each(alldata, function(o, e){
		//console.log(o);
		
		var $span = $.parseHTML(e[11]);
		//console.log($span[0]);
	})
	//console.log(alldata);
	$("#temp_p" + id).html(thisval);
}

function go_next_input($this){
		$('input.inputpayment').keydown(function (e) {
			if (e.which === 13) {
			
			$(':input:eq(' + ($(':input').index(this) + 2) + ')').focus();
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