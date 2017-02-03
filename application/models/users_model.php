<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Users_model extends CI_Model
{
	
	function login($username, $password)
 	{
	   $this -> db -> select();
	   $this -> db -> from('users');
	   $this -> db -> where('username', $username);
	   $this -> db -> where('password', MD5($password));
	   $this -> db -> where('active', '1');
	   $this -> db -> limit(1);
	
	   $query = $this -> db -> get();
	
	   if($query -> num_rows() == 1)
	   {
	     return $query->result_array();
	   }
	   else
	   {
	     return false;
	   }
	}
	
	function get($username, $password)
	{
		$this -> db -> select();
		$this -> db -> from('users');
		$this -> db -> where('username', $username);
		$this -> db -> where('password', MD5($password));
		$this -> db -> where('active', '1');
		$this -> db -> limit(1);
	
		$query = $this -> db -> get();
	
		if($query -> num_rows() == 1)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
}


/* End of file customers_model.php */
/* Location: ./application/models/customer_model.php */