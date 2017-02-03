<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_amort_dates_model extends CI_Model {
	public $data = array();
	public $id = "";
	public $date = "";
	public $loan_id = "";
	private $table = 'loan_amort_dates';
	
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function create(){
		
		$this->db->insert($this->table, $this->data);
		if($this->db->affected_rows() > 0)
			return $this->db->insert_id();
		
		return FALSE;
	}
    
	function create_batch(){
		$this->db->insert_batch($this->table, $this->data);
	}
	
	function update(){
		$this->db->where('id', $this->id);
		$this->db->update($this->table, $this->data); 
		
		if($this->db->affected_rows() > 0)
			return $this->db->insert_id();
		
		return FALSE;
    }
    
    function update_status_by_loan_id(){
    	$this->db->where('customer_loan_id', $this->loan_id);
    	$this->db->update($this->table, $this->data);
    	
    }
    
    function update_by_date(){
    	$this->db->where('customer_loan_id', $this->loan_id);
    	$this->db->where('amort_date', $this->date);
    	$this->db->update($this->table, $this->data);
    	
    	if($this->db->affected_rows() > 0)
    		return $this->db->insert_id();
    	
    	return FALSE;
    }
    
    function get_customers_amortization($start_date = NULL, $end_date = NULL){
    	$this->db->select('lad.*, cl.amortization, CONCAT(c.surname, ",", c.firstname, " ", c.middlename) as name', FALSE);
    	$this->db->from('loan_amort_dates lad');
    	$this->db->join('customers_loan cl', 'cl.id = lad.customer_loan_id', 'left');
    	$this->db->join('customers c', 'c.id=cl.customer_id', 'left');
    	//$this->db->where('amort_date >=', $start_date);
    	//$this->db->where('amort_date <=', $end_date);
    	$query = $this->db->get();
    	return $query->result_array();
    }
    
    function get_amort_by_loan_id(){
    	$this->db->where('customer_loan_id', $this->loan_id);
    	$query =$this->db->get($this->table);
    	return $query->result_array();
    }
    
    function get_daily_collectible($today = NULL){
    	$this->db->select('c.id as customer_id, c.account_no as account_no, mop.name as mode_of_payment, cl.id as loan_id, cl.loan_amount as loan_amount, cl.amortization, CONCAT(c.surname, ",", c.firstname, " ", c.middlename) as name, lad.amort_date as amort_date, lad.daily_amort as daily_amort, lad.amount_paid as amount_paid, lad.id as id',  FALSE);
    	$this->db->from('loan_amort_dates lad');
    	$this->db->join('customers_loan cl', 'cl.id = lad.customer_loan_id', 'left');
    	$this->db->join('customers c', 'c.id=cl.customer_id', 'left');
    	$this->db->join('mode_of_payment mop', 'cl.mode_of_payment=mop.id');
    	//$this->db->where('lad.amount_paid =', 0);
    	$this->db->where('cl.status >', 0);
    	
    	if(! is_null($today)){
    		$this->db->where('lad.amort_date', $today);
    	}
    	//$this->db->where('lad.status', 1);
    	
    	$query = $this->db->get();
    	return $query->result_array();
    }
    
    function get_cutoff_details($start_date = NULL, $end_date = NULL, $isPEP=0){
    	$this->db->select('c.id as customer_id, c.account_no as account_no, cl.amortization, CONCAT(c.surname, ",", c.firstname, " ", c.middlename) as name, lad.amort_date as amort_date, lad.daily_amort as daily_amort, lad.id as id, lad.amount_paid as amount_paid',  FALSE);
    	$this->db->from('loan_amort_dates lad');
    	$this->db->join('customers_loan cl', 'cl.id = lad.customer_loan_id', 'left');
    	$this->db->join('customers c', 'c.id=cl.customer_id', 'left');
    	$this->db->where('lad.amort_date >=', $start_date);
    	$this->db->where('lad.amort_date <=', $end_date);
    	$this->db->where('lad.customer_loan_id', $this->loan_id);
    	$this->db->where('lad.is_pep', $isPEP);
    	$query = $this->db->get();
    	return $query->result_array();
    }
    
    function get_loan_schedule(){
    	$this->db->where('customer_loan_id', $this->loan_id);
    	$this->db->order_by("amort_date", "asc");
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
    function get_pep_schedule(){
    	$this->db->where('customer_loan_id', $this->loan_id);
    	$this->db->where('is_pep', '1');
    	$this->db->order_by("amort_date", "asc");
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */