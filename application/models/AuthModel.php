<?php

class AuthModel extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	
	}
	
	
	
	public function register($table,$data) 
	{
		$this->db->insert($table,$data);
	}
	
	public function get_user($username,$password) 
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where(array('username' => $username, 'password' => $password));
		$query = $this->db->get();
		return $query; 
	}

}
	