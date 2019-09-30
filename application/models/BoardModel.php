<?php
class BoardModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	
	public function auth_inf()
	{
		$ai = array ( 'user_logged' => ($this->session->has_userdata('user_logged') ? TRUE : FALSE ),
			'username' => ($this->session->has_userdata('user_logged') ? $this->session->username : ''),
			'user_id' => ($this->session->has_userdata('user_logged') ? $this->session->user_id : FALSE),
			'board_id' => $this->session->userdata('board_id'),
		);
		return $ai;
	}
	
	public function path_inf()
	{
		$pi = array ('base' => base_url().'index.php/board/answer/', 
			'base_del' => base_url().'index.php/board/delete_post/',
		);
		return $pi;
	}
	
	public function prepare_data($data)
	{
		$data['ai']= $this->auth_inf();
		$data['pi']= $this->path_inf();
		return $data;
	}

}	
	