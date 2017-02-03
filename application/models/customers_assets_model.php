<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_assets_model extends CI_Model {

	public $id = "";
	public $asset = "";
	public $active = "";
	private $table = 'customers_assets';
	
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

/* End of file customers_assets_model.php */
/* Location: ./application/models/customer_assets_model.php */