<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public $javascripts = array();
	public $css = array();
	
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->helper('template');
		$this->load->helper(array('form'));
		//$this->load->view('login_view');
		
		$data = array();
		//render_page('login', $data);
		$this->load->view('login_page');
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */