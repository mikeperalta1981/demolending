<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Structures extends AKTK_Controller {
	
	public $tree_structure = array();
	public $tree_html = "";
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('user');
		$this->load->helper(array('user', 'kiosk'));
		$this->load->model('Servers_model', 'servers');
		$this->load->model('Entities_model', 'entities');
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->javascripts = array(	'resources/admin-lte/plugins/datatables/jquery.dataTables.min.js',
									'resources/admin-lte/plugins/datatables/dataTables.bootstrap.min.js',
									'resources/admin-lte/plugins/select2/select2.min.js',
									'resources/admin-lte/plugins/jstree-master/dist/jstree.min.js',
									'resources/admin-lte/plugins/iCheck/icheck.min.js',
									'resources/admin-lte/dist/js/default.js',
									'resources/admin-lte/dist/js/pages/structures.js',
									'resources/admin-lte/dist/js/pages/entity-functions.js');
		
		$this->css = array(	'resources/admin-lte/plugins/datatables/dataTables.bootstrap.css',
							'resources/admin-lte/plugins/jstree-master/dist/themes/default/style.min.css',
							'resources/admin-lte/plugins/select2/select2.min.css',
							'resources/admin-lte/plugins/iCheck/all.css');
		
		$data = array();
		
		/**
		 * servers
		 */
		$data['servers'] = $this->servers->get()->result_array();
		$data['entities'] = $this->entities->get()->result_array();
		$this->load->view('default/templates/header');
		$this->load->view('default/pages/structures', $data);
		$this->load->view('default/templates/footer');
	}
	
	/**
	 * get entity
	 * @return array
	 */
	protected function _get($id)
	{
		return $this->entities->get_where(array('entities.id' => $id), 1)->row_array();
	}	
	
	/**
	 * create entity
	 * @return array
	 */

	protected function _process_apirequest(){
		$post = $this->input->post(NULL, true);
		
		foreach($post['params'] as $val){
			if($val['name']=='parent_entity_name'){
				$params['parententityname'] = strtoupper($val['value']);
			}
			$params[$val['name']]  = $val['value'];	
		}

		$baseparams = $params['apirequest'] . '/';
		
		$extraparams = "";

		if($params['apirequest']=='admin/create' || $params['apirequest']=='kiosk/create' || $params['apirequest']=='entity/update' || $params['apirequest']=='kiosk/update'){
			$params['entityname'] = strtoupper($params['parententityname']);
			unset($params['parententityname']);
		}
		
		if($params['apirequest']=='kiosk/update'){
			unset($params['entityname']);	
		}
		unset($params['apirequest']);


		foreach($params as $key => $val){

			if($key!='server_id' && $key != 'server_name' && $key!='parent_entity_id' && $key!='parent_entity_name' && $key!='entity_id'){
				if($val!=''){
					if(strlen($extraparams)>0){
						$extraparams .= "/";
					}
					if($key=='entityname' || $key=='kioskname' || $key=='adminname'){
						$val = strtoupper($val);
					}
					$extraparams .= $key . '/' . $val;		
				}
			}
		}

		$apiparams = $baseparams . $extraparams;
		
		$parent_entity_info = array();

		
		$kiosk_config = get_kiosk_config($params['parent_entity_id']);

		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = isset($kiosk_config['entity_code']) ? $kiosk_config['entity_code'] : "";

		$result = $this->kiosk->send($apiparams);

		return $result;

	}

	protected function _update_admin(){
		$post = $this->input->post(NULL, true);

		$postparam = array();
		foreach($post['params'] as $val){
			$postparam[$val['name']] = $val['value'];
		}

		unset($postparam['server_id']);
		unset($postparam['server_name']);
		unset($postparam['entity_id']);
		unset($postparam['api_request']);

		$entity_id = $postparam['parent_entity_id'];
		unset($postparam['parent_entity_id']);
		unset($postparam['parent_entity_name']);

		$params = array();
		foreach($postparam as $key => $val){
			$paramkey = explode('___', $key);
			
			if(count($paramkey)==3){
				$params[$paramkey[0]][$paramkey[1]] = array($paramkey[2] => $val);	
			}
			elseif(count($paramkey)==2){
				$params[$paramkey[0]][$paramkey[1]] = $val;	
			}
			else{
				$params[$key] = $val;
			}
		}

		$baseparam = 'admin/update/';
		$params_str = "";
		foreach($params as $key => $val){
			if(strlen($params_str) > 0){
				if($val!="")
					$params_str .= "/";
			}

			if(is_array($val))
				$val = json_encode($val);

			if($val!='')
				$params_str .= $key . "/" . $val;
		}
		
		$apiparams = $baseparam . $params_str;

		$kiosk_config = get_kiosk_config($entity_id);

		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = isset($kiosk_config['entity_code']) ? $kiosk_config['entity_code'] : "";

		$result = $this->kiosk->send($apiparams);

		$return = array(
			'adminname' => $postparam['adminname'],
			'result' => json_decode($result, TRUE)
		);
		return $return;
		
	}

	protected function _create_entity()
	{
		$post = $this->input->post(NULL, true);
		
		foreach($post['params'] as $val){
			if($val['name']=='parent_entity_name'){
				$params['parententityname'] = $val['value'];
			}
			$params[$val['name']]  = $val['value'];	
		}

		$baseparams = 'entity/create/';
		$extraparams = "";
		foreach($params as $key => $val){

			if($key!='server_id' && $key != 'server_name' && $key!='parent_entity_id' && $key!='parent_entity_name' && $key!='entity_id'){
				if($val!=''){
					if(strlen($extraparams)>0){
						$extraparams .= "/";
					}
					if($key=='entityname'){
						$val = strtoupper($val);
					}
					$extraparams .= $key . '/' . $val;		
				}
			}
			
		}

		$apiparams = $baseparams . $extraparams;

		$parent_entity_info = array();

		$parent_entity_info_param = "entity/info/entityname/" . $params['parent_entity_name'];
		
		$kiosk_config = get_kiosk_config($params['parent_entity_id']);

		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = isset($kiosk_config['entity_code']) ? $kiosk_config['entity_code'] : "";

		$result = $this->kiosk->send($apiparams);

		return $result;

	}

	protected function _create_kiosk()
	{
		$post = $this->input->post(NULL, true);
		
		foreach($post['params'] as $val){
			if($val['name']=='parent_entity_name'){
				$params['entityname'] = $val['value'];
			}

			if($val['name']=='languagecode' || $val['name']=='countrycode')
				$val['value'] = strtoupper($val['value']);

			$params[$val['name']]  = $val['value'];		

			
		}
	
		$baseparams = 'kiosk/create/';
		$extraparams = "";
		foreach($params as $key => $val){
			

			if($key!='server_id' && $key != 'server_name' && $key!='parent_entity_id' && $key!='parent_entity_name' && $key!='entity_id'){
				if($val!=''){
					if(strlen($extraparams)>0){
						$extraparams .= "/";
					}
					if($key=='kioskname'){
						$val = strtoupper($val);
					}
					$extraparams .= $key . '/' . $val;		
				}
			}


			
		}
		
		$apiparams = $baseparams . $extraparams;
		

		$parent_entity_info = array();

		$parent_entity_info_param = "entity/info/entityname/" . $params['parent_entity_name'];
		
		$kiosk_config = get_kiosk_config($params['parent_entity_id']);

		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = isset($kiosk_config['entity_code']) ? $kiosk_config['entity_code'] : "";

		$result = $this->kiosk->send($apiparams);
		return $result;

	}


	protected function _create_admin()
	{
		$post = $this->input->post(NULL, true);
		
		foreach($post['params'] as $val){
			if($val['name']=='parent_entity_name'){
				$params['entityname'] = $val['value'];
			}

			if($val['name']=='languagecode' || $val['name']=='countrycode')
				$val['value'] = strtoupper($val['value']);

			$params[$val['name']]  = $val['value'];		

			
		}

		$baseparams = 'admin/create/';
		$extraparams = "";
		foreach($params as $key => $val){
			

			if($key!='server_id' && $key != 'server_name' && $key!='parent_entity_id' && $key!='parent_entity_name' && $key!='entity_id'){
				if($val!=''){
					if(strlen($extraparams)>0){
						$extraparams .= "/";
					}
					if($key=='adminname'){
						$val = strtoupper($val);
					}
					$extraparams .= $key . '/' . $val;		
				}
			}


			
		}
		
		$apiparams = $baseparams . $extraparams;

		$parent_entity_info = array();

		$parent_entity_info_param = "entity/info/entityname/" . $params['parent_entity_name'];
		
		$kiosk_config = get_kiosk_config($params['parent_entity_id']);

		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = isset($kiosk_config['entity_code']) ? $kiosk_config['entity_code'] : "";

		$result = $this->kiosk->send($apiparams);

		return $result;

	}


	
	/**
	 * list of entities for datatables
	 * @return array
	 */
	protected function _read()
	{
		$user = get_logged_user();
		
		$where = array();
		if($user['access_id'] > 1)
			$where['servers.user_id'] = $user['id'];
		
		$return = array();
		
		$entities = $this->entities->get_where($where)->result_array();
		
		$this->load->helper('text');
		
		if(! empty($entities))
		{
			foreach($entities as $entity)
			{
				$entity['entity_key'] = ellipsize($entity['entity_key'], 32, .5);
				$entity['action'] = '<a href="#edit-entity-modal" class="edit-entity" data-entity-id="'.$entity['id'].'" title="update" data-toggle="modal"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp; 
							<a href="#remove-entity-modal" data-toggle="modal" title="remove" data-entity-id="'.$entity['id'].'" class="remove-entity" data-entity-name="'.$entity['name'].'"><span class="glyphicon glyphicon-remove"></span></a>';
				$return['data'][] = $entity;
			}
		}
		else
			$return['data'] = array();
		
		return $return;
	}
	
	/**
	 * update entity
	 * @return array
	 */
	protected function _update()
	{
		$post = $this->input->post(NULL, true);
		$update = array('name' => $post['name'], 
						'server_id' => $post['server_id'], 
						'entity_key' => $post['entity_key'],
						'entity_code' => $post['entity_code']);
		
		$success = $this->entities->update($update, array('id' => $post['entity_id']));
		
		if($success)
			return array('success' => 'Entity has been updated successfully.');
		else
			return array('error' => 'Error updating entity. Please try again.');
	}
	
	/**
	 * delete entity
	 * @return array
	 */
	protected function _delete()
	{
		$post = $this->input->post(NULL, true);
				
		$success = $this->entities->delete(array('id' => $post['entity_id']));
		
		if($success)
			return array('success' => 'Entity has been deleted successfully.');
		else
			return array('error' => 'Error deleting entity. Please try again.');
	}
	
	
	protected function _get_entites_by_server_id(){
		$post = $this->input->post(NULL, true);
		
		
		$entities = $this->entities->get_by_server_id($post['server_id']);
		
		return $entities;
	}

	private function get_entity_by_name_and_server_id($server_id, $entity_name){
		$entities = $this->entities->get_entity_by_name_and_server_id($server_id, $entity_name);

		return $entities;
	}
	

	
	private function compose_tree($entity_structure, $entity_info = array(), $parent_entity = ""){

		if(empty($entity_structure)){
			return;
		}


		foreach($entity_structure as $key => $val){
			foreach($val as $k => $v){

				if(strtolower($k)=='entity'){
					//$this->tree_structure[$k][] = $v;
					$entity_name = $v['ENTITYNAME'];
					if($parent_entity == "") {
						$parent_entity = $entity_name;	
						$this->tree_html .= '<tr class="treegrid-'.$v['ENTITYNAME'].'_entity treegrid-collapsed">';
						$this->tree_html .= '<td><span class="treegrid-expander glyphicon glyphicon-plus"></span>'.$v['ENTITYNAME'].'</td><td>Entity</td>';
						$this->tree_html .= '</tr>';
					}
					else{
						$this->tree_html .= '<tr class="treegrid-'.$v['ENTITYNAME'].'_entity treegrid-parent-'.$parent_entity.'_entity" style="display: none;">';
						$this->tree_html .= '<td id="'.$v['ENTITYNAME'].'"><span class="treegrid-indent"></span><span class="treegrid-expander"></span> '. $v['ENTITYNAME'] . '</td><td>Admin</td>';
		                $this->tree_html .= '</tr>';	
					}
						 
				}
				if(strtolower($k)=='admins'){
					if(is_array($v)){
						foreach($v as $a => $admin){
							//$this->tree_structure[$k][] = $b;


							$this->tree_html .= '<tr class="treegrid-'.$admin['ADMINNAME'].'_admin treegrid-parent-'.$entity_name.'_entity" style="display: none;">';
							$this->tree_html .= '<td id="'.$admin['ADMINNAME'].'"><span class="treegrid-indent"></span><span class="treegrid-expander"></span><i class="fa fa-user"></i> '. $admin['ADMINNAME'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$entity_info['currency'] . ' ' . number_format($admin['DEPOSITBALANCE']) .  '</td><td>Admin</td>';
			                $this->tree_html .= '</tr>';		

						}
					}
				}
				if(strtolower($k)=='childs'){
					if(is_array($v)){

						$this->compose_tree($v, $entity_info, $entity_name);
					}
				}
			}
		}	
		//return $this->tree_html;
	}



	protected function _display_structure()
	{
		/**
		* USED FOR DISPLAYING STRUCTURE AT ONCE
		**/
		$post = $this->input->post(NULL, true);
		$params = array();
		foreach($post['params'] as $val){
			$params[$val['name']]  = $val['value'];	
		}
		
		$apiparams = 'entity/structure/entityname/' . strtoupper($params['entity_name']);
		$kiosk_config = get_kiosk_config($params['entity_id']);


		
		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];
		

		$entity_info = $this->get_entity_info($params['entity_name'], $params['entity_id']);

		$result = json_decode($this->kiosk->send($apiparams), TRUE);
		
		$structure = array();
		
		if(! empty($result['result'])){
			$structure =  $result['result'];
		}


		$this->tree_html = "";
		$this->compose_tree($structure, $entity_info, '');
		
		
		$return = array(
			/*'entity_id' => $entity_info_from_db[0]['id'],
			'server_id' => $entity_info_from_db[0]['server_id'],
			'entity_name' => strtoupper($child_name),*/
			'entity_structure' => $this->tree_html

		);

		return $return;


	}

	private function get_entity_info($entity_name, $entity_id){

		$apiparams = 'entity/info/entityname/' . strtoupper($entity_name);	
		$kiosk_config = get_kiosk_config($entity_id);
		
		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];

		$result = json_decode($this->kiosk->send($apiparams), TRUE);
		
		$entity_info = array();
		if(! empty($result['result']['result'])){
			$entity_info =  $result['result']['result'];
		}

		return $entity_info;
	}

	private function get_kiosk_info($kioskname, $entity_id){

		$apiparams = 'kiosk/info/kioskname/' . strtoupper($kioskname);	
		$kiosk_config = get_kiosk_config($entity_id);
		
		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];

		$result = json_decode($this->kiosk->send($apiparams), TRUE);
		
		$entity_info = array();
		if(! empty($result['result']['result'])){
			$kiosk_info =  $result['result']['result'];
		}

		return $kiosk_info;
	}


	/**
	* STRUCTURE WITH LAZY LOADING
	*/
	protected function _get_structure(){

		$get = $this->input->get(NULL, true);

		$params = array();

		foreach($get['params'] as $val){
			$params[$val['name']]  = $val['value'];	
		}
		

		if($get['id']=='#'){
			$entity_name = $params['entity_name'];
		}
		else{
			$entity_name = str_replace('___entity', '', $get['id']);
		}

		$entity_info = $this->get_entity_info($entity_name, $params['entity_id']);

		$apiparams = 'entity/structure/entityname/' . strtoupper($entity_name) . '/childmaxlevel/2';
		


		$kiosk_config = get_kiosk_config($params['entity_id']);
		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];
		

		$entity_info = $this->get_entity_info($entity_name, $params['entity_id']);

		$result = json_decode($this->kiosk->send($apiparams), TRUE);
		
		$structure = array();
		
		if(! empty($result['result'])){
			$structure =  $result['result'];
		}


		if($get['id']=='#'){

				$js_tree = $this->prepare_entity_structure($structure, $entity_info);
				return array($js_tree);

		}
		else{

				$return = array();
				$childs = array();
				if(isset($structure['result'])){
					foreach($structure['result'] as $key => $val){
						
						if(strtolower($key)=='childs'){
							
							if(isset($structure['result']['admins']) && count($structure['result']['admins'])>0){
								foreach($structure['result']['admins'] as $aa => $dd){
									$return[] = array(
										"id" => $dd['ADMINNAME'] . "___admin",
										"text" => $dd['ADMINNAME'].' (' .(isset($entity_info['currency']) ? $entity_info['currency'] : ''). '&nbsp;' . number_format($dd['DEPOSITBALANCE']) .')',
										"icon" => 'fa fa-user'
									);
								}
							}

							foreach($val as $k => $v){
								if(! empty($v['entity'])){
									$entity_kiosk = '';	
									if($v['kiosk']['KIOSKNAME']!='null' && $v['kiosk']['KIOSKNAME']!=''){
										$entity_kiosk = '&nbsp;&nbsp;&nbsp; <i class="fa fa-laptop"></i> '.$v['kiosk']['KIOSKNAME'];
									}	

									
									$return[] = array(
										"id" => $v['entity']['ENTITYNAME'] . "___entity",
										"text" => $v['entity']['ENTITYNAME'] . $entity_kiosk,
										"children" => true	
									);
								}

								
							}


						}
					}
				}

		
				$js_tree = $return;
				return $js_tree;

		}

		return array($js_tree);

	}



	private function prepare_entity_structure($structure, $entity_info = array()){
		$return = array();
		$childs = array();
		$admins= array();
		if(isset($structure['result'])){
			foreach($structure['result'] as $key => $val){
				if(strtolower($key) == 'entity'){
					$return = array(
						"id" => $val['ENTITYNAME'] . "___entity",
						"text" => $val['ENTITYNAME']
					);
				}

				if(strtolower($key)=='admins'){
					if(is_array($val) && count($val) > 0){
						//echo "<pre>",print_r($entity_info),die();
						foreach($val as $k => $admin){

							$return['children'][] = array(
								
									"id" => $admin['ADMINNAME'] . '___admin',
									"text" => $admin['ADMINNAME'].' (' . (isset($entity_info['currency']) ? $entity_info['currency'] : ''). '&nbsp;' . number_format($admin['DEPOSITBALANCE']) .')',
									"icon" => 'fa fa-user'
							);		
						}
					}
				}	

				if(strtolower($key)=='kiosk'){
					if(isset($val['KIOSKNAME'])) {
						if($val['KIOSKNAME']!='null' && $val['KIOSKNAME']!=''){

							$return['text']	.= '&nbsp;&nbsp;&nbsp; <i class="fa fa-laptop"></i> '.$val['KIOSKNAME'];
						}
					}
				}

				if(strtolower($key)=='childs'){
					$childs = $this->get_entity_children($val, $entity_info);
					if(! empty($childs)){
						foreach($childs as $ch){
							$return['children'][] = $ch;	
						}
						
					}
				}
			}
		}

		return $return;
	}

	private function get_entity_children($childs, $entity_info = array()){
		$return = array();
		
		if(count($childs) > 0){
			foreach($childs as $key => $val){
				//$i=0;
				if(count($val['childs'])>0){
					
					foreach($val as $k => $v){
						$kiosk_admin_text = "";
						if(strtolower($k) == 'entity') {

							if(isset($val['kiosk']['KIOSKNAME'])){
								if($val['kiosk']['KIOSKNAME']!='null' && $val['kiosk']['KIOSKNAME']!=''){
									$kiosk_admin_text .= '&nbsp;&nbsp;&nbsp; <i class="fa fa-laptop"></i> '.$val['kiosk']['KIOSKNAME'];	
								}
							}

							$return[] = array(
								"id" => $v['ENTITYNAME'] . '___entity',
								"text" => $v['ENTITYNAME'] . $kiosk_admin_text,
								"children" => true	
							);		
						}
					}
				}
				else{
					//$i=0;
					
					foreach($val as $k => $v){
						$kiosk_admin_text = "";
						if(strtolower($k) == 'entity'){

							if($val['kiosk']['KIOSKNAME']!='null' && $val['kiosk']['KIOSKNAME']!=''){
								$kiosk_admin_text .= '&nbsp;&nbsp;&nbsp; <i class="fa fa-laptop"></i> '.$val['kiosk']['KIOSKNAME'];	
							}

							$return[] = array(
								"id" => $v['ENTITYNAME'] . '___entity',
								"text" => $v['ENTITYNAME'] . $kiosk_admin_text
								
							);		
						}

					}
				}
				
			}
		}


		return $return;
	}

	protected function _get_entity_by_entityname(){
		$post = $this->input->post(NULL, TRUE);

		$parent_entity = $this->entities->get_where(array('entities.name' => $post['entity_name']))->result_array();

		return $parent_entity;
	}

	protected function _get_admin_update_form(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('Languages_model', 'lm');
		$this->load->model('Countries_model', 'cm');

		$function = explode('/', $post['apifunction']);
		//get admin info
		$kiosk_config = get_kiosk_config($post['entity_id']);
		$params = 'admin/info/adminname/' . $post['admin_name'] . '/with3RDPData/1';
		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];

		$admin_info = json_decode($this->kiosk->send($params), TRUE);
		$admin_info_array = $admin_info['result']['result'];
		
		//get help admin update
		$kiosk_config = get_kiosk_config($post['entity_id']);
		$params = 'help/admin/update';
		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];

		$admin_update_fields = json_decode($this->kiosk->send($params), TRUE);

		$admin_update_fields_array = isset($admin_update_fields['result']['result']['params']['post']) ? $admin_update_fields['result']['result']['params']['post'] : array();

		$formhtml = "";

		$languages = $this->lm->get()->result_array();
		$countries = $this->cm->get()->result_array();
		
		foreach($admin_update_fields_array as $key => $val){

			$mandatory = '';
			$minlength = '';
			$maxlength = '';
			$pattern = '';

			if(isset($val['mandatory']) && $val['mandatory']==1){
				$mandatory = 'required';
			}

			if($val['type']=='string'){

				if(isset($val['minlength'])){
					$minlength = 'min="'.$val['minlength'].'"';
				}
				if(isset($val['maxlength'])){
					$maxlength = 'max="'.$val['maxlength'].'"';
				}
				if(isset($val['regex'])){
					//$pattern = 'pattern="'.str_replace("\\\\", "\\", $val['regex']).'"';
				}

				if(isset($val['values']) && !empty($val['values'])){
					
					if($val['name']!='revenueshare'){
						$formhtml .= '<div class="form-group">';
						$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
						$formhtml .= 	'<div class="col-sm-6">';
						$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';

							foreach($val['values'] as $opt){
								$selected = '';
								if(array_key_exists($val['name'], $admin_info_array)){
									if($form_values[$val['name']]==$opt){
										$formhtml .= 			'<option value="'.$opt.'" selected="selected">'.$opt.'</option>';          				
									}
									else{
										$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';          					
									}
								}


								
							}
						$formhtml .= 		'</select>';
						$formhtml .= 	'</div>';
						$formhtml .= '</div>';	
					}
					
					

					
				}
				else{
					if($val['name']=='languagecode'){
						$formhtml .= '<div class="form-group">';
						$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
						$formhtml .= 	'<div class="col-sm-6">';
						$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';
							foreach($languages as $language){
									$formhtml .= 			'<option value="'.$language['code'].'">'.$language['name'] . ' ('. $language['code'] . ')</option>';          		
							}
						$formhtml .= 		'</select>';
						$formhtml .= 	'</div>';
						$formhtml .= '</div>';
					}
					elseif($val['name']=='countrycode'){
						$formhtml .= '<div class="form-group">';
						$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
						$formhtml .= 	'<div class="col-sm-6">';
						$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';
							foreach($countries as $country){
						$formhtml .= 			'<option value="'.$country['iso_alpha2'].'">'.strtoupper($country['name']) . ' ('. $country['iso_alpha2'] . ')</option>';          		
							}
						$formhtml .= 		'</select>';
						$formhtml .= 	'</div>';
						$formhtml .= '</div>';
					}
					
					elseif($val['name']=='password'){

						$formhtml .= '<div class="form-group">';
						$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
						$formhtml .= 	'<div class="col-sm-4">';
						$formhtml .= 		'<input type="text" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
						$formhtml .= 	'</div>';
						$formhtml .= 	'<button type="button" class="btn btn-large btn-success btn-password" onclick="generate_password()" >Generate Password</button>';
						$formhtml .= '</div>';
					}
					else{

						$formhtml .= '<div class="form-group">';
						$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
						$formhtml .= 	'<div class="col-sm-6">';
						
						$fieldval = "";
						if(array_key_exists($val['name'], $admin_info_array)){
							$fieldval = $admin_info_array[$val['name']];
						}
						if($val['name']=='entityname' || $val['name']=='kioskname')
							$formhtml .= 		'<input type="text" style="text-transform: uppercase;" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. ' value="'.$fieldval.'">';
						else
							$formhtml .= 		'<input type="text" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. ' value="'.$fieldval.'">';

						

						$formhtml .= 	'</div>';
						$formhtml .= '</div>';
					}
				}	
					
			}
			elseif ($val['type']=='float') {
					$formhtml .= '<div class="form-group">';
					$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
					$formhtml .= 	'<div class="col-sm-6">';
					$formhtml .= 		'<input type="number" step="any" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
					$formhtml .= 	'</div>';
					$formhtml .= '</div>';	
			}
			elseif ($val['type']=='integer') {
				if(isset($val['values']) && !empty($val['values'])){
					if($val['name']!='is_deposit_owner' && $val['name']!='is_deposit_manager' && $val['name']!='is_bonus_owner' && $val['name']!='is_bonus_manager'){
						$formhtml .= '<div class="form-group">';
						$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
						$formhtml .= 	'<div class="col-sm-6">';
						$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';
							foreach($val['values'] as $opt){
						$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';          		
							}
						$formhtml .= 		'</select>';
						$formhtml .= 	'</div>';
						$formhtml .= '</div>';	
					}

				}
				else{
					$formhtml .= '<div class="form-group">';
					$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
					$formhtml .= 	'<div class="col-sm-6">';
					$formhtml .= 		'<input type="number" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
					$formhtml .= 	'</div>';
					$formhtml .= '</div>';	
				}
					
			}
			elseif ($val['type']=='json') {
				if($val['name']=='accesslist'){
					$formhtml .= '
						<div class="box box-primary box-solid">
			            	<div class="box-header with-border">
			              		<h3 class="box-title">Access List</h3>
				              	<div class="box-tools pull-right">
				                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				                	</button>
				              	</div>
			            	</div>
			            
			            	<div class="box-body">';

					$formhtml .= '
								<div class="row">';
					foreach($admin_info_array['accesslist'] as $al => $alv){

						$formhtml .= '
									<div class="col-md-12">
						          		<div class="box box-info box-solid">
						            		<div class="box-header with-border">
						              			<h3 class="box-title">'.$al.'</h3>
						            		</div>
						            <!-- /.box-header -->
						            		<div class="box-body" style="display: block;">
						            			<div class="row">';

						            foreach($alv as $alvk => $alvv){
						            	$checked = $alvv == 1 ? "checked" : "";
						            	$formhtml .= '
						            				<div class="col-md-3">';
						            	$formhtml .= '<input name="accesslist___'.$al.'___'.$alvk.'" type="hidden" value="0">';
						            	$formhtml .= '<input class="al_checkbox" name="accesslist___'.$al.'___'.$alvk.'" type="checkbox" value="1"'. $checked.'> '.$alvk;
						            	$formhtml .= '</div>';
						              
						            }

						            $formhtml .= '
						            			</div>
						            		</div>
						          		</div>
						        	</div>';
					}	
					$formhtml .= '
								</div>
							</div>
						</div>';


				}
				elseif($val['name']=='customreportspermissions'){
					$formhtml .= '
						<div class="box box-primary box-solid">
			            	<div class="box-header with-border">
			              		<h3 class="box-title">Custom Report Permission</h3>
			              	<div class="box-tools pull-right">
			                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                	</button>
			              	</div>
			            </div>
			            
			            <div class="box-body">';

					$formhtml .= '
							<div class="row">';
					foreach($admin_info_array['customreportspermissions'] as $ccpk => $ccpv){
							$checked = $ccpv == 1 ? "checked" : "";
							$formhtml .= '
				            				<div class="col-md-3">';
				            	$formhtml .= '<input name="customreportspermissions___'.$ccpk.'" type="hidden" value="0">';
				            	$formhtml .= '<input name="customreportspermissions___'.$ccpk.'" class="al_checkbox" type="checkbox" value="1"'.$checked.'> '.$ccpk;
				            	$formhtml .= '</div>';
						
					}	
					$formhtml .= '
							</div>
						</div>';
				}
				elseif($val['name']=='3RDPContainer'){
				}
				else{
					$formhtml .= '<div class="form-group">';
					$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
					$formhtml .= 	'<div class="col-sm-6">';
					$formhtml .= 		'<textarea id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" width="100" height="100">';
					$formhtml .= 		'</textarea>';
					$formhtml .= 	'</div>';
					$formhtml .= '</div>';	
				}
					
			}
			else{

			}	
		}

		return $formhtml;

		/*echo "<pre>",print_r($admin_update_fields_array);
		die();*/
	}
	
	protected function _get_form(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('Languages_model', 'lm');
		$this->load->model('Countries_model', 'cm');
		//echo "<pre>",print_r($post),die();	

		$params = 'help/' . $post['apifunction'];

		$function = explode('/', $post['apifunction']);

		$kiosk_config = get_kiosk_config($post['entity_id']);

		$this->load->library('kiosk', $kiosk_config);
		$this->kiosk->tool = 'libcurl';
		$this->kiosk->entity_code = $kiosk_config['entity_code'];

		$help_info = $this->kiosk->send($params);

		$help_info_array = json_decode($help_info, TRUE);
		$formhtml = "";


		$exclude_field = array();
		if($function[0]=='entity'){
			$exclude_field[] = 'parententityname';
			if($function[1]=='update'){
				$exclude_field[] = 'entityname';
			}
		}
		if($function[0]=='kiosk' || $function[0]=='admin'){
			$exclude_field[] = 'entityname';	

		}

		$languages = $this->lm->get()->result_array();
		$countries = $this->cm->get()->result_array();

		$form_values = array();

		if($post['apifunction']=='entity/update'){
			$form_values = $this->get_entity_info($post['entity_name'], $post['entity_id']);
		}
		if($post['apifunction']=='admin/update'){
			//$entity_info_array = $this->get_admin_info($post['parententityname'], $post['entity_id']);	
		}
		if($post['apifunction']=='kiosk/update'){
			$form_values = $this->get_kiosk_info($post['kioskname'], $post['entity_id']);
		}

		if(isset($form_values['restrictedcountry'])){
			$form_values['restricted_countrycode'] = $form_values['restrictedcountry'];
			///unset($form_values['restrictedcountry']);
		}
		
		$kioskname = isset($post['kioskname']) ? $post['kioskname'] : '';
		$form_values['kioskname'] = $kioskname;

		//for kiosk update

		$form_values['ask_password_on_action'] = isset($form_values['askpasswordonaction']) ? $form_values['askpasswordonaction'] : '';
		$form_values['cashout_receipt_enabled'] = isset($form_values['cashoutreceiptenabled']) ? $form_values['cashoutreceiptenabled'] : '';
		$form_values['confirm_deposit_action'] = isset($form_values['confirmdepositaction']) ? $form_values['confirmdepositaction'] : '';
		$form_values['confirm_newplayer_action'] = isset($form_values['confirmnewplayeraction']) ? $form_values['confirmnewplayeraction'] : '';
		$form_values['player_username_minlength'] = isset($form_values['playerusernameminlength']) ? $form_values['playerusernameminlength'] : '';
		$form_values['player_username_maxlength'] = isset($form_values['playerusernamemaxlength']) ? $form_values['playerusernamemaxlength'] : '';
		$form_values['player_username_prefix'] = isset($form_values['playerusernameprefix']) ? $form_values['playerusernameprefix'] : '';
		$form_values['player_username_only_numbers'] = isset($form_values['playerusernameonlynumbers']) ? $form_values['playerusernameonlynumbers'] : '';
		$form_values['player_password_minlength'] = isset($form_values['playerpasswordminlength']) ? $form_values['playerpasswordminlength'] : '';
		$form_values['player_password_maxlength'] = isset($form_values['playerpasswordmaxlength']) ? $form_values['playerpasswordmaxlength'] : '';
		$form_values['player_pwd_from_toplevel_ent'] = isset($form_values['playerpwdfromtoplevelent']) ? $form_values['playerpwdfromtoplevelent'] : '';
		$form_values['default_player_password'] = isset($form_values['defaultplayerpassword']) ? $form_values['defaultplayerpassword'] : '';
		$form_values['unfriendly_player_passwords'] = isset($form_values['unfriendlyplayerpasswords']) ? $form_values['unfriendlyplayerpasswords'] : '';
		$form_values['def_viplevel'] = isset($form_values['defviplevel']) ? $form_values['defviplevel'] : '';
		$form_values['passwordchange'] = isset($form_values['password_change']) ? $form_values['password_change'] : '';


		
		if(isset($help_info_array['result']['result'])){
			foreach($help_info_array['result']['result']['params']['post'] as $key => $val){

				if(! in_array($val['name'], $exclude_field)){
					$mandatory = '';
					$minlength = '';
					$maxlength = '';
					$pattern = '';

					if(isset($val['mandatory']) && $val['mandatory']==1){
						$mandatory = 'required';
					}

					if($val['type']=='string'){

						if(isset($val['minlength'])){
							$minlength = 'min="'.$val['minlength'].'"';
						}
						if(isset($val['maxlength'])){
							$maxlength = 'max="'.$val['maxlength'].'"';
						}
						if(isset($val['regex'])){
							//$pattern = 'pattern="'.str_replace("\\\\", "\\", $val['regex']).'"';
						}

						if(isset($val['values']) && !empty($val['values'])){
							if($function[1]=='update'){
								if($val['name']!='revenueshare'){
									$formhtml .= '<div class="form-group">';
									$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
									$formhtml .= 	'<div class="col-sm-6">';
									$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';

										foreach($val['values'] as $opt){
											$selected = '';
											if(array_key_exists($val['name'], $form_values)){
												if($form_values[$val['name']]==$opt){
													$formhtml .= 			'<option value="'.$opt.'" selected="selected">'.$opt.'</option>';          				
												}
												else{
													$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';          					
												}
											}
											
										}
									$formhtml .= 		'</select>';
									$formhtml .= 	'</div>';
									$formhtml .= '</div>';	
								}
							}
							else{
								$formhtml .= '<div class="form-group">';
								$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
								$formhtml .= 	'<div class="col-sm-6">';
								$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';

									foreach($val['values'] as $opt){
										$selected = '';
										if($function[1]=='update'){
											if(array_key_exists($val['name'], $form_values)){
												if($form_values[$val['name']]==$opt){
													$formhtml .= 			'<option value="'.$opt.'" selected="selected">'.$opt.'</option>';          				
												}
												else{
													$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';          					
												}
											}
										}
										else{
											$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';          			
										}	



										
									}
								$formhtml .= 		'</select>';
								$formhtml .= 	'</div>';
								$formhtml .= '</div>';	
							}

							
						}
						else{
							if($val['name']=='languagecode'){
								$formhtml .= '<div class="form-group">';
								$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
								$formhtml .= 	'<div class="col-sm-6">';
								$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';
									foreach($languages as $language){
											$formhtml .= 			'<option value="'.$language['code'].'">'.$language['name'] . ' ('. $language['code'] . ')</option>';          		
									}
								$formhtml .= 		'</select>';
								$formhtml .= 	'</div>';
								$formhtml .= '</div>';
							}
							elseif($val['name']=='countrycode'){
								$formhtml .= '<div class="form-group">';
								$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
								$formhtml .= 	'<div class="col-sm-6">';
								$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';
									foreach($countries as $country){
								$formhtml .= 			'<option value="'.$country['iso_alpha2'].'">'.strtoupper($country['name']) . ' ('. $country['iso_alpha2'] . ')</option>';          		
									}
								$formhtml .= 		'</select>';
								$formhtml .= 	'</div>';
								$formhtml .= '</div>';
							}
							
							elseif($val['name']=='password'){

								$formhtml .= '<div class="form-group">';
								$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
								$formhtml .= 	'<div class="col-sm-4">';
								$formhtml .= 		'<input type="text" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
								$formhtml .= 	'</div>';
								$formhtml .= 	'<button type="button" class="btn btn-large btn-success btn-password" onclick="generate_password()" >Generate Password</button>';
								$formhtml .= '</div>';
							}
							else{

								$formhtml .= '<div class="form-group">';
								$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
								$formhtml .= 	'<div class="col-sm-6">';
								if($function[1]=='update'){
									$fieldval = "";
									if(array_key_exists($val['name'], $form_values)){
										$fieldval = $form_values[$val['name']];
									}
									if($val['name']=='entityname' || $val['name']=='kioskname')
										$formhtml .= 		'<input type="text" style="text-transform: uppercase;" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. ' value="'.$fieldval.'">';
									else
										$formhtml .= 		'<input type="text" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. ' value="'.$fieldval.'">';

								}
								else{
									if($val['name']=='entityname' || $val['name']=='kioskname')
										$formhtml .= 		'<input type="text" style="text-transform: uppercase;" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
									else
										$formhtml .= 		'<input type="text" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';

								}
								

								$formhtml .= 	'</div>';
								$formhtml .= '</div>';
							}
						}	
							
					}
					elseif ($val['type']=='float') {
							$formhtml .= '<div class="form-group">';
							$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
							$formhtml .= 	'<div class="col-sm-6">';
							$formhtml .= 		'<input type="number" step="any" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
							$formhtml .= 	'</div>';
							$formhtml .= '</div>';	
					}
					elseif ($val['type']=='integer') {
						if(isset($val['values']) && !empty($val['values'])){
							if($val['name']!='is_deposit_owner' && $val['name']!='is_deposit_manager' && $val['name']!='is_bonus_owner' && $val['name']!='is_bonus_manager'){
								$formhtml .= '<div class="form-group">';
								$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
								$formhtml .= 	'<div class="col-sm-6">';
								$formhtml .= 		'<select id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" style="width:100%;">';

									foreach($val['values'] as $opt){
											$selected = '';
											if(array_key_exists($val['name'], $form_values)){
												if($form_values[$val['name']]==$opt){
													$formhtml .= 			'<option value="'.$opt.'" selected="selected">'.$opt.'</option>';          				
												}
												else{
													$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';          					
												}
											}
											else{
												$formhtml .= 			'<option value="'.$opt.'">'.$opt.'</option>';   
											}
											
										}

								$formhtml .= 		'</select>';
								$formhtml .= 	'</div>';
								$formhtml .= '</div>';	
							}

						}
						else{
							$formhtml .= '<div class="form-group">';
							$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
							$formhtml .= 	'<div class="col-sm-6">';
							$formhtml .= 		'<input type="number" class="form-control" id="'.$val['name'].'" name="'.$val['name'].'" placeholder="'.$val['description'].'" '.$mandatory. ' ' .$minlength. ' ' .$maxlength. ' ' .$pattern. '>';
							$formhtml .= 	'</div>';
							$formhtml .= '</div>';	
						}
							
					}
					elseif ($val['type']=='json') {
							$formhtml .= '<div class="form-group">';
							$formhtml .= 	'<label for="name" class="col-sm-4 control-label">'.ucfirst(str_replace('_', ' ', $val['name'])).'</label>'; 
							$formhtml .= 	'<div class="col-sm-6">';
							$formhtml .= 		'<textarea id="'.$val['name'].'" name="'.$val['name'].'" class="form-control" width="100" height="100">';
							$formhtml .= 		'</textarea>';
							$formhtml .= 	'</div>';
							$formhtml .= '</div>';	
					}
					else{

					}	

					
				}
			}
			$formhtml .= '<div style="text-align: center" id="error_div"></div>';
			$formhtml .= '<input name="apirequest" value="'. $post['apifunction'] .'" type="hidden">';
		}

						
		return array('formfields' => $formhtml);

	}


}
