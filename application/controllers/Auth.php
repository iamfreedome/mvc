<?php
class Auth extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AuthModel');
		$this->load->library('session');
	}
		
	public function logout() 
	{
		
		$this->session->sess_destroy();
		redirect("auth/login","refresh");
	}
		
	public function login() 
	{
		$this->form_validation->set_rules('username','Username','required' );
		$this->form_validation->set_rules('password','Password','required|min_length[5]' );
			
		if ($this->form_validation->run() == TRUE) 
		{	
			//проверить пользователя в базе
		$query = $this->AuthModel->get_user($this->input->post('username'),md5($this->input->post('password')));
		$user = $query->row();
			//если пользователь есть. if user exist.
			
		if ((isset($user))&&($user->email)) 
		{
			$this->session->set_flashdata("success","Вы вошли в систему");
			//задать переменные
			$insess = array (
				'user_logged' => TRUE,
				'username' => $user->username,
				'user_id' => $user->user_id,
			);
			$this->session->set_userdata($insess);	
						
			redirect("board/view_board","refresh");	
						
			} else 
			{
				$this->session->set_flashdata("error","Нет такого пользователя в базе данных.");
				redirect("auth/login","refresh");
			}
			
		}
			
			//echo 'login page';
		$this->load->view('board/login');
	}
	
	public function register() 
	{
		if (isset($_POST['register'])) 
		{
			$this->form_validation->set_rules('username','Username','required' );
			$this->form_validation->set_rules('email','Email','required' );
			$this->form_validation->set_rules('password','Password','required|min_length[5]' );
			$this->form_validation->set_rules('password','Confirm_password','required|min_length[5]|matches[password]' );
				
			if ($this->form_validation->run() == TRUE) 
			{
				//echo 'Форма корректна';
				$data = array(
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'password' => md5($this->input->post('password')),
					);
					
				// add user in database
				$this->AuthModel->register('users',$data);
				$this->session->set_flashdata("success","Ваш аккаунт зарегистрирован. Вы можете войти уже сейчас.");
				redirect("auth/register","refresh");
			}
		}
		
		$this->load->view('board/register');
		
	}
}
