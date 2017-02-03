<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_loan_model extends CI_Model {
	public $data = array();
	public $id = "";
	private $table = 'customers_loan';
	
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
    
	function update(){
		$this->db->where('id', $this->id);
		$this->db->update($this->table, $this->data); 
    }
    
    
    function set_params($params = array()){
    	if(! empty($params)){
    		foreach($params as $key => $val){
    			if(isset($this->$key)){
    				$this->$key = $val;
    			}
    		}
    	}
    	
    }
        
	function delete(){
    	$this->db->delete($this->table, array('id' => $this->id));
    }
    
    
	function get(){
		$this->db->select('c.id as customer_id, c.account_no,  CONCAT(IFNULL(c.surname, ""), ", ", IFNULL(c.firstname, ""), " ", IFNULL(c.middlename, "")) as name, l.id as loan_id, l.application_status as application_status, l.loan_type as loan_type, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, mop.name as mode_of_payment, mop.id as mopid, CONCAT(IFNULL(c.address_home_no, ""), " ", IFNULL(c.address_st_name,""), " ", IFNULL(c.address_brgy,""), " ", IFNULL(c.address_municipality,""), " ", IFNULL(c.address_city,""), " ", IFNULL(c.address_prov,""), " ", IFNULL(c.postal_code,"")) as address, ba.area_name as area_name', FALSE);
		$this->db->from('customers c');
		$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
		$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
		$this->db->join('branch_areas ba', 'ba.id=c.area_id');
		$this->db->where('l.status >', 0);
    	$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
    
    function get_approved_daily_with_payments(){
    	$this->db->select('c.id as customer_id, lp.payment_date as payment_date, lp.amount as payment_amount, c.account_no, CONCAT(c.surname, ", ", c.firstname, " ", c.middlename) as name, l.id as loan_id, l.application_status as application_status, l.loan_type as loan_type, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, mop.name as mode_of_payment, mop.id as mopid', FALSE);
    	$this->db->from('customers c');
    	$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
    	$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
    	$this->db->join('loan_payments lp', 'l.id=lp.loan_id');
    	//$this->db->where('lp.approved >', 0);
    	$this->db->where('l.status >', 0);
    	$this->db->where('l.mode_of_payment =', 1);
    	$this->db->where('l.application_status =', 2);
    	$query = $this->db->get();
    	$result = $query->result_array();
    	return $result;
    }
    
    function get_approved_daily($area_id = ''){
    	$this->db->select('ba.area_name as area_name, ba.id as area_id, c.area_id as area_id, c.id as customer_id, c.account_no, CONCAT(IFNULL(c.surname, ""), ", ", IFNULL(c.firstname, ""), " ", IFNULL(c.middlename, "")) as name, l.id as loan_id, l.application_status as application_status, l.loan_type as loan_type, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, mop.name as mode_of_payment, mop.id as mopid', FALSE);
    	$this->db->from('customers c');
    	$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
    	$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
		$this->db->join('branch_areas ba', 'ba.id=c.area_id');
    	$this->db->where('l.status >', 0);
    	$this->db->where('l.mode_of_payment =', 1);
    	$this->db->where('l.application_status =', 2);
    	if($area_id!=''){
    		$this->db->where('ba.id =', $area_id);
    	}
    	$this->db->order_by("c.surname", "asc"); 
    	$query = $this->db->get();
    	$result = $query->result_array();
    	return $result;
    }
    
    function get_approved_daily_dcr($area_id = '', $branch_id=''){
    	$this->db->select('l.date_completed, ba.area_name as area_name, ba.id as area_id, c.area_id as area_id, c.id as customer_id, c.account_no, CONCAT(IFNULL(c.surname, ""), ", ", IFNULL(c.firstname, ""), " ", IFNULL(CONCAT(LEFT(c.middlename,1), "."), "")) as name, l.id as loan_id, l.application_status as application_status, l.loan_type as loan_type, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, mop.name as mode_of_payment, mop.id as mopid, br.branch_name', FALSE);
    	$this->db->from('customers c');
    	$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
    	$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
    	$this->db->join('branch_areas ba', 'ba.id=c.area_id');
        $this->db->join('branches br', 'br.id=ba.branch_id');
    	//$this->db->where('l.status >', 0);
    	$this->db->where('l.mode_of_payment =', 1);
    	$this->db->where('l.application_status =', 2);
    	if($area_id!=''){
    		$this->db->where('ba.id =', $area_id);
    	}
        if($branch_id!=''){
            $this->db->where('br.id =', $branch_id);
        }
    	$this->db->order_by("c.surname", "asc");
    	$query = $this->db->get();
    	//echo $this->db->last_query();die;
    	$result = $query->result_array();
    	return $result;
    }
    
    function get_completed(){
    	$this->db->select('c.id as customer_id, c.account_no, CONCAT(c.surname, ", ", c.firstname, " ", c.middlename) as name, l.id as loan_id, l.application_status as application_status, l.loan_type as loan_type, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, l.date_completed as date_completed, mop.name as mode_of_payment, mop.id as mopid', FALSE);
    	$this->db->from('customers c');
    	$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
    	$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
    	$this->db->where('l.status =', 0);
    	$this->db->order_by('l.id', 'asc');
    	$query = $this->db->get();
    	$result = $query->result_array();
    	return $result;
    }
    
    function get_recent_completed($customer_id){
    	//$this->db->select('c.id as customer_id, c.account_no, CONCAT(c.surname, ", ", c.firstname, " ", c.middlename) as name, l.id as loan_id, l.application_status as application_status, l.loan_type as loan_type, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.status as loan_status, l.loan_term as loan_term, l.date_completed as date_completed, l.id_presented as id_presented, l.loan_purpose as loan_purpose, l.collateral as collateral, mop.name as mode_of_payment, mop.id as mopid', FALSE);
    	$this->db->select('c.id as customer_id, c.account_no, CONCAT(IFNULL(c.surname, ""), ", ", IFNULL(c.firstname, ""), " ", IFNULL(c.middlename, "")) as name, l.id as loan_id, l.id_presented as id_presented, l.loan_purpose as loan_purpose, l.collateral as collateral, l.loan_type as loan_type, l.application_status as application_status, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, l.loan_term as loan_term, mop.name as mode_of_payment, mop.id as mopid, CONCAT(IFNULL(c.address_home_no, ""), " ", IFNULL(c.address_st_name,""), " ", IFNULL(c.address_brgy,""), " ", IFNULL(c.address_municipality,""), " ", IFNULL(c.address_city,""), " ", IFNULL(c.address_prov,""), " ", IFNULL(c.postal_code,"")) as address, c.marital_status as marital_status, l.useSpouse, l.type_of_business,  l.co_maker1, l.co_maker1_address, l.co_maker2, l.co_maker2_address, l.witness1, l.witness2, l.collateral_address, CONCAT(IFNULL(c.spouse_surname, ""), ", ", IFNULL(c.spouse_firstname,""), " ", IFNULL(c.spouse_middlename,"")) as spouse_name, l.maker_id, l.maker_id_issue_date, l.co_maker1_id, l.co_maker1_id_issue_date, l.co_maker2_id, l.co_maker2_id_issue_date, l.co_borrower_id, l.co_borrower_id_issue_date', FALSE);
    	$this->db->from('customers c');
    	$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
    	$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
    	
    	$this->db->where('l.status =', 0);
    	$this->db->where('l.customer_id =', $customer_id);
    	$this->db->order_by("l.date_completed", "desc");
    	$this->db->limit(1);
    	$query = $this->db->get();
    	
    	$result = $query->result_array();
    	
    	return $result;
    }
    
    function get_collaterals($loan_id){
    	$this->db->select();
    	$this->db->from('loan_collaterals');
    	$this->db->where('loan_id =', $loan_id);
    	
    	$query = $this->db->get();
    	$result = $query->result_array();
    	return $result;
    }
    
    function check_customer_loan($id){
    	$this->db->where('customer_id', $id);
    	$this->db->where('status >', 0);
    	$this->db->where('application_status <', 3);
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
    function get_by_id($id){
    	$this->db->where('customer_id', $id);
    	$this->db->where('status !=', 0);
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    	
    }
     function get_by_loan_id_cheque($id){
        $this->db->select('c.id as customer_id, c.account_no, CONCAT(IFNULL(c.firstname, ""), " ", IFNULL(c.middlename, ""), " ", IFNULL(c.surname, "")) as name, l.id as loan_id, l.id_presented as id_presented, l.loan_purpose as loan_purpose, l.collateral as collateral, l.loan_type as loan_type, l.application_status as application_status, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, l.loan_term as loan_term, mop.name as mode_of_payment, mop.id as mopid, CONCAT(IFNULL(c.address_home_no, ""), " ", IFNULL(c.address_st_name,""), " ", IFNULL(c.address_brgy,""), " ", IFNULL(c.address_municipality,""), " ", IFNULL(c.address_city,""), " ", IFNULL(c.address_prov,""), " ", IFNULL(c.postal_code,"")) as address, c.marital_status as marital_status, l.useSpouse, l.type_of_business,  l.co_maker1, l.co_maker1_address, l.co_maker2, l.co_maker2_address, l.witness1, l.witness2, l.collateral_address, CONCAT(IFNULL(c.spouse_surname, ""), ", ", IFNULL(c.spouse_firstname,""), " ", IFNULL(c.spouse_middlename,"")) as spouse_name, l.maker_id, l.maker_id_issue_date, l.co_maker1_id, l.co_maker1_id_issue_date, l.co_maker2_id, l.co_maker2_id_issue_date, l.co_borrower_id, l.co_borrower_id_issue_date, l.mutual_aid', FALSE);
        $this->db->from('customers c');
        $this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
        $this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
        $this->db->where('l.id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_by_loan_id($id){
    	$this->db->select('c.id as customer_id, c.account_no, CONCAT(IFNULL(c.surname, ""), ", ", IFNULL(c.firstname, ""), " ", IFNULL(c.middlename, "")) as name, l.id as loan_id, l.id_presented as id_presented, l.loan_purpose as loan_purpose, l.collateral as collateral, l.loan_type as loan_type, l.application_status as application_status, l.loan_amount, l.loan_proceeds, l.loan_term_duration, l.date_released, l.maturity_date, l.interest_pct, l.interest_amount, l.service_fee_pct, l.service_fee_amount, l.amortization, l.is_pep as pep_status, l.pep_startdate as pep_startdate, l.pep_enddate as pep_enddate, l.pep_amort as pep_amort, l.status as loan_status, l.total_payments as total_payments, l.loan_balance as loan_balance, l.loan_term as loan_term, mop.name as mode_of_payment, mop.id as mopid, CONCAT(IFNULL(c.address_home_no, ""), " ", IFNULL(c.address_st_name,""), " ", IFNULL(c.address_brgy,""), " ", IFNULL(c.address_municipality,""), " ", IFNULL(c.address_city,""), " ", IFNULL(c.address_prov,""), " ", IFNULL(c.postal_code,"")) as address, c.marital_status as marital_status, l.useSpouse, l.type_of_business,  l.co_maker1, l.co_maker1_address, l.co_maker2, l.co_maker2_address, l.witness1, l.witness2, l.collateral_address, CONCAT(IFNULL(c.spouse_surname, ""), ", ", IFNULL(c.spouse_firstname,""), " ", IFNULL(c.spouse_middlename,"")) as spouse_name, l.maker_id, l.maker_id_issue_date, l.co_maker1_id, l.co_maker1_id_issue_date, l.co_maker2_id, l.co_maker2_id_issue_date, l.co_borrower_id, l.co_borrower_id_issue_date, l.mutual_aid', FALSE);
		$this->db->from('customers c');
		$this->db->join('customers_loan l', 'c.id=l.customer_id', 'right');
		$this->db->join('mode_of_payment mop', 'l.mode_of_payment=mop.id');
		$this->db->where('l.id', $id);
    	$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
    
    function get_customer_loans(){
    	$query = $this->db->get($this->table);
    	return $query->result_array();
    }
    
   
    
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */