$(function(){
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.reports_grouping").addClass('active');
	$("ul.sidebar-menu>li.reports_grouping>ul.treeview-menu").css('display', 'block');
	$(".repayment-performance").addClass('active');
	$("#repayment_performance_text").css('font-weight', 'bold');
	$(".angleicon").removeClass('fa-angle-left').addClass('fa-angle-down');
	
	
  $('#rp_date').on('show', function(e){
      if ( e.date ) {
           $(this).data('stickyDate', e.date);
      }
      else {
           $(this).data('stickyDate', null);
      }
  });

  $('#rp_date').on('hide', function(e){
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {
          $(this).datepicker('setDate', stickyDate);
          $(this).data('stickyDate', null);
      }
  });
	
	$( "#rp_date" ).datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
        startDate: '2016-02-09',
	}).on('changeDate', function(ev){
		$rpr_table.ajax.reload( null, false );
      
      $('#frm_generate_rp input[name=rp_date]').val($(this).val());
    });

    $('#frm_rpr select[name=area_id]').on('change', function(){
    	$rpr_table.ajax.reload( null, false );
      $('#frm_generate_rp input[name=area_id]').val($(this).val());
    })

    $('#frm_rpr select[name=branch_id]').on('change', function(){
      $rpr_table.ajax.reload( null, false );
      $('#frm_generate_rp input[name=branch_id]').val($(this).val());
    })


	var $rpr_table = $('#rpr_table').DataTable( {
      	scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        searching: false,
        fixedColumns:   {
            leftColumns: 2
        },
        "ajax": {
		    "url": site_url + 'reports/get_repayment_performance',
		    "type": 'POST',
		    "data": function ( d ) { return $('#frm_rpr').serialize();} 
		},
    
    "createdRow": function( row, data, dataIndex ) {
      var $date_released = data.date_released;
      var $maturity_date = data.maturity_date;
      var $basedate = $('#rp_date').val();
      //console.log($basedate);
      var $today = moment().format('YYYY-MM-DD');
      var $total_loan_amount = parseFloat(data.loan_amount.replace(',',''));
      var $total_balance = parseFloat(data.total_balance.replace(',',''));
      var $total_payments = parseFloat(data.total_payments.replace(',',''));

      if($total_loan_amount>$total_payments){
        //if($maturity_date<$today){
          if($maturity_date<$basedate){

          /*console.log($today + "==" + $maturity_date);
          console.log($total_loan_amount + "==" + $total_payments);*/
          
          var $area_colors = {Area1: 'yellow', Area2: '#ADFF2F', Area3: 'blue', Area4: 'red'}
          
           $(row).css( 'background-color', $area_colors[data.area]);

        }
      }

    },
		"columns": [
            { "data": "account_no" },
            { "data": "customer_name" },
            { "data": "branch" },
            { "data": "area" },
            { "data": "loan_amount" },
            { "data": "date_released" },
            { "data": "maturity_date" },
            { "data": "daily_amortization" },
            { "data": "total_due" },
            { "data": "total_payments" },
			{ "data": "total_balance" },
            { "data": "repayment_performance_adc" },
            { "data": "repayment_performance_tl" },
            { "data": "action" }
        ],
        columnDefs: [
            { targets: [4, 7, 8, 9, 10, 11], class: 'right'},
            { "width": "51px", "targets": 0 },
            { "width": "200px", "targets": 1 },
            { "width": "51px", "targets": 2 },
            { "width": "40px", "targets": 3 },
            { "width": "51px", "targets": 4 },
            { "width": "67px", "targets": 5 },
            { "width": "67px", "targets": 6 },
            { "width": "40px", "targets": 7 },
            { "width": "40px", "targets": 8 },
            { "width": "63px", "targets": 9 },
            { "width": "60px", "targets": 10 },
            { "width": "60px", "targets": 11 },

        ],
        "initComplete": function(settings, json) {
           //$('th#tmptotal').html('TOTAL');
           
           /*$('th#total_loan_amount').html(json.total_loan_amount);
           $('th#total_daily_amort').html(json.total_daily_amort);
           $('th#total_due').html(json.total_due);
           $('th#total_payments').html(json.total_payments);
           $('th#total_repayment_performance').html(json.total_repayment_performance);*/
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
			
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            /*// Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
           
 */
            // Update footer
            $( api.column( 4 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
               'P'+  
               number_format(api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))

            );

             $( api.column( 7 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );

            
             $( api.column( 8 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );

              $( api.column( 9 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );
			
			  $( api.column( 10 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );

            var $loan_amount = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                  
            var $due = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var $payments = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
			var $balance = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );	

            var $rep_perf_adc = $payments/$due * 100;
             $( api.column( 11 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                 parseFloat($rep_perf_adc).toFixed(2) + "%"
            );

             var $rep_perf_tl = $payments/$loan_amount * 100;
             $( api.column( 12 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                parseFloat($rep_perf_tl).toFixed(2) + "%"
            );

        }

    }


    );
    
})

function view_payments($info){
    var $data = $($info).data();
    $.post(site_url + 'reports/get_customer_payments', $data, function(result){
        var $obj = $.parseJSON(result);
         var dataSet = $obj.data;
         $('#rp_loan_amount').html($obj.loan_amount);
         $('#rp_date_released').html($obj.date_released);
         $('#rp_maturity_date').html($obj.maturity_date);
         $('#rp_daily_amort').html($obj.daily_amort);
         $('#rp_total_due').html($obj.total_due);
         $('#rp_total_payments').html($obj.total_payments);
		 
         $('.customer_name').html($obj.customer_name);
         $('#payment_as_of').html($obj.rp_date);
         $('#total_rp_adc').html($obj.total_rp_adc);
         $('#total_rp_tl').html($obj.total_rp_tl);

         var $custtable = $('#tbl-customer-payments').DataTable( {
            searching: false,
            paging: false,
            data: dataSet,
            sort: false,
            scrollY:     '300px',
            destroy: true,
            columnDefs: [
                { targets: [0, 2, 3, 4, 5], class: 'right'},
                { "width": "10px", "targets": 0 },
                { "width": "67px", "targets": 1 },
                { "width": "51px", "targets": 2 },
                { "width": "51px", "targets": 3 },
                { "width": "60px", "targets": 4 },
                { "width": "60px", "targets": 5 }

            ],
            //scrollX: '100%',
            //scrollXInner: "100%",
            //scrollCollapse: true,
            //autoWidth: false,
           /* columns: [
                { title: "Payment Date" },
                { title: "Daily Payment" },
                { title: "Actual Payment" },
                { title: "Repayment Performance \n(vs ADC)" },
                { title: "Repayment Performance \n(vs Loan Amount)" }
            ]*/
        } );
         $('#customer-payments-modal').modal('show');
    })
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