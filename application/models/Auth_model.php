<?php
/*$query->row() will return a single(first) row form the result as Class Object. 
It is recommended to use when you want to get single record through query by using unique id or any other specified single row or using limit 1.

$query->result() will return all the records as array. 
and all the records in the array are Class Objects.

if you use $query->row() in this scenario it will return the first record only in the result as  Class Object. 
so it is not recommended here.

you can also use $query->row_array() and $query->result_array() to get result as array instead of Class Object.
*/
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
		return $query; //->row_array();
	}
	
	public function get_all_boards(){
		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		
		return $query; //->result_array();
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
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_board_other($board_id,$limit,$offset) {
		//$limit = 5;
		//$offset = 0;
		
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
		
		
		return $this->db->get();
	}
	
	public function add_post($data) {
		$table = 'posts';
		$this->db->insert($table,$data);
		
	}
	
	public function get_post($post_id) {
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where(array('post_id' => $post_id));
		
		return $this->db->get();
		
	}
	
	public function dell_post($post_id) {
		//print_r ($this->db);
		//print ($this->db->username);
		$con = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
		if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
}		$con->query("UPDATE `posts` SET `title` = 'сообщение удалено', `theme` = 'сообщение удалено', `text` = 'сообщение удалено', `deleted` = '1'  WHERE `posts`.`post_id` = ".$post_id);
		$con->close();

	}
}
?>