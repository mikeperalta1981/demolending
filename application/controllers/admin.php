<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {
	private $data = array();
	public $javascripts = array('js/plugins/datatables/jquery.dataTables.js', 'js/plugins/datatables/fnReloadAjax.js', 'js/plugins/datatables/dataTables.bootstrap.js', 'js/pages-js/admin.js');
	public $css = array('css/datatables/dataTables.bootstrap.css', 'css/pages-css/admin.css');
	private $user_info = array();
	
	public function __construct(){
		parent::__construct();
		
		$this->user_info = $this->session->userdata('logged_in');
		
	}
	
	public function index()
	{
		$this->load->helper('template');
		$this->load->model('branches_model', 'branches');
		
		$this->db->select('ba.*, CONCAT(c.lastname, " ", c.firstname, " ", c.middlename) as collector_name', FALSE);
		$this->db->from('branch_areas ba');
		$this->db->join('collectors c', 'ba.collector_id=c.id', 'left');
		$this->db->where('ba.active =' , '1');
		$this->db->order_by('ba.area_name', 'asc');
		$query = $this->db->get();
		$branch_areas = $query->result_array();
		
		$this->data = array(
			'branch_areas' => $branch_areas
		);
		render_page('admin_page', $this->data);
	}
	
	public function create_area(){
		$post = $this->input->post(NULL, TRUE);
		$post['branch_id'] = '1';
		$post['active'] = '1';
		$id = $this->db->insert('branch_areas', $post);
		
		$response = array(
				'success' => TRUE,
				'id' => $id
		);
			
		echo json_encode($response);
	}
	
	public function create_collector(){
		$post = $this->input->post(NULL, TRUE);
		//$post['branch_id'] = '1';
		//$post['active'] = '1';
		$area_id = $post['area_id'];
		unset($post['area_id']);
		
		$this->db->insert('collectors', $post);
		$id =  $this->db->insert_id();
		$data = array(
				'collector_id' => $id
		);
		//echo $area_id;
		//echo $id;
		//die;
		
		
		$this->db->where('id', $area_id);
		$this->db->update('branch_areas', $data);
		
		$response = array(
				'success' => TRUE,
				'id' => $id
		);
			
		echo json_encode($response);
	}
	
	public function create_user(){

		$post = $this->input->post(NULL, TRUE);
		
		$post['active'] = '1';
		$post['password'] = md5($post['password']);
		$this->db->insert('users', $post);
		$id =  $this->db->insert_id();
		$data = array(
				'id' => $id
		);
		
		$response = array(
				'success' => TRUE,
				'id' => $id
		);
			
		echo json_encode($response);
		
	}
	
	public function get_area_name(){
		$this->db->select();
		$this->db->from('branch_areas');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		$branch_areas = $query->result_array();
		$branchnum = $branch_areas[0]['id'] + 1;
		$data = array(
				'area_name' => 'Area' . $branchnum
		);
	
		echo json_encode($data);
	}
	
	
	public function get_area_by_id(){
		$post = $this->input->post(NULL, TRUE);
		
		$query = $this->db->get_where('branch_areas', array('id' => $post['id']));

		$result = $query->result_array();
		
		echo json_encode($result);
	}
	
	public function get_user_by_id(){
		$post = $this->input->post(NULL, TRUE);
	
		$query = $this->db->get_where('users', array('id' => $post['id']));
	
		$result = $query->result_array();
	
		echo json_encode($result);
	}
	
	public function get_collector_by_id(){
		$post = $this->input->post(NULL, TRUE);
	
		$this->db->select('c.*, ba.id as area_id, ba.area_name as area_name', FALSE);
		$this->db->from('collectors c');
		$this->db->join('branch_areas ba', 'c.id=ba.collector_id', 'left');
		$this->db->where('c.id', $post['id']);
		$this->db->order_by('c.lastname', 'asc');
		$query = $this->db->get();
		
		//$query = $this->db->get_where('collectors', array('id' => $post['id']));
	
		$result = $query->result_array();
	
		echo json_encode($result);
	}
	
	public function get_area_table(){
		
		$this->db->select('ba.*, b.id as branch_id', FALSE);
		$this->db->from('branch_areas ba');
		$this->db->join('branches b', 'ba.branch_id=b.id', 'left');
		$this->db->order_by('ba.area_name', 'asc');
		$query = $this->db->get();
		
		
		$result = $query->result_array();
		//--compose array for table
		$area_data = array();
		foreach($result as $val){
			
			$action = "<a href='#' class='edit-area' title='Edit' data-id='".$val["id"]."' data-toggle='modal' ><i class='fa fa-edit'></i></a>";
			//$action .= "<a href='#' title='Deactivate' data-id='".$val["id"]."'><i class='fa fa-minus-square-o'></i></a>";
			
			if($val['active']==1){
				$status = '<span class="label label-success">Active</span>';
			}
			else{
				$status = '<span class="label label-danger">Deactivated</span>';
			}
			
			$area_data[] = array(
				"id" => $val['id'],
				"area_name" => $val['area_name'],
				"date_created" => $val['born'],
				"status" => $status, 
				"action" => $action
			);
		}
		
		$data = array();
		foreach($area_data as $val){
			
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
	
	
	public function get_users_table(){

		$query = $this->db->get('users');
		$result = $query->result_array();
		
		$usertype = array(
			"1" => "Super User",
			"2" => "Manager",
			"3" => "Secretary",
			"4" => "Cashier"	
		);
		//--compose array for table
		$user_data = array();
		foreach($result as $val){
		
			$action = "<a href='#' class='edit-user' title='Edit' data-id='".$val["id"]."' data-toggle='modal' ><i class='fa fa-edit'></i></a>";
			
		
			if($val['active']==1){
				$status = '<span class="label label-success">Active</span>';
				$action .= "<a href='#' class='deactivate-user' title='Deactivate' data-id='".$val["id"]."' data-name='".$val["lastname"]. " ". $val['firstname'] . " " . $val['middlename'] . "'><i class='fa fa-minus-square-o'></i></a>";
			}
			else{
				$status = '<span class="label label-danger">Deactivated</span>';
				$action .= "<a href='#' class='activate-user' title='Activate' data-id='".$val["id"]."' data-name='".$val["lastname"]. " ". $val['firstname'] . " " . $val['middlename'] . "'><i class='fa fa-check-square-o'></i></a>";
				
			}
		
			$user_data[] = array(
					"id" => $val['id'],
					"name" => $val['lastname'] . " " . $val['firstname']. " ". $val['middlename'] . " " . $val['suffix'],
					"user_type" => $usertype[$val['user_type']],
					"username" => $val['username'],
					"status" => $status,
					"action" => $action
			);
		}
		
		$data = array();
		foreach($user_data as $val){
		
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
	
	public function get_collector_table(){
	
		$this->db->select('c.*, ba.id as area_id, ba.area_name as area_name', FALSE);
		$this->db->from('collectors c');
		$this->db->join('branch_areas ba', 'c.id=ba.collector_id', 'left');
		$this->db->order_by('c.lastname', 'asc');
		$query = $this->db->get();
	
	
		$result = $query->result_array();
		//--compose array for table
		$area_data = array();
		foreach($result as $val){
				
			$action = "<a href='#' class='edit-collector' title='Edit' data-id='".$val["id"]."' data-toggle='modal' ><i class='fa fa-edit'></i></a>";
			//$action .= "<a href='#' title='Deactivate' data-id='".$val["id"]."'><i class='fa fa-minus-square-o'></i></a>";
				
			if($val['active']==1){
				$status = '<span class="label label-success">Active</span>';
			}
			else{
				$status = '<span class="label label-danger">Deactivated</span>';
			}
				
			$area_data[] = array(
					"id" => $val['id'],
					"collector_name" => $val['lastname'] . " " . $val['firstname']. " ". $val['middlename'],
					"area" => $val['area_name'],
					"status" => $status,
					"action" => $action
			);
		}
	
		$data = array();
		foreach($area_data as $val){
				
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
	
	public function update(){
		
		$post = $this->input->post(NULL, TRUE);
		
		$data = array(
				'area_name' => $post['area_name'],
				'born' => $post['born']
		);
		
		$this->db->where('id', $post['id']);
		$this->db->update('branch_areas', $data);
		
		$response = array(
			'success' => TRUE
		);
			
		
		echo json_encode($response);
		
		
	}
	
	public function update_collector(){
	
		$post = $this->input->post(NULL, TRUE);
	
		$data = array(
				'lastname' => $post['lastname'],
				'firstname' => $post['firstname'],
				'middlename' => $post['middlename']
		);
	
		$this->db->where('id', $post['id']);
		$this->db->update('collectors', $data);
		
		$data1 = array(
			'collector_id' => $post['id']	
		);
		
		$this->db->where('id', $post['area_id']);
		$this->db->update('branch_areas', $data1);
	
		
		$response = array(
				'success' => TRUE
		);
			
	
		echo json_encode($response);
	
	
	}
	
	public function update_user(){
	
		$post = $this->input->post(NULL, TRUE);
	
		if($post['password']!=''){
			$post['password'] = md5($post['password']);
		}
		else{
			unset($post['password']);
		}
		$id = $post['id'];
		unset($post['id']);
		
		/* $data = array(
				'lastname' => $post['lastname'],
				'firstname' => $post['firstname'],
				'middlename' => $post['middlename']
		); */
	
		$this->db->where('id', $id);
		$this->db->update('users', $post);
	
		$response = array(
				'success' => TRUE
		);
			
	
		echo json_encode($response);
	
	
	}
	
	public function deactivate_user(){
		$post = $this->input->post(NULL, TRUE);

		$data = array(
		 'active' => '0'
		);
		
		$this->db->where('id', $post['id']);
		$this->db->update('users', $data);
		
		$response = array(
				'success' => TRUE
		);
		
		echo json_encode($response);
		
	}
	
	public function activate_user(){
		$post = $this->input->post(NULL, TRUE);
	
		$data = array(
			 'active' => '1'
		);
	
		$this->db->where('id', $post['id']);
		$this->db->update('users', $data);
	
		$response = array(
				'success' => TRUE
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
	
	public function get_branch_areas_no_collector(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('branch_areas_model', 'branch_areas');
		$branch_areas = $this->branch_areas->get_by_branch_id($post['id']);
		$html = "";
		foreach($branch_areas as $val){
			if($val['collector_id']==0)
				$html .= "<option value='".$val['id']."'>".$val['area_name']."</option>";
		}
	
		echo $html;
	}
	
	
	public function backup_database(){
		// Load the DB utility class
		$this->load->dbutil();
		
		
		$prefs = array(
				'tables'      => array(),  // Array of tables to backup.
				'ignore'      => array(),           // List of tables to omit from the backup
				'format'      => 'txt',             // gzip, zip, txt
				//'filename'    => 'ccc_db_'.date('Y-m-d').'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
				'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
				'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
				'newline'     => "\n"               // Newline character used in backup file
		);
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs);
		
		// Load the file helper and write the file to your server
		
		/*
		$this->load->helper('file');
		$db_filename = 'glc_db_'.date('Y-m-d').'.sql';
		write_file('backup/' . $db_filename, $backup);
		
		

		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'ginhawalending2016@gmail.com',
		    'smtp_pass' => 'Ginhawa2016',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1'
		);

	
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		//$this->email->initialize($config);

		//$this->load->library('email', $config);

		$this->email->from('ginhawalending2016@gmail.com', 'Ginhawa Lending Company');
		$this->email->to('megsperalta@gmail.com'); 
		$this->email->cc('musteranerizza@ymail.com'); 
		$this->email->bcc(''); 

		$this->email->subject('Database Backup');
		$this->email->message('GLC Database Backup as of ' . date('Y-m-d'));	
		$this->email->attach('backup/' . $db_filename);

		$this->email->send();
		*/


		//echo $this->email->print_debugger();	die();


		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('glc_db_'.date('Y-m-d').'.sql', $backup);
		
		
	}
	
	public function check_username(){
		$post = $this->input->post(NULL, TRUE);
		
		$this->db->where('username', $post['username']);
		$query = $this->db->get('users');
		
		$result = $query->result_array();
		
		$success = true;
		if(count($result) > 0){
			$success = false;
		}
		
		echo json_encode(array('success' => $success));
	}
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */