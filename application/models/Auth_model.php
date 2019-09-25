<?php

class Auth_model extends CI_Model {
	public function __construct(){
		$this->load->database();
	
	}
	
//one model on all request;	
	
	public function register($table,$data) {
		
		$this->db->insert($table,$data);
			
	}
	
	public function get_user($username,$password) {
					
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where(array('username' => $username, 'password' => $password));
			$query = $this->db->get();
		return $query; 
	}
	
	public function get_all_boards(){
			$this->db->select('*');
			$this->db->from('users');
			$query = $this->db->get();
		return $query; 
	}

	public function get_board($board_id) {
			$limit = 5;
			$offset = 0;
			$_SESSION['offset'] = 0;
		
			$this->db->select('*');
			$this->db->from('posts');
			$this->db->where(array('board_id' => $board_id)); //WHERE `board_id` = <номер доски>, `DELETED` < 1
			$this->db->where('deleted <', 1);
			$this->db->limit($limit,$offset);
			$this->db->order_by('post_id', 'ASC');
		//added
			$query = $this->db->get();
		//
		return $query;
	}
	
	public function get_board_other($board_id,$limit,$offset) { 
			
			$this->db->select('*');
			$this->db->from('posts');
			$ar = (($board_id == -1) ? array('user_id' => $_SESSION['user_id']) : array('board_id' => $board_id)   );
			$this->db->where($ar); //WHERE `board_id` = <номер доски>, `DELETED` < 1
			$this->db->where('deleted <', 1);
			$this->db->limit( $limit , $offset);
			$this->db->order_by('post_id', 'ASC');
			$query = $this->db->get();
		return $query;
	}
	
	
	public function all_posts($user_id) {
		//add limit 5 records(rows)
			$limit = 5;
			$offset = 0;
			$_SESSION['offset'] = 0;
		
			$this->db->select('*');
			$this->db->from('posts');
			$this->db->where(array('user_id' => $user_id));
		
			$this->db->where('deleted <', 1);
			$this->db->limit($limit,$offset);
			$this->db->order_by('post_id', 'ASC');
		
			$query = $this->db->get();
		
		return $query;//
	}
	
	public function add_post($data) {
			$table = 'posts';
			$this->db->insert($table,$data);
		
	}
	
	public function get_post($post_id) {
			$this->db->select('*');
			$this->db->from('posts');
			$this->db->where(array('post_id' => $post_id));
		
			$query = $this->db->get();
		
		return $query;//
		
	}
	
	
	public function get_post_withusername($post_id) {
			$this->db->select('*');
			$this->db->from('`posts`,`users`');
			$this->db->where("`posts`.`user_id`=`users`.`user_id` AND `posts`.`post_id`=$post_id");
		
			$query = $this->db->get();
		
		
		return $query; //
		
	}
	
	public function get_all_comment() {
			$this->db->select('*'); //'`text`,`post_id`,`deleted`'
			$this->db->from('posts');
			$ret = $this->db->get();
			
		return $ret;
	}
	
	public function get_comment($comment_id) {
			if ($comment_id > 0) {
				$arcom = $this->get_all_comment();
				$arcom = $arcom->result();
		
				foreach ($arcom as $arrow) {
					if ($comment_id == $arrow->post_id) { 
						if ($arrow->deleted > 0) { return ('Сообщение было удалено ранее');} else {
			return ($arrow->text);
					} }
				}	
	
			} else { return '';}
	}
	
	public function add_comment(array $ar) {
			foreach ($ar as $rowsa) {
			
				$rowsa->comment = $this->get_comment($rowsa->comment_id);
			}
		return (array) $ar;
	}
	
	
		
	public function dell_post($post_id) {
			$con = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
			if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
			}		
			$con->query("UPDATE `posts` SET `title` = 'сообщение удалено', `theme` = 'сообщение удалено', `text` = 'сообщение удалено', `deleted` = '1'  WHERE `posts`.`post_id` = ".$post_id);
			$con->close();

		}
	}
?>