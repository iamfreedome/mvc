<?php //controller/shkaf.php
class Shkaf extends CI_Controller
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('kniga_model'); 
	}
		
	public function index()
	{
		$data = $this->kniga_model->list_book(); //получили список книг в шкафу 
		
		$this->load->view('shkaf/listbook',$data);
			
	}
		
	public function book_append($shkaf_name,$book_name)
	{
		$this->load->helper('form');
				
		$data['text'] = $this->kniga_model->open_book($shkaf_name,$book_name);
		$data['shkaf_name'] = $shkaf_name;//$book_on_path['shkaf_name'];
		$data['book_name'] = $book_name;//$book_on_path['book_name'];
		
		$data['append'] = TRUE;
		$data['path'] = $this->kniga_model->getPath($shkaf_name,$book_name);
				
		$this->load->view('shkaf/bookAppend',$data);
		
	}	
	
	public function make_append($shkaf_name,$book_name) 
	{
		$this->kniga_model->append_book($shkaf_name,$book_name);
		 
		$this->load->view('shkaf/makeAppend');
	}

	public function book_open($shkaf_name,$book_name) 
	{ 
		$data['text'] = $this->kniga_model->open_book($shkaf_name,$book_name);
		
		$data['shkaf_name'] = $shkaf_name;//$book_on_path['shkaf_name'];
		$data['book_name'] = $book_name;//$book_on_path['book_name'];
		$data['append'] = FALSE;
			
		$this->load->view('shkaf/bookOpen',$data);
	}
	
	public function book_add() 
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title','Название книги','required');
		$this->form_validation->set_rules('text','Текст книги','required');
		
		if ($this->form_validation->run() === FALSE)
		{ 	
			$this->load->view('shkaf/bookCreate'); 
					
		} else
		{ 	
			$this->kniga_model->add_book('shkaf');
			echo "книга добавлена только что!"; 
			$this->index();
		}
	}
}
	
	
