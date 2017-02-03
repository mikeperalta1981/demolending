<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verify_login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'users');
		$this->load->helper('template');
	}
	
	function index()
	{
		//This method will have the credentials validation
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		
		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.  User redirected to login page
			$this->load->view('login_page');

		}
		else
		{
			//Go to private area
			 redirect('dashboard', 'refresh');
		}
	
	}
	
	function check_database($password)
	{
		
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');
		
		//query the database
		$result = $this->users->get($username, $password);
		//print_r($result);die;
		if($result)
		{
			$this->session->set_userdata('logged_in', $result[0]);
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */