<?php

class Board extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('Auth_model');
	}
		public function all_posts() {  //все комменты одного пользователя
			if (isset($_SESSION['user_id'])) {
			$data['title'] = 'Все комментарии: '.$_SESSION['username'];
			
			$res = $this->Auth_model->all_posts($_SESSION['user_id']);
			$res = $res -> result();
			//print_r($res);
			$data['resi'] = $res;
			$_SESSION['board_id']= -1;
			$this->load->view('templates/header_board',$data);
			$this->load->view('posts',$data);
			$this->load->view('templates/footer_board');
		
			} else {
			redirect("auth/login","refresh");
			}
		}
		
		public function view($user_id,$user_name) { //посты на доске
			//print ($user_name);
			$data['title'] = 'Доска пользователя: '.$user_name;
			
			$_SESSION['board_id'] = $user_id;
			
			
			$res = $this->Auth_model->get_board($user_id); 
			$rest = $res->result();
			//print_r ($rest);
		
			if (isset($rest)) {
				$data['resi'] = $rest;
			//print_r ($_SESSION);
			$this->load->view('templates/header_board',$data);
			$this->load->view('posts',$data);
			$this->load->view('templates/footer_board');
		} else {
			
			$this->load->view('templates/header_board',$data);
			$this->load->view('empty');
			$this->load->view('templates/footer_board');
		}
	}
		
		public function my_board() {
			//print ($user_name);
		if (isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
			$user_name = $_SESSION['username'];
			$data['title'] = 'Доска пользователя: '.$user_name;
			
			$_SESSION['board_id'] = $user_id;
			
			$res = $this->Auth_model->get_board($user_id); 
			$rest = $res->result();
			$data['resi'] = $rest;
			//print_r ($_SESSION);
			$this->load->view('templates/header_board',$data);
			$this->load->view('posts',$data);
			$this->load->view('templates/footer_board');
		} else { $this->load->view('templates/header_board',array ('title' => 'МОЯ СТРАНИЦА'));
	
	$this->load->view('templates/footer_board');
			
		}
	}
		
		public function view_board() { //доски всеъх пользователей
			
			$res = $this->Auth_model->get_all_boards();
			$data['resi'] = $res->result(); //was res-> row()
			
			//print_r ($res);
			//print_r ($data);
			//print_r ($_SESSION);
		$data['title'] = 'Доски пользователей';
			
			$this->load->view('templates/header_board',$data);
			$this->load->view('boards',$data);
			$this->load->view('templates/footer_board',$data);
		}
		
		public function main() {
			redirect("board/view_board","refresh");
		}
		
		public function comment($post_id) { //добавить пост на страницу
			print_r ($_SESSION);
		
			if (isset($_POST['comment'])) { //Сделать обязательными все поля.
				$this->form_validation->set_rules('title','Заголовок','required' );
				$this->form_validation->set_rules('theme','Email','required' );
				$this->form_validation->set_rules('text','ТЕКСТ','required' );
				$transfer = FALSE;
				
				if ($this->form_validation->run() == TRUE) {
						//форма комментария корректна. известить комментарий в базу
							$transfer = TRUE;
							$data = array (
								'board_id' => $_SESSION['board_id'],
								'user_id' => $_SESSION['user_id'],
								'comment_id' => $post_id,
								'title' => $_POST['title'],
								'theme' => $_POST['theme'],
								'text' => $_POST['text'],
								'deleted' => -1);
							//	print_r($_POST);
							$this->Auth_model->add_post($data);
							//redirect("board/view_board","refresh");
							
					
				
				//print ('Форма корректна');
				
				
				}
				//форма заполнена не полностью ... ну форм валидатор справиться сам
			
			//
			}

			//до момента нажатия кнопки коммент
			$data['title'] = 'Комментировать Доску  '.$_SESSION['username'];
						
			$this->load->view('templates/header_board',$data);
			$this->load->view('comment',$data);
			$this->load->view('templates/footer_board',$data);
		
		
		}
		
public function answer($post_id) {
	if (isset($_SESSION['user_id'])) { $user_id = $_SESSION['user_id']; $user_name= $_SESSION['username']; } 
	else { redirect("board/view_board","refresh"); }
	$data['title'] = 'Ответить пользователю  '.$user_name;
	
	//print ('Tracer tag answer'.$post_id);
		
	$com_post = $this->Auth_model->get_post($post_id);	
	$com_post = $com_post->row();
	
	
	$data['text']= $com_post->text;
	
	$this->load->view('templates/header_board',$data);
			$this->load->view('answer',$data);
			$this->load->view('templates/footer_board',$data);
		
	
	//print_r ($data);
}
	
public function del_post($post_id) {
	//проверка нужна или нет. по умолчанию проверять не будем. пусть даже удалят
	if (isset($_SESSION['user_id'])) {
		$this->Auth_model->dell_post($post_id);
		$this->view($_SESSION['user_id'],$_SESSION['username']);
	}
	
}

public function post_other() { //return JSON
	
	$_SESSION['offset'] = (isset($_SESSION['offset']) ? $_SESSION['offset'] + (isset($_POST['limit']) ? $_POST['limit'] : 0 ) : 5 );
	//if (isset($_POST['offset'])) { $offset = $_POST['offset']; } else { $offset = 5;}
	$limit = (isset($_POST['limit']) ? $_POST['limit'] : 0 );
	$id_board = (isset($_POST['board_id']) ? $_POST['board_id'] : 1);
	
	//print($_SESSION['offset']);
	$res = $this->Auth_model->get_board_other($id_board, $limit,  $_SESSION['offset']);
	$res = $res->result();
	
	header('Content-type: application/json; charset=utf-8');
	$json = json_encode($res, JSON_UNESCAPED_UNICODE);
	//коверкать илди нет кирилицу $json = json_encode($res);
	//echo 'Tracert tag function pos';
	
	echo ($json);
}

public function post_other_html() { //html
	
	$_SESSION['offset'] = (isset($_SESSION['offset']) ? $_SESSION['offset'] + (isset($_POST['limit']) ? $_POST['limit'] : 0 ) : 5 );
	//if (isset($_POST['offset'])) { $offset = $_POST['offset']; } else { $offset = 5;}
	$limit = (isset($_POST['limit']) ? $_POST['limit'] : 0 );
	$id_board = (isset($_SESSION['board_id']) ? $_SESSION['board_id'] : $_POST['board_id']);
	
	//print($_SESSION['offset']);
	$res = $this->Auth_model->get_board_other($id_board, $limit,  $_SESSION['offset']);
	$res = $res->result();
	
				$data['title'] = 'Дополнительные комментарии ';
				$data['resi'] = $res;

	$this->load->view('post_other',$data);


}


		
}
/*MVC
На его основе создать сайт со следующим функционалом:


1)+ Авторизация и регистрация пользователей.  (поля для входа и регистрации  email и пароль ) 


2)+ Пользователь при регистрации получает страницу профиля со стеной. 

+
На которой каждый авторизованный пользователь может оставлять комментарии. 
(поля формы заголовок, тема, текст сообщения, кнопка «отправить») 
Сделать обязательными все поля.

+
Не авторизованные пользователи могут только просматривать стены. 
( просто просматривать сообщения  на стене ) 

+
3) На своей странице пользователь может удалять все комментарии, 
на чужих только свои. 
( рядом с оставленным комментарием сделать кнопку «Удалить комментарий» по нажатию комментарий будет  удаляться. 

+
4) Ограничить количество комментариев на странице 5. Остальные комментарии подгружать методом ajax.  
По умолчанию будут выводиться 5 комментариев. Если записей больше указывать  стрелку вниз, по клику на неё будут выводиться  все комментарии оставленные на стене. 

-
5) Добавить возможность отвечать на написанные комментарии (для таких комментариев перед текстом выводить блок с цитатой сообщения на которое написан ответ).
-
вывести кнопку ответить – по нажатию будет  отображаться автор  на чьё сообщение хотите ответить и ниже форма с полями 
Заголовок  сообщения, само сообщение . 

-
В случае если родительский комментарий удален вместо сообщения выводить: “комментарий удален”.

+
6) Создать для пользователя страницу, на которой он может просматривать все свои комментарии.  
На данной странице будут отображаться все комментарии вида : 
заголовок сообщения, само сообщение. 
*/
?>