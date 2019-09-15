<?php //controller/shkaf.php
	class Shkaf extends CI_Controller{
		public function __construct() {
			parent::__construct();
			$this->load->model('kniga_model'); 
			}
		
		public function index(){
			$data = $this->kniga_model->list_book(); //получили список книг в шкафу data['listbook'][i][path|shkaf_name|book_name]
			$data['title']="СОДЕРЖАНИЕ ШКАФА";
			
			$this->load->view('templates/header_shkaf',$data);
			$this->load->view('shkaf/listbook',$data);
			$this->load->view('templates/footer_shkaf');
			//echo 'Hello World';
		}
		
		public function book_append($shkaf_name,$book_name){
			$this->load->helper('form');
			//$this->load->library('form_validation');
			
			//$this->form_validation->set_rules('title','Title','required');
			//$this->form_validation->set_rules('text','text','required');
			
			$path = $shkaf_name.'/'.$book_name;
			$data['text'] = $this->kniga_model->open_book($path);
			$data['shkaf_name'] = $shkaf_name;//$book_on_path['shkaf_name'];
			$data['book_name'] = $book_name;//$book_on_path['book_name'];
			$data['title'] = 'Дописать книгу ';
			$data['append'] = TRUE;
			$data['path'] = $path;
			
						
			$this->load->view('templates/header_shkaf',$data);
			$this->load->view('shkaf/bookOpen',$data);
//представление для дозаписи в книгу
			$this->load->view('shkaf/bookAppend',$data);
			$this->load->view('templates/footer_shkaf');
		
				//echo 'Look at this';
		}	
		public function make_append($shkaf_name,$book_name) {
			$data['title'] = 'Книга дописана';
			$this->kniga_model->append_book($shkaf_name,$book_name);
			//echo 'make append nOW!';
					$this->load->view('templates/header_shkaf',$data);
					$this->load->view('templates/footer_shkaf');

		}

		public function book_open($shkaf_name,$book_name) { //$shkaf_name,$book_name,
			$path = $shkaf_name.'/'.$book_name;
			$data['text'] = $this->kniga_model->open_book($path);
			//$book_on_path = $this->kniga_model->get_book_name($path);
			//получили список книг в шкафу data['listbook'][i][path|shkaf_name|book_name]); //получили книгу в шкафу data[path|shkaf_name|book_name|text]
			$data['shkaf_name'] = $shkaf_name;//$book_on_path['shkaf_name'];
			$data['book_name'] = $book_name;//$book_on_path['book_name'];
			$data['title'] = 'Открыть книгу';
			$data['append'] = FALSE;
			
			$this->load->view('templates/header_shkaf',$data);
			$this->load->view('shkaf/bookOpen',$data);
			//echo $path;
			$this->load->view('templates/footer_shkaf');
		}
	
		public function book_add() {
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('text','text','required');
			
			
			$data['title'] = 'Добавить книгу в шкаф';
			if ($this->form_validation->run() === FALSE)
			{ 	$this->load->view('templates/header_shkaf',$data);
				$this->load->view('shkaf/bookCreate'); //was news/create
				$this->load->view('templates/footer_shkaf');
			} else
			{ 	
				$this->kniga_model->add_book('shkaf');
				echo "книга добавлена только что"; 
				$this->index();
				//$this->load->view('news/create',$data);// 
				//$this->load->view('news/success');
				//$this->load->view('templates/footer');
			}
			
			
		}
	}
	
	
?>