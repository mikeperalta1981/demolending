<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('render_page'))
{
	function render_page($page, $data = array())
	{
		$CI = &get_instance();
		$CI->load->view('template/header');
		$CI->load->view('template/topnav');
		$CI->load->view('template/leftnav');
		$CI->load->view('page/' . $page, $data);
		$CI->load->view('template/footer');
	}
}

if ( ! function_exists('get_template_dir'))
{
	function get_template_dir($path = NULL)
	{
		return base_url('resources/' .$path);
	}
}

if(! function_exists('get_logged_admin'))
{
	function get_logged_admin($key = NULL)
	{
		$CI = &get_instance();
		
		$admin = $CI->session->userdata('admin');

		if(! empty($key) && ! empty($admin))
			return isset($admin[$key]) ? $admin[$key] : false;
			
		return ! empty($admin) ? $admin : false;
	}
}

if ( ! function_exists('login_page'))
{
	function login_page($view, $data = array(), $return = FALSE)
	{
		$CI = &get_instance();
		
		$theme = get_current_theme();
		
		$CI->config->load('themes');
		$theme_config = $CI->config->item($theme);
				
		foreach($theme_config['pages'][$view] as $page)
			$CI->load->view($theme.'/'.$page, $data);
	}
}
if ( ! function_exists('render_javascript'))
{
	function render_javascript()
	{
		$js_str = '';
		$CI =& get_instance();
		if(isset($CI->javascripts))
		{
			if(count($CI->javascripts) > 0)
			{
				foreach($CI->javascripts as $js)
				{
					if(preg_match('/^((https?):)?\/\//', $js, $matches))
						$js_str .= '<script src="'.$js.'" type="text/javascript"></script>'."\n";
					else
						$js_str .= '<script src="'.get_template_dir($js).'" type="text/javascript"></script>'."\n";
				}
			}
		}
		return $js_str;
	}
}

if ( ! function_exists('render_css'))
{
	function render_css()
	{
		$css_str = '';
		$CI =& get_instance();
		
		if(isset($CI->css)){
			if(count($CI->css) > 0){
				foreach($CI->css as $css){
					$css_str .= '<link href="'.get_template_dir($css).'" rel="stylesheet"  type="text/css">';
					
				}
			}	
		}
		
		
		return $css_str;
	}
}








/* End of file template_helper.php */
/* Location: ./application/helpers/template_helper.php */