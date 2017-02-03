<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_house_type_model extends CI_Model {

	public $id = "";
	public $house_type = "";
	public $active = "";
	private $table = 'customers_house_type';
	
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get(){
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return $result;
    }
    
    
}

/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */