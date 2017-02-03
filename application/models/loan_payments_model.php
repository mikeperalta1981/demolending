<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_payments_model extends CI_Model {
	public $data = array();
	public $id = "";
	public $loan_id = "";
	public $payment_date = "";
	private $table = 'loan_payments';
	
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
    
    function get_approved_only(){
    	$this->db->where('approved', '1');
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
    function update_by_loanid_and_date(){
    	$this->db->where('loan_id', $this->loan_id);
    	$this->db->where('payment_date', $this->payment_date);
    	$this->db->update($this->table, $this->data);
    }
    
    function get_payments_by_id($id, $approved_only = FALSE){
    	$this->db->where('loan_id', $id);
    	$this->db->order_by('payment_date', 'asc');
    	if($approved_only){
    		$this->db->where('approved', '1');
    	}
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
    function get_payments_by_date_and_id($id, $payment_date, $approved_only = FALSE){
    	$this->db->where('loan_id', $id);
    	$this->db->where('payment_date', $payment_date);
    	if($approved_only){
    		$this->db->where('approved', '1');
    	}
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
    function get_payments(){
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
    function get_current_month_amortization($start_date, $end_date){
    	$this->db->select('lad.*, cl.amortization, CONCAT(c.surname, ",", c.firstname, " ", c.middlename) as name', FALSE);
    	$this->db->from('loan_amort_dates lad');
    	$this->db->join('customers_loan cl', 'cl.id = lad.customer_loan_id', 'left');
    	$this->db->join('customers c', 'c.id=cl.customer_id', 'left');
    	//$this->db->where('amort_date >=', $start_date);
    	//$this->db->where('amort_date <=', $end_date);
    	$query = $this->db->get();
    	return $query->result_array();
    }
    
    
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */