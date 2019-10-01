<?php
class PostModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function getDeleted()
	{	$deleted = array ( 'title' => '@deleted',
			'theme' => '@deleted',
			'text' => '@deleted',
			'deleted' => 1,
			);
		return $deleted;
	}
	
	public function getTableName()
	{
		return 'posts';
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
		$this->db->from($this->getTableName());
		$this->db->where(array('board_id' => $board_id)); 
		$this->db->where('deleted <', 1);
		$this->db->limit($limit,$offset);
		$this->db->order_by('post_id', 'ASC');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_board_other($board_id,$limit,$offset) 
	{ 
		$this->db->select('*');
		$this->db->from($this->getTableName());
		$ar = (($board_id == -1) ? array('user_id' => $_SESSION['user_id']) : array('board_id' => $board_id)   );
		$this->db->where($ar); 
		$this->db->where('deleted <', 1);
		$this->db->limit( $limit , $offset);
		$this->db->order_by('post_id', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function all_posts($user_id) 
	{
		$limit = 5;
		$offset = 0;
		$_SESSION['offset'] = 0;
		
		$this->db->select('*');
		$this->db->from($this->getTableName());
		$this->db->where(array('user_id' => $user_id));
		
		$this->db->where('deleted <', 1);
		$this->db->limit($limit,$offset);
		$this->db->order_by('post_id', 'ASC');
		
		$query = $this->db->get();
		return $query;
	}
	
	public function add_post($data) 
	{
		$this->db->insert($this->getTableName(),$data);
	}
	
	public function get_post($post_id) 
	{
		$this->db->select('*');
		$this->db->from($this->getTableName());
		$this->db->where(array('post_id' => $post_id));
		$query = $this->db->get();
		return $query;
	}

	public function get_post_withusername($post_id) 
	{
		$this->db->select('*');
		$this->db->from("`posts`,`users`");
		$this->db->where("`posts`.`user_id`=`users`.`user_id` AND `posts`.`post_id`=$post_id");
		$query = $this->db->get();
		return $query;
	}

	public function delete_post($post_id) 
	{	
		$this->db->where(array('post_id' => $post_id));
		$data = $this->getDeleted();
		$this->db->update($this->getTableName(),$data);
	}	
}