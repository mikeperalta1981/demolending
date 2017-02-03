<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller {

	public $userdata = array();
	public function __construct()
	{
		parent::__construct();
		
		$CI =& get_instance();
		if(! $CI->session->userdata('logged_in')){
			$CI->load->helper('template');
				
			redirect('login', 'refresh');
		}
		
	}
	
	
}

/* End of file AKTK_Controller.php */
/* Location: ./application/core/AKTK_Controller.php */