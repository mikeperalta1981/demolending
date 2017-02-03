<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_applications extends MY_Controller {
	private $data = array();
	private $userinfo = array();
	public $javascripts = array(
		'js/plugins/datatables/jquery.dataTables.js', 
		'js/plugins/datatables/fnReloadAjax.js', 
		'js/plugins/datatables/dataTables.bootstrap.js', 
		'js/jquery.numeric.min.js', 
		'js/bootbox.min.js', 
		'js/select2.min.js',
		'plugins/bootstrap-switch-master/dist/js/bootstrap-switch.min.js',
		'js/pages-js/loan_applications.js'
	);
	public $css = array(
		'css/datatables/dataTables.bootstrap.css', 
		'css/select2.min.css', 
		'plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.min.css',
		'css/pages-css/loan_applications.css'
	);
	private $configs = array();
	
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('configs_model', 'conf');
		
		//temporary. iyo ini ang igoglobal pag login pa lang kan sarong emple
		$this->configs = $this->conf->get_by_business_id('cfsi1');
		$this->userinfo = $this->session->userdata('logged_in');
		
	}
	
	public function index()
	{
		$this->load->helper('template');

		
		$this->data = array(
			"payment_mode" => $this->get_payment_mode()
		);
		render_page('loan_applications_page', $this->data);
	}
	
	public function recommend_loan(){
		$this->load->helper('form');
		$this->load->model('customer_loan_model', 'clm');
		$post = $this->input->post(NULL, TRUE);
		$data = array(
				"application_status" => '1'
		);
		
		$this->clm->id = $post['loan_id'];
		$this->clm->data = $data;
		$this->clm->update();
		
		$response = array(
				'success' => TRUE
		);
		
		echo json_encode($response);
	}
	
	public function deny_loan(){
		$this->load->helper('form');
		$this->load->model('customer_loan_model', 'clm');
		$post = $this->input->post(NULL, TRUE);
		$data = array(
				"reason_denied" => $post['reason_denied'],
				"application_status" => '3'
		);
		
		$this->clm->id = $post['loan_id'];
		$this->clm->data = $data;
		$this->clm->update();
		
		$response = array(
				'success' => TRUE
		);
		
		echo json_encode($response);
	}
	
	public function update_to_pending(){
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->model('customer_loan_model', 'clm');
		$post = $this->input->post(NULL, TRUE);
				
		$data = array(
			"date_released" => '0000-00-00',
			"maturity_date" => '0000-00-00',
			"application_status" => '0'
		);
		
		$this->clm->id = $post['loan_id'];
		$this->clm->data = $data;
		$this->clm->update();
		
		
		$response = array(
			'success' => TRUE
		);
		
		echo json_encode($response);
	
		
	}
	
	public function approve_loan(){
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->model('customer_loan_model', 'clm');
		
		$post = $this->input->post(NULL, TRUE);
		
		$loan_details = $this->clm->get_by_loan_id($post['loan_id']);
		
		$loan_info = $loan_details[0];
		
		$tmpdate = str_replace('-', '/', $post['date_released']);
		
		$duration = 0;
		$semimonthly_amort_day_start = "";
		$monthly_amort_day_start = "";
		
		if($loan_info['mopid']==1){
			$duration = $loan_info['loan_term_duration'];
			$amort_period = strtotime($tmpdate . "+" .$duration. "days");
			$amort_day_start = date('Y-m-d', strtotime($tmpdate . "+1 days"));
		}
		elseif($loan_info['mopid']==2){
			//$duration = $loan_info['loan_term_duration']/2;
			$duration = $loan_info['loan_term_duration'];
			
			$amort_period = strtotime($tmpdate . "+" .$duration. "months");
			//echo $tmpdate . "+" .$duration. "months";die;
			if(date('d', strtotime($tmpdate))<=15){
				$semimonthly_amort_day_start = date('Y/m/15', strtotime($tmpdate));
			}
			else{
				$semimonthly_amort_day_start = date('Y/m/t', strtotime($tmpdate));
			}
			
			$amort_day_start = date('Y-m-d', strtotime($semimonthly_amort_day_start . "+1 days"));
		}
		else{
			$amort_period = strtotime($tmpdate . "+" .$loan_info['loan_term_duration']. "months");
			$monthly_amort_day_start = date('Y/m/t', strtotime($tmpdate));
			$amort_day_start = date('Y-m-d', strtotime($monthly_amort_day_start . "+1 days"));
		}
		
		$maturity_date = date("Y-m-d", $amort_period);
		//echo $maturity_date;die;
		$amort_day_end = date('Y-m-d', strtotime($maturity_date));		
				
		$data = array(
			"date_released" => $post['date_released'],
			"maturity_date" => $maturity_date,
			"application_status" => '2'
		);
		
		$this->clm->id = $post['loan_id'];
		$this->clm->data = $data;
		$this->clm->update();
		
		
		if($loan_info['mopid']==1){
			$amort_dates = $this->createDateRangeArray($amort_day_start, $amort_day_end);
		}
		elseif($loan_info['mopid']==2){
			$amort_dates = $this->createSemiMontlySched($post['date_released'], $loan_info['loan_term_duration']);
		}
		else{
			$amort_dates = $this->createMontlySched($post['date_released'], $loan_info['loan_term_duration']);
		}
		
		
		$response = array(
			'success' => TRUE
		);
		
		echo json_encode($response);
		
	
		
	}
	
	public function get_notarial_fee(){
		$post = $this->input->post(NULL, TRUE);
		//get notarial fee
		$query = $this->db->get('notarial_fee');

		$notarial_fee = $query->result_array();
		$fee = 0;
		foreach($notarial_fee as $val){
			if($post['loan_amount']>$val['from_amount'] && $post['loan_amount'] <= $val['to_amount']){
				$fee = $val['notarial_fee'];
			}
			if($fee!=0){
				break;
			}
		}

		echo json_encode(array('notarial_fee' => $fee));
	}

	public function create(){
		$this->load->helper('form');
		$this->load->helper('date');
		$post = $this->input->post(NULL, TRUE);
		
		//echo "<pre>";print_r($post);die;
		
		$data = array(
			"customer_id" => $post['customer_id'],
			"created_by" => "",
			"loan_amount" => $post['loan_amount'],
			"loan_proceeds" => $post['loan_proceeds'],
			"mode_of_payment" => $post['mode_of_payment'],
			"loan_term" => $post['loan_term'],
			"loan_term_duration" => $post['loan_term_duration'],
			//"date_released" => $post['date_released'],
			//"maturity_date" => $maturity_date,
			"interest_pct" => $post['interest_pct'],
			"interest_amount" => $post['interest_amount'],
			//"service_fee_pct" => $post['service_fee_pct'],
			"service_fee_amount" => $post['service_fee_amount'],
			"amortization" => $post['amortization'],
			//"collateral" => $post['collateral'],
			//"id_presented" => $post['id_presented'],
			"loan_purpose" => $post['loan_purpose'],
			"type_of_business" => $post['type_of_business'],
			"co_maker1" => $post['co_maker1'],
			"co_maker1_address" => $post['co_maker1_address'],
			"co_maker1_id" => $post['co_maker1_id'],
			"co_maker1_id_issue_date" => $post['co_maker1_id_issue_date'],
			"co_maker2" => $post['co_maker2'],
			"co_maker2_address" => $post['co_maker2_address'],
			"co_maker2_id" => $post['co_maker2_id'],
			"co_maker2_id_issue_date" => $post['co_maker2_id_issue_date'],
			"witness1" => $post['witness1'],
			"witness2" => $post['witness2'],
			"useSpouse" => $post['useSpouse'],
			"collateral_address" => $post['collateral_address'],
			"status" => '1',
			"loan_type" => $post['loan_type'],
			"application_status" => '0',
			"loan_balance" => $post['loan_amount'],
			"maker_id" => $post['maker_id'],	
			"maker_id_issue_date" => $post['maker_id_issue_date'],
			"co_borrower_id" => $post['co_borrower_id'],
			"co_borrower_id_issue_date" => $post['co_borrower_id_issue_date'],
			"mutual_aid" => isset($post['mutual_aid']) ? $post['mutual_aid'] : 0
		);
		
		$this->load->model('customer_loan_model', 'customer_loan');
		
		$this->customer_loan->data = $data;
		
		$customer_loan_id = $this->customer_loan->create();
		
		if($customer_loan_id){
			$collateral_data = array();
			for($i=1; $i<=10; $i++){
				if($post['brand' . $i]!=''){
					$collateral_data[] = array(
							'loan_id' => $customer_loan_id,
							'brand' => $post['brand' . $i],
							'make' => $post['make' . $i],
							'serial' => $post['serial' . $i]
					);
				}
					
			}	
			if(! empty($collateral_data)){
				$this->db->insert_batch('loan_collaterals', $collateral_data);
			}
			
		}
			
		$response = array(
			'success' => TRUE,
			'customer_id' => $post['customer_id']
		);
		
		echo json_encode($response);
		
	}
	
	private function createMontlySched($strDateFrom, $months){
		$post = $this->input->post(NULL, TRUE);
	
		$tmpdate = str_replace('-', '/', $strDateFrom);
	
		$monthStart = $strDateFrom;
		$monthEnd = date('Y-m-d', strtotime($tmpdate . "+" .$months. "months"));
	
		$amort_sched = array();
		while($monthStart < $monthEnd)
		{
			$amort_sched[] = date("Y-m-t", strtotime($monthStart));
			$monthStart = date('Y-m-d', strtotime($monthStart . "+1 months"));
		}
		
		return $amort_sched;
	}
	
	private function createSemiMontlySched($strDateFrom, $months){
		$post = $this->input->post(NULL, TRUE);
		
		$tmpdate = str_replace('-', '/', $strDateFrom);
		
		if(date('d', strtotime($strDateFrom))>=15){
			$months = $months + 1;
		}
		
		
		$monthStart = $strDateFrom;
		$monthEnd = date('Y-m-d', strtotime($tmpdate . "+" .$months. "months"));
	
		$amort_sched = array();
		
		
		
		while($monthStart < $monthEnd)
		{
			$amort_sched[] = date("Y-m-15", strtotime($monthStart));
			$amort_sched[] = date("Y-m-t", strtotime($monthStart));
			$monthStart = date('Y-m-d', strtotime($monthStart . "+1 months"));
		}
		
		$removed_first = array();
		$removed_last = array();
		if(date('d', strtotime($strDateFrom))>=15){
			$removed_first = array_shift($amort_sched);
			$removed_last = array_pop($amort_sched);
		}
		
		
		return $amort_sched;
	}
	
	private function createDateRangeArray($strDateFrom,$strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom)
		{
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
			while ($iDateFrom<$iDateTo)
			{
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}
	
	public function edit(){
		$post = $this->input->post(NULL, TRUE);
		
		$this->load->model('customer_loan_model', 'clm');
		
		
		$result = $this->clm->get_by_loan_id($post['loan_id']);
		
		$loan_collaterals = array();
		if(! empty($result)){
			$query = $this->db->get_where('loan_collaterals', array('loan_id' => $result[0]['loan_id']));
			$loan_collaterals = $query->result_array();
		}
		$loan_collaterals_array = array();
		if(! empty($loan_collaterals)){
			foreach($loan_collaterals  as $key => $val){
				$key++;
				$loan_collaterals_array['brand' . $key] = $val['brand'];
				$loan_collaterals_array['make' . $key] = $val['make'];
				$loan_collaterals_array['serial' . $key] = $val['serial'];
			}
		}
		$data = array();
		if(! empty($result)){
			$data = array_merge($result[0], $loan_collaterals_array);
		}

		$return = array(
				'data' => $data
		);
		
		echo json_encode($return);
		
	}
	
	public function update(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		if($post['application_status']==2){
			$data = array(
					"created_by" => "",
					//"loan_amount" => $post['loan_amount'],
					//"loan_proceeds" => $post['loan_proceeds'],
					//"mode_of_payment" => $post['mode_of_payment'],
					//"loan_term" => $post['loan_term'],
					//"loan_term_duration" => $post['loan_term_duration'],
					//"date_released" => $post['date_released'],
					//"maturity_date" => $maturity_date,
					//"interest_pct" => $post['interest_pct'],
					//"interest_amount" => $post['interest_amount'],
					//"service_fee_pct" => $post['service_fee_pct'],
					//"service_fee_amount" => $post['service_fee_amount'],
					//"amortization" => $post['amortization'],
					//"collateral" => $post['collateral'],
					//"id_presented" => $post['id_presented'],
					"loan_purpose" => $post['loan_purpose'],
					"type_of_business" => $post['type_of_business'],
					"co_maker1" => $post['co_maker1'],
					"co_maker1_address" => $post['co_maker1_address'],
					"co_maker1_id" => $post['co_maker1_id'],
					"co_maker1_id_issue_date" => $post['co_maker1_id_issue_date'],
					"co_maker2" => $post['co_maker2'],
					"co_maker2_address" => $post['co_maker2_address'],
					"co_maker2_id" => $post['co_maker2_id'],
					"co_maker2_id_issue_date" => $post['co_maker2_id_issue_date'],
					"witness1" => $post['witness1'],
					"witness2" => $post['witness2'],
					"useSpouse" => $post['useSpouse'],
					"collateral_address" => $post['collateral_address'],
					//"status" => '1',
					//"loan_type" => $post['loan_type'],
					//"application_status" => '0',
					//"loan_balance" => $post['loan_amount'],
					"maker_id" => $post['maker_id'],
					"maker_id_issue_date" => $post['maker_id_issue_date'],
					"co_borrower_id" => $post['co_borrower_id'],
					"co_borrower_id_issue_date" => $post['co_borrower_id_issue_date']
			
			);
		}
		else{
			$data = array(
					"created_by" => "",
					"loan_amount" => $post['loan_amount'],
					"loan_proceeds" => $post['loan_proceeds'],
					"mode_of_payment" => $post['mode_of_payment'],
					"loan_term" => $post['loan_term'],
					"loan_term_duration" => $post['loan_term_duration'],
					//"date_released" => $post['date_released'],
					//"maturity_date" => $maturity_date,
					"interest_pct" => $post['interest_pct'],
					"interest_amount" => $post['interest_amount'],
					"service_fee_pct" => $post['service_fee_pct'],
					"service_fee_amount" => $post['service_fee_amount'],
					"amortization" => $post['amortization'],
					//"collateral" => $post['collateral'],
					//"id_presented" => $post['id_presented'],
					"loan_purpose" => $post['loan_purpose'],
					"type_of_business" => $post['type_of_business'],
					"co_maker1" => $post['co_maker1'],
					"co_maker1_address" => $post['co_maker1_address'],
					"co_maker1_id" => $post['co_maker1_id'],
					"co_maker1_id_issue_date" => $post['co_maker1_id_issue_date'],
					"co_maker2" => $post['co_maker2'],
					"co_maker2_address" => $post['co_maker2_address'],
					"co_maker2_id" => $post['co_maker2_id'],
					"co_maker2_id_issue_date" => $post['co_maker2_id_issue_date'],
					"witness1" => $post['witness1'],
					"witness2" => $post['witness2'],
					"useSpouse" => $post['useSpouse'],
					"collateral_address" => $post['collateral_address'],
					"status" => '1',
					"loan_type" => $post['loan_type'],
					//"application_status" => '0',
					"loan_balance" => $post['loan_amount'],
					"maker_id" => $post['maker_id'],
					"maker_id_issue_date" => $post['maker_id_issue_date'],
					"co_borrower_id" => $post['co_borrower_id'],
					"co_borrower_id_issue_date" => $post['co_borrower_id_issue_date']
					//,"mutual_aid" => $post['mutual_aid']
			);
		}
		
		//echo "<pre>";print_r($post);die;
		
		$this->clm->id = $post['loan_id'];
		//unset($post['loan_id']);
		$this->clm->data = $data;
		$this->clm->update();
		//$this->load->model('customer_loan_model', 'customer_loan');
		
		//$this->customer_loan->data = $data;
		
		//$customer_loan_id = $this->customer_loan->create();
		
		if($post['loan_id'] != ''){
			$this->db->delete('loan_collaterals', array('loan_id' => $post['loan_id']));
			
			$collateral_data = array();
			for($i=1; $i<=10; $i++){
				if($post['brand' . $i]!=''){
					$collateral_data[] = array(
							'loan_id' => $post['loan_id'],
							'brand' => $post['brand' . $i],
							'make' => $post['make' . $i],
							'serial' => $post['serial' . $i]
					);
				}
					
			}
			$this->db->insert_batch('loan_collaterals', $collateral_data);
			
		}
		
		//echo "<pre>",print_r($post),die();
		
		echo json_encode(array('success' => TRUE));
	}
	
	
	public function get(){
		$this->load->model('customer_loan_model', 'loans');
		$this->load->model('loan_payments_model', 'lp');
		
		
		$result = $this->loans->get();
		
		//--compose array for table
		$loan_cycle_array = array();
		$cycle_counter = 1;
		foreach($result as $val){
			if($val['loan_status']==1 && $val['application_status']==1){
				if(array_key_exists($val['account_no'], $loan_cycle_array)){
					$cycle_counter++;
				}
				$loan_cycle_array[$val['account_no']] = $cycle_counter;
			}
			
		}

		$customer_data = array();
		$application_status = "";
		

		$payments = $this->lp->get_payments();
		$payments_array = array();
		
		foreach($payments as $val){
			
			$payments_array[$val['loan_id']][$val['payment_date']] = $val;	
		}


		foreach($result as $val){
			$action = "";
			//$loan_payments = $this->lp->get_payments_by_id($val['loan_id']);
			$loan_payments = array();

			if(isset($payments_array[$val['loan_id']])){
				$loan_payments = $payments_array[$val['loan_id']];	
			}

			

			/*$total_payments = 0;
			if(isset($payments_array[$val['loan_id']])){
				$total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
			}
			
			
			$current_payment = array();
			if(isset($payments_array[$val['loan_id']][$today])){
				$current_payment[] = $payments_array[$val['loan_id']][$today];
			}*/



			if($val['loan_status']!=0){
				$pep = "NO";
				if($val['pep_status']==1){
					$pep = "YES";
				}
				if($val['application_status']==3){
					$application_status = '<span class="label label-danger">Denied</span>';
				}
				
				if($val['application_status']!=3){
					$action .= "<button class='btn btn-xs btn-info' onclick='edit_loan(".$val['loan_id'].")' title='Edit'><i class='fa fa-edit'></i></button>";
				}
				
				
				if($val['application_status']==0){
					//$application_status = "Pending";
					$application_status = '<span class="label label-info">Pending</span>';
					
					//$action .= "<button class='btn btn-xs btn-info' onclick='edit_loan(".$val['loan_id'].")' title='Edit'><i class='fa fa-edit'></i></button>";
					if($this->userinfo['user_type']==3 || $this->userinfo['user_type']==4){
						
					}
					else{
						$action .= "&nbsp;<button class='btn btn-xs btn-warning' onclick='recommend_loan(".$val['loan_id']." , \"".$val['name']."\")' title='Approve'><i class='fa fa-check-square-o'></i></button>";
						$action .= "&nbsp;<button class='btn btn-xs btn-danger' onclick='deny_loan(".$val['loan_id']." , \"".$val['name']."\")' title='Deny'><i class='fa fa-ban'></i></button>";
					}
					
					
					$pep = "-";
				}
				
				
				if($val['application_status']==1){
					$application_status = '<span class="label label-warning">Approved</span>';
					
					//if($this->userinfo['user_type']==1 || $this->userinfo['user_type']==2 || $this->userinfo['user_type']==4){
						$action .= "&nbsp;<button class='btn btn-xs btn-success' onclick='approve_loan(".$val['loan_id']." , \"".$val['name']."\")' title='Release'><i class='fa fa-check'></i></button>";
					//}
					
					
				}
				
				
				
				if($val['application_status']==2){
					//$application_status = "Approved";
					$application_status = '<span class="label label-success">Released</span>';
					
					if($this->userinfo['id']==1){
						
						if(empty($loan_payments)){
							$action .= "&nbsp;<button class='btn btn-xs btn-default' onclick='update_loan_status(".$val['loan_id']." , \"".$val['name']."\")' title='Update Status'><i class='fa fa-calendar'></i></button>";
						}
							
					}
					
				}
				
				/* if($this->userinfo['user_type']>=3){
					$action = "";
				} */
					
				//$action .= "<a href='#' class='view-loan-details' title='Loan Details' data-id='".$val["loan_id"]."'><i class='fa fa-list'></i></a>";
				$date_released = $val['date_released'];
				$maturity_date = $val['maturity_date'];
				if($val['date_released']=='0000-00-00'){
					$date_released = "-";
					$maturity_date = "-";
				}
				
				$customer_data[] = array(
						"id" => $val['loan_id'],
						"mopid" => $val['mopid'],
						"account_no" => $val['account_no'],
						"name" => $val['name'],
						"loan_amount" => $val['loan_amount'],
						"mode_of_payment" => $val['mode_of_payment'],
						"loan_term_duration" => $val['loan_term_duration'],
						"interest_pct" => $val['interest_pct'] . "%",
						"interest_amount" => $val['interest_amount'],
						"service_fee_pct" => $val['service_fee_pct'] . "%",
						"service_fee_amount" => $val['service_fee_amount'],
						"loan_proceeds" => $val['loan_proceeds'],
						"amortization" => $val['amortization'],
						"date_released" => $date_released,
						"maturity_date" => $maturity_date,
						"customer_id" => $val['customer_id'],
						"loan_cycle" => isset($loan_cycle_array[$val['account_no']]) ?$loan_cycle_array[$val['account_no']] : "-" ,
						"pep" => $pep,
						"status" => $application_status,
						"action" => $action,
						"address" => $val['address'],
						"area_name" => $val['area_name'],
						"application_status" => $val['application_status']
				);
			}
			
			
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
	
	public function get_loan_terms(){
		$post = $this->input->post(NULL, TRUE);
		
		if(isset($post['mode_of_payment_id']) && $post['mode_of_payment_id']!=""){
			$this->db->where('mode_of_payment_id', $post['mode_of_payment_id']);
			$query = $this->db->get('loan_term');
			$result = $query->result_array();
			
			$html = "";
			
			foreach($result as $val){
				$html .= "<option value='".$val['id']."'>".$val['payment_term']."</option>";
			}
			
			echo $html;
		}
		
		if(isset($post['loan_term_id']) && $post['loan_term_id']!=""){
			$this->db->where('id', $post['loan_term_id']);
			$query = $this->db->get('loan_term');
			$result = $query->result_array();
				
			$return = array(
					"term_pct" => $result[0]['term_pct'],
					"term_duration" => $result[0]['term_duration']
			);
			
				
			echo json_encode($return);
		}
		
		
	}
	
	public function get_payment_mode(){
		$query = $this->db->get('mode_of_payment');
		$result = $query->result_array();
		
		$html = "";
		foreach($result as $val){
			$html .= "<option value='".$val['id']."'>".$val['name']."</option>";
		}
		return $html;
		
	}
	
	public function check_customer_loan(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		$data = $this->clm->check_customer_loan($post['id']);
		
		echo json_encode(array(
			"success" => TRUE,
			"data" => $data,
			"datacount" => count($data) 	
		));
	}
	
	public function renew_loan(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		$existing_loan = $this->clm->check_customer_loan($post['customer_id']);
		
		
		
		if(empty($existing_loan)){
			$loan_info = $this->clm->get_recent_completed($post['customer_id']);
			
			if(! empty($loan_info)){
				$loan_collaterals = $this->clm->get_collaterals($loan_info[0]['loan_id']);
				
				$loan_info[0]['collaterals'] = $loan_collaterals;
			}
			
			//echo "<pre>";print_r($loan_info);die;
			
			
			$return = array(
					'success' => true,
					'loan_info' => empty($loan_info) ? $loan_info : $loan_info[0]
			);
		}
		else{
			$return = array(
					'success' => true,
					'message' => 'Customer still have active or pending loan.'
			);
		}
		
		
		echo json_encode($return);die;
	}


	function generate_voucher(){
		$this->load->helper(array('dompdf', 'file'));
	
		$this->load->model('loan_payments_model', 'lp');
		$this->load->model('customer_loan_model', 'cl');
		$post = $this->input->post(NULL, TRUE);
	
		//$loan_payments = $this->lp->get_payments_by_id($post['voucher_loan_id']);
		$customer_loan = $this->cl->get_by_loan_id($post['voucher_loan_id']);
	
		/* if(! empty($customer_loan)){
			$loan_amount = $customer_loan[0]['loan_amount'];
		}
	
		$outstanding_balance = 0;
		$total_payments = 0;
		foreach($loan_payments as $val){
			$total_payments += $val['amount'];
		}
	
		$outstanding_balance = floatval($customer_loan[0]['loan_amount']) - floatval($total_payments);
		$this->data = array(
				"loan_details" => $customer_loan,
				"loan_payments" => $loan_payments,
				"outstanding_balance" => $outstanding_balance,
				"total_payments" => $total_payments
		); */
		if(! empty($customer_loan)){
			$this->data = array(
					"customer_name" => $customer_loan[0]['name'],
					"address" => $customer_loan[0]['address'],
					"date" => date('Y-m-d'),
					"account_no" => $customer_loan[0]['account_no'],
					"cheque_no" => '0000',
					"loan_amount" => $customer_loan[0]['loan_amount'],
					"interest_amount" => $customer_loan[0]['interest_amount'],
					"service_fee" => $customer_loan[0]['service_fee_amount'],
					"others" => "0",
					"net_proceeds" => $customer_loan[0]['loan_proceeds'],
					"interest_pct" => $customer_loan[0]['interest_pct'],
					"loan_term_duration" => $customer_loan[0]['loan_term_duration']
			);
			
			$html = $this->load->view('page/voucher', $this->data, true);
			pdf_create($html, 'voucher');
		}
		
		/* or
		 $data = pdf_create($html, '', false);
		 write_file('name', $data);
		//if you want to write it to disk and/or send it as an attachment */
	}
	
	function get_customer_loan($loan_id){
		$pos = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'cl');
		$customer_loan = $this->cl->get_by_loan_id($post['loan_id']);
		
		print_r($customer_loan);die;
		
	}
	
	function generate_contract_data(){


		/**
		 *
		 * ALTER TABLE  `customers_loan` ADD  `useSpouse` TINYINT NOT NULL DEFAULT  '0';
		 * ALTER TABLE  `customers_loan` ADD  `witness1` VARCHAR( 255 ) NOT NULL ,
		 * ADD  `witness2` VARCHAR( 255 ) NOT NULL ,
		 * ADD  `collateral_address` VARCHAR( 255 ) NOT NULL ;
		 * ALTER TABLE  `customers_loan` CHANGE  `loan_purpose`  `loan_purpose` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
		 *
		 *
		 */
		
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		$query = $this->db->get('business_info');
		$business_info = $query->result_array();
		
		$customer_loan = $this->clm->get_by_loan_id($post['contract_loan_id']);
		//echo "<PRE>",print_r($customer_loan);die();
		$data = array();
		$date = date('Y-m-d');
		$loan_collateral =array();
		if(! empty($customer_loan)){
		
			$query = $this->db->get_where('loan_collaterals', array('loan_id' => $customer_loan[0]['loan_id']));
		
			$loan_collateral = $query->result_array();
		
		
			$tmpdate = str_replace('-', '/', $customer_loan[0]['date_released']);
			$amort_day_start = date('Y-m-d', strtotime($tmpdate . "+1 days"));
		
		
			$data = array(
					'data' => $customer_loan[0],
					'date' => $date,
					'business_name' => $business_info[0]['name'],
					'contract_address' => 'CAMALIG ALBAY',
					'business_address' => $business_info[0]['address'],
					'first_party' => $business_info[0]['owner'],
					'first_party_id' => $business_info[0]['owner_id'],
					'first_party_id_issue_date' => '',
					'loan_collaterals' => $loan_collateral,
					'la_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['loan_amount'])),
					'amort_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['amortization'])),
					'payment_start' => date('M d, Y', strtotime($amort_day_start))
			);
		}
		
		
		//echo "<pre>",print_r($data),die();
		
		//$html = $this->load->view('page/contract', $data, true);
		$html = $this->load->view('page/contractdata', $data, true);
		pdf_create($html, 'contract');
		
		
	}
	
	function generate_contract_form(){

		/**
		 *
		 * ALTER TABLE  `customers_loan` ADD  `useSpouse` TINYINT NOT NULL DEFAULT  '0';
		 * ALTER TABLE  `customers_loan` ADD  `witness1` VARCHAR( 255 ) NOT NULL ,
		 * ADD  `witness2` VARCHAR( 255 ) NOT NULL ,
		 * ADD  `collateral_address` VARCHAR( 255 ) NOT NULL ;
		 * ALTER TABLE  `customers_loan` CHANGE  `loan_purpose`  `loan_purpose` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
		 *
		 *
		 */
		
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		$query = $this->db->get('business_info');
		$business_info = $query->result_array();
		
		$customer_loan = $this->clm->get_by_loan_id($post['contract_loan_id']);
		//echo "<PRE>",print_r($customer_loan);die();
		$data = array();
		$date = date('Y-m-d');
		$loan_collateral =array();
		if(! empty($customer_loan)){
				
			$query = $this->db->get_where('loan_collaterals', array('loan_id' => $customer_loan[0]['loan_id']));
				
			$loan_collateral = $query->result_array();
				
				
			$tmpdate = str_replace('-', '/', $customer_loan[0]['date_released']);
			$amort_day_start = date('Y-m-d', strtotime($tmpdate . "+1 days"));
				
				
			$data = array(
					'data' => $customer_loan[0],
					'date' => $date,
					'business_name' => $business_info[0]['name'],
					'contract_address' => 'CAMALIG ALBAY',
					'business_address' => $business_info[0]['address'],
					'first_party' => $business_info[0]['owner'],
					'first_party_id' => $business_info[0]['owner_id'],
					'first_party_id_issue_date' => '',
					'loan_collaterals' => $loan_collateral,
					'la_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['loan_amount'])),
					'amort_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['amortization'])),
					'payment_start' => date('M d, Y', strtotime($amort_day_start))
			);
		}
		
		
		//echo "<pre>",print_r($data),die();
		
		//$html = $this->load->view('page/contract', $data, true);
		$html = $this->load->view('page/contractform', $data, true);
		pdf_create($html, 'contractform');
		
	}
	
	function generate_contract(){
		/**
		 * 
		 * ALTER TABLE  `customers_loan` ADD  `useSpouse` TINYINT NOT NULL DEFAULT  '0';
		 * ALTER TABLE  `customers_loan` ADD  `witness1` VARCHAR( 255 ) NOT NULL ,
		 * ADD  `witness2` VARCHAR( 255 ) NOT NULL ,
		 * ADD  `collateral_address` VARCHAR( 255 ) NOT NULL ;
		 * ALTER TABLE  `customers_loan` CHANGE  `loan_purpose`  `loan_purpose` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
		 * 
		 * 
		 */
		
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		$query = $this->db->get('business_info');
		$business_info = $query->result_array();
		
		$customer_loan = $this->clm->get_by_loan_id($post['contract_loan_id']);
		//echo "<PRE>",print_r($customer_loan);die();
		$data = array();
		$date = date('Y-m-d');
		$loan_collateral =array();
		if(! empty($customer_loan)){
			
			$query = $this->db->get_where('loan_collaterals', array('loan_id' => $customer_loan[0]['loan_id']));
			
			$loan_collateral = $query->result_array();
			
			
			$tmpdate = str_replace('-', '/', $customer_loan[0]['date_released']);
			$amort_day_start = date('Y-m-d', strtotime($tmpdate . "+1 days"));
			
			
			$data = array(
				'data' => $customer_loan[0], 
				'date' => $date,
				'business_name' => $business_info[0]['name'],
				'contract_address' => 'LIGAO ALBAY',		
				'business_address' => $business_info[0]['address'],
				'first_party' => $business_info[0]['owner'],
				'first_party_id' => $business_info[0]['owner_id'],
				'first_party_id_issue_date' => '',
				'loan_collaterals' => $loan_collateral,
				'la_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['loan_amount'])),
				'amort_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['amortization'])),	
				'payment_start' => date('M d, Y', strtotime($amort_day_start))	
			);
		}
		
		
		//echo "<pre>",print_r($data),die();
		
		$html = $this->load->view('page/contract', $data, true);
		//$html = $this->load->view('page/contractform', $data, true);
		pdf_create($html, 'contract');
	}


	
	function generate_cheque(){
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		
		$query = $this->db->get('business_info');
		$business_info = $query->result_array();
		
		$customer_loan = $this->clm->get_by_loan_id_cheque($post['cheque_loan_id']);
		//echo "<PRE>",print_r($customer_loan);die();
		$data = array();
		$date = date('Y-m-d');
		$loan_collateral =array();
		if(! empty($customer_loan)){
				
			$query = $this->db->get_where('loan_collaterals', array('loan_id' => $customer_loan[0]['loan_id']));
				
			$loan_collateral = $query->result_array();
				
				
			$tmpdate = str_replace('-', '/', $customer_loan[0]['date_released']);
			$amort_day_start = date('Y-m-d', strtotime($tmpdate . "+1 days"));
				
				
			$data = array(
					//'data' => $customer_loan[0],
					//'date' => date('m-d-Y', strtotime($date)),
					'date' => $customer_loan[0]['date_released'],
					//'business_name' => $business_info[0]['name'],
					//'contract_address' => 'CAMALIG ALBAY',
					//'business_address' => $business_info[0]['address'],
					//'first_party' => $business_info[0]['owner'],
					//'first_party_id' => $business_info[0]['owner_id'],
					//'first_party_id_issue_date' => '',
					//'loan_collaterals' => $loan_collateral,
					'net' => $customer_loan[0]['loan_proceeds'],
					'net_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['loan_proceeds'])),
					//'amort_in_words' => $this->convert_number_to_words(intval($customer_loan[0]['amortization'])),
					//'payment_start' => date('M d, Y', strtotime($amort_day_start))
					'name' => $customer_loan[0]['name']
			);
		}
		
		
		//echo "<pre>",print_r($data),die();
		
		$html = $this->load->view('page/cheque', $data, true);
		pdf_create($html, 'cheque');
		
	}
	
	private function convert_number_to_words($number) {
    
	    //$hyphen      = '-';
	    /*$conjunction = ' and ';
	    $separator   = ', ';*/
	    $hyphen      = ' ';
	    $conjunction = ' ';
	    $separator   = ' ';
	    $negative    = 'negative ';
	    $decimal     = ' point ';
	    $dictionary  = array(
	        0                   => 'zero',
	        1                   => 'one',
	        2                   => 'two',
	        3                   => 'three',
	        4                   => 'four',
	        5                   => 'five',
	        6                   => 'six',
	        7                   => 'seven',
	        8                   => 'eight',
	        9                   => 'nine',
	        10                  => 'ten',
	        11                  => 'eleven',
	        12                  => 'twelve',
	        13                  => 'thirteen',
	        14                  => 'fourteen',
	        15                  => 'fifteen',
	        16                  => 'sixteen',
	        17                  => 'seventeen',
	        18                  => 'eighteen',
	        19                  => 'nineteen',
	        20                  => 'twenty',
	        30                  => 'thirty',
	        40                  => 'fourty',
	        50                  => 'fifty',
	        60                  => 'sixty',
	        70                  => 'seventy',
	        80                  => 'eighty',
	        90                  => 'ninety',
	        100                 => 'hundred',
	        1000                => 'thousand',
	        1000000             => 'million',
	        1000000000          => 'billion',
	        1000000000000       => 'trillion',
	        1000000000000000    => 'quadrillion',
	        1000000000000000000 => 'quintillion'
	    );
	    
	    if (!is_numeric($number)) {
	        return false;
	    }
	    
	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
	        // overflow
	        trigger_error(
	            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
	            E_USER_WARNING
	        );
	        return false;
	    }
	
	    if ($number < 0) {
	        return $negative . $this->convert_number_to_words(abs($number));
	    }
	    
	    $string = $fraction = null;
	    
	    if (strpos($number, '.') !== false) {
	        list($number, $fraction) = explode('.', $number);
	    }
	    
	    switch (true) {
	        case $number < 21:
	            $string = $dictionary[$number];
	            break;
	        case $number < 100:
	            $tens   = ((int) ($number / 10)) * 10;
	            $units  = $number % 10;
	            $string = $dictionary[$tens];
	            if ($units) {
	                $string .= $hyphen . $dictionary[$units];
	            }
	            break;
	        case $number < 1000:
	            $hundreds  = $number / 100;
	            $remainder = $number % 100;
	            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
	            if ($remainder) {
	                $string .= $conjunction . $this->convert_number_to_words($remainder);
	            }
	            break;
	        default:
	            $baseUnit = pow(1000, floor(log($number, 1000)));
	            $numBaseUnits = (int) ($number / $baseUnit);
	            $remainder = $number % $baseUnit;
	            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
	            if ($remainder) {
	                $string .= $remainder < 100 ? $conjunction : $separator;
	                $string .= $this->convert_number_to_words($remainder);
	            }
	            break;
	    }
	    
	    if (null !== $fraction && is_numeric($fraction)) {
	        $string .= $decimal;
	        $words = array();
	        foreach (str_split((string) $fraction) as $number) {
	            $words[] = $dictionary[$number];
	        }
	        $string .= implode(' ', $words);
	    }
	    
	    return $string;
	}
}

/* End of file loan_application.php */
/* Location: ./application/controllers/loan_application.php */