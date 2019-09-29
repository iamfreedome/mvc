<?php
class PostModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all_boards()
	{
		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		return $query; 
	}
	
	public function get_board($board_id) 
	{
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
	
		public function get_board_other($board_id,$limit,$offset) 
	{ 
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

public function all_posts($user_id) 
	{
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
	
	public function add_post($data) 
	{
		$table = 'posts';
		$this->db->insert($table,$data);
	}
	
	public function get_post($post_id) 
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where(array('post_id' => $post_id));
		$query = $this->db->get();
		return $query;//
	}

	public function get_post_withusername($post_id) 
	{
		$this->db->select('*');
		$this->db->from('`posts`,`users`');
		$this->db->where("`posts`.`user_id`=`users`.`user_id` AND `posts`.`post_id`=$post_id");
		
		$query = $this->db->get();
		return $query; //
	}

	public function delete_post($post_id) 
	{
		$con = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
		if (mysqli_connect_errno()) 
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}		
		$con->query("UPDATE `posts` SET `title` = 'сообщение удалено', `theme` = 'сообщение удалено', `text` = 'сообщение удалено', `deleted` = '1'  WHERE `posts`.`post_id` = ".$post_id);
		$con->close();
	}	
}