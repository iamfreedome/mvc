<?php
class CommentModel extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all_comment() 
	{
		$this->db->select('*'); //'`text`,`post_id`,`deleted`'
		$this->db->from('posts');
		$ret = $this->db->get();
			
		return $ret;
	}

	public function get_comment($comment_id) 
	{
		if ($comment_id > 0) 
		{
			$arcom = $this->get_all_comment();
			$arcom = $arcom->result();
		
			foreach ($arcom as $arrow) 
			{
				if ($comment_id == $arrow->post_id) 
				{ 
					if ($arrow->deleted > 0) 
					{ 
						return ('Сообщение было удалено ранее');
					} else 
					{
						return ($arrow->text);
					} 
				}
			}	
	
		} else 
		{ return '';
		}
	}	

	public function add_comment(array $ar) 
	{
		foreach ($ar as $rowsa) 
		{
			$rowsa->comment = $this->get_comment($rowsa->comment_id);
		}
		return (array) $ar;
	}

public function set_comment($data) 
	{
		$table = 'posts';
		$this->db->insert($table,$data);
	}

}