<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {
	
	public $javascripts = array();
	public $css = array();
	
	
	function __construct()
	{
		parent::__construct();
		$this->session->sess_destroy();
	}
	
	public function index()
	{
		$this->load->helper('template');
		
		$this->load->view('login_page');
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */