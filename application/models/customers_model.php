<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_model extends CI_Model {
	public $data = array();
	public $id = "";
	private $table = 'customers';
	
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
		
		if($this->db->affected_rows() > 0)
			return $this->db->insert_id();
		
		return FALSE;
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
    
    function get_by_id(){
    	$this->db->select('c.*', FALSE);
		$this->db->from('customers c');
		$this->db->where('c.id', $this->id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
    
	function get(){
		$this->db->where('active', '1');
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return $result;
    }
    
    function get_customers_with_loan(){
    	$this->db->select('c.id, CONCAT(c.surname, ", ", c.firstname, " ", c. middlename) as name, cl.id as loan_id', FALSE);
    	$this->db->from('customers c');
    	$this->db->join('customers_loan cl', 'c.id=cl.customer_id', 'left');
    	$this->db->where('c.active', '1');
    	$query = $this->db->get();
    	return $query->result_array();
    }
    
   
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */