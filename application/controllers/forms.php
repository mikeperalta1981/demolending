<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends CI_Controller {
	private $data = array();
	public $javascripts = array('js/plugins/datatables/jquery.dataTables.js', 'js/plugins/datatables/fnReloadAjax.js', 'js/plugins/datatables/dataTables.bootstrap.js', 'js/jquery.numeric.min.js', 'js/pages-js/reports.js');
	public $css = array('css/datatables/dataTables.bootstrap.css', 'css/pages-css/reports.css');
	
	public function index()
	{
		$this->load->helper('template');
		
		render_page('reports_page', $this->data);
	}
	
	
	function contract(){
		
	}
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */