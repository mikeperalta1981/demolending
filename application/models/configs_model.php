<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configs_model extends CI_Model {
	public $data = array();
	private $table = 'configs';
	
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get(){
		$query = $this->db->get($this->table);
		
		return $query->result_array();
	}
    
	function get_by_business_id($business_id){
		$this->db->where('business_id', $business_id);
		$this->db->where('status', '1');
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
    
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */