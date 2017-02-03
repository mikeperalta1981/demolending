<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends MY_Controller {
	private $data = array();
	public $javascripts = array(
		'js/plugins/datatables/jquery.dataTables.js', 
		'js/plugins/datatables/fnReloadAjax.js', 
		'js/plugins/datatables/dataTables.bootstrap.js'
		,'plugins/input-mask/jquery.inputmask.js'
		,'plugins/input-mask/jquery.inputmask.extensions.js'
		,'plugins/input-mask/jquery.inputmask.numeric.extensions.js'
		,'js/pages-js/customers.js');
	public $css = array('css/datatables/dataTables.bootstrap.css', 'css/pages-css/customers.css');
	private $user_info = array();
	
	public function __construct(){
		parent::__construct();
		
		$this->user_info = $this->session->userdata('logged_in');
	}
	
	public function index()
	{
		$this->load->model('customers_house_type_model', 'house_type');
		$this->load->model('customers_assets_model', 'assets');
		$this->load->helper('template');
		$this->load->model('branches_model', 'branches');
		
		$house_type = $this->house_type->get();
		$assets = $this->assets->get();
		
		$this->data = array(
			'house_type' => $house_type,
			'assets' => $assets,
			'branches' => $this->branches->get()
		);
		render_page('customers_page', $this->data);
	}
	
	
	public function get_account_no(){
		$this->load->model('customers_model', 'cm');
	
		$customers = $this->cm->get();
		$account_no_array = array();
		foreach($customers as $val){
			$account_no_array[] = $val['account_no'];
		}
		//echo "<PRE>",print_r($account_no_array),die;
		rsort($account_no_array);
	
		$data = array(
				'account_no' => isset($account_no_array[0]) ? $account_no_array[0] + 1 : 100001
		);
	
		echo json_encode($data);
	}
	
	private function check_customer($surname, $firstname, $middlename){
		
		$this->db->where('surname', $surname);
		$this->db->where('firstname', $firstname);
		$this->db->where('middlename', $middlename);
		$query = $this->db->get('customers');
		
		$result = $query->result_array();
		
		$success = true;
		if(count($result)>0){
			$success = false;
		}
		
		return $success;
	}
	
	public function create(){
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->model('customers_model', 'customers');
		$this->load->model('customers_references_model', 'customers_references');
		$post = $this->input->post(NULL, TRUE);
		
		$crdata = array();
		foreach($post as $key => $val){
			if(is_array($val)){
				$post[$key] = json_encode($val);
			} 
			else{
				if(substr($key, 0, 3)=='cr_'){
					$crdata[$key] = $val; 
					unset($post[$key]);
				}	
			}
			
		}
		
		//echo "<pre>";print_r($post);die;
		
		$data = array();
		$data = array_filter($post);
		$data['active'] = 1;
		$this->customers->data = $data;
		
		if($this->check_customer($post['surname'], $post['firstname'], $post['middlename'])){
			$customer_id = $this->customers->create();
			
			$response = array();
			if($customer_id){
					
				$ctr = 1;
				$references = array();
				$params = array();
				foreach($crdata as $key => $val){
					$counter = substr($key, -1);
					if($ctr==$counter){
						$tmpkey = substr(substr($key, 3), 0, -1);
						$references[$tmpkey] = $val;
						if($key=="cr_is_dependent" . $counter){
							$references['customer_id'] =  $customer_id;
							$ctr++;
							array_push($params, $references);
							$references = array();
						}
					}
						
				}
					
				foreach($params as $key => $val){
					if($val['surname']==""){
						unset($params[$key]);
					}
				}
					
				$this->customers_references->create_batch($params);
					
				$response = array(
						'success' => TRUE,
						'customer_id' => $customer_id
				);
					
			}	
		}
		else{
			$response = array(
					'success' => FALSE
			);
		}
		
		
		echo json_encode($response);
		
	}
	
	public function update(){
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->model('customers_model', 'customers');
		$this->load->model('customers_references_model', 'customers_references');
		$post = $this->input->post(NULL, TRUE);
		
		if(isset($post['house_type'])){
			$post['house_type'] = json_encode($post['house_type']);
		}
		
		if(isset($post['assets'])){
			$post['assets'] = json_encode($post['assets']);
		}
		
		
		$crdata = array();
		foreach($post as $key => $val){
			if(is_array($val)){
				$post[$key] = json_encode($val);
			} 
			else{
				if(substr($key, 0, 3)=='cr_'){
					$crdata[$key] = $val; 
					unset($post[$key]);
				}	
			}
			
		}
		
		
		
		$data = array();
		$data = array_filter($post);
		
		$this->customers->id = $post['id'];
		$cust_id = $post['id'];
		unset($post['id']);
		$this->customers->data = $data;
		$customer_id = $this->customers->update();
		
		$response = array();
		
		
		/**
		 * 
		 * Update Customer references
		 * @var unknown_type
		 */	
		
		$ctr = 1;
		$references = array();
		$params = array();
		foreach($crdata as $key => $val){
				$counter = substr($key, -1);
				if($ctr==$counter){
					$tmpkey = substr(substr($key, 3), 0, -1);
					$references[$tmpkey] = $val;
					if($key=="cr_is_dependent" . $counter){
						//$references['customer_id'] =  $customer_id;
						$ctr++;
						array_push($params, $references);
						$references = array();
					}	
				}
				
		}
		
		foreach($params as $key => $val){
			if($val['surname']==""){
				unset($params[$key]);
			}	
		}
		
		$update_params = array();
		$create_params = array();
		foreach($params as $val){
			if(empty($val['id'])){
				$val['customer_id'] = $cust_id;
				$create_params[] = $val;
			}
			else{
				$val['updated_at'] = date('Y-m-d H:i:s');
				$update_params[] = $val;
			}
		}
		
		
		if(! empty($create_params)){
			$this->customers_references->create_batch($create_params);	
		}
		if(! empty($update_params)){
			$this->customers_references->data = $update_params;
			$this->customers_references->update_batch();
		}
		
		
		
		$response = array(
			'success' => TRUE,
			'customer_id' => $customer_id  
		);
			
		
		echo json_encode($response);
		
		
	}
	
	
	private function get(){
		$this->load->model('customers_model', 'customers');
		$result = $this->customers->get();
		return $result;
	}
	
	public function select_option_customers(){
		$customers = $this->get();
		$options = "<option value=''>-Select-</option>";
		foreach($customers as $val){
			$options .= "<option value='".$val['id']."'>".$val['surname'] . ", " . $val['firstname'] . " " . $val['middlename']."</option>";
		}
		
		echo $options;
	}
	
	public function select_option_customers_add(){
		$this->db->select();
		$this->db->from('customers');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		
		$customers = $query->result_array();		
		
		//$options = "<option value=''>-Select-</option>";
		$options = "<option></option>";
		foreach($customers as $val){
			$options .= "<option value='".$val['id']."'>".$val['surname'] . ", " . $val['firstname'] . " " . $val['middlename']."</option>";
		}
	
		echo $options;
	}
	
	public function customer_datatable(){
		
		$result = $this->get();
		//--compose array for table
		$customer_data = array();
		foreach($result as $val){
			$action = "";
			if($this->user_info['user_type']<2){
				$action .= "<a href='#' class='edit-customer' title='Edit' data-id='".$val["id"]."' data-toggle='modal' ><i class='fa fa-edit'></i></a>";
			}
			else{
				$action .= "<a href='#' class='edit-customer' title='Edit' data-id='".$val["id"]."' data-toggle='modal' ><i class='fa fa-eye'></i></a>";
			}
			
			/* $action .= "&nbsp;&nbsp;";
			$action .= "<a href='#' title='Deactivate' data-id='".$val["id"]."'><i class='fa fa-minus-square-o'></i></a>";
			$action .= "&nbsp;&nbsp;";
			$action .= "<a href='#' title='Loan Details' data-id='".$val["id"]."'><i class='fa fa-tasks'></i></a>"; */
			
			$customer_data[] = array(
				"id" => $val['id'],
				"account_no" => $val['account_no'],
				"name" => $val['surname'] . ", " . $val['firstname'] . " " . $val['middlename'],
				"address" => $val['address_home_no'] . " " . $val['address_st_name'] . " " . $val['address_brgy'] . " " . $val['address_municipality'] . " " . $val['address_city'] . " " . $val['address_prov'] . " " . $val['postal_code'], 
				"home_phone" => $val['residence_phone'],
				"mobile_phone" => $val['mobile_phone'],
				"enrolled_date" => date("Y-m-d", strtotime($val['created_at'])),
				"action" => $action
			);
		}
		
		$data = array();
		foreach($customer_data as $val){
			
			$row = array();	
			
			foreach($val as $k => $v){
				$row[] = $v;
			}
			
			$data[] = $row;
		}
		
		$return = array(
			"sEcho" => count($data),
    		"iTotalRecords" => count($data),
    		"iTotalDisplayRecords" =>  count($data),
			"aaData" => $data
		);
		
		
		echo json_encode($return);
	}
	
	//for datatable 1.10.4
	public function get1(){
		$this->db->select('c.id, c.account_no, CONCAT(c.surname,", ", c.firstname, " ", c.middlename) as account_name, l.loan_amount, l.loan_proceeds, l.date_released, l.maturity_date, l.daily_amort', FALSE);
		$this->db->from('customers c');
		$this->db->join('customers_loan l', 'l.customer_id=c.id', 'left');
		$query = $this->db->get();
		
		$result = $query->result_array();
		
		$data = array();
				
		foreach($result as $val){
			$val['action'] = "";
			$data[] = $val;
		}
		
		echo json_encode(array('data' => $data));
	}
	
	public function get_customer_by_id(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customers_model', 'customers');
		$this->load->model('customers_references_model', 'customers_references');
		
		$this->customers->id = $post['id'];
		$this->customers_references->id = $post['id'];
		
		$customers_data = $this->customers->get_by_id();
		$customers_references_data = $this->customers_references->get_by_customer_id();
		
		$result = array(
			"customers_data" => $customers_data,
			"customers_references_data" => $customers_references_data 
		);
		
		echo json_encode($result);
	}
	
	public function get_branch_areas(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('branch_areas_model', 'branch_areas');
		$branch_areas = $this->branch_areas->get_by_branch_id($post['id']);
		$html = "";
		foreach($branch_areas as $val){
			$html .= "<option value='".$val['id']."'>".$val['area_name']."</option>";
		}
		
		echo $html;
	}
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */