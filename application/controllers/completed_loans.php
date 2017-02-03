<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Completed_loans extends MY_Controller {
	private $data = array();
	public $javascripts = array('js/plugins/datatables/jquery.dataTables.js', 'js/plugins/datatables/fnReloadAjax.js', 'js/plugins/datatables/dataTables.bootstrap.js', 'js/jquery.numeric.min.js', 'js/bootbox.min.js', 'js/pages-js/completed_loans.js');
	public $css = array('css/datatables/dataTables.bootstrap.css', 'css/pages-css/completed_loans.css');
	private $configs = array();
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('configs_model', 'conf');
		
		//temporary. iyo ini ang igoglobal pag login pa lang kan sarong emple
		$this->configs = $this->conf->get_by_business_id('cfsi1');
		
	}
	
	public function index()
	{
		$this->load->helper('template');
		
		render_page('completed_loans_page', $this->data);
	}
	
	
	public function get(){
		$this->load->library('Loan');
		$this->load->model('customer_loan_model', 'loans');
		$this->load->model('loan_payments_model', 'lpm');
		$result = $this->loans->get_completed();
		
		//--compose array for table
		$loan_cycle_array = array();
		//$cycle_counter = 1;
		/* foreach($result as $val){
			if(array_key_exists($val['account_no'], $loan_cycle_array)){
				$cycle_counter++;
			}
			$loan_cycle_array[$val['account_no']][$val['loan_id']] = $cycle_counter;
		} */
		
		$customer_data = array();
		
		$payment_status = "";
		
		
		$payments = $this->lpm->get_approved_only();
		$payments_array = array();
		
		foreach($payments as $val){
			
			$payments_array[$val['loan_id']][$val['payment_date']] = $val;	
		}
		
		//echo "<pre>";print_r($result);die;
		
		foreach($result as $val){
			$cycle_counter = 1;
			$pep = "NO";
			if($val['pep_status']==1){
				$pep = "YES";
			}
				
			if($val['date_released']!=""){
				$status = "Approved";
			}
			
			$loan_balance = $val['loan_amount'];
			#######################
			$tmp_date_released = str_replace('-', '/', $val['date_released']);
			$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));


			//$loan_bal_payments = $this->loan->get_loan_balance_and_total_payments($val['loan_id']);

			if(isset($payments_array[$val['loan_id']])){
				$total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
				$loan_balance = $val['loan_amount'] - $total_payments;
			}

			$loan_payments = $payments_array[$val['loan_id']];

			//$lapses = $this->get_lapses($val['loan_id'], $val['amortization'], $val['date_released'], $amort_day_start, $val['date_completed'], $loan_bal_payments['loan_balance']);
			$lapses = $this->get_lapses($val['loan_id'], $val['amortization'], $val['date_released'], $amort_day_start, $val['date_completed'], $loan_balance, $loan_payments);
			
			#######################

			$payment_status = "";
			if(intval($lapses)>=0 && intval($lapses)<=10){
				$payment_status .= '<button type="button" class="btn btn-success btn-xs" disabled="disabled"><span class="badge">EP</span> - '.$lapses.' days</button>';
					
			}
			elseif(intval($lapses)>10 && intval($lapses)<22){
				$payment_status .= '<button type="button" class="btn btn-warning btn-xs" disabled="disabled"><span class="badge">GP</span> - '.$lapses.' days</button>';
					
			}
			else{
				$payment_status .= '<button type="button" class="btn btn-danger btn-xs" disabled="disabled"><span class="badge">SP</span> - '.$lapses.' days</button>';
					
			}
			
			$action = '<button type="button" class="btn btn-primary btn-xs" data-date_completed="'.$val['date_completed'].'" data-maturity_date="'.$val['maturity_date'].'" data-date_released="'.$val['date_released'].'" data-amortization="'.$val['amortization'].'" data-loan_amount="'.$val['loan_amount'].'" data-account_number="'.$val['account_no'].'" data-customer_name="'.$val['name'].'" data-id="'.$val['loan_id'].'" onclick="view_payments(this)">View payments</button>';
			
			
			
			if(array_key_exists($val['account_no'], $loan_cycle_array)){
				$cycle_counter += $loan_cycle_array[$val['account_no']];
			}
			$loan_cycle_array[$val['account_no']] = $cycle_counter;
			
			
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
					"date_released" => $val['date_released'],
					"maturity_date" => $val['maturity_date'],
					"customer_id" => $val['customer_id'],
					//"loan_cycle" => $loan_cycle_array[$val['account_no']],
					"loan_cycle" => $cycle_counter,
					"pep" => $pep,
					"date_completed" => $val['date_completed'],
					"payment_status" => $payment_status,
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
	

	private function get_total_payments_from_array($loan_payments){
		
		$total_payments = 0;
		
		foreach($loan_payments as $val){
			$total_payments += $val['amount'];
		}	
		
		
		return $total_payments;
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
	
	private function get_lapses($loan_id, $amortization, $date_released, $cutoff_start_date, $cutoff_end_date, $loan_balance, $loan_payments = array()){
		$this->load->model('loan_payments_model', 'lpm');

		//$loan_payments = $this->lpm->get_payments_by_id($loan_id, TRUE);
		
		//echo "<pre>";print_r($loan_payments);die;

		$total_payments_before_current_cutoff = 0;
		$total_cutoff_payments = 0;
		$overdue = 0;
		$loan_payments_array = array();
		$total_payments = 0;
		foreach($loan_payments as $key => $val){
			if($val['approved']==1){
				if($val['payment_date']< $cutoff_start_date  && $val['payment_date'] > $date_released){
					/* if($pep_status==1){
						if($val['payment_date']>=$pep_startdate){
							$total_payments_before_current_cutoff += floatval($val['amount']);
						}
					}
					else{
						$total_payments_before_current_cutoff += floatval($val['amount']);
					} */
		
					$total_payments += $val['amount'];
					$loan_payments_array[$val['payment_date']] = $val['amount'];
				}
				elseif($val['payment_date']>=$cutoff_start_date && $val['payment_date']<=$cutoff_end_date){
					$total_cutoff_payments += floatval($val['amount']);
		
					$total_payments += $val['amount'];
					$loan_payments_array[$val['payment_date']] = $val['amount'];
				}
				else{
						
				}
					
					
			}
		
		}
		$total_balance = $loan_balance - $total_payments;
		############## COMPUTE LAPSES ###############
		$payment_schdules = $this->loan->createDateRangeArray($cutoff_start_date, $cutoff_end_date);
		$schedule_with_payments_array = array();
		//echo "<pre>";print_r($loan_payments_array);die();
		$total_amort = 0;
		$total_paid_amort = 0;
		$lapses = 0;
		foreach($payment_schdules as $val){
			if($val < date('Y-m-d')){
				$total_amort += $amortization;
				if(isset($loan_payments_array[$val])){
					if($loan_payments_array[$val]<$amortization){
						//$lapses++;
					}
					$total_paid_amort += $loan_payments_array[$val];
				}
				else{
					//$lapses++;
				}
					
				$schedule_with_payments_array[$val] = isset($loan_payments_array[$val]) ? $loan_payments_array[$val] : 0;
					
				if($total_paid_amort-$total_amort < 0){
					$lapses++;
				}
		
			}
		
				
		}
		
		return $lapses;
	}
	
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */