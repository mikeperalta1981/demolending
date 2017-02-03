$(function(){
	
	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.reports_grouping").addClass('active');
	$("ul.sidebar-menu>li.reports_grouping>ul.treeview-menu").css('display', 'block');
	$(".collection-performance").addClass('active');
	$("#collection_performance_text").css('font-weight', 'bold');
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
		  $cpr_table.ajax.reload( null, false );
      $('#frm_generate_cp input[name=rp_date]').val($(this).val());
    });


     $('#frm_cpr select[name=area_id]').on('change', function(){
      $cpr_table.ajax.reload( null, false );
      $('#frm_generate_cp input[name=area_id]').val($(this).val());
    })

    $('#frm_cpr select[name=branch_id]').on('change', function(){
      $cpr_table.ajax.reload( null, false );
      $('#frm_generate_cp input[name=branch_id]').val($(this).val());
    })


   /* $('select[name=area_id],  select[name=branch_id]').on('change', function(){
    	$cpr_table.ajax.reload( null, false );
    });*/

	var $cpr_table = $('#cpr_table').DataTable( 
    {
      	scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        searching: false,
        fixedColumns:   {
            leftColumns: 2
        }
        ,"ajax": {
		    "url": site_url + 'reports/get_collection_performance',
		    "type": 'POST',
		    "data": function ( d ) { return $('#frm_cpr').serialize();} 
		}
		,"columns": [
            { "data": "branch" },
            { "data": "area" },
            { "data": "total_loan_amount" },
            { "data": "total_daily_amort" },
            { "data": "total_due" },
            { "data": "total_payments" },
            { "data": "collection_performance_adc" },
            { "data": "collection_performance_tl" }
        ],
        columnDefs: [
            { targets: [2, 3, 4, 5, 6, 7], class: 'right'}
        ],
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
            $( api.column( 2 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
               'P '+  
               number_format(api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))

            );

             $( api.column( 3 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );
            var $total_la = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             var $total_due = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var $total_payments = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            
            var $colperf_adc = $total_payments/$total_due * 100;
            var $colperf_tl = $total_payments/$total_la * 100;

              $( api.column( 4 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );

             $( api.column( 5 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                'P'+ number_format(api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ))
            );

              $( api.column( 6 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
               parseFloat($colperf_adc).toFixed(2) + '%'
            );

               $( api.column( 7 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
               parseFloat($colperf_tl).toFixed(2) + '%'
               //$total_payments + "/ " + $total_la
            );

        }
        

    }
    );

     $('#cp_date').on('show', function(e){
      if ( e.date ) {
           $(this).data('stickyDate', e.date);
      }
      else {
           $(this).data('stickyDate', null);
      }
  });

  $('#cp_date').on('hide', function(e){
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {
          $(this).datepicker('setDate', stickyDate);
          $(this).data('stickyDate', null);
      }
  });

    $( "#cp_date" ).datepicker({
      format: 'yyyy-mm',
      autoclose: true,
      viewMode: "months", 
        minViewMode: "months"
    });

    $( "#cp_year" ).datepicker({
      format: 'yyyy',
      autoclose: true,
      viewMode: "years", 
        minViewMode: "years"
    });

       $('#cp_year').on('show', function(e){
      if ( e.date ) {
           $(this).data('stickyDate', e.date);
      }
      else {
           $(this).data('stickyDate', null);
      }
  });

  $('#cp_year').on('hide', function(e){
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {
          $(this).datepicker('setDate', stickyDate);
          $(this).data('stickyDate', null);
      }
  });

    

    $('#cp_date').on('change', function(){
      var $data = $('#frm_cpchart').serializeArray();
      $.post(site_url + 'reports/get_collection_performance_chart', {'data': $data}, function(result) {
        var $obj = $.parseJSON(result);

        $('#collectionchart').highcharts({
            credits: {
                    enabled: false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Collection Performance'
            },
            subtitle: {
                text: 'Ginhawa Lending'
            },
            xAxis: {
                categories: $obj.categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Collection Performance Percentage'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: $obj.categories_data
        });  
      });
      
    })

    $('#cp_date').trigger('change');

    $('select[name=area_id], select[name=branch_id]').change(function(){

        var $viewtype = $( "select[name=view_type] option:selected" ).val();
        
        if($viewtype=='weekly'){
          $('#cp_date').trigger('change');      
        }
        else{
          $('#cp_year').trigger('change');      
        }

        
    })

    $('select[name=view_type]').change(function(){

         if($(this).val()=='weekly'){
            $('#cp_date').prop('disabled', false);
            $('#cp_date').show();

            $('#cp_year').prop('disabled', true);
            $('#cp_year').hide();

            $('#cp_date').trigger('change');  

         }
         else{
            $('#cp_date').prop('disabled', true);
            $('#cp_date').hide();

            $('#cp_year').prop('disabled', false);
            $('#cp_year').show();

            $('#cp_year').trigger('change');  
         } 
    })

    $('select[name=view_type]').trigger('change');


    $('#cp_year').on('change', function(){
      var $data = $('#frm_cpchart').serializeArray();
      $.post(site_url + 'reports/get_collection_performance_chart', {'data': $data}, function(result) {
        var $obj = $.parseJSON(result);

        $('#collectionchart').highcharts({
            credits: {
                    enabled: false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Collection Performance'
            },
            subtitle: {
                text: 'Ginhawa Lending'
            },
            xAxis: {
                categories: $obj.categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Collection Performance Percentage'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: $obj.categories_data
        });  
      });
      
    })
    
})


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