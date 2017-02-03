<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_references_model extends CI_Model {

	public $id = "";
	public $data = array();
	private $table = 'customers_references';
	
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function create_batch($params = array()){
		
		if(! empty($params))
			$this->db->insert_batch($this->table, $params);
	}
	
    
	function update_batch(){
		$this->db->update_batch($this->table, $this->data, 'id');
		return TRUE;
    }
    
	function get_by_customer_id(){
    	$this->db->select('cr.*', FALSE);
		$this->db->from('customers_references cr');
		$this->db->where('cr.customer_id', $this->id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
    
  
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */