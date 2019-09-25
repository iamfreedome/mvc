<?php
class Auth extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('Auth_model');
			
		}
		
		public function logout() {
			unset($_SESSION);
			session_destroy();
			redirect("auth/login","refresh");
			
		}
		
		public function login() {
			
			$this->form_validation->set_rules('username','Username','required' );
			$this->form_validation->set_rules('password','Password','required|min_length[5]' );
			
			if ($this->form_validation->run() == TRUE) {	
			//проверить пользователя в базе
			$query = $this->Auth_model->get_user($_POST['username'],md5($_POST['password']));
			$user = $query->row();
			//если пользователь есть. if user exist.
			
			if ((isset($user))&&($user->email)) {
				$this->session->set_flashdata("success","Вы вошли в систему");
				
				//задать переменные
				$_SESSION['user_logged'] = TRUE;
				$_SESSION['username'] = $user->username;
				$_SESSION['user_id'] = $user->user_id;
				
				//переадрессация/redirect
				
				redirect("board/view_board","refresh");	
						
			} else {
				$this->session->set_flashdata("error","Нет такого пользователя в базе данных.");
				redirect("auth/login","refresh");
			
			}
			
			}
			
			//echo 'login page';
			$this->load->view('login');
			$this->load->view('templates/footer_board');	//,$data
		}
		public function register() {
			
			if (isset($_POST['register'])) {
				$this->form_validation->set_rules('username','Username','required' );
				$this->form_validation->set_rules('email','Email','required' );
				$this->form_validation->set_rules('password','Password','required|min_length[5]' );
				$this->form_validation->set_rules('password','Confirm_password','required|min_length[5]|matches[password]' );
				
			if ($this->form_validation->run() == TRUE) {
					//echo 'Форма корректна';
					
				$data = array(
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => md5($_POST['password'])
					);
					
					// add user in database
				$this->Auth_model->register('users',$data);
				$this->session->set_flashdata("success","Ваш аккаунт зарегистрирован. Вы можете войти уже сейчас.");
				redirect("auth/register","refresh");
				}
			}
			$this->load->view('templates/header_board',array('title' => 'Регистрация'));
			$this->load->view('register');
			$this->load->view('templates/footer_board');//,$data
		}
}
?>