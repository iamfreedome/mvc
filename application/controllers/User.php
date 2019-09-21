<?php
class user extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if ((!isset($_SESSION['user_logged'])) or ($_SESSION['user_logged'] == FALSE)) {
				
				$this->session->set_flashdata("error","Please login first to view this page");
				redirect("auth/login","refresh");
			} 
			
		}
		
		public function profile() {
				
				if ((!isset($_SESSION['user_logged'])) or ($_SESSION['user_logged'] == FALSE)) {
				
				$this->session->set_flashdata("error","Please login first to view this page");
				redirect("auth/login","refresh");
			
			} 
				
				$this->load->view('profile');
			
			
			
		}
	
}
?>