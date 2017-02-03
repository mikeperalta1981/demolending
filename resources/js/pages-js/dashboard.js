$(document).ready(function () {
	$('#chartloading').hide();

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
      $.post(site_url + 'dashboard/get_collection_chart', {'data': $data}, function(result) {
        var $obj = $.parseJSON(result);
        //console.log($obj);
        $('#collectionchart').highcharts({
            credits: {
                    enabled: false
            },
            title: {
                text: 'Collection Performance',
                x: -20 
            },
            subtitle: {
                text: 'Ginhawa Lending Co',
                x: -20
            },
            xAxis: {
                categories: $obj.categories
            },
            yAxis: {
                title: {
                    text: 'Collection Performance (%)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '%'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: $obj.categories_data,
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true   
                    },
                    enableMouseTracking: true
                }
            }
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
      $.post(site_url + 'dashboard/get_collection_chart', {'data': $data}, function(result) {
        var $obj = $.parseJSON(result);

        $('#collectionchart').highcharts({
            credits: {
                    enabled: false
            },
            title: {
                text: 'Collection Performance',
                x: -20 
            },
            subtitle: {
                text: 'Ginhawa Lending Co',
                x: -20
            },
            xAxis: {
                categories: $obj.categories
            },
            yAxis: {
                title: {
                    text: 'Collection Performance (%)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '%'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: $obj.categories_data,
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true   
                    },
                    enableMouseTracking: true
                }
            }
        });  
      });
      
    })
    











	$("ul.sidebar-menu>li").removeClass('active');
	$("ul.sidebar-menu>li.dashboard").addClass('active');
	
    $('#sales_year').change(function(n){
        var $year = $(this).val();
       
       $.post(site_url + 'dashboard/get_monthly_sales', {'year': $year}, function(jd) {
            var $data = $.parseJSON(jd);
            
            $('#saleschart').highcharts({
                title: {
                    text: ' Sales',
                    x: -20 
                },
                subtitle: {
                    text: $year,
                    x: -20
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Amount'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ''
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: $data,
                credits: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                },
            });
        });

    });

    $('#sales_year').trigger('change');
	
	
 });
