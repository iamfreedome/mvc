<?php

class Board extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AuthModel');
		$this->load->model('PostModel');
		$this->load->model('CommentModel');
		$this->load->library('session');
		$this->load->model('BoardModel');
	}
	
	public function all_posts() 
	{  
		if ($this->session->has_userdata('user_id')) 
		{
			$res = $this->PostModel->all_posts($this->session->user_id);
			$res = $res -> result();
			$res = $this->CommentModel->add_comment($res);
			
			$data['resi'] = $res;
			$this->session->set_userdata('board_id', -1);
			$data['uname'] = $this->session->username;
			$data = $this->BoardModel->prepare_data($data);
			
			$this->load->view('board/posts_all',$data);
				
		} else 
		{
			redirect("auth/login","refresh");
		}
	}
		
	public function view($user_id,$user_name) 
	{ //посты на доске 
		$this->session->set_userdata('board_id', $user_id);
		$data['uname'] = $user_name;
		$data = $this->BoardModel->prepare_data($data);
					
		
		$res = $this->PostModel->get_board($user_id); 
		$res = $res->result();
		$res = $this->CommentModel->add_comment($res);
			
		if (isset($res)) 
		{
			$data['resi'] = $res;
			$this->load->view('board/posts',$data);
		} 
		else 
		{
			$this->load->view('board/empty');
		}
	}
		
	public function my_board() 
	{	
		if ($this->session->has_userdata('user_id')) 
		{
			$user_id = $this->session->user_id;
			$user_name = $this->session->username;
			
		
			$this->session->set_userdata('board_id', $user_id);
		
			$res = $this->PostModel->get_board($user_id); 
			$res = $res->result(); 
			$res = $this->CommentModel->add_comment($res);
			
			$data['resi'] = $res;
			$data['uname'] = $user_name;
			$data = $this->BoardModel->prepare_data($data);
			
			$this->load->view('board/posts',$data);
			
		} else 
		{ 
			redirect("board/view_board","refresh");
		}
	}
		
	public function view_board()
	{ //доски всеъх пользователей
		$this->session->set_userdata('board_id', -1);	
		$res = $this->PostModel->get_all_boards();
		$data['resi'] = $res->result(); 
		$data = $this->BoardModel->prepare_data($data);
		$this->load->view('board/boards',$data);
		
	}
		
	public function comment($post_id) 
	{ //добавить пост на страницу
		if (isset($_POST['comment'])) 
		{ //Сделать обязательными все поля.
			$this->form_validation->set_rules('title','Заголовок','required' );
			$this->form_validation->set_rules('theme','Email','required' );
			$this->form_validation->set_rules('text','ТЕКСТ','required' );
			$transfer = FALSE;
				
			if ($this->form_validation->run() == TRUE) 
			{
			//форма комментария корректна. известить комментарий в базу
				$transfer = TRUE;
				$data = array (
					'board_id' => $this->session->board_id,
					'user_id' => $this->session->user_id,
					'comment_id' => $post_id,
					'title' => $this->input->post('title'),
					'theme' => $this->input->post('theme'),
					'text' => $this->input->post('text'),
					'deleted' => -1,
					);
							
				$this->PostModel->add_post($data);
			}
				//форма заполнена не полностью ... ну форм валидатор справиться сам
		}
		
		$this->load->view('board/comment',array('title' => $this->session->username));
	}
		
	public function answer($post_id) 
	{
		if ($this->session->has_userdata('user_id')) 
		{ 
			$user_id = $this->session->user_id; $user_name= $this->session->username; 
		} 
		else 
		{ 
			redirect("board/view_board","refresh"); 
		}
		$com_post = ($this->PostModel->get_post_withusername($post_id));	
		$com_post = $com_post->row();
		$data['text']= $com_post->text;
		$data['board_id'] = $com_post->board_id;
		$data['answer'] = $com_post->username;
	
		if (isset($_POST['comment'])) 
		{ //Сделать обязательными все поля.
			$this->form_validation->set_rules('title','Заголовок','required' );
			$this->form_validation->set_rules('text','ТЕКСТ','required' );
			$transfer = FALSE;
				
			if ($this->form_validation->run() == TRUE) 
			{
			//форма комментария корректна. известить. комментарий в базу
				$transfer = TRUE;
				$data_insert = array (
					'board_id' => $data['board_id'],
					'user_id' => $this->session->user_id,
					'comment_id' => $post_id,
					'title' => $this->input->post('title'),
					'theme' => 'Answer '.$post_id.' '.$com_post->title.' to '.$data['answer'],
					'text' => $this->input->post('text'),
					'deleted' => -1,
				);
				
				$this->CommentModel->set_comment($data_insert);
				redirect("board/view_board","refresh");
			}
				//форма заполнена не полностью ... ну форм валидатор справиться сам
		}
		$this->load->view('board/answer',$data);
	}
	
	public function delete_post($post_id) 
	{  	//проверка нужна или нет. по умолчанию проверять не будем. пусть даже удалят
		if ($this->session->has_userdata('user_id')) 
		{
			$this->PostModel->delete_post($post_id);
			$this->view($this->session->user_id,$this->session->username);
		}
	}

	public function post_other() 
	{ //return JSON
		$this->session->set_userdata('offset', ($this->session->has_userdata('offset') ? $this->session->offset + ($this->input->post('limit') ? $this->input->post('limit') : 0 ) : 5 ));
	
		$limit = ($this->input->post('limit') ? $this->input->post('limit') : 0 );
		$id_board = ($this->input->post('board_id') ? $this->input->post('board_id') : 1);
	
		$res = $this->PostModel->get_board_other($id_board, $limit, $this->session->offset);
		$res = $res->result();
		$res =  $this->CommentModel->add_comment($res);
	
		foreach ($res as $row):
			$row = (array) $row;
		endforeach;
		
		header('Content-type: application/json; charset=utf-8');
		$json = json_encode($res, JSON_UNESCAPED_UNICODE);
		//коверкать илди нет кирилицу $json = json_encode($res);
	
		echo ($json);
	}

	public function post_other_html() 
	{ //html
	
		$this->session->set_userdata('offset', ($this->session->has_userdata('offset') ? $this->session->offset + ($this->input->post('limit') ? $this->input->post('limit') : 0 ) : 5 ));
		$limit = ($this->input->post('limit') ? $this->input->post('limit') : 0 );
		$id_board = ($this->session->has_userdata('board_id') ? $this->session->board_id : $this->input->post('board_id'));
		
		$res = $this->PostModel->get_board_other($id_board, $limit,  $this->session->offset);
		$res = $res->result();
		$res =  $this->CommentModel->add_comment($res);
	
		foreach ($res as $row):
			$row = (array) $row;
		endforeach;
		$data['resi'] = $res;
		$data = $this->BoardModel->prepare_data($data);
		$this->load->view('board/post_other',$data);
	}
	
}
/*MVC
	1)+ https://prnt.sc/pcqb67
	2)+ https://prnt.sc/pcqbbw каст не используют обычно
	3)+ https://prnt.sc/pcqbgr
	4)+ https://prnt.sc/pcqblh нельзя работать с текстами в модели, тока во вью или контроллере если это аякс
	5)+ https://prnt.sc/pcqbyr лишнаяя переменная
		6)+ https://prnt.sc/pcqccp первй раз вижу такую функцию
	7)+ https://prnt.sc/pcqcg3 форматирование
	8)+ https://prnt.sc/pcqcs8 дублирование кода
	9)+ https://prnt.sc/pcqcy7 текст
	10)+ https://prnt.sc/pcqd53
	11)+ https://prnt.sc/pcqdcy что за дичь?
	12)+ https://prnt.sc/pcqdpn странные функции в контроллерах, может это модель или хелпер? Контроллеры грузят вьюхи
	13)+ https://prnt.sc/pcqdzk опять комменты
	14)+ https://prnt.sc/pcqe91 недопускается использование стандартных POST
	15)+ https://prnt.sc/pcqek6 что это? - debug
	16)+ https://prnt.sc/pcqeok что за куски кода?
	17)+ https://prnt.sc/pcqfjs хедер напрямую в темплейте
	
	1)+ Использовать встренный механизм сессий, а не $_SESSION
2)+ Форматирование не соотвествует стандартам движка, например https://prnt.sc/pbngzu
	3)+ Не использовать шаблонизацию внутри контроллеров, для этого есть вьюхи https://prnt.sc/pbnh5x
	4)+ Использовать для проверки доступа к приватной зоне либо стандартные средства, либо общий контроллер от которого идет наследование для всех других https://prnt.sc/pbnhgz
	5)+ Непонятен смысл таких конструкций https://prnt.sc/pbnj6t
	6)+ Опять форматирование https://prnt.sc/pbnjjl
	7)+ Есть струткруные проблемы с построением моделей, модель поста одна, модель комментария другая, пост != коммент, соотвественно нужно это поправить, сейчас вообще моделей нет?
	8 )+ https://prnt.sc/pbnko2 англ язык тут поправить либо del либо delete
	9) + Проверить на уязвимость стороннего открытия файлов системы, те можно ли открыть файл на диске С подделав запрос
https://prnt.sc/pbnlce
	10)+ https://prnt.sc/pbnlw0 в модель авторизации нельзя писать действия которые нужны для модели постов и комментов, это разные сущности
11)+ Для форматирования можно юзать вот этот гайд https://framework.zend.com/manual/2.4/en/ref/coding.standard.html
	12)+ https://prnt.sc/pbnmh6 лишние файлы
	13)+ не использовать сессии во вью, они принмают данные тока от контроллеров
	14)+ нельзя дублировать код во вью, использовать струткуру где постоянные элементы вставляются автоматически, типа шапки



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

+
5) Добавить возможность отвечать на написанные комментарии (для таких комментариев перед текстом выводить блок с цитатой сообщения на которое написан ответ).
+
вывести кнопку ответить – по нажатию будет  отображаться автор  на чьё сообщение хотите ответить и ниже форма с полями 
Заголовок  сообщения, само сообщение . 

+
В случае если родительский комментарий удален вместо сообщения выводить: “комментарий удален”.

+
6) Создать для пользователя страницу, на которой он может просматривать все свои комментарии.  
На данной странице будут отображаться все комментарии вида : 
заголовок сообщения, само сообщение. 
*/