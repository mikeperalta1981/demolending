<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch_areas_model extends CI_Model {
	public $data = array();
	public $id = "";
	private $table = 'branch_areas';
	
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
    
	function get(){
		$this->db->where('active', '1');
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return $result;
    }
    
    function get_by_branch_id($id){
    	$this->db->where('active', '1');
    	$this->db->where('branch_id', $id);
    	$query = $this->db->get($this->table);
    	$result = $query->result_array();
    	return $result;
    }
    
    
    
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */