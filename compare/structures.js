var $prompt;	
var $entitykioskname;
$(function () {

	$("select[name=server_id]").select2();
	
	$("#display-structure-form select[name=server_id]").change(function(){
		var $server_id = $(this).val();
		var $server_name = $(this).find("option:selected").text();
		$.post(site_url + "structures/ajax/get_entites_by_server_id",  {'server_id' : $server_id}, function(result){
			var $options = "";
			if(result.length){
				
				$.each(result, function($obj, $ele){
					$options += "<option value='"+$ele.id+"'>" +$ele.name + "</opton>";
				})
				
				$("select[name=entity_id]").html($options);
				$("select[name=entity_id]").select2();
				
				
				$(".btn-display-structure").attr('disabled', false);
				var $entity_name = $("select[name=entity_id] option:selected").text();

				$("#entity_name_hidden").val($entity_name)

			}
			else{
				$("select[name=entity_id]").html($options);
				$("select[name=entity_id]").select2('val', '');
				$(".btn-display-structure").attr('disabled', true);
				$("#entity_name_hidden").val('')
			}

			$('#subject-form input[name=server_id]').val($server_id);
			$('#subject-form input[name=server_name]').val($server_name);

			$('#admin-info-form input[name=server_id]').val($server_id);
			$('#admin-info-form input[name=server_name]').val($server_name);
			
		});

		$('.add-entity').addClass('disabled');
		$('.update-entity').addClass('disabled');

		$('.add-admin').addClass('disabled');
		$('.update-admin').addClass('disabled');

		$('.add-kiosk').addClass('disabled');
		$('.update-kiosk').addClass('disabled');

		$('.entity-games, .entity-limits').addClass('disabled');

		 $("#container").html('');

	});
	$("#display-structure-form select[name=server_id]").trigger('change');
	
	$("#display-structure-form select[name=entity_id]").change(function(){
		var $entity_name = $(this).find("option:selected").text();

		$("#entity_name_hidden").val($entity_name);
		
		$('.add-entity').addClass('disabled');
		$('.update-entity').addClass('disabled');

		$('.add-admin').addClass('disabled');
		$('.update-admin').addClass('disabled');

		$('.add-kiosk').addClass('disabled');
		$('.update-kiosk').addClass('disabled');

		$('.entity-games, .entity-limits').addClass('disabled');

		$("#container").html('');
	})
	$("#display-structure-form select[name=entity_id]").trigger('change');
	
	$('.add-entity').addClass('disabled');
	$('.update-entity').addClass('disabled');

	$('.add-admin').addClass('disabled');
	$('.update-admin').addClass('disabled');

	$('.add-kiosk').addClass('disabled');
	$('.update-kiosk').addClass('disabled');

	$('.entity-games, .entity-limits').addClass('disabled');
	
	$('#display-structure-form').submit(function(e){
		e.preventDefault();
		var $params = $(this).serializeArray();
		var $btn = $('.btn-display-structure');	
		$btn.button('loading');
		$('#container').jstree('destroy');
		 $('#container').jstree({
		 	'core' : {
		      'data' : {
		        "url" : site_url + 'structures/ajax/get_structure?lazy&id=#',
		        "data" : function (node) {
		        	return { "id" : node.id,  'params': $params};
		        },
		        "success": function(){
		        	$btn.button('reset');

		        	$('.add-entity').addClass('disabled');
					$('.update-entity').addClass('disabled');

					$('.add-admin').addClass('disabled');
					$('.update-admin').addClass('disabled');

					$('.add-kiosk').addClass('disabled');
					$('.update-kiosk').addClass('disabled');

					$('.entity-games, .entity-limits').addClass('disabled');

		        	 $("#container").bind(
				        "select_node.jstree", function(evt, data){
				           var $selected_parent_entity_name = data.selected[0];
				           var $parent_entity_name = data.selected[0].split('___')[0];
				           var $selected_function = data.selected[0].split('___')[1];
				           $('#subject-form input[name=parent_entity_name]').val($parent_entity_name);
				           $('.btn-entity-functions').data('entity_name', $parent_entity_name);
				           if($selected_function=='entity'){
				           		
				           		$('.add-entity').removeClass('disabled');	
				           		$('.update-entity').removeClass('disabled');	

				           		$('.entity-games, .entity-limits').removeClass('disabled');

				           		$('.add-admin').removeClass('disabled');
				           		$('.update-admin').addClass('disabled');		
				           		
				           		if(data.node.text.search('fa fa-laptop') < 0){
				           			$('.add-kiosk').removeClass('disabled');
				           			$('.update-kiosk').addClass('disabled');
				           		}
				           		else{
				           			$('.add-kiosk').addClass('disabled');
				           			$('.update-kiosk').removeClass('disabled');

				           			$entitykioskname = data.node.text.split('<i class="fa fa-laptop"></i>')[1].trim();
				           			//console.log(nodetext);

				           		}
					           
				           }
				           else if($selected_function=='admin'){

				           		$('.add-entity').addClass('disabled');	
				           		$('.add-kiosk').addClass('disabled');
				           		$('.add-admin').addClass('disabled');

				           		$('.update-entity').addClass('disabled');
				           		$('.update-kiosk').addClass('disabled');

				           		$('.entity-games, .entity-limits').addClass('disabled');
				           		
				           		var $admin_name = data.selected[0].split('___')[0];
				           		$('.update-admin').removeClass('disabled');

				           }
				           else{

					            $('.add-entity').addClass('disabled');
								$('.update-entity').addClass('disabled');

								$('.add-admin').addClass('disabled');
								$('.update-admin').addClass('disabled');

								$('.add-kiosk').addClass('disabled');
								$('.update-kiosk').addClass('disabled');

								$('.entity-games, .entity-limits').addClass('disabled');								
				           }

				           $.post(site_url + 'structures/ajax/get_entity_by_entityname', {'entity_name': $parent_entity_name}, function(result){
				           		
				           		$('#subject-form input[name=entity_id]').val('');
				           		if(! $.isEmptyObject(result)){
				           		
				           			$('#subject-form input[name=entity_id]').val(result[0].id);
				           			
				           		}
				           		
				           })
				           $('#success_info').html('');
				        }
					);
		        }	
		      }
		    }
		 });
		
	})
	$('#admin-info-form').submit(function(e){
		e.preventDefault();
		var $params = $(this).serializeArray();
		var $btn = $('#admin-info-form .btn-submit');

		if(confirm('Update admin?')){
			$btn.button('loading');
			$.post(site_url + 'structures/ajax/update_admin', {'params': $params}, function(result){
				$msg = "";
				if(result.result.result.result.result){
					$msg = result.result.result.result.result	
				}
				else{

				}
				
				$html = '<div class="alert alert-success">';
				$html += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
				$html += '<strong>Success!</strong> ' + $msg;
				$html += '</div>';

				$('#success_info').html($html)
				var $parentparent = $('#container').jstree(true).get_parent(result.adminname + '___admin');
				$('#container').jstree(true).refresh_node($parentparent);
				$('#container').jstree(true).open_node($parentparent);	
				$btn.button('reset');
           		
           		$('#admin-info-form-modal').modal('hide');
        	})
		}
	});

	//general	
	$('#subject-form').submit(function(e){
		e.preventDefault();
		var $url = $(this).prop('action');
		var $btn = $('.btn-submit');

		if(confirm($prompt + '?')){
			$btn.button('loading');
			var $params = $(this).serializeArray();
			var $node_id = $('#subject-form input[name=parent_entity_name]').val();
			var $kioskname = $('#subject-form input[name=kioskname]').val();
			var $newkioskname = $('#subject-form input[name=newkioskname]').length > 0 ? $('#subject-form input[name=newkioskname]').val() : '';
			var $functiontype = $('#apirequest').val();
			//alert($prompt);
			var $tree_structure_params = $('#display-structure-form').serializeArray();
			$.post($url,{params: $params}, function(result){
				$btn.button('reset');
				if(result){
					var $obj = $.parseJSON(result);
					
					if('error' in $obj.result){
						$html = '<div class="alert alert-danger">';
						$html += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

						console.log($obj.result.error);
						if($obj.result.error && $obj.result.error.name && $obj.result.error.name.recordFound){
							$html += '<strong>Error!</strong> ' + $obj.result.error.name.recordFound;	
						}
						else{
							
						}

						if($obj.result.error){
							var $err = '';
							//$.map(obj, function(el) { return el });
							$.each($obj.result.error, function($a, $b){
								$err += $a + "\n"
								$.each($b, function($c, $d){
									$err +=  ' -> ' + $c + ":" + $d
;								})
							})
							$html += '<strong>Error!</strong> ' + $err;
						}
						
						$html += '</div>';

						$('#error_div').html($html);
					}
					else{
						
						$('.add-entity').addClass('disabled');
						$('.add-admin').addClass('disabled');
						$('.add-kiosk').addClass('disabled');

						$kiosknamestr = "";
						
						if($kioskname != '' && $kioskname != null){
							if($newkioskname!='' && $newkioskname!=null){
								$kioskname = $newkioskname;
							}
						
							$kiosknamestr += '&nbsp;&nbsp;&nbsp; <i class="fa fa-laptop"></i> ' + $kioskname.toUpperCase();	
							$('#container').jstree('set_text', $node_id + '___entity', $node_id + $kiosknamestr);						
						}
						
						var $parentparent = $('#container').jstree(true).get_parent($node_id + '___entity');
						if($prompt=='Update Entity'){
							$('#container').jstree(true).refresh_node($parentparent);
							$('#container').jstree(true).open_node($parentparent);	
						}
						else{
							$('#container').jstree(true).refresh_node($node_id + '___entity');
							$('#container').jstree(true).open_node($node_id + '___entity');	
						}
						

						$html = '<div class="alert alert-success">';
						$html += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	  					$html += '<strong>Success!</strong> ' + $obj.result.result.result;
						$html += '</div>';

						$('#success_info').html($html)	
						$('#form-modal').modal('hide');
						$(this).trigger("reset");
					}

				}

			})	
		}
		
	})
	//end general

	
	$('.li_apifunction').on('click', function(event){
		var $apirequest = $(this).data('apiparam');
		var $buttonname = $(this).data('buttonname');
		var $strrequest = $(this).data('method');
		var $method = 'process_apirequest';

		$('#formLabel').html($strrequest.replace('_', ' ').toUpperCase())
		$prompt = $(this).data('prompt');
		
		if($strrequest == 'create_entity'){
			$('#entityname_label').html('Parent Entity Name');
		}
		else{
			$('#entityname_label').html('Entity Name');	
		}

		if($(this).hasClass('disabled')){
			event.preventDefault();
			event.stopPropagation();
		}
		else{
			var $btn = $('.btn-' + $buttonname);
			var $parent_entity_name =  $('#display-structure-form select[name="entity_id"]').find("option:selected").text();
			var $parent_entity_id =  $('#display-structure-form select[name="entity_id"]').find("option:selected").val();
			var $entity_name = $('#subject-form input[name=parent_entity_name]').val();
			if($strrequest == 'update_admin'){
				$btn.button('loading');
				$("#admin-info-form").attr("action", site_url + 'structures/ajax/update_admin');
				$.post(site_url + 'structures/ajax/get_admin_update_form', {'entity_id': $parent_entity_id, 'apifunction' : $apirequest, 'admin_name' : $entity_name}, function(result){
					$btn.button('reset');
					$('#admin_formfields').html(result);

					$('#admin-info-form input[name=parent_entity_id]').val($parent_entity_id);
					$('#admin-info-form input[name=entity_name]').val('');

					//$('#admin-info-form-modal').modal()
					$('#admin-info-form-modal').modal('show') 
					//$('#admin-info-form-modal').modal({ keyboard: false, backdrop: 'static' })


					//$('.al_checkbox').bootstrapSwitch()	
				})
				
			}
			else{
				$("#subject-form").attr("action", site_url + 'structures/ajax/' + $method);
				$btn.button('loading');
				$('#subject-form input[name=parent_entity_id]').val($parent_entity_id);
				$('#subject-form input[name=entity_name]').val('');

				$.post(site_url + 'structures/ajax/get_form', {'entity_id': $parent_entity_id, 'apifunction' : $apirequest, 'entity_name' : $entity_name, 'kioskname' : $entitykioskname}, function(result){
					
					$btn.button('reset');
					$('#subject_formfields').html(result.formfields);
					//$('#form-modal').modal()
					$('#form-modal').modal('show') 
					//$('#form-modal').modal({ keyboard: false, backdrop: 'static' })
					if($('#subject-form select[name=languagecode]').length){
						$('#subject-form select[name=languagecode]').select2();
					}
					if($('#subject-form select[name=countrycode]').length){
						$('#subject-form select[name=countrycode]').select2();
					}
				})
			}

			
		}

	});

	
});

function generate_password(){
	 var length = 8,
        charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        randpassword = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        randpassword += charset.charAt(Math.floor(Math.random() * n));
    }
    if($('#subject-form input[name=password]').length)
    	$('#subject-form input[name=password]').val(randpassword)

    if($('#admin-info-form input[name=password]').length)
    	$('#admin-info-form input[name=password]').val(randpassword)
    
}



