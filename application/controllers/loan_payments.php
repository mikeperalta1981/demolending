<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_payments extends MY_Controller {
	private $data = array();
	public $javascripts = array('js/plugins/datatables/jquery.dataTables.js', 'js/plugins/datatables/fnReloadAjax.js', 'js/plugins/datatables/dataTables.bootstrap.js', 'js/jquery.numeric.min.js', 'js/pages-js/loan_payments.js');
	public $css = array('css/datatables/dataTables.bootstrap.css', 'css/pages-css/loan_payments.css');
	
	public function index()
	{
		$this->load->helper('template');
		$this->load->model('branch_areas_model', 'bam');
		//$branch_areas = $this->bam->get();
		
		$this->db->select('ba.*, CONCAT(c.lastname, " ", c.firstname, " ", c.middlename) as collector_name', FALSE);
		$this->db->from('branch_areas ba');
		$this->db->join('collectors c', 'ba.collector_id=c.id', 'left');
		$this->db->where('ba.active =' , '1');
		$this->db->order_by('ba.area_name', 'asc');
		$query = $this->db->get();
		$branch_areas = $query->result_array();
		//echo "<pre>";print_r($branch_areas);die();get_daily_collectibles
		$this->data = array(
				'areas' => $branch_areas
		);
		
		render_page('loan_payments_page', $this->data);
	}
	
	private function get_total_payments_from_array($loan_payments){
		
		$total_payments = 0;
		
		foreach($loan_payments as $val){
			$total_payments += $val['amount'];
		}	
		
		
		return $total_payments;
	}
	
	private function get_total_payments($loan_id){
		$this->load->model('loan_payments_model', 'lpm');
		
		$loan_payments = $this->lpm->get_payments_by_id($loan_id);
		$total_payments = 0;
		foreach($loan_payments as $val){
			$total_payments += $val['amount'];
		}
		
		return $total_payments;
	}
	
	public function daily_collectibles($area_id = "", $date = ""){
		
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->model('customer_loan_model', 'clm');
		
		$approved_loans = $this->clm->get_approved_daily_dcr($area_id);
		
		
		$today = date('Y-m-d');
		//$date = '2015-11-04';
		if($date!='')
			$today = $date;
		
		$payment_field = "";
		$action = "";
		$daily_collectibles = array();
		
		
		$payments = $this->lpm->get_payments();
		$payments_array = array();
		
		foreach($payments as $val){
			
			$payments_array[$val['loan_id']][$val['payment_date']] = $val;	
		}
		
		
		//echo "<pre>",print_r($approved_loans),die();
		
		foreach($approved_loans as $val){
			
			//$total_payments = $this->get_total_payments($val['loan_id']);
			//$current_payment = $this->lpm->get_payments_by_date_and_id($val['loan_id'], $today);
			//if($val['loan_status']==1){
			if($val['date_completed'] == '0000-00-00' || $val['date_completed'] >= $today){

				$total_payments = 0;
				if(isset($payments_array[$val['loan_id']])){
					$total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
				}
				
				
				$current_payment = array();
				if(isset($payments_array[$val['loan_id']][$today])){
					$current_payment[] = $payments_array[$val['loan_id']][$today];
				}
				
					
				$date_released = $val['date_released'];
				
				$tmp_date_released = str_replace('-', '/', $date_released);
				$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));
				$daily_amort = $val['amortization'];
				if($val['pep_status']==1){
					$amort_day_start = $val['pep_startdate'];
					$daily_amort = $val['pep_amort'];
				}
				$readonly = "";
				$tmp_payments = 0;
				if($today >= $amort_day_start){
					
						if(! empty($current_payment[0]['amount'])  && $current_payment[0]['amount']>0 && $current_payment[0]['amount']!=''){
							$tmp_payments = $current_payment[0]['amount'];
							$inputfield = '';
							
							
							
							if($current_payment[0]['approved']==0){

								$action = "<span class='label label-warning'>For Approval</span>";
								$inputfield .= '<div class="input-group">';
								$inputfield .= '<input onkeydown="go_next_input(this)" type="text" class="inputpayment form-control" aria-label="..." onkeyup="calculate_total(this.value, '.$val['loan_id'].')" value="'.$current_payment[0]['amount'].'" name="'. $val['loan_id'].'">';
								$inputfield .= '<span class="input-group-addon">';
								$inputfield .= '<input type="checkbox" class="hidden" name="chkbox_payments" value="'. $current_payment[0]['id']. "_" . $val['loan_id'] .'">';
							}
							else{
								$action = "<span class='label label-success'>Approved</span>";
								
								$inputfield .= '<div class="input-group">';
								$inputfield .= '<input onkeydown="go_next_input(this)" type="text" class="inputpayment form-control" aria-label="..." onkeyup="calculate_total(this.value, '.$val['loan_id'].')" value="'.$current_payment[0]['amount'].'" name="'. $val['loan_id'].'" readonly>';
								$inputfield .= '<span class="input-group-addon">';
								
								$readonly = "readonly='readonly'";
							}
							$inputfield .= '</span>';
							$inputfield .= '</div>';
							$payment_field =$inputfield ;
						}
						else{

							$payment_field = "<input onkeydown='go_next_input(this)'  class='inputpayment form-control' onkeyup='calculate_total(this.value, ".$val['loan_id'].")' value='' name='". $val['loan_id']."'>";
							$action = "";
						}
						
						
							
						
						
						$type_of_collection = "<select class='form-control' name='tc_".$val['loan_id']."'".$readonly.">";
						if(! empty($current_payment[0]['type_of_collection'])){
							if($current_payment[0]['type_of_collection']=='out'){
								$type_of_collection .= "<option value='out' selected='selected'>Out</option>";
								$type_of_collection .= "<option value='in'>In</option>";
							}
							else{
								$type_of_collection .= "<option value='out'>Out</option>";
								$type_of_collection .= "<option value='in' selected='selected'>In</option>";
							}
						}
						else{
							$type_of_collection .= "<option value='out'>Out</option>";
							$type_of_collection .= "<option value='in'>In</option>";
						}
						
						
						$type_of_collection .= "</select>";
						
						if($val['date_completed']!='0000-00-00'){
							
							if($val['date_completed']>=$today){
								$daily_collectibles[] = array(
										"loan_id" => $val['loan_id'],
										"account_no" => $val['account_no'],
										"name" => $val['name'],
										"loan_amount" => $val['loan_amount'],
										//"remaining_balance" => $remaining_balance,
										"mode_of_payment" => $val['mode_of_payment'],
										"amort_date" => $today,
										"daily_amort" => $daily_amort,
										"payment" => $payment_field,
										"type_of_collection" => $type_of_collection,
										"action" => $action,
										"area_name" => $val['area_name'],
										"tmppayments" => "<span id='temp_p".$val['loan_id']."'>".$tmp_payments."</span>"
								);
							}
								
						}
						else{
							$daily_collectibles[] = array(
									"loan_id" => $val['loan_id'],
									"account_no" => $val['account_no'],
									"name" => $val['name'],
									"loan_amount" => $val['loan_amount'],
									//"remaining_balance" => $remaining_balance,
									"mode_of_payment" => $val['mode_of_payment'],
									"amort_date" => $today,
									"daily_amort" => $daily_amort,
									"payment" => $payment_field,
									"type_of_collection" => $type_of_collection,
									"action" => $action,
									"area_name" => $val['area_name'],
									"tmppayments" => "<span id='temp_p".$val['loan_id']."'>".$tmp_payments."</span>"
							);
						}
						
						
						
				}

			}
			
		}
		
		$data = array();
		foreach($daily_collectibles as $val){
		
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
				"aaData" => $data,
				"area_id" => isset($post['area_id']) ? $post['area_id'] : "" 
				
		);
		
		return $return;
		
	}
	
	public function get_daily_collectibles(){
		$get = $this->input->get(NULL, TRUE);
		$return = $this->daily_collectibles(isset($get['area_id']) ? $get['area_id'] : "", isset($get['date']) ? $get['date'] : "");
		
		echo json_encode($return);
		
	}
	
	public function post_payments(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->library('Loan');
		
		$data = array();
		$tmp_name = "";
		$loan_payments_create = array();
		$loan_payments_update = array();
		$loan_payments_delete = array();
		$loan_ids = array();
		//echo"<pre>",print_r($post['tc_data']),die();
		$date = isset($post['date']) ? $post['date'] : date('Y-m-d');
			
		$tc_data = array();
		foreach($post['tc_data'] as $val){
			$key = substr($val['name'], 3);
			$tc_data[$key] = $val['value'];	
		}
		//echo count($post['params']) . "==" . count($tc_data) . "<br>";
		//echo "<pre>";print_r($post['params']);
		//echo"<pre>",print_r($tc_data),die();
		foreach($post['params'] as $val){
				
				if($val['name']!='chkbox_payments'){
					$checkpayments = $this->lpm->get_payments_by_date_and_id($val['name'], $date);
					
					if(empty($checkpayments)){
						if(floatval($val['value'])>0){
							$loan_payments_create[] = array(
									"loan_id" => $val['name'],
									"payment_date" => $date,
									"amount" => floatval($val['value']),
									"type_of_collection" => $tc_data[$val['name']]
							);
						}
							
					}
					else{
						if($val['value']=='' || $val['value']==0){
							$loan_payments_delete[] = $checkpayments[0]['id'];
						}
						else{
							$loan_payments_update[] = array(
									"loan_id" => $val['name'],
									"payment_date" => $date,
									"amount" => floatval($val['value']),
									"type_of_collection" => $tc_data[$val['name']]
							);
						}
							
					}
						
						
					$loan_ids[] = $val['name'];
				}
			
		}
		
		
		
		
		if(! empty($loan_ids)){
			
			if(! empty($loan_payments_create)){
				$this->lpm->data = $loan_payments_create;
				$this->lpm->create_batch();
			}
			
			if(! empty($loan_payments_update)){
				
				foreach($loan_payments_update as $val){
					$this->db->where('loan_id', $val['loan_id']);
					$this->db->where('payment_date', $val['payment_date']);
					$this->db->update('loan_payments', $val);
				}
			}
			
			if(! empty($loan_payments_delete)){
				$this->db->where_in('id', $loan_payments_delete);
				$this->db->delete('loan_payments');
			}
			
			
			echo json_encode(array(
					"success" => true,
					"message" => 'Loans posting success.'
			));
		}
		else{
			echo json_encode(array(
					"success" => false,
					"message" => 'No postings made.'
			));
		}
		
	}
	
	public function get_cfc(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->model('customer_loan_model', 'clm');
		
		$approved_loans = $this->clm->get_approved_daily($post['area_id']);
		$today = date('Y-m-d');
		
		$payment_field = "";
		$daily_collectibles = array();
		$area_name = "";
		##temp for bolanyos only
		if(isset($post['area_id'])){
			if($post['area_id'] =='')
				$area_name = 'All';
			if($post['area_id']==1)
				$area_name = 'Area 1';
			if($post['area_id']==2)
				$area_name = 'Area 2';
		}
		
		$payments = $this->lpm->get_payments();
		$payments_array = array();
		foreach($payments as $val){
			$payments_array[$val['loan_id']][$val['payment_date']] = $val;
		}
		
		
		foreach($approved_loans as $val){
				
			//$total_payments = $this->get_total_payments($val['loan_id']);
			//$current_payment = $this->lpm->get_payments_by_date_and_id($val['loan_id'], $today);
			
			$total_payments = 0;
			if(isset($payments_array[$val['loan_id']])){
				$total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
			}
			
			$current_payment = array();
			if(isset($payments_array[$val['loan_id']][$today])){
				$current_payment[] = $payments_array[$val['loan_id']][$today];
			}
				
			$date_released = $val['date_released'];
				
			$tmp_date_released = str_replace('-', '/', $date_released);
			$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));
			$daily_amort = $val['amortization'];
			if($val['pep_status']==1){
				$amort_day_start = $val['pep_startdate'];
				$daily_amort = $val['pep_amort'];
			}
		
				
			$daily_collectibles[] = array(
					"loan_id" => $val['loan_id'],
					"account_no" => $val['account_no'],
					"name" => $val['name'],
					"loan_amount" => $val['loan_amount'],
					//"remaining_balance" => $remaining_balance,
					"mode_of_payment" => $val['mode_of_payment'],
					"amort_date" => $today,
					"daily_amort" => $daily_amort,
					"payment" => '',
					"area_name" => $val['area_name']
			);
				
		}
		
		
		
		$data = array();
		foreach($daily_collectibles as $val){
		
			$data[] = array(
				'account_no' => $val['account_no'],
				'name' => $val['name'],
				'amortization' => $val['daily_amort']	
			);
		}
		
		$return = array(
				"success" => true,
				"data" => $data,
				"num_of_accounts" => count($data),
				"area_name" => $area_name,
				"area_id" => $post['area_id']
		);
		
		echo json_encode($return);
	}
	/**
	 * 
	 * ALTER TABLE  `loan_payments` ADD  `approved` TINYINT NOT NULL DEFAULT  '0' COMMENT  '1=approved';
	 * 
	 */
	public function generate_cfc(){
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->model('customer_loan_model', 'clm');
		
		$approved_loans = $this->clm->get_approved_daily($post['area_id']);
		$today = date('Y-m-d');
		
		$payment_field = "";
		$daily_collectibles = array();
		$area_name = "";
		##temp for bolanyos only
		if(isset($post['area_id'])){
			if($post['area_id'] =='')
				$area_name = 'All';
			if($post['area_id']==1)
				$area_name = 'Area 1';
			if($post['area_id']==2)
				$area_name = 'Area 2';
		}
		
		$payments = $this->lpm->get_payments();
		$payments_array = array();
		foreach($payments as $val){
			$payments_array[$val['loan_id']][$val['payment_date']] = $val;
		}
		
		foreach($approved_loans as $val){
				
			//$total_payments = $this->get_total_payments($val['loan_id']);
			//$current_payment = $this->lpm->get_payments_by_date_and_id($val['loan_id'], $today);
			
			$total_payments = 0;
			if(isset($payments_array[$val['loan_id']])){
				$total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
			}
				
				
			$current_payment = array();
			if(isset($payments_array[$val['loan_id']][$today])){
				$current_payment[] = $payments_array[$val['loan_id']][$today];
			}
			
			
				
			$date_released = $val['date_released'];
				
			$tmp_date_released = str_replace('-', '/', $date_released);
			$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));
			$daily_amort = $val['amortization'];
			if($val['pep_status']==1){
				$amort_day_start = $val['pep_startdate'];
				$daily_amort = $val['pep_amort'];
			}
				
				
			if($today >= $amort_day_start){
				if($val['loan_amount'] > $total_payments){
					if(! empty($current_payment[0]['amount'])  && $current_payment[0]['amount']>0){
						$payment_field = "<input class='inputpayment' onchange='calculate_total()' value='".$current_payment[0]['amount']."' name='". $val['loan_id']."'>";
					}
					else{
						$payment_field = "<input class='inputpayment' onchange='calculate_total()' value='' name='". $val['loan_id']."'>";
					}
						
				}
			}
				
				
			$daily_collectibles[] = array(
					"loan_id" => $val['loan_id'],
					"account_no" => $val['account_no'],
					"name" => $val['name'],
					"loan_amount" => $val['loan_amount'],
					//"remaining_balance" => $remaining_balance,
					"mode_of_payment" => $val['mode_of_payment'],
					"amort_date" => $today,
					"daily_amort" => $daily_amort,
					"payment" => '',
					"area_name" => $val['area_name']
			);
				
		}
		
		
		
		$data = array();
		foreach($daily_collectibles as $val){
			$data[] = array(
				'account_no' => $val['account_no'],
				'name' => $val['name'],
				'amortization' => $val['daily_amort']	
			);
		}
		
		$return = array(
				"success" => true,
				"data" => $data,
				"num_of_accounts" => count($data),
				"area_name" => $area_name,
				"collector_name" => $post['collector_name']
		);
		
		$this->data = $return;
		
		$html = $this->load->view('page/cfc', $this->data, true);
		pdf_create($html, 'cfc');
	}
	
	public function approve_payment(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->library('Loan');
		
		$data = array();
		$cl_data = array();
		$tmpval = array();
		
		$tc_data = array();
		$tc_id_arr = array();
		$tc_id = 0;
		
		
		
		
		//echo "<pre>",print_r($post['tc_data']);
		//echo "<pre>",print_r($post['params']),die();
		
		foreach($post['tc_data'] as $val){
			$tc_id_arr = explode("_", $val['name']);
			$tc_id = $tc_id_arr[1];
			$tc_data[$tc_id] = $val['value'];
		}
		
		
		$this->db->where('payment_date', $post['payment_date']);
		$this->db->where('approved', '0');
		$query = $this->db->get('loan_payments');
		$result = $query->result_array();
		
		//echo "<pre>";print_r($result);die;
		
		
		/* foreach($post['params'] as $val){
			$tmpval = explode("_", $val['value']);
			$data[] = array(
				"approved" => 1,
				"id" => $tmpval[0],
				"type_of_collection" => $tc_data[$tmpval[1]]	
			);
			$loan_bal_payments = $this->loan->get_loan_balance_and_total_payments($tmpval[1]);
			
			if($loan_bal_payments['loan_balance']<=0){
				$loan_status = 0;
				$date_completed = date('Y-m-d');
			}
			else{
				$loan_status = 1;
				$date_completed = '0000-00-00';
			}
			
			$cl_data[] = array(
					"id" => $tmpval[1],
					"total_payments" => $loan_bal_payments['total_payments'],
					"loan_balance" => $loan_bal_payments['loan_balance'],
					"status" => $loan_status,
					"date_completed" => $date_completed
			);
		} */
		
		foreach($result as $val){
			//$tmpval = explode("_", $val['value']);
			$data[] = array(
					"approved" => 1,
					"id" => $val['id']
			);
			
		}
		//print_r($cl_data);die;
		$this->db->update_batch('loan_payments', $data, 'id');
		

		//to set completed
		foreach($result as $val){
			$loan_bal_payments = $this->loan->get_loan_balance_and_total_payments($val['loan_id']);
			
			if($loan_bal_payments['loan_balance']<=0){
				$loan_status = 0;
				$date_completed = date('Y-m-d');
			}
			else{
				$loan_status = 1;
				$date_completed = '0000-00-00';
			}
			
			
			$cl_data[] = array(
					"id" => $val['loan_id'],
					"total_payments" => $loan_bal_payments['total_payments'],
					"loan_balance" => $loan_bal_payments['loan_balance'],
					"status" => $loan_status,
					"date_completed" => $date_completed
			);
		}
		
		
		if(! empty($cl_data)){
			$this->db->update_batch('customers_loan', $cl_data, 'id');
		}

		$return = array(
				"success" => true,
		);
		
		echo json_encode($return);
	}
	
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */